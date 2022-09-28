<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" />

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo url . '/' . $this->folder ?>/slack_report"><?php echo $this->langControl('reports') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page"> تقرير الركود المفاجئ </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <form action="<?php echo url . '/' . $this->folder ?>/view/<?php echo $id ?>" method="post" enctype="multipart/form-data">

            <!-- هنا نختار الموديل  -->
            <div class="row align-item-center">
                <div class="col-auto">
                    <label for="model"> الموديل </label>
                    <div class="form-group select_drop" style="width: 100%">
                        <select name="model" id="model" class="selectpicker" aria-expanded="false" data-live-search="true">
                            <!-- if model is 0  -->
                            <?php if ($model == '0') { ?>
                                <option value="0" > حدد الفئة </option>
                            <?php }else { ?>
                            <option value="<?= $model ?>"><?php echo $this->langControl($model) ?></option>
                            <?php } ?>
                            <?php foreach ($this->category_website as $key => $value) { ?>
                                <option value="<?= $key ?>"><?= $value ?></option>

                            <?php } ?>

                        </select>
                    </div>
                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                        width: 392px !important;
                    }
                </style>



                <div class="col-auto">
                    <label for="id_cat">الفئة</label>
                    <div class="form-group select_drop" id='div_cat' style="width: 100%">
                        <select name="id_cat" id="id_cat">
                            <?php if ($id_cat == 0) { ?>
                                <option value="0" selected>الكل</option>    
                            <?php }else{ ?>
                                <option value="<?=$id_cat?>">الفئة المختارة</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                        width: 392px !important;
                    }
                </style>
                <div class="col-auto">
                    <label for="day_count">النسبة</label>
                    <input type="number" class="form-control" id="day_count" name="day_count" placeholder="النسبة" value="<?= $count ?>">
                </div>
                <div class="col-auto align-self-center">
                   
                        <input type="submit" id='search_id' class="btn btn-primary" value="بحث"<?php if($model==0) echo 'disabled' ?> onclick="return search()">
                        <!-- <button  class="btn  btn_search_filter" onclick="colorDevice_public()"    >  عرض الحافظات </button> -->
                    
                    <!-- <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Primary link</a> -->


                    <!-- <input class="btn btn-primary" value="بحث" type="submit" name="submit" /> -->
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <table id="example" class="table table-striped display d-table">
            <thead>
                <tr>
                    <th> باركود </th>
                    <th> المادة </th>
                    <!-- <th>الباركود</th> -->
                    <th>العدد</th>
                    <th>الوقت المستغرق لبيع القطعة الواحدة</th>
                    <th>مدة الركود</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var selected = [];
    // get value in day_count

    var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo url . '/' . $this->folder ?>/processing_slack_report/<?php echo $count . "/" . $model."/".$id_cat ?>",

        info: false,
        "fnDrawCallback": function() {
            jQuery('.toggle-demo').bootstrapToggle();

        },
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'row_' + aData[1]);
        },

        'columnDefs': [{
            "targets": [0],
            "orderable": false
        }],
        
        aLengthMenu: [50, 100, 200, 300, -1],
        oLanguage: {
            sLoadingRecords: "تحميل ...",
            sProcessing: " معالجة ...",
            sLengthMenu: "عرض _MENU_ ",
            sSearch: " أبحث  ",
            oPaginate: {
                sFirst: "First",
                sLast: "Last",
                sNext: "&raquo;",
                sPrevious: "&laquo;"
            },
            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
            sSearchPlaceholder: "البحث"


        },
        <?php if ($this->permit('export_excel', $this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel',
                'pageLength'
            ],
        <?php  }  ?>
        bFilter: true,
        bInfo: true,

    });
    $(document).ready(function() {



        $('a.toggle-vis').on('click', function(e) {
            e.preventDefault();

            // Get the column API object
            var column = table.column($(this).attr('data-column'));

            // Toggle the visibility
            column.visible(!column.visible());
        });

        // table.draw();
        /**@abstract
         * اعادة نحميل الجدول عند اختيار احد انواع المستخدمين
         * 
         */
        // $('#day_count').change(function() {
        //     console.log($(this).val());

        //     table.draw();
        // });
       
        




        /**@abstract
         * ملء الفئات عند اختيار نوع المودل 
         */
        $('#model').on('change', function() {
            var value = $(this).val();
            console.log(value);
            $.post("<?php echo url . '/' . $this->folder . '/getCatgry/' ?>" + value,
                function(data, status) {
                    var jsonData = JSON.parse(data);
                    $("#id_cat").empty();
                    $("#id_cat").append(new Option("الكل", 0));
                    $.each(jsonData, function(index, value) {
                        $("#id_cat").append(new Option(value['title'], value['id']));
                    });
                    document.getElementById("search_id").disabled = false;
                    $("#id_cat").select2();

                });
        });
        /**@abstract
         * ملء الفئات عند اختيار نوع المودل 
         */
       
        


    });
</script>


<style>
    table thead tr {
        text-align: center;
    }

    table tbody tr td {
        text-align: center;
    }


    .d-table {
        width: 100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }

    .class_delete_row {
        background: transparent;
        border-radius: 50%;
        padding: 0;
        width: 35px;
        height: 35px;
        font-size: 28px;
        margin: 0;
    }
</style>

<script>

    function search() {
        var model = $('#model').val();
        var day_count = $('#day_count').val();
        var id_cat = $('#id_cat').val();

        window.location.href = "<?php echo url . '/goods_availability' ?>/slack_report/" + day_count + "/" + model+ "/" + id_cat;
        return false;

    }
</script>










<br>
<br>
<br>
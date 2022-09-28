

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl($this->folder) ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >   تفعيل / الغاء تفعيل المواقع او ادخال السيريال عند التجهيز </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row align-items-center">
    <div class="col-lg-4">
        <div class="  select_drop"  style="width: 100%" >
            <select  id="list_catg"  class="selectpicker"   aria-expanded="false"  data-live-search="true"  >
                <option value="all" > كل محتويات الاقسام </option>
                <?php foreach ($data_cat as $list_cat)  {     ?>
                    <option  value="<?php  echo $list_cat['id'] ?>"   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>
            </select>
        </div>
    </div>

    <div class="col-auto">

        <select id="type" name="type" class="form-control"  >
            <option value="location" >مواقع  </option>
            <option value="serial"> ادخال السيريال عند التجهيز </option>
        </select>

    </div>

    <div class="col-auto">

        <div class="custom-control custom-radio custom-control-inline">
            <input checked type="radio"  value="1" id="customRadioInline1" name="ls" class="custom-control-input" >
            <label class="custom-control-label" for="customRadioInline1">  تفعيل </label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" value="0" id="customRadioInline2" name="ls" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2"> الغاء تفعيل </label>
        </div>
    </div>

    <div class="col-auto">
        <button class="btn btn-primary"  onclick="active_set()"  >موافق</button>
    </div>

    <div class="col-lg-2" id="process_active">
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

    </div>


</div>

<script>

    function   active_set() {

        if (confirm('هل انت متأكد؟')) {
            $('#process_active').show()

            cat = $("#list_catg :selected").val();
            type = $("#type").val();
            ls = $("input[name='ls']:checked").val();
            $.get("<?php echo url . '/' . $this->folder  ?>/active_pro", {
                cat: cat,
                type: type,
                ls: ls
            }, function (data) {

                console.log(data)
                if (data) {
                    $('#process_active').hide()

                    if (ls === '1') {
                        alert("تم التفعيل")

                    } else {
                        alert("تم الغاء التفعيل")
                    }

                } else {
                    $('#process_active').hide()
                    alert("حدثت مشكلة في العملية")
                }


            });
        }return false;
    }
</script>

<hr>


<style>
    #process_active
    {
        display: none;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100%;
    }

</style>

<br>
<br>




<script>
    var  table;
    $(document).ready(function() {



        table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url  .'/'. $this->folder ?>/processing_all_category",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>


<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>القسم</th>
                <th>  تفعيل / الغاء تفعيل التجهيز بستخدام السيريال </th>
                <th>  تفعيل / الغاء تفعيل  تكرار السيريال لمواد اخرى </th>
                <th>  تفعيل / الغاء تفعيل سيريال المناقلات </th>
                <th>  تفعيل / الغاء تفعيل سيريال المرتجع </th>
                <th>  تفعيل / الغاء تفعيل سيريال الشراء </th>
                <th>  تفعيل / الغاء تفعيل سيريال السحب </th>

                <th>المستخدم</th>

            </tr>
            </thead>

        </table>

    </div>
</div>


<style>

    table thead tr
    {
        text-align: center;
    }

    table tbody tr td
    {
        text-align: center;
    }


    .d-table
    {
        width:100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }
    .class_delete_row
    {
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


    function visible_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/visible_serial/"+vis+'/'+id, function(data){


        })

    }


    function transfer_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/transfer_serial/"+vis+'/'+id, function(data){


        })

    }

    function duplication_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/duplication_serial/"+vis+'/'+id, function(data){


        })

    }


    function rewind_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/rewind_serial/"+vis+'/'+id, function(data){


        })

    }

    function purchase_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/purchase_serial/"+vis+'/'+id, function(data){


        })

    }

    function withdraw_serial(e,id) {


        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'. $this->folder ?>/withdraw_serial/"+vis+'/'+id, function(data){


        })

    }




</script>












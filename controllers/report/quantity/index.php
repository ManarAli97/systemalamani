<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"> <?php echo $this->langControl('report_upload') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<script>
    $(document).ready(function() {
        var selected = [];
        $('#example').DataTable({
            <?php if ($cat && $fromtime_stamp && $totime_stamp) { ?> "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url . '/' . $this->folder ?>/processing_quantity/<?php echo $string ?>?out=<?php echo $out_id ?>",
            <?php } ?> info: false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();
            },
            "order": [
                [0, 'desc']
            ],
            aLengthMenu: [10, 25, 50, 100, -1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
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
            dom: 'Bfrtip',
            buttons: [
                'excel',
                'pageLength'
            ],
            bFilter: true,
            bInfo: true
        });
    });
</script>
<br>
<form action="<?php echo url . '/' . $this->folder ?>/report_upload" method="get">
    <div class="row align-items-center x_report">
        <div class="col-auto mb-3 select_drop">
            <label>القسم</label>
            <select onchange="reloadPage()" name="cat" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required>
                <option value="0">الكل</option>
                <?php foreach ($this->category_website as  $key => $catg) { ?>
                    <option value="<?php echo $key ?>" <?php if ($key == $cat)  echo 'selected' ?>> <?php echo $this->langControl($catg) ?> </option>
                <?php  } ?>
            </select>
        </div>
        <div class="col-auto mb-3 ">
            <label>من تاريخ</label>
            <input data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر" name="fromdate" type="datetime-local" data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر" value="<?php echo $fromdate ?>" class="form-control" required>
        </div>
        <div class="col-auto mb-3">
            <label>الى تاريخ</label>
            <input data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر" name="todate" type="datetime-local" data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر" value="<?php echo $totdate ?>" class="form-control" required>
        </div>
        <div class="col-auto">
            <label for="model"> عرض فقط : </label>
            <div class="form-group select_drop">
                <select id="framework" name="out[]" multiple class="form-control">
                    <?php foreach ($allCat as $catsall) {   ?>
                        <option value="<?php echo $catsall['id'] ?>" <?php if (in_array($catsall['id'], $out))  echo 'selected' ?>> <?php echo $catsall['title'] ?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <style>
        .multiselect-container.dropdown-menu.show {
            height: 500px !important;
            overflow-x: auto !important;
            background: white;
        }

        span.input-group-addon {
            border: 1px solid;
            padding: 5px 4px;
            color: #ced4da;
        }

        button.btn.btn-default.multiselect-clear-filter {
            border: 1px solid !important;
            margin-left: 7px;
            color: #ced4da;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#framework').multiselect({
                nonSelectedText: 'حدد بعض الاقسام لعرض موادها',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: false,
                buttonWidth: '400px',
                includeSelectAllOption: true,
                selectAllText: ' تحديد الكل',
            });
        });

        function reloadPage() {
            var mod = $("#inlineFormCustomSelect :selected").val();
            window.location = "<?php echo url . '/' . $this->folder ?>/report_upload?cat=" + mod
        }
        //getCatg()
        //function getCatg() {
        //    var mod=$("#inlineFormCustomSelect :selected").val();
        //    $.get( "<?php //echo url .'/'.$this->folder 
                        ?>///getcatg",{model:mod}, function( data ) {
        //     if (data)
        //     {
        //         $( "#out_model" ).html( data );
        //
        //     }
        //
        //    });
        //}
        function allR(e) {
            var vis = $(e).is(':checked') ? 1 : 0;
            if (vis === 1) {
                $(".xx").prop('checked', false);
                $(".yx").prop('checked', false);
            }
        }

        function itemmax(e) {
            var vis = $(e).is(':checked') ? 1 : 0;
            if (vis === 1) {
                $(".yx").prop('checked', false);
            }
        }

        function notFoundxR(e) {
            var vis = $(e).is(':checked') ? 1 : 0;
            if (vis === 1) {
                $(".xx").prop('checked', false);
                $(".yy").prop('checked', false);
            }
        }
    </script>
    <hr>
    <div class="text-center">
        <input type="submit" name="submit" value="بحث" class="btn btn-success">
        <a class="btn btn-primary" href="<?php echo url . '/' . $this->folder ?>/report_upload"><i class="fa fa-refresh"></i> </a>
    </div>
</form>
<hr>
<div class="row">
    <div class="col">
        <table id="example" class="table table-striped display d-table">
            <thead>
                <tr>
                    <th> القسم </th>
                    <th> اسم المادة </th>
                    <th> الباركود </th>
                    <!-- <th> الكمية </th> -->
                    <th> الكمية المواقع الكلية </th>
                    <th> المباع </th>
                    <!-- <th> السعر دولار </th>
                <th> السعر دينار </th> -->
                    <th> الصورة </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
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
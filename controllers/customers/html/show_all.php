<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" />
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?php echo url . '/' . $this->folder ?>"><?php echo "customers_compensation" ?> </a></li> -->
                <li class="breadcrumb-item active" aria-current="page">تعويض الزبائن الكلي</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<hr>
<div class="form-group row">
    <!-- <div class="col-md-3">
        <a href="<?php echo url . '/' . $this->folder ?>/add_viwe"><button type="button" id="create_groups" class="btn btn-success">اضافة</button></a>
    </div> -->
</div>
<div class="row">
    <div class="col">
        <table id="example" class="table table-striped display d-table">
            <thead>
                <tr>
                    <th> اسم الزبون </th>
                    <th> رقم هاتف الزبون </th>
                    <th>رقم الفاتورة</th>
                    <th>تاريخ التسجيل</th>
                    <th>اسم موظف الكول سنتر</th>
                    <th>ملاحظة موظف الكول سنتر</th>
                    <th>تاريخ التحقيق</th>
                    <th>اسم موظف المبيعات</th>
                    <th>ملاحظة موظف المبيعات</th>
                    <th>الحالة</th>
                    <th>ملاحظة الاتصال بعد التعويض</th>

                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var selected = [];
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url . '/' . $this->folder ?>/show_all_processing",
            info: false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();
            },
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row_' + aData[7]);
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
            <?php if ($this->permit('export_excel', $this->folder)) { ?>dom: 'Bfrtip',
            buttons: [
                'excel',
                'pageLength'
            ],
        <?php  }  ?> bFilter: true,
        bInfo: true,
        });
    });

        /**@abstract
     *  تضيف قيمة لحقل ملاحظات الكول سنتر في جدول اطلب ما  لم تجده
     */
    function addNoteCalled(note,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addNoteCalled/",
        data: 'value1='+note+'&value2='+id,

        success: function(data){}

        });
         
    }
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
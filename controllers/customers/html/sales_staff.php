<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" />
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="<?php echo url . '/' . $this->folder ?>"><?php echo "customers_compensation" ?> </a></li> -->
                <li class="breadcrumb-item active" aria-current="page"> تعويض الزبائن (واجهة موظفي المبيعات)</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<hr>
<!-- <div class="form-group row">
    <div class="col-md-3">
        <a href="<?php //echo url . '/' . $this->folder 
                    ?>/customers_compensation_viwe"><button type="button" id="create_groups" class="btn btn-success">اضافة</button></a>
        <a href="<?php //echo url . '/' . $this->folder 
                    ?>/show_all"><button type="button" id="create_groups" class="btn btn-success">اضهار الكل</button></a>
    </div>
</div> -->
<div class="row">
    <div class="col">
        <table id="example" class="table table-striped display d-table">
            <thead>
                <tr>
                    <th> اسم الزبون </th>
                    <th> رقم هاتف الزبون </th>
                    <th>رقم الفاتورة</th>
                    <th>تاريخ التسجيل</th>
                    <!-- <th>اسم موظف الكول سنتر</th> -->
                    <th>ملاحظة موظف الكول سنتر</th>
                    <th>تأكيد التعويض</th>
                    <!-- <th>تاريخ التحقيق</th> -->
                    <!-- <th>اسم موظف المبيعات</th> -->
                    <!-- <th>ملاحظة موظف المبيعات</th> -->
                </tr>
            </thead>
        </table>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>
            </div>
            <div class="modal-body">

            </div>
            <form action="<?php echo url . '/' . $this->folder ?>/customers" method="post" enctype="multipart/form-data" class="form-note">
                <!-- <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div> -->
                <div class="form-group">
                    <label for="message-text" class="col-form-label">ملاحظة تأكيد التعويض :</label>
                    <textarea class="form-control" name="note_check" id="note_check"></textarea>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-success" onclick="get_sales_staff_data()">تم التعويض</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var selected = [];
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url . '/' . $this->folder ?>/sales_staff_processing",
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
</script>
<script>
    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text('ملاحظة(اختياري)');
        // modal.find('.modal-body').text(title);
        modal.find('.modal-body').text("اسم الزبون : " + title);
        modal.find('.form-note');
        modal.find('#save').val(recipient)
    });


    // ON CLICK SAVE BUTTON send data to update_sales_staff
    function get_sales_staff_data() {
        var id = $('#save').val();
        var note_check = $('#note_check').val();

        $.ajax({
            url: "<?php echo url . '/' . $this->folder ?>/update_sales_staff",
            type: "POST",
            data: {
                id: id,
                note_check: note_check
            },
            success: function(data) {
                // hide column after click on button
                $('#row_' + id).remove();
                $('#exampleModal').modal('hide')
                // reload window
                location.reload();
                // $('#example').DataTable().ajax.reload();
            }
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
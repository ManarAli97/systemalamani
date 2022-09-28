<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">تفاصيل الباركود </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <table id="example" class="table table-striped display d-table">
            <thead>
                <tr>
                    <th>الباركود</th>
                    <th>الموديل</th>
                    <th>الأكسل</th>
                    <th>حجز</th>
                    <th>مجموع الكميات(بانتضار التاكيد+مجموع كميات المواقع)</th>
                    <th>مجموع كميات المواقع</th>
                    <th>بانتضار التاكيد</th>
                    <th>التاريخ</th>
                    <th>التاريخ</th>
                </tr>
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
            "ajax": "<?php echo url . '/' . $this->folder ?>/processing_viwe_full_quantity_change_control/<?php echo $code ?>",
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
            buttons: [
                'excel',
                'pageLength'
            ],
        });
    });
</script>
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?php echo $this->langControl('quantity_change_control') ?> </li>
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
                    <th>الموديل</th>
                    <th>الباركود</th>
                    <th>عدد الباركودات</th>
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
            "ajax": "<?php echo url . '/' . $this->folder ?>/processing_viwe_quantity_change_control",
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
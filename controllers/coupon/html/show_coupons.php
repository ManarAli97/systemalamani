

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/groups_coupons"><?php  echo $this->langControl('groups_coupons') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >الكوبونات </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<form>

  <div class="form-group row">

    <label for="colFormLabel" class="col-sm-2 col-form-label">توليد باركود</label>
    <div class="col-sm-2">
      <input type="number" class="form-control" id="barcode_count" placeholder="العدد">
    </div>
    <button type="button" id="create_barcode" class="btn btn-success">توليد</button>
  </div>
</form>
<hr>
<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> التسلسل </th>
                <th> الباركود </th>
                <th> المستخدم </th>
                <th> الحالة </th>
                <th> تاريخ التوليد </th>

            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
     $(document).ready(function(){

            var selected = [];

            var table = $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_show_coupons/<?php echo $idGroup ?>",
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id','row_'+ aData[7]);
                },

                'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }],
                "order": [[ 0, 'desc'] ],
                aLengthMenu: [ 50,100, 200, 300,-1],
                oLanguage: {
                    sLoadingRecords: "تحميل ...",
                    sProcessing: " معالجة ...",
                    sLengthMenu: "عرض _MENU_ ",
                    sSearch: " أبحث  ",
                    oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                    sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                    sSearchPlaceholder: "البحث"


                },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
                dom: 'Bfrtip',
                buttons: [
                    'excel'  ,
                    'pageLength'
                ],
                <?php  }  ?>
                bFilter: true, bInfo: true,

            } );
            $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );
    } );








});

$( "#create_barcode" ).click(function() {
    var code_count= $('#barcode_count').val();
    console.log(code_count);
    var id_group = <?php echo $idGroup ?>;
    $.get( "<?php echo url .'/'.$this->folder ?>/create_coupons/"+id_group+'/'+code_count, function( data ) {
        alert( " تم توليد " + code_count + ' باركود ');
        $('#example').DataTable().ajax.reload();
    });
});


</script>










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


<br>
<br>
<br>



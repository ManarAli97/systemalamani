<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('groups_coupons') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<?php if ($this->permit('create_groups_coupons','coupon')){ ?>
<form>

  <div class="form-group row">
    <div class="col-md-3">
    اسم المجموعة
      <input type="text" class="form-control" id="name_groups" >
    </div>
    <button type="button" id="create_groups" class="btn btn-success" >اضافة</button>
  </div>

</form>
<?php } ?>
<hr>
<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> التسلسل </th>
                <th> اسم المجموعة </th>
                <th> عدد الكوبونات </th>
                <th>  الكوبونات المحجوزة </th>
                <th>  الكوبونات غيرالمحجوزة </th>
                <th>  توليد الكوبانات</th>
                <th>  اضافة فائزين</th>
                <th> اسم المستخدم </th>
                <th> تاريخ الاضافة </th>
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
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_groups_coupons",
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

$( "#create_groups" ).click(function() {
    var name_group = $('#name_groups').val();
    var  dataD={'name_group':name_group};
    if(name_group != ''){
        $.get( "<?php echo url .'/'.$this->folder ?>/create_groups/",{ jsonData: JSON.stringify(dataD)}, function(data) {
        alert( "تم اضافة المجموعة '  " + name_group + "'");
        location.reload();
        // $('#example').DataTable().ajax.reload();
    });

    }else{
        alert('ادخل اسم المجموعة');
    }

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
        white-space: nowrap;
    }

    #create_groups{
        border-radius: 6px;
        margin-top: 24px;
        height:40px;
        width:6%;
        color: #ffff;
    }
    .d-table
    {
        width:100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }
</style>


<br>
<br>
<br>



















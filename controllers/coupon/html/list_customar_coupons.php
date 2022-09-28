
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view"><?php  echo $this->langControl('coupon') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >الكوبونات</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<form>

  <div class="form-group row">
    <div class=" col-md-3">
      مجاميع الكوبونات
        <select class="custom-select dropdown_filter" name="select_group" id="select_group" >
        <option>   اختر المجموعة </option>
			<?php foreach ($category as $key => $group) {   ?>
                <option    value="<?php  echo $group['id']?>"><?php  echo $group['name_group']?></option>
			<?php  } ?>

        </select>

    </div>
    <div class="col-md-3">
    رقم الزبون
      <input type="text" class="form-control" id="custmor_number" >
    </div>
    <button type="button" id="set_barcode" class="btn btn-success" disabled>تسليم</button>
  </div>
  <p id ='note'></p>
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
                <th> الزبون </th>
                <th> الحالة </th>
                <th> التاريخ </th>
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
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_list_customer_coupons",
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

$("#set_barcode").click(function() {
    var custmor_number= $('#custmor_number').val();
    var id_group= $('#select_group').val();
    // console.log(brand);
    $.get( "<?php echo url .'/'.$this->folder ?>/set_barcode/"+custmor_number+'/'+id_group, function( data ) {
        if(data!=-1)
        {
            min = data - 24;
            max = data;
            alert( " حصل الزبون على التسلسلات من " + min + " الى " + data);
            $("#note").text( " حصل الزبون على التسلسلات من " + min + " الى " + data);
            location.reload();
        }else
        {
            alert( " لا تمتلك صلاحية");
        }

    });
});

$('#custmor_number , #select_group ').on('input , change',function(e){
    var custmor_number= $('#custmor_number').val();
    var id_group= $('#select_group').val();
    if(custmor_number!='')
    {
        $.get( "<?php echo url .'/'.$this->folder ?>/check_customar_number/"+custmor_number+'/'+id_group, function( data ) {
            if(data ==0)
            {
                $("#note").text("الرقم لا يمتلك QR");
                $("#set_barcode").attr("disabled", true);
            }
            else if(data == 1)
            {
                $("#note").text("الرقم غير فائز");
                $("#set_barcode").attr("disabled", true);
            }
            else if (data ==-1)
            {
                $("#note").text("تم تسليم الكوبونات مسبقا");
                $("#set_barcode").attr("disabled", true);
            }
            else
            {
                $("#note").text("الرقم صالح");
                $("#set_barcode").attr("disabled", false);
            }
        });
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

    input[type="text"] , #select_group
    {
        border-radius: 6px;
        margin-top: 5px;
    }
    #set_barcode{
        border-radius: 10px;
        margin-top: 22px;
        height:40px;
        width:5%;
        color: #ffff;
    }
</style>


<br>
<br>
<br>



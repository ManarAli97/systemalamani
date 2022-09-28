

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view"><?php  echo $this->langControl('remove_coupon') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >تسقيط الباركودات</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<form>
    
  <div class="form-group row">
    <label for="custmor_number" class="col-sm-2 col-form-label"> رقم الزبون او الQR</label>
    <div class="col-md-3">
      <input type="text" class="form-control" id="custmor_number" >
    </div>
    <label for="coupon_barcode" class="col-sm-2 col-form-label">الباركود</label>
    <div class="col-md-3">
      <input type="text" class="form-control" id="coupon_barcode" >
    </div>
    <button type="button" id="confirmation_of_use" class="btn btn-success" disabled>تاكيد</button>
  </div>
  <p id ='note'></p>
</form>
<hr>
<table id = 'myTable'>
    <thead>
        <tr>
            <th>الباركود</th>
            <th>المبلغ</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>المجموع</td>
            <td>0</td>
        </tr>
    </tbody>
    </table>
<script>
     $(document).ready(function(){
        

});

$( "#confirmation_of_use" ).click(function() {
    var coupon_barcode= $('#coupon_barcode').val();
    $.get( "<?php echo url .'/'.$this->folder ?>/confirmation_of_use/"+coupon_barcode, function( data ) {
        if(data ==0)
        {
            alert( " لم تتم العملية "  );
        }
        else if (data ==1)
        {
            // alert( " تم العملية "  );
            $("#confirmation_of_use").attr("disabled", true);
            var sum = ($('#myTable tr').length-1)*1000 ;
            $('#myTable tr:last').remove();
            $('#myTable tr:last').after('<tr><td>'+coupon_barcode+'</td><td>1000</td></tr><tr><td>المجموع</td><td>'+sum+'</td></tr>');
            $('#coupon_barcode').val('');
        }
    });  
});

$(' #coupon_barcode').on('input',function(e){
    var custmor_number= $('#custmor_number').val();
    var coupon_barcode= $('#coupon_barcode').val();
    $.get( "<?php echo url .'/'.$this->folder ?>/check_customar_barcode/"+custmor_number+"/"+coupon_barcode, function( data ) {
        if(data ==0)
        {
            $("#note").text("خطا في الباركود");
            $("#confirmation_of_use").attr("disabled", true);
        }
        else if (data ==1)
        {
            $("#note").text("");
            $("#confirmation_of_use").attr("disabled", false);
        }
           
    }); 
});
$('#custmor_number').on('input',function(e){
    var custmor_number= $('#custmor_number').val();
    $.get( "<?php echo url .'/'.$this->folder ?>/check_won_barcode/"+custmor_number, function( data ) {
        if(data ==0)
        {
            $("#note").text("الرقم غير رابح ");
            $("#confirmation_of_use").attr("disabled", true);
            $("#coupon_barcode").attr("disabled", true);
        }
        else if (data >0)
        {
            $("#note").text("يمتلك الرقم "+data+ "باركود ");
            // $("#confirmation_of_use").attr("disabled", false)
            $("#coupon_barcode").attr("disabled", false);
        }
           
    }); 
});
var input = document.getElementById("coupon_barcode");
input.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("confirmation_of_use").click();
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
    table, th, td {
        border: 1px solid #ccc;
        border-collapse: collapse;
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



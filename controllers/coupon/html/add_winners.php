<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/groups_coupons"><?php  echo $this->langControl('groups_coupons') ?> </a></li>
                <li class="breadcrumb-item active"><?php  echo $this->langControl('add_winners') ?></li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<form>

  <div class="form-group row">
  <div class="col-lg-3 col-md-3">
        رقم الزبون
      <input type="text" class="form-control" id="custmor_phone" maxlength="11">
    </div>
    <div class="col-lg-3 col-md-3">
        اسم الزبون
      <input type="text" class="form-control" id="custmor_name" >
    </div>
    <button type="su" id="add_winner" class="btn btn-success" disabled>اضافة</button>
  </div>
  <p id ='note'></p>
</form>
<hr>

<script>


$('#custmor_phone').on('input',function(e){
    var phone= $('#custmor_phone').val();
    if(phone!='')
    {
        if(phone.length ==11)
        {
            $("#add_winner").attr("disabled", false);
            $.get( "<?php echo url .'/'.$this->folder ?>/check_phone_customer/"+phone, function( data ) {
               console.log(data);
                if(data ==0)
                {
                    $("#note").text("غير مسجل");
                }
                else if (data ==1)
                {
                    $("#note").text("رقم الزبون مسجل");
                }
                else
                {
                    $("#note").text("رقم الزبون مسجل و يمتلك qr");
                }
            });
        }
        else{
            $("#note").text("عدد الارقام :" +phone.length);
            $("#add_winner").attr("disabled", true);

        }
    }
});

$( "#custmor_phone" ).keyup(function() {
    var phone= $('#custmor_phone').val();
    if(phone!='')
    {
        $.get( "<?php echo url .'/'.$this->folder ?>/get_customer_name_by_phone/"+phone, function(data) {
            $("#custmor_name").val(data);
        });
    }
});

$( "#add_winner" ).click(function() {
    var name = $('#custmor_name').val();
    var phone = $('#custmor_phone').val();
    var id_group = <?php echo $idGroup ?>;
    var  dataD={'name':name,'phone':phone,'id_group':id_group};
    if(phone!=''){
        $.get( "<?php echo url .'/'.$this->folder ?>/create_winners/",{ jsonData: JSON.stringify(dataD)}, function(data) {
            // console.log(data);
            if(data == 0){
                alert( "الرقم موجود");
                location.reload();
            }else{
                alert( "تمت الاضافة ");
                location.reload();
            }

            // $('#custmor_name').val() = '';
            // $('#custmor_phone').val() = '';

            // $('#example').DataTable().ajax.reload();
        });
    }else{
        alert("الرجاء ادخال رقم الزبون");
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

    input[type="text"]
    {
        border-radius: 6px;
        margin-top: 5px;
    }
    #add_winner{

        border-radius: 6px;
        margin-top: 28px;
        height:40px;
        width:6%;
        color: #ffff;
    }
</style>


<br>
<br>
<br>



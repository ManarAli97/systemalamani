

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('accountant') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات </li>

            </ol>
        </nav>

    </div>

    <div class="col-auto">
        <div style="cursor: pointer" onclick="sun_total_money()" class="sumAllMoney"  data-toggle="tooltip" data-placement="top" title="  اضغط هنا لعرض المجموع الكلي " >
            <span> حساب المجموع الكلي </span>
        </div>
    </div>


</div>

<script>

    function  sun_total_money () {
        $( ".sumAllMoney" ).html(`
         <span>  جاري  حساب المبلغ   : </span>  <img style="width:18px" src="<?php echo $this->static_file_site ?>/image/site/loding.gif">
        ` );
        $.get( "<?php  echo url .'/'.$this->folder ?>/sun_total_money", function( data ) {
            if (data)
            {
                $( ".sumAllMoney" ).html(`
         <span>  المبلغ الكلي   : </span> <span>  ${data}  </span> <span> د.ع</span>
        ` );
            }
        });
    }

</script>


<br>


<nav id="reloadPage">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>" ><span>قيد المحاسبة</span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy() ?>" >  <?php  echo $this-> all_notification_buy() ?>   </span></a>
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/accounting_made" > تمت المحاسبة</a>
		<?php  if ($this->permit('rest_amount_to_customer',$this->folder)) {  ?>
            <a class="nav-item nav-link active "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="باقي المبلغ الى الزبون"  href="<?php echo url .'/'.$this->folder ?>/minus" > <span>باقي المبلغ الى الزبون</span>  <i class="fa fa-undo">   </i> <span id="notif2" class="badge badge-danger" data-notif2="<?php  echo $this-> minus_notification_buy() ?>" >  <?php  echo $this-> minus_notification_buy() ?>   </span></a>
		<?php } ?>
		<?php  if ($this->permit('retrieval',$this->folder)) {  ?>
            <a class="nav-item nav-link  "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="قيد الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind" > <span>قيد الاسترجاع</span>     <i class="fa fa-undo">   </i> <span id="rewindNotifx" class="badge badge-danger" data-rewindNotif_data="<?php  echo $this-> rewindNotif() ?>" >  <?php  echo $this-> rewindNotif_buy() ?>      </a>
		<?php } ?>
		<?php  if ($this->permit('rewind_done',$this->folder)) {  ?>
            <a class="nav-item nav-link "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="تم الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind_done" > <span>تم الاسترجاع</span>       </a>
		<?php } ?>
        <?php  if ($this->permit('auto_print',$this->folder)) {  ?>
            <a class="nav-item nav-link "    data-toggle="tooltip" data-placement="top" title=" 1-بقاء هذة النافذة مفتوحة   <br> 2-يجب ضبط الطباعة وتحديد الطابعة من نافذة الطباعة في المتصفح <br> 3- ضبط kiosk mode للمتصفح"   data-html="true"  id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/auto_print" >  الطباعة التلقائه  للفواتير  </a>
        <?php } ?>
    </div>
</nav>



<div class="row">
    <div class="col-lg-3"  >

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php  if (!empty($count_active)) {  ?>
                <div class="userList">
                <div class="row">
                    <?php  foreach ($count_active as $result )  { ?>
                    <div class="col-12 " >
                        <a style="position: relative" class="infoCustomer ifactive" id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">
                            <div><?php echo $result['name'] ?>   (<?php echo $result['number_bill'] ?>) </div>
                            <div   style="direction: ltr;">

								<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
									<?php echo  $result['phone'] ?>
								<?php }else{ ?>
									<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
								<?php  }  ?>

                            </div>

                        </a>
                    </div>
                    <?php  }  ?>
                </div>
                </div>
                <?php } else {   ?>
                    <br>
                    <div class="alert alert-warning" role="alert">
                        لا توجد طلبات فيها استرجاع مبالغ الى الزبون
                    </div>
                <?php }  ?>
            </div>

        </div>


    </div>
    <div class="col-lg-9">
        <br>
        <div class="result"></div>
    </div>

</div>


<style>


    .userList {
        overflow-y: auto;
        border: 2px solid #cad8e6;
        padding: 4px;
        background: #fbfbfb;
        border-top: 0;
    }

    .infoCustomer
    {
        display: block;
        text-decoration: none;
        background: #ecedee;
        margin: 7px 0 7px 0;
        padding: 5px 14px;

    }
    .infoCustomer:hover
    {

        text-decoration: none;


    }
    .result {


        overflow-y: auto;
    }
    .thisActive
    {
        background: #adb !important;
        color: #ffffff;
    }
    .thisActive:hover
    {
        
        color: #ffffff;
    }
</style>


<script>

    $(document).ready(function() {
        $('.result_order').css('height',Number($('body').height()-175 )+'px')
        $('.userList').css('height',Number($('body').height()-175 )+'px')

    });


    var publicid='row';

    $(document).ready(function() {
        $('.result').css('height',Number($('body').height()-175 )+'px')

    });



    function getOrder(id,number_bill) {
        publicid="#row"+number_bill;
        $.get( "<?php  echo url .'/'.$this->folder?>/order_miuns/"+id+"/"+number_bill, function( data ) {
            $( ".result" ).html( data );
            $( ".ifactive" ).removeClass( 'thisActive' );
            $( "#row"+number_bill ).addClass( 'thisActive' );
        });
   }



    function action_minus(id,number_bill) {
        if (confirm('هل تريد فعلا استرجاع باقي المبلغ الى الزبون؟'))
        {
            $.get( "<?php  echo url .'/'.$this->folder?>/action_minus/"+id+"/"+number_bill,{note:$('#noteminus').val()}, function( data ) {

                console.log(data)
                if (data ==='true')
                {
                    alert('تم الاسترجاع');

                    window.location.reload()
                }else if (data==='-1')
                {
                    alert('المبلغ الذي معك غير كافي للسترجاع!');
                }
                else {
                       alert('حدثت مشكلة اعد المحاولة مرة ثانية')
                }

            });
        }else
        {
            return false;
        }

   }



    function number_bill_reload() {
            $(publicid).click();
    }



    toggleOn();
    function toggleOn() {
        $('.menuControl').css('display','none');
        $('#controlMenu').bootstrapToggle('on')
    }


    
    function reloadData() {

        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#reloadPage').children();
            $('#reloadPage').empty().html(founddata);
            $(publicid).addClass( 'thisActive' );
        });
    }
    
    
</script>

<style>


    .g_account
    {
        background: #4CAF50;
        color: #ffff;
        padding: 0 6px;
        border-radius: 15px;
        display: block;
    }

    .n_account
    {
        background: #000000;
        color: #ffff;
        padding: 1px 6px;
        border-radius: 15px;
        display: block;
    }


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




.bell_style
    {
        font-size: 33px;
        color: red;
        margin-top: -10px;
    }
    .number_req
    {
        position: absolute;
        top: -14px;
        width: 25px;
        height: 25px;
        background: #007bff;
        text-align: center;
        left: 4px;
        border-radius: 50%;
        font-weight: bold;
        color: #ffffff;
    }
    .set_text_table
    {
        text-align:center;
    }
</style>






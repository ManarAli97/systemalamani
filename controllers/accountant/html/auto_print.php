
<div class="hide_print">
<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

                    <ol class="breadcrumb"  >
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


<nav  id="reloadPage">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>" ><span>قيد المحاسبة</span> <span id="notif_order" class="badge badge-danger" ><?php  echo $this-> all_notification_buy() ?></span></a>
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/accounting_made" > تمت المحاسبة</a>

        <?php  if ($this->permit('rest_amount_to_customer',$this->folder)) {  ?>
        <a class="nav-item nav-link "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="باقي المبلغ الى الزبون"  href="<?php echo url .'/'.$this->folder ?>/minus" > <span>باقي المبلغ الى الزبون</span>  <i class="fa fa-undo">   </i> <span id="notification_minus" class="badge badge-danger"   ><?php  echo $this-> minus_notification_buy() ?></span></a>
        <?php } ?>
		<?php  if ($this->permit('retrieval',$this->folder)) {  ?>
            <a class="nav-item nav-link  "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="قيد الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind" > <span>قيد الاسترجاع</span>     <i class="fa fa-undo">   </i> <span id="rewindNotifx" class="badge badge-danger" ><?php  echo $this-> rewindNotif_buy() ?></span></a>
		<?php } ?>
		<?php  if ($this->permit('rewind_done',$this->folder)) {  ?>
        <a class="nav-item nav-link "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="تم الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind_done" > <span>تم الاسترجاع</span>       </a>
		<?php } ?>
        <?php  if ($this->permit('auto_print',$this->folder)) {  ?>
        <a class="nav-item nav-link  active" id="nav-home-tab"   data-toggle="tooltip" data-placement="top" title=" 1-بقاء هذة النافذة مفتوحة   <br> 2-يجب ضبط الطباعة وتحديد الطابعة من نافذة الطباعة في المتصفح <br> 3- ضبط kiosk mode للمتصفح"   data-html="true"  href="<?php echo url .'/'.$this->folder ?>/auto_print" > <span>  الطباعة التلقائة للفواتير   </span> <span id="auto_print" class="badge badge-danger" ><?php  echo $this->  all_notification_auto_print() ?></span> </a>
        <?php } ?>
    </div>
</nav>
</div>



<div class="row" >

    <div class="col-12">
        <div class="result"></div>
    </div>

</div>


<style>
    .user_account {
        border: 1px solid gainsboro;
        padding: 5px;
        background: white;
        color: #000;
    }

    .userList {
        overflow-y: auto;
        border: 2px solid #cad8e6;
        padding: 4px;
        background: #fbfbfb;
        border-top: 0;
    }

    .no_thing {
        display: block;
        background: #5b6d80;
        border-radius: 5px;
        color: #fff;
        margin: 4px 0;
        text-align: center;
    }



    .direct_bill
    {
        background: #e0a800 !important;
    }
    .thisActive.direct_bill
    {
        background:#1e88e5 !important;
    }

    .direct_user_name {
        background: black;
        color: #fff;
        padding: 0 13px 0 0;
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

    function getOrder(id,number_bill) {

        $( ".result" ).html( `<div class="loading_order"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>` );

        $.get( "<?php  echo url .'/'.$this->folder?>/view_order/"+id,{number_bill:number_bill}, function( data ) {
            $( ".result" ).html( data );
            if (print_bill_casher())
            {
                print_bill_casher()
                auto_print_bill();
                $( ".result" ).empty();
            }
        });

     }

    setInterval(function() {
        auto_print_bill();
    }, 10000);


    auto_print_bill();
    function auto_print_bill()
        {
            notifa=$('#auto_print').text();
            $.get( "<?php  echo url .'/'.$this->folder?>/auto_print_bill/", function( data ) {
                if ( Number(data) > 0  )
                {
                    $.get( "<?php  echo url .'/'.$this->folder?>/get_auto_print/", function( response ) {
                        if (response)
                        {

                            var  resp=JSON.parse(response);

                                $.get( "<?php  echo url .'/'.$this->folder?>/done_auto_print",{id:resp['id'],number_bill:resp['number_bill']}, function( done ) {
                                    if (done)
                                    {
                                        getOrder(resp['id'],resp['number_bill'])
                                        $('#auto_print').text(Number(data)-1);
                                    }

                                });

                        }
                    })

                }

            });
        }





    function number_bill_reload() {
        $(publicid).click();
}

    toggleOn();
    function toggleOn() {
        $('.menuControl').css('display','none');
        $('#controlMenu').bootstrapToggle('on')
    }


    var waitTime = 30 * 60 * 1000;
    setInterval(function() {
        window.location=''
    }, waitTime);





</script>

<style>

    .loading_order{
        text-align: center;
        padding: 25px;
    }
    .loading_order img{
        width: 100px;
    }

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






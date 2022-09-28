<div class="hide_print">

<br>

<div class="row   notShowInPrint">

    <div class="col">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/direct3_account"><?php  echo $this->langControl('direct') ?> </a></li>
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



    <nav id="reloadPage">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>/direct3_account" ><span>   قيد المحاسبة </span>  </a>
        <a class="nav-item nav-link active "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>/direct3" ><span>   قيد التجهيز    </span> <span id="notif_order" class="badge badge-danger" data-notif="<?php  $num= $this-> all_notification_buy3() ?>" ><?php  echo  $num ?></span></a>
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/prepared_made3" >   تم تجهيزها </a>
        <?php  if ($this->permit('retrieval',$this->folder)) {  ?>
            <a class="nav-item nav-link   "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="قيد الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind" > <span>قيد الاسترجاع</span>     <i class="fa fa-undo">   </i>   </a>
        <?php } ?>
        <?php  if ($this->permit('rewind_done',$this->folder)) {  ?>
            <a class="nav-item nav-link "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="تم الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind_done" > <span>تم الاسترجاع</span>       </a>
        <?php } ?>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/review" ><span>   مرتجع  </span> </a>
        <a class="nav-item nav-link  "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/rewind_cancel" > <span>   الغاء   مرتجع      </span> </a>

    </div>
</nav>
</div>
<div class="row">
    <div class="col-lg-3 notShowInPrint"  >


        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="userList">



                    <div class="input-group">

                        <input type="text" onkeyup="searchCustomer()" id="searchCustomer" name="search" class="form-control" autocomplete="off" placeholder="بحث فاتوره او الاسم او رقم الهاتف">
                        <div class="input-group-prepend" style="padding: 0;margin: 0">
                            <button id="btnWebCam" onclick="openWebCam()" class="btn" style="font-size: 21px;padding: 2px 8px 0 8px;margin: 0;background: #adc;"><i class="fa fa-qrcode"></i></button>
                        </div>
                    </div>



                    <div id="listSearch"></div>

                    <div id="listRoll" class="row">
                    <?php  foreach ($count_active as $result )  { ?>
                      <div class="col-12 " >
                        <a class="infoCustomer ifactive  <?php  if ($result['accountant'] ==1)echo 'direct_bill' ?>  " id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">
                            <div class='row align-items-center justify-content-between'>
                                <div class='col'>
                                    <div><?php echo $result['name'] ?>  (<?php  echo $result['number_bill']  ?>)</div>
                                    <div  style="direction: ltr;">

                                        <?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
                                            <?php echo  $result['phone'] ?>
                                        <?php }else{ ?>
                                            <?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
                                        <?php  }  ?>

                                    </div>
                                </div>
                                <?php  if ($result['user_direct']){ ?>
                                    <div class='col-auto'>
                                        <div class='user_account'>     <?php echo $this->UserInfoBill($result['user_direct']) ?> </div>
                                    </div>
                                <?php } ?>
                            </div>

							<?php  if ($result['accountant']==1) {  ?>
                                <div class="direct_user_name"> تمت المحاسبه من قبل المحاسب :<?php echo $result['id_accountant_user'] ?></div>
							<?php  } ?>

                        </a>
                    </div>
                    <?php  }  ?>
                    </div>
                </div>
                </div>

            </div>

        </div>

    <div class="col-lg-9">
        <div class="qr_web_cam">
            <div class="resultErrorcam"><span></span></div>
            <video id="webcam-preview"></video>
        </div>
        <style>

            .qr_web_cam
            {
                display: none;
            }
            #webcam-preview
            {
                width: 100% !important;
                height: 400px !important;
                border-radius: 5px;
            }
            .resultErrorcam
            {
                text-align: center;
                padding: 10px 4px;
            }
            .resultErrorcam span
            {
                text-align: center;
                color: #ffffFF;
                background: red;
                padding: 0 18px;
                border-radius: 5px;
            }


        </style>
        <div class="result"></div>
    </div>

</div>




<script>
    const codeReader = new ZXing.BrowserQRCodeReader();

    var closeWebCam=0;
    function openWebCam() {

        if (closeWebCam == 1)
        {
            $('.result').show();
            $('.qr_web_cam').hide()
            $('#btnWebCam').html('<i class="fa fa-qrcode"></i>').css({'background':'#adc','color':'#000'});
            $('#searchCustomer').val('').removeAttr('disabled').css({'background':'#fff','color':'#000'});

            closeWebCam = 0;
            codeReader.reset();
            codeReader.stopContinuousDecode();

        }else {
            $('.result').hide();
            $('.qr_web_cam').show()
            $('#btnWebCam').html('<i class="fa fa-times"></i>').css({'background':'red','color':'#fff'});
            $('#searchCustomer').val('كامرة QR تعمل ... ').attr('disabled','disabled').css({'background':'red','color':'#fff'});
            closeWebCam=1;
            codeReader.decodeFromVideoDevice(null, 'webcam-preview', (result, err) => {
                if (result) {
                    var audio = new Audio('<?php echo $this->static_file_site ?>/camera/qr.mp3');
                    audio.play();
                    $.get( "<?php  echo url .'/'.$this->folder ?>/search_new_qr_direct3_tz",{qr:result.text}, function( data ) {
                        if (data)
                        {
                            $('.result').show();
                            $('.qr_web_cam').hide()
                            $('#btnWebCam').html('<i class="fa fa-qrcode"></i>').css({'background':'#adc','color':'#000'});
                            $('#searchCustomer').val('').removeAttr('disabled').css({'background':'#fff','color':'#000'});

                            $( "#listRoll" ).empty();
                            $( "#listSearch" ).html( data );
                            $( ".active_order_by_qr" ).click();
                            console.log(result.text)
                            codeReader.reset();
                            codeReader.stopContinuousDecode();
                        }else
                        {
                            $('.resultErrorcam span').html('لاتوجد فاتورة');

                        }
                    });



                }

                if (err) {

                    if (err instanceof ZXing.NotFoundException) {
                        // console.log('No QR code found.')
                        $('.resultErrorcam span').html('لا يوجد رمز QR امام الكامرا ');

                    }

                    if (err instanceof ZXing.ChecksumException) {
                        $('.resultErrorcam span').html('تم العثور على رمز QR ، لكن قيمة قراءته لم تكن صالحة.');

                    }

                    if (err instanceof ZXing.FormatException) {

                        $('.resultErrorcam span').html('تم العثور على رمز QR ، لكنه كان بتنسيق غير صالح.');

                    }
                }
            })
        }
    }
    </script>


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
    .user_account {
        border: 1px solid gainsboro;
        padding: 5px;
        background: white;
        color: #000;
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




    function searchCustomer() {
        value=$('#searchCustomer').val();

        if (value)
        {
            $('#listSearch').show();
            $('#listRoll').hide();

            $.get( "<?php echo url .'/'.$this->folder  ?>/searchActive",{value:value}, function( data ) {
                $( "#listSearch" ).html( data );
            });

        }
        else
        {
            $('#listSearch').hide().empty();
            $('#listRoll').show()
        }

    }









    var publicid='row';

    $(document).ready(function() {
        $('.result').css('height',Number($('body').height()-175 )+'px')
        $('.userList').css('height',Number($('body').height()-175 )+'px')
    });



    function getOrder(id,number_bill) {

        if (publicid !== "#row"+number_bill) {
            $(".result").html(`<div class="loading_order"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
        }


        publicid="#row"+number_bill;
        $.get( "<?php  echo url .'/'.$this->folder?>/view_order3/"+id+"/"+number_bill, function( data ) {
            $( ".result" ).html( data );
            $( ".ifactive" ).removeClass( 'thisActive' );
            $( "#row"+number_bill ).addClass( 'thisActive' );
        });


        resetParmt()

}

    function  resetParmt() {


        serialList=[];
        thisCode='';
        code='';

    }



    setInterval(function() {
        checkNewOrder()

    }, 10000);


    function checkNewOrder()
    {
        notifx=$('#notif_order').text();

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order3backto/", function( data ) {
            if ( ( Number(data) > 0 && ( Number(data)  > Number(notifx))) || ( Number(notifx) > Number(data) )  )
            {
                $('#notif_order').text(data);
                $.get( "<?php  echo url .'/'.$this->folder?>/load_order/", function( response ) {
                    if (data)
                    {
                        $('#listRoll').html(response);
                        setTimeout(function () {
                            $(publicid).addClass( 'thisActive' );
                        },500)
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
    .form_add
    {
        display: none;
    }
</style>






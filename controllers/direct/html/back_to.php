


<div class="row align-items-center notShowInPrint">

    <div class="col">
        <br>
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('prepared') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات </li>

            </ol>
        </nav>

    </div>

    <br>
    <br>

</div>

<br>

<nav id="reloadPage">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/prepared_made3" >   تم تجهيزها </a>
        <a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>/direct3" ><span>  طلب جديد  </span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy3() ?>" >  <?php  echo $this-> all_notification_buy3() ?>   </span></a>
        <!--                <a class="nav-item nav-link active"  id="nav-profile-tab"    href="--><?php //echo url .'/'.$this->folder ?><!--/back_to" ><span>  تمت المحاسبة    </span> <span id="notif2" class="badge badge-danger" data-notif="--><?php // echo $this-> all_notification_buy3back() ?><!--" >  --><?php // echo $this-> all_notification_buy3back() ?><!--   </span></a>-->
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/review" ><span>   مرتجع  </span> </a>

    </div>
</nav>
<div class="row">
    <div class="col-lg-3 notShowInPrint" id="loadListRow"  >


        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <?php  foreach ($count_active as $result )  { ?>
                        <div class="col-12 " >
                            <a class="infoCustomer ifactive" id="row<?php echo $result['id'] ?>" href="#" onclick="getOrderbackto(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">
                                <div><?php echo $result['name'] ?></div>
                                <div  style="direction: ltr;">

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

        </div>


    </div>
    <div class="col-lg-9">
        <div class="result"></div>
    </div>

</div>


<style>
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
    var publicid='row';

    $(document).ready(function() {
        $('.result').css('height',Number($('body').height()-175 )+'px')

    });



    function getOrderbackto(id,number_bill) {
        publicid="#row"+id;
        $.get( "<?php  echo url .'/'.$this->folder?>/view_orderBackto/"+id+"/"+number_bill, function( data ) {
            $( ".result" ).html( data );
            $( ".ifactive" ).removeClass( 'thisActive' );
            $( "#row"+id ).addClass( 'thisActive' );
        });
    }


    function checkNewOrder()
    {

        notifx=$('#notif').attr('data-notif');

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order3/", function( data ) {
            if (Number(data) > 0 && Number(data)  > Number(notifx))
            {
                $.get(window.location.href, function (data) {
                    var founddata = $(data).find('#reloadPage').children();
                    $('#reloadPage').empty().html(founddata);


                    var founddataRow = $(data).find('#loadListRow').children();
                    $('#loadListRow').empty().html(founddataRow);

                    $(publicid).addClass( 'thisActive' );
                });
            }
        });


        notif2=$('#notif2').attr('data-notif');

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order3backto/", function( data ) {
            if (data > 0 && data > notif2)
            {
                $.get(window.location.href, function (data) {
                    var founddata = $(data).find('#reloadPage').children();
                    $('#reloadPage').empty().html(founddata);
                    $(publicid).addClass( 'thisActive' );
                });
            }
        });


    }



    setInterval(function() {
        checkNewOrder()
    }, 5000);



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






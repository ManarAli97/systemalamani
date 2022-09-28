

<div class="hide_print">
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


</div>



<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/prepared_made" >   تم تجهيزها </a>
        <a class="nav-item nav-link active"  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>" ><span>  قيد التجهيز   </span> <span id="notif_order" class="badge badge-danger"  ><?php  echo $this-> all_notification_buy() ?></span></a>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/review" ><span>   مرتجع  </span> </a>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/rewind_cancel" > <span>   الغاء   مرتجع      </span> </a>
    </div>
</nav>
</div>

<div class="row">
    <div class="col-lg-3 notShowInPrint" >


        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="userList">
                    <input type="text" onkeyup="searchCustomer()" id="searchCustomer" name="search" class="form-control" autocomplete="off" placeholder="بحث فاتوره او الاسم او رقم الهاتف">

                    <div id="listSearch"></div>

                    <div id="listRoll" class="row">
                    <?php  foreach ($count_active as $result )  { ?>
                    <div class="col-12 " >
                        <a class="infoCustomer ifactive" id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">

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



                        </a>
                    </div>
                    <?php  }  ?>
                </div>

                </div>
            </div>

        </div>


    </div>
    <div class="col-lg-9" style="padding-top: 5px">


      <?php  if ($this->permit('search_for_bill',$this->folder)) { ?>
            <form  id="fast_show_bill"  action="<?php echo url .'/'.$this->folder ?>/get_bill" method="get">
                <div class="row">
                    <div class="col-auto">
                        <input id="insert_bill"  placeholder="رقم الفاتورة" class="form-control" name="bill" required autocomplete="off">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">بحث</button>
                    </div>
                </div>
            </form>
        <hr>
        <script>

            $("#fast_show_bill").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $(".result").html(`<div class="loading_order"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);

               var number_bill = $('#insert_bill').val();

                $.ajax({
                    type: "GET",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        if (data)
                        {
                            $( ".result" ).html( data );
                            $( ".ifactive" ).removeClass( 'thisActive' );
                            $( "#row"+number_bill ).addClass( 'thisActive' );

                        }else
                        {
                            $( ".result" ).empty();

                            alert('لا توجد فاتورة')
                        }


                    }
                });


            });

        </script>

<?php  }  ?>
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
    .user_account {
        border: 1px solid gainsboro;
        padding: 5px;
        background: white;
        color: #000;
    }
    .form_add
    {
        display: none;
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
        $.get( "<?php  echo url .'/'.$this->folder?>/view_order/"+id+"/"+number_bill, function( data ) {
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

        function checkNewOrder()
        {

            notifx=$('#notif_order').text();

            $.get( "<?php  echo url .'/'.$this->folder?>/notification_order", function( data ) {
                if ( ( Number(data) > 0 && ( Number(data)  > Number(notifx))) || ( Number(notifx) > Number(data) )  )
                {
                    $('#notif_order').text(data);
                    $.get( "<?php  echo url .'/'.$this->folder?>/load_order", function( response ) {
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






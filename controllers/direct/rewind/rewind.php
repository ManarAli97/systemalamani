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
        <a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>/direct3_account" ><span>   قيد المحاسبة </span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy3_new() ?>" >  <?php  echo $this-> all_notification_buy3_new() ?>   </span></a>
        <a class="nav-item nav-link  "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>/direct3" ><span>   قيد التجهيز    </span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy3() ?>" >  <?php  echo $this-> all_notification_buy3() ?>   </span></a>
        <a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/prepared_made3" >   تم تجهيزها </a>
        <?php  if ($this->permit('retrieval',$this->folder)) {  ?>
            <a class="nav-item nav-link active "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="قيد الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind" > <span>قيد الاسترجاع</span>     <i class="fa fa-undo">   </i> <span id="rewindNotifx" class="badge badge-danger" ><?php  echo $this-> rewindNotif_buy() ?></span></a>
        <?php } ?>
        <?php  if ($this->permit('rewind_done',$this->folder)) {  ?>
            <a class="nav-item nav-link "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="تم الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind_done" > <span>تم الاسترجاع</span>       </a>
        <?php } ?>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/review" ><span>   مرتجع  </span> </a>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/rewind_cancel" > <span>   الغاء   مرتجع      </span> </a>
    </div>

</nav>

</div>

<div class="row">
	<div class="col-lg-3" id="loadListRow" >

		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
			<div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

				<div class="userList"  >
					<input type="text"  onkeyup="searchCustomer()" id="searchCustomer" name="search" class="form-control" autocomplete="off" placeholder="بحث عن الاسم او رقم الهاتف ">

					<div id="listSearch"></div>


                    <div class="row" id="listRoll">
                        <?php  foreach ($rewind_active as $result )  { ?>
                            <div class="col-12" >
                                <a style="position: relative" class="infoCustomer ifactive" id="row<?php echo $result['id_customre'] ?>" href="#" onclick="getRewind(<?php  echo $result['id_customre']  ?>,'<?php echo $result['number_bill_new'] ?>')">
                                    <div><?php echo $result['name'] ?>  </div>
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


	</div>
	<div class="col-lg-9">
		<div class="result"></div>
	</div>

</div>





<script>

	function delete_item(id_item,id_customer,number_bill_new) {

	    if (confirm('هل انت منأكد؟')) {
            $.get("<?php  echo url . '/' . $this->folder ?>/delete_item_rewind/" + id_item + "/" + id_customer, function (data) {

                if (data === 'true') {
                    getRewind(id_customer,number_bill_new)
                } else if (data === 'true0') {
                    $('.result').empty();
                    $('#row' + id_customer).remove();
                } else {
                    $('.result').empty();
                    $('#row' + id_customer).remove();
                }

            });

        }else return false;

    }

</script>


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


    function getRewind(id,number_bill) {

        publicid="#row"+id;
        $.get( "<?php  echo url .'/'.$this->folder?>/view_rewind3/"+id+"/"+number_bill, function( data ) {

            $( ".result" ).html( data );
            $( ".ifactive" ).removeClass( 'thisActive' );
            $( "#row"+id ).addClass( 'thisActive' );
        });

    }



    setInterval(function() {
        checkNewOrder()
    }, 5000);


    function checkNewOrder()
    {
        notifx=$('#notif_order').text();
        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order/", function( data ) {
            if ( ( Number(data) > 0 && ( Number(data)  > Number(notifx))) || ( Number(notifx) > Number(data) )  )
            {
                $('#notif_order').text(data);

            }

        });
    }

    function checkNewOrder2()
    {

        notif=$('#notification_minus').text();
        $.get( "<?php  echo url .'/'.$this->folder?>/notification_minus/", function( data ) {
            if ( ( Number(data) > 0 && ( Number(data)  > Number(notif))) || ( Number(notif) > Number(data) )  )
            {
                $('#notification_minus').text(data);
            }
        });

    }


    function rewindNotif_data()
    {

        rewindNotif=$('#rewindNotifx').text();
        $.get( "<?php  echo url .'/'.$this->folder?>/rewindNotif/", function( datar ) {
            if ( ( Number(datar) > 0 && ( Number(datar)  > Number(rewindNotif))) || ( Number(rewindNotif) > Number(datar) )  )
            {
                $('#rewindNotifx').text(datar);
            }
        });
    }



    setInterval(function() {
        rewindNotif_data()
        checkNewOrder2()
    }, 15000);






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




    function searchCustomer() {
        value=$('#searchCustomer').val();

        if (value)
        {
            $('#listSearch').show();
            $('#listRoll').hide();

            $.get( "<?php echo url .'/'.$this->folder  ?>/rewind_search_new3",{value:value}, function( data ) {
                $( "#listSearch" ).html( data );
            });

        }
        else
        {
            $('#listSearch').hide().empty();
            $('#listRoll').show()
        }

    }



    $(document).ready(function() {
        $('.result_order').css('height',Number($('body').height()-175 )+'px')
        $('.userList').css('height',Number($('body').height()-175 )+'px')

    });


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


    .userList {
        overflow-y: auto;
        border: 2px solid #cad8e6;
        padding: 4px;
        background: #fbfbfb;
        border-top: 0;
    }

</style>






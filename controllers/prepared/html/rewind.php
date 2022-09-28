


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



<nav id="reloadPage">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		<a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/prepared_made" >   تم تجهيزها </a>
		<a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>" ><span>  قيد التجهيز   </span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy() ?>" >  <?php  echo $this-> all_notification_buy() ?>   </span></a>
		<a class="nav-item nav-link active"  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/review" ><span>   مرتجع  </span> </a>
        <a class="nav-item nav-link "  id="nav-review-tab"    href="<?php echo url .'/'.$this->folder ?>/rewind_cancel" > <span>   الغاء   مرتجع      </span> </a>

    </div>
</nav>

<br>

<form id="reviewForm" action="<?php  echo url .'/'.$this->folder?>/item_review" method="post">
<div class="row align-items-end">




	<div class="col-auto search_rewind">
		<label>اسم الزبون او رقم الهاتف</label>
		<input   type="text" onkeyup="searchCustomerinfo()" id="searchCustomer" name="search" class="form-control" autocomplete="off"  >
		<input id="id_costumer" type="hidden" name="id_costumer">
		<div id="listSearch"></div>

	</div>

	<div class="col-auto search_rewind">
	 <label>رقم الفاتورة</label>
		<input type="text"  id="number_bill"  name="number_bill" class="form-control" autocomplete="off"  >
	</div>

	<div class="col-auto search_rewind">
	 <label>  الباركود او السيريال  </label>
		<input type="text" id="serial"  name="serial" class="form-control" autocomplete="off" >
	</div>

	<div class="col-auto search_rewind">
	 <label>   من تاريخ  </label>
		<input type="date" id="fromDate"  name="fromDate" class="form-control" autocomplete="off" >
	</div>

	<div class="col-auto search_rewind">
	 <label>   الى تاريخ  </label>
		<input type="date" id="toDate"  name="toDate" class="form-control" autocomplete="off" >
	</div>


</div>
<hr>
    <div class="text-center">


            <button id="search_item"   type="submit" class="btn btn-warning" name="submit">بحث</button>

            <button type="button"  class="btn btn-danger" onclick="emptyTeble()"><i class="fa fa-times"></i> </button>

<br>
<br>
    </div>

</form>
<!--<input id="id_costumer2" type="hidden" name="id_costumer">-->
<form  id="insert_item_review" action="<?php  echo url .'/'.$this->folder?>/insert_item_review" method="post" >

<label for="note_review">سبب المرتجع</label>
    <textarea id="note_review" class="form-control mb-3"  name="note_review" placeholder="سبب المرتجع" required ></textarea>

	<table class="table table-striped table-bordered text-center">
		<tbody>
		<tr>
			<th style="width: 100px !important;">#</th>
			<th style="width: 100px !important;">id</th>
			<th>اسم الزبون</th>
			<th>صورة</th>
			<th>اسم المادة</th>
			<th>الباركود</th>
			<th>السيريالات</th>
			<th>سيريال التجهيز</th>
			<th>لون المادة</th>
			<th>سعر الشراء</th>
			<th>السعر الحالي</th>
			<th>تاريخ الشراء</th>
			<th> المستودع  </th>
			<th> ملاحظة  </th>
			<th>حذف</th>
		</tr>
		</tbody>
		<tbody class="rowData">
		<tr  class="lodingRow"><td colspan="11" style="text-align: center">  <img   width="50" src="<?php echo $this->static_file_site ?>/image/site/loding.gif"> </td> </tr>

		</tbody>


	</table>

	<div id="send_item" class="text-center">
		<hr>
		<button id="sendtable" type="submit" name="submit" class="btn btn-success">موافق</button>
	</div>

</form>

<br>
<br>

<script>

	  count=1;
    $("#reviewForm").submit(function(e) {

		if ($("#searchCustomer").val() || 	$("#number_bill").val() || $("#serial").val() ) {

            $('.rowData tr.lodingRow').show();
            $('#search_item').attr('disabled', 'disabled')
            $('#send_item').show();
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize() + "&count=" + count, // serializes the form's elements.
                success: function (data) {

                    		console.log(data)
                    if (data) {
                        $('.rowData tr.lodingRow').hide();
                    }
                    if (data === '0') {
                        alert('لا توجد مادة')
                        $('#search_item').removeAttr('disabled')
                    } else {
                        $('.rowData').append(data);
                        count++;
                        $('#search_item').removeAttr('disabled')
                    }

                    chRowReview()
                }
            });

        }
		else
		{
		    alert('يجب ملئ حقل واحد على الاقل')
			return false;
		}
    });

    $("#insert_item_review").submit(function(e) {

		$('#sendtable').attr('disabled','disabled');
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                console.log(data)

                if (data === 'serial_note_found')
                {

                    alert('يرجى التحقق من السيريلات المدخلة غير مطابقة')
                    $('#sendtable').removeAttr('disabled')
                } else   if (data ==='0')
                {
				    alert('حدثت مشكلة');
                    $('#sendtable').removeAttr('disabled')
				}else
				{
				    alert("تم انشاء فاتورة مرتجع .يرجى توجية الزبون الى المحاسب");
				 window.location="<?php echo url .'/'.$this->folder ?>/review"
				}
                chRowReview();

             }
        });


    });


    function chRowReview() {

        if ($(".rowData tr").hasClass('haveData_review'))
		{
			$('#send_item').show()
		}else {
            $('#send_item').hide()
		}

    }



    function removerow(row) {
		$('#x'+row).remove();
        chRowReview()
    }



    function emptyTeble() {
        $('.rowData').empty();
        count=1;
        $('#send_item').hide();
    }



    var publicid='row';

    $(document).ready(function() {
        $('.result').css('height',Number($('body').height()-175 )+'px')

    });




    function checkNewOrder()
    {

        notifx=$('#notif').attr('data-notif');

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order/", function( data ) {
            if (Number(data) > 0 && Number(data)  > Number(notifx))
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





    toggleOn();
    function toggleOn() {
        $('.menuControl').css('display','none');
        $('#controlMenu').bootstrapToggle('on')
    }



    function searchCustomerinfo() {
        value=$('#searchCustomer').val();

        if (value)
        {
            $('#listSearch').show();
            $('#listRoll').hide();

            $.get( "<?php echo url .'/'.$this->folder  ?>/search_rewind",{value:value}, function( data ) {
                $( "#listSearch" ).html( data );
            });

        }
        else
        {
            $('#id_costumer').val('');
            $('#id_costumer2').val('');
            $('#listSearch').hide().empty();
            $('#listRoll').show()
        }

    }

    function getOrder_search_rewind(e) {

        $('#id_costumer').val($(e).data('id'));
        $('#id_costumer2').val($(e).data('id'));
        $('#searchCustomer').val($(e).data('name')+' - '+$(e).data('phone'));
        $('#listSearch').hide().empty();
    }



      function add_comma(e)
      {
          valu=$(e).val();
          $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      }






</script>

<style>
	.lodingRow
	{
		display: none;
	}

	#send_item
	{
		display: none;
	}
	.col-auto.search_rewind {
		margin-bottom: 12px;
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

	div#listSearch {
		max-height: 310px;
		overflow: auto;
		position: absolute;
		width: 92%;
		background: #fff;
		z-index: 150000;
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


	.review_back td
	{
		background: #dc3545 !important;
		color: #ffffff;
	}

    .review_back_wait td
    {
        background: #ffc107 !important;
        color: #000000;
    }


</style>






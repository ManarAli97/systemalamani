<div class="hide_print">

<table class="table table-striped table-dark set_text_table"  style="margin-top: 10px" >
	<thead>
	<tr>

		<th scope="col">الاسم </th>
		<th scope="col">حالة الزبون </th>
		<th scope="col"> الموبايل </th>
		<th scope="col">  المحافظة </th>
		<th scope="col"> العنوان </th>

	</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo $result['name'] ?>  </td>
		<td    style="background: <?php  if ($result['type_customer_12'] == 1)  echo '#4CAF50'; else echo 'red';?> "> <?php echo $result['type_customer'] ?>   </td>
		<td>   <div  style="direction: ltr;">

				<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
					<?php echo  $result['phone'] ?>
				<?php }else{ ?>
					<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
				<?php  }  ?>

			</div>
		</td>
		<td> <?php echo $result['city'] ?>  </td>
		<td> <?php echo $result['address'] ?>  </td>
	</tr>

	</tbody>
</table>

<hr>


<table class="table table-striped table-bordered text-center">
	<tbody>
	<tr>
		<th style="width: 100px !important;">#</th>
		<th>اسم حساب الموظف</th>
		<th>صورة</th>
		<th>اسم المادة</th>
		<th>الباركود</th>
		<th>لون المادة</th>
		<th>  الكمية </th>
		<th>سعر المرتجع </th>
		<th> السعر الحالي </th>
		<th>تاريخ الشراء</th>
		<th>  ملاحظة </th>


	</tr>
	</tbody>
	<tbody>

<?php foreach ($rewind_active as $key=> $item) { ?>
	<tr>
		<td> <?php echo $key+1 ?>  </td>
		<td><?php  echo  $item['username'] ?></td>
		<td><img width="40" src="<?php echo $this->save_file . $item['image'] ?>"></td>
		<td><?php  echo  $item['item_name'] ?></td>
		<td><?php  echo $item['code'] ?></td>
		<td><?php  echo $item['color'] ?></td>
		<td><?php  echo $item['number'] ?></td>
		<td><?php  echo number_format($item['price_new']) ?>  د.ع </td>
		<td><?php  echo $item['now_price'] ?>   </td>
		<td>   <?php echo  date('Y-m-d h:i:s A',$item['date_buy'])  ?> </td>
		<td><?php  echo $item['note'] ?></td>

	</tr>

	<?php  } ?>
<tr class="sum_bill">
	<td style="text-align: right" colspan="7">  مجموع المبلغ المرتجع  </td>
	<td> <strong> <?php echo number_format( $price )  ?>   د.ع  </strong> </td>
	<td>   </td>
	<td>   </td>
	<td>   </td>


</tr>
	</tbody>


</table>


<hr>


<div class="text-center">
	 <button id="stopClick"   onclick="cancel_rewind()" class="btn btn-success">الغاء المرتجع</button>


</div>
<br>
<br>
<br>
</div>


<script>


    function cancel_rewind() {
        if(confirm('هل انت متأكد من الغاء الاسترجاع ? ')) {
            $.get("<?php echo url . '/' . $this->folder ?>/cancel_rewind/<?php echo $id ."/". $number_bill?>", function (data) {
                if (data)
				{
				    alert('تم الغاء الاسترجاع')
                    window.location=''

				}else
				{
                    alert(' حدثت مشكلة اعد المحاولة ')
				}

            });
        } return false
    }



    function print_bill_sale_sale() {
        $('.print_bill_casher'). removeClass('casher');
        $('.print_bill_sale'). addClass('sale');

        window.print();
    }

</script>


<style>


	.sum_bill td
	{
		background:#cce5ff;
	}

</style>



<style>
    .not_prepared td{
        background-color: gainsboro !important;
    }

    .progs_d_x
    {
        display: none;
    }
    .progs_r_x
    {
        display: none;
    }

    .image_prod
    {
        width: 50px;
        height: 50px;
    }


    .color_item_table
    {
        width: 27px;
        height: 27px;
        display: block;
    }
    .error{
        color: red;
    }

    .set_text_table
    {
        text-align:center;
    }


    .note_prepared
    {
        font-size:26px ;
        color: red !important;
    }
    .done_prepared
    {
        font-size:26px ;
        color: green !important;
    }
    .note_prepared:before
    {

        color: red !important;
    }
    .done_prepared:before
    {

        color: green !important;
    }

    .notMyModel
    {
        opacity: 0.3;
    }


    .image_prod
    {

        height: 50px;
    }




    .color_item_table
    {
        width: 27px;
        height: 27px;
        display: inline-block;
    }
    .error{
        color: red;
    }

    .set_text_table
    {
        text-align:center;
    }
    .btn_tajhez
    {
        width: 100%;
        background: #17a2b8;
        margin: 0;
        color: #fff;
    }



    #addLocation
    {
        display: none;
    }


    #addLocationSerial
    {
        display: none;
    }



    .user_sale
    {
        margin: 5px 0;
    }

    .title_company
    {
        margin-bottom: 5px !important;
    }
    .title_company img
    {
        width: 100%;
    }

    .customer_mohtram.customer_name {
        margin-bottom: 15px;
    }


    .print_bill_sale
    {
        margin-top: 92px !important;
        padding: 8px;
        display: none;

    }


    .print_bill_casher
    {
        padding: 8px;
        display: none;

    }




    .customer_name
    {
        font-size: 18px;
        font-weight: bold;
    }

    .image_prod
    {
        height: 50px;
    }

    .tableBill.table-bordered tr td {
        border: 4px solid black !important;
        padding: 2px 5px;
        vertical-align: inherit;

    }

    .tableBill_casher.table-bordered tr td {
        border: 5px solid black !important;

    }

    table.requ_on td  {
        vertical-align: middle;
    }

    @media print {

        @page {
            size: A5; /* DIN A4 standard, Europe */
            margin:0;
        }

        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

        }
        .hide_print
        {
            display: none;
        }
        .fixed-top,.down_fixed,.notShowInPrint,.menuControl
        {
            height: 0;
            display: none;
        }


        .result
        {
            height: auto !important;
            overflow: unset !important;
        }

        .bodyControl
        {
            overflow: unset;
        }

        .footer_bill
        {
            margin-top:30px ;
        }

        .print_bill_sale.sale {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill_sale.sale * {
            position: relative;
            visibility: visible;
        }


        .print_bill_casher.casher {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill_casher.casher * {
            position: relative;
            visibility: visible;
        }


        .footer
        {
            display:  none;
        }

    }




</style>



<style>

    .user_sale
    {
        margin: 5px 0;
    }

    .title_company
    {
        margin-bottom: 15px !important;
    }
    .title_company img
    {
        width: 100%;
    }

    .customer_mohtram.customer_name {
        margin-bottom: 15px;
    }


    .print_bill_sale
    {
        margin-top: 92px !important;
        padding: 8px;
        display: none;

    }


    .print_bill_casher
    {
        padding: 8px;
        display: none;

    }




    .customer_name
    {
        font-size: 18px;
        font-weight: bold;
    }

    .image_prod
    {
        height: 50px;
    }

    .tableBill.table-bordered tr td {
        border: 2px solid black !important;
        padding: 2px 5px;
        vertical-align: inherit;
    }

    .tableBill_casher.table-bordered tr td {
        border: 2px solid black !important;

    }

    table.requ_on td  {
        vertical-align: middle;
    }

    @media print {

        @page {
            size: A5; /* DIN A4 standard, Europe */
            margin:0;
        }

        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

        }
        .hide_print
        {
            display: none;
        }
        .fixed-top,.down_fixed,.notShowInPrint,.menuControl
        {
            height: 0;
            display: none;
        }


        .result
        {
            height: auto !important;
            overflow: unset !important;
        }

        .bodyControl
        {
            overflow: unset;
        }

        .footer_bill
        {
            margin-top:30px ;
        }

        .print_bill_sale.sale {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill_sale.sale * {
            position: relative;
            visibility: visible;
        }


        .print_bill_casher.casher {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill_casher.casher * {
            position: relative;
            visibility: visible;
        }


        .footer
        {
            display:  none;
        }

    }




</style>




























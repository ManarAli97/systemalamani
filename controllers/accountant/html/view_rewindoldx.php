


<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale">
            <?php  if (!empty($rewind_active)) { ?>

                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-7 col-sm-7 col-7">
                        <div class="customer_name">
                            <span>  حضرة السيد   :</span> <span>  <?php echo $result['name'] ?> </span>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-5 col-5">
                        <div class="customer_name">
                            <span>المحترم</span>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-7 col-sm-7 col-7">
                        <div class="date_and_type_pay customer_name">


                            <div class="row justify-content-between">



                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <span>التاريخ:</span> <span> <?php echo date('d-m-Y',time())  ?> </span>
                                    <span>الوقت:</span> <span>  <?php echo date('h:i A',time())  ?></span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span>   مرتجع  </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-5 col-5">


                        <div class="barcode_image">
                            <div class="row align-items-center">
                                <div class="col-auto customer_name">
                                    رقم القائمة:
                                </div>
                                <div class="col-auto">
                                    <svg class="barcode"></svg>
                                </div>
                            </div>
                            <script>

                                JsBarcode(".barcode", "<?php echo $number_bill ?>", {
                                    height: 40,
                                    displayValue: true
                                });

                            </script>
                        </div>

                    </div>


                </div>

                <table class="table tableBill table-bordered  "   >

                    <tbody>

                    <tr>
                        <td style="width: 100px;">  رمز المادة </td>
                        <td>اسم المادة</td>
                        <td style="width: 40px;"> اللون  </td>
                        <td style="width: 40px;">  الكمية </td>

                        <td style="width: 100px;">السعر</td>
                        <td style="width: 160px;">السعر الاجمالي</td>

                    </tr>

                    <?php   foreach ($rewind_active as $rows)  {  ?>
                        <tr  >
                            <td style="font-size:20px" ><?php  echo $rows['code'] ?></td>
                            <td  ><?php  echo $rows['item_name'] ?></td>
                            <td><?php  echo $rows['color']   ?>  </td>
                            <td><?php  echo $rows['number'] ?></td>
                             <td style="font-size:21px" ><?php  echo number_format($rows['price_new']) ?>  د.ع </td>
                            <td style="font-size:21px" ><?php  echo number_format((int)trim(str_replace($this->comma,'',$rows['price_new'])) * (int)$rows['number'])    ?>  </td>


                        </tr>

                    <?php  }  ?>


                    </tbody>
                </table>


                <div class="row justify-content-between">

                    <div class="col" >

                        <div class="row">
                            <div class="col-auto">

                                <div class="sumbill_denar">
                                    <span>   مجموع القائمة دينار  : </span> <span> <?php echo number_format( $price )  ?> </span>
                                </div>
                            </div>
                            <div class="col-auto">

                                <div class="amonut_write">
                                    <span>    المبلغ فقط  : </span> <span id="write_amount"></span>
                                </div>


                                <script>
                                    main ();
                                    function main (){

                                        document.getElementById ("write_amount").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price))  ?>);
                                        document.getElementById ("write_amount2").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price))  ?>);

                                    }
                                </script>

                            </div>
                        </div>

                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <span> عدد الانواع:</span>  <span> <?php echo $number_type ?> </span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <span> مجموع المواد: </span> <span> <?php echo $sum_material ?> </span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <span>منضم الفاتورة:</span> <span> <?php echo $_SESSION['usernamelogin'] ?> </span>
                            </div>
                        </div>


                    </div>

                    <div class="col-auto">
                        <svg class="barcode_amount"></svg>
                        <script>

                            JsBarcode(".barcode_amount", "<?php echo $price    ?>", {
                                height: 40,
                                displayValue: true
                            });

                        </script>
                    </div>
                </div>


                <div style="border-top:1px solid #5a5a5a;padding-top: 5px " class="text-center">


                    <div style="font-size: 16px !important;">
                        نسعى دوما بأن تكون تجربة جميع زبائننا معنا تتحقق مقولتنا
                        "وعند الاماني تتحقق الاماني"
                    </div>

                    <div style="font-size: 14px !important;">
                        حال وجود اي ملاحظات نرجو ارسالها عبر السوق الالكتروني لشركتنا:
                        <span style="font-size: 18px !important;font-weight: bold"> www.alamani.iq</span>
                        لكم منا جزيل الشكر والامتنان
                    </div>


                </div>



            <?php   }  ?>
        </div>

    </div>
</div>







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
		<th>  الغاء  </th>

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
		<td><?php  echo number_format($item['price_new']) ?>  </td>
		<td><?php  echo $item['now_price'] ?>   </td>
		<td>   <?php echo  date('Y-m-d h:i:s A',$item['date_buy'])  ?> </td>
		<td><?php  echo $item['note'] ?></td>
		<td>
		<button class="btn btn-danger" type="button"   onclick="delete_item(<?php echo $item['id'] ?>,<?php echo $result['id'] ?>,'<?php echo $item['number_bill_new'] ?>')" ><i class="fa fa-times"></i> </button>
		</td>
	</tr>

	<?php  } ?>
<tr class="sum_bill">
	<td style="text-align: right" colspan="7">  مجموع المبلغ المرتجع  </td>
	<td> <strong> <?php echo number_format( $price )  ?>   د.ع  </strong> </td>
	<td>   </td>
	<td>   </td>
	<td>   </td>
	<td>   </td>

</tr>
	</tbody>


</table>


<hr>


<div class="text-center">
	 <button id="stopClick"   onclick="success_rewind()" class="btn btn-success">موافق</button>
    <button class="btn btn-primary"     id="bill_sale" onclick="print_bill_sale_sale()"> <i class="fa fa-print"></i> <span> طباعة فاتورة  مرتجع  </span></button>
    <button id="stopClick_cancel"   onclick="cancel_rewind(<?php echo $result['id'] ?>)" class="btn btn-danger">الغاء الاسترجاع</button>


</div>
<br>
<br>
<br>
</div>


<script>

    function success_rewind() {

        $('#stopClick').attr('disabled','disabled');

        if(confirm('هل انت متأكد من الاسترجاع؟'))
        {
            $.get( "<?php  echo url .'/'.$this->folder?>/success_rewind",{id:<?php echo  $result['id']  ?>,number_bill:<?php echo  $number_bill  ?>}, function( dataxx ) {


                if (dataxx==='1')
                {
                    print_bill_sale_sale();

                    $( ".result" ).empty();
                    $( "#row"+<?php echo  $result['id']  ?>).remove();
                    alert('تمت دفع المرتجع الى الزبون')

                } else if (dataxx==='-1')
                {
                    $('#stopClick').removeAttr('disabled')
                    alert(' لا يوجد لديك مبلغ كافي للسترجاع ')

                }else {
                    $('#stopClick').removeAttr('disabled')
                    alert('حدثت مشكلة برجى اعادة تحميل الصفحة')
                }

            });
        }else
        {
            $('#stopClick').removeAttr('disabled')
            return false;
        }

    }


    function cancel_rewind(id) {
        if(confirm('هل انت متأكد من الغاء الاسترجاع ? ')) {
            $.get("<?php echo url . '/' . $this->folder ?>/cancel_rewind/" + id+"/<?php echo $number_bill?>", function (data) {

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




























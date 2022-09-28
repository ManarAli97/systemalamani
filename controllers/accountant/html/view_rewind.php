<div class="row">
    <div class="col-sm-12 col-12 python_print" style="padding: 3px">
        <div class="print_bill_casher">
            <?php  if (!empty($rewind_active)) { ?>
                <div class="title_company">

                    <img src="<?php echo $this->static_file_site ?>/image/site/bill_title3.png">
                </div>
                <div style="text-align: left;margin-bottom: 5px;font-size: 18px" > <span>السوق الالكتروني</span>  <span>  alamani.iq  </span> </div>





                <table  style="width: 100%;border-collapse: collapse;"  >
                    <tbody>

                    <tr>

                        <td style="text-align: right; ;font-size: 18px;"  >
                            <div class="date_bill">  <span>التاريخ: </span>  <span> <?php echo date('d-m-Y',time())  ?> </span> </div>
                            <div class="time_bill"><span>الوقت:</span> <span> <?php echo date('h:i A',time())  ?> </span> </div>
                        </td>
                        <td style="text-align: left; ">
                            <span><svg class="barcode"></svg></span> <span>:NO</span>
                            <script>

                                JsBarcode(".barcode", "<?php echo $number_bill ?>", {
                                    height: 40,
                                    displayValue: true
                                });

                            </script>
                        </td>

                    </tr>

                    </tbody>
                </table>




                <div class="customer_name" style="margin-bottom: 15px;font-size: 20px;" >

                    <span> حضرة السيد: </span> <span>  <?php echo $result['name'] ?>  </span>

                </div>



                <div style="text-align: center;margin-bottom: 15px;font-weight: bold;font-size: 18px">
                    مرتجع
                </div>
                <table border='1' class="  tableBill  tableBill_casher  table-bordered  "  style="width: 100%;border-collapse: collapse;"   >

                    <tbody>
                    <tr>
                        <td style="width: 100px;  padding : 0.75rem !important;font-weight: bold;font-size: 20px;">  رمز المادة </td>
                        <td  style='padding : 0.75rem !important;font-weight: bold;font-size: 20px;'>اسم المادة</td>
                        <td style="width: 40px;padding : 0.75rem !important;font-weight: bold;font-size: 20px;"> اللون  </td>
                        <td style="width: 40px;padding : 0.75rem !important;font-weight: bold;font-size: 20px;">  الكمية </td>

                        <td style="width: 100px;padding : 0.75rem !important;font-weight: bold;font-size: 20px;">السعر</td>


                    </tr>
                    <?php   foreach ($rewind_active as $rows)  {  ?>
                        <tr  >
                            <td style="padding : 0.75rem !important;font-size: 18px;" ><?php  echo $rows['code'] ?></td>
                            <td   style='padding : 0.75rem !important;font-size: 18px;'><?php  echo $rows['item_name'] ?></td>
                            <td  style='padding : 0.75rem !important;font-size: 18px;'><?php  echo $rows['color']   ?>  </td>
                            <td  style='padding : 0.75rem !important;font-size: 18px;'><?php  echo $rows['number'] ?></td>
                            <td style="padding : 0.75rem !important;font-size: 18px;" ><?php  echo number_format($rows['price_new']) ?>    </td>


                        </tr>

                    <?php  }  ?>
                    </tbody>
                </table>


                <table style="width: 100%;border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <td   style=' font-size: 18px;'  > <span>    عدد المواد: </span> <span>  <?php echo  $number_type ?>  </span></td>
                        <td    style=' font-size: 18px;'   > <span>     مجموع الكمية: </span> <span>  <?php echo  $sum_material ?>  </span></td>

                        <td    style=' font-size: 18px;'  ><span>البائع:</span> <span>  <?php echo $_SESSION['usernamelogin'] ?>  </span></td>
                    </tr>
                    </tbody>
                </table>



                <div   style="margin: 15px 0 ;font-size: 24px" >
                    <span>  مجموع الفاتورة: </span> <span> <?php echo  number_format($price)  ?></span> <span> دينار </span>

                </div>

                <div style="text-align: center">
                    <svg class="barcode_amount"></svg>
                </div>
                <script>

                    JsBarcode(".barcode_amount", "<?php echo number_format($price)     ?>", {
                        height: 40,
                        displayValue: true
                    });

                </script>
                <div style="margin: 15px 0;margin-bottom: 35px; font-size: 18px;" >
                    <span>     المبلغ فقط: </span> <span id="write_amount2"> </span> <span> دينار </span>
                    <script>
                        main ();
                        function main (){

                            document.getElementById ("write_amount2").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price))  ?>);

                        }
                    </script>
                </div>

                <hr>
                <div  style="text-align: center">

                    <div style="padding: 2px"> نسعى دوما بأن تكون تجربة جميع زبائننا معنا تتحقق مقولتنا  </div>
                    <div style="padding: 2px">  "وعند الاماني تتحقق الاماني"   </div>
                    <div style="padding: 2px"> حال وجود اي ملاحظات نرجو ارسالها عبر السوق الالكتروني لشركتنا:  </div>
                    <div style="font-size: 28px; padding: 2px">  alamani.iq  </div>
                    <div style="font-size: 24px;padding: 2px"> او الاتصال بخدمة الزبائن 6007 </div>
                    <div style="font-size: 24px;padding: 2px"> لكم منا جزيل الشكر والامتنان  </div>


                </div>
                <div style="border-top:1px solid #5a5a5a;margin-top:15px;padding-top: 5px;font-size: 18px !important;font-weight:bold  " class="text-center">

                    زبائننا الكرام ، كي يسهل عليكم ركن دراجاتكم او سياراتكم ننصحكم عند زيارتنا الدخول من الباب الخلفية للشركة

                </div>
            <?php  } ?>
        </div>
    </div>
</div>


<div class="hide_print">



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
		<th>تاريخ البيع</th>
		<th>تاريخ المرتجع</th>
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
		<td>   <?php echo  date('Y-m-d h:i:s A',$item['date'])  ?> </td>
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
	<td>   </td>

</tr>
	</tbody>


</table>


<hr>


<div class="text-center">
	 <button id="stopClick"   onclick="success_rewind()" class="btn btn-success">موافق</button>
    <button class="btn btn-primary"     id="bill_sale" onclick="print_bill_casher()"> <i class="fa fa-print"></i> <span> طباعة فاتورة  مرتجع  </span></button>
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


                console.log(dataxx)
                if (dataxx==='1')
                {
                    print_bill_casher();

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



    function print_bill_casher() {


        <?php if ($_SESSION['print']) {   ?>



        var bill = $('.python_print').html();

        $.post( "<?php  echo url  ?>/bill_print",{bill:bill}, function( data ) {
            if (data)
            {

                $('.body_print_bill'). hide();
                $('.result'). empty();

            }else{
                $('.spinner'). hide();
                alert('لا يمكن الطباعة')
            }

        });

        <?php  } else{  ?>

        $('.print_bill_sale'). removeClass('sale');
        $('.print_bill_casher'). addClass('casher');

        window.print();


        <?php  } ?>


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
            top: 0;
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




























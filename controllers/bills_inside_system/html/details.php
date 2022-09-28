
<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale" style="display: none">
            <?php  if (!empty($request)) { ?>

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
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <span>التاريخ:</span> <span> <?php echo date('d-m-Y',$date)  ?> </span>
                                    <span>الوقت:</span> <span>  <?php echo date('H:i',$date)  ?></span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <span>طريقة الدفع:نقدي</span>
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

                    <?php   foreach ($request as $rows)  {  ?>
                        <tr class="<?php  if ($rows['prepared']==1) echo 'not_prepared'?>" >
                            <td style="font-size:20px" ><?php  echo $rows['code'] ?></td>
                            <td  ><?php  echo $rows['title'] ?></td>
                            <td><?php  echo $rows['color_name']   ?>  </td>
                            <td><?php  echo $rows['number'] ?></td>
                            <td  style="font-size:21px" ><?php  echo str_replace( 'د.ع','', $rows['price'] )  ?>  </td>
                            <td style="font-size:21px" ><?php  echo number_format((int)trim(str_replace($this->comma,'',$rows['price'])) * (int)$rows['number'])    ?>  </td>


                        </tr>

                    <?php  }  ?>


                    </tbody>
                </table>
                <?php if (!empty($html_list))  {  ?>
                    <div style="text-align: left;font-size: 20px!important;">
                        <?php echo $html_list ?>
                    </div>
                <?php } ?>

                <div class="row justify-content-between">

                    <div class="col-auto">

                        <div class="row">
                            <div class="col-auto">

                                <div class="sumbill_denar">
                                    <span>   مجموع القائمة دينار  : </span> <span> <?php echo $price1 ?> </span>
                                </div>
                            </div>
                            <div class="col-auto">

                                <div class="amonut_write">
                                    <span>    المبلغ فقط  : </span> <span id="write_amount"></span>
                                </div>


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
                                <span>منضم الفاتورة:</span> <span> <?php echo $seles ?> </span>
                            </div>
                        </div>


                    </div>

                    <div class="col-auto">
                        <svg class="barcode_amount"></svg>

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

<div class="row">
    <div class="col-12" style="padding: 3px">
        <div class="print_bill_casher" style="display: none">
            <?php  if (!empty($request)) { ?>
                <div class="title_company">
                    <img src="<?php echo $this->static_file_site ?>/image/site/bill_title3.png">
                </div>
                <div style="text-align: left;margin-bottom: 5px;font-size: 18px" > <span>السوق الالكتروني</span>  <span> www.alamani.iq  </span> </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                        <div class="date_bill">  <span>التاريخ: </span>  <span> <?php echo date('d-m-Y',$date)  ?> </span> </div>
                        <div class="time_bill"><span>الوقت:</span> <span> <?php echo date('H:i',$date)  ?> </span> </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6  ">
                        <div class="row align-items-center justify-content-end">
                            <div class="col-auto">
                                <svg class="barcode"></svg>
                            </div>
                            <div class="col-auto" style="padding-right: 0">
                                :NO
                            </div>
                        </div>
                    </div>
                </div>
                <div class="customer_name" style="margin-bottom: 15px" >
                    <span> حضرة السيد: </span> <span>  <?php echo $result['name'] ?>  </span>
                </div>
                <table class="table tableBill  tableBill_casher  table-bordered  "   >
                    <tbody>
                    <tr>
                        <td>اسم المادة</td>
                        <td>  اللون </td>
                        <td>  الكمية  </td>
                        <td>السعر  </td>

                    </tr>
                    <?php    foreach ($request as $key => $rows)  {  ?>
                        <tr  class="<?php  if ($rows['prepared']==1) echo 'not_prepared'?>">
                            <td><?php  echo $rows['title'] ?></td>
                            <td><?php  echo $rows['color_name']   ?>  </td>
                            <td><?php  echo $rows['number'] ?></td>
                            <td  style="font-size:18px" ><?php  echo str_replace( 'د.ع','', $rows['price'] )  ?>  </td>
                        </tr>
                    <?php  }  ?>
                    </tbody>
                </table>

                <?php if (!empty($html_list))  {  ?>
                    <div style="text-align: left;font-size: 20px!important;">
                        <?php echo $html_list ?>
                    </div>
                <?php } ?>

                <div class="row justify-content-between">
                    <div class="col-auto">
                        <span>    عدد المواد: </span> <span>  <?php echo  $number_type ?>  </span>
                    </div>
                    <div class="col-auto">
                        <span>     مجموع الكمية : </span> <span>  <?php echo  $sum_material ?>  </span>
                    </div>
                    <div class="col-auto">
                        <span>البائع:</span> <span>  <?php echo $seles ?>  </span>
                    </div>
                </div>

                <div   style="margin: 15px 0 ;font-size: 24px" >
                    <span>  مجموع الفاتورة: </span> <span> <?php echo $price1  ?></span> <span> دينار </span>

                </div>

                <div class="text-center">
                    <svg class="barcode_amount"></svg>
                </div>

                <div style="margin: 15px 0;margin-bottom: 35px " >
                    <span>     المبلغ فقط: </span> <span id="write_amount2"> </span> <span> دينار </span>

                </div>

                <hr>
                <div  class="text-center">

                    <div style="padding: 2px"> نسعى دوما بأن تكون تجربة جميع زبائننا معنا تتحقق مقولتنا  </div>
                    <div style="padding: 2px">  "وعند الاماني تتحقق الاماني"   </div>
                    <div style="padding: 2px"> حال وجود اي ملاحظات نرجو ارسالها عبر السوق الالكتروني لشركتنا:  </div>
                    <div style="font-size: 28px; padding: 2px">  www.alamani.iq  </div>
                    <div style="font-size: 24px;padding: 2px"> او الاتصال بخدمة الزبائن 6007 </div>
                    <div style="font-size: 24px;padding: 2px"> لكم منا جزيل الشكر والامتنان  </div>


                </div>

            <?php  } ?>
        </div>
    </div>
</div>

<div class="hide_print">

<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="<?php echo url .'/'.$this->folder?>"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلب </li>

            </ol>

        </nav>

    </div>

</div>



<hr>


<?php  if ($result['active_wholesale_price'] == 1) { ?>
    <p><span style="background: #4CAF50;
                padding: 5px 20px;
                color: #fff;border-radius: 10px" > حساب جملة </span> </p>
<?php  } ?>

<table class="table table-striped table-dark set_text_table" <?php  if ($result['active_wholesale_price'] == 1) echo 'style="background: #4CAF50"'?> >
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

        <td   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $result['name']  ?>">           <?php echo $result['name'] ?>  </td>
        <td    style="background: <?php  if ($result['type_customer_12'] == 1)  echo '#4CAF50'; else echo 'red';?> "> <?php echo $result['type_customer'] ?>   </td>
        <td   style="direction: ltr;">
            <div>

				<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
					<span    onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $result['phone']  ?>">  <?php echo  $result['phone'] ?> </span>
				<?php }else{ ?>

                    <span    onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>">  <?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?> </span>

                <?php  }  ?>

            </div>


        </td>
        <td> <?php echo $result['city'] ?>  </td>
        <td> <?php echo $result['address'] ?>  </td>
    </tr>

    </tbody>
</table>

<hr>
<div class="row">

    <div class="col-12"  id="reloadPage">

        <?php  if (!empty($request)) { ?>
            <div class="row justify-content-between">
                <div class="col-auto infoBillOpen">
                   <span>رقم الفاتورة:</span>  <span><?php echo $number_bill ?></span> //         <span>  مجموع الفاتورة:</span>  <span id="number_bill_reload"> <?php echo $price1 ?> </span><span>د.ع</span>

                </div>
                <div class="col-auto">
                <?php  		if ($this->permit('edit_bill', 'bills_inside_system')) {?>
                    <div class='row justify-content-center align-items-center'>

                        <div class='col-auto' style='padding-left: 2px'>
                            <input   <?php  if (!empty($bills_crystal))  echo 'disabled'   ?>     style="width:200px " placeholder="رقم فاتورة كرستال" id='numberBill_<?php echo $number_bill ?>'  value='<?php echo $bills_crystal   ?>' type='text' class='form-control withBill' name='crystal_bill' required>
                        </div>
                        <?php  if (empty($bills_crystal)) {   ?>
                        <div class='col-auto' style='padding-right: 2px'>
                            <button type='submit' id='btn_in_bill_<?php echo $number_bill ?>' onclick=saveBill('<?php echo $number_bill ?>')  name='submit' class='btn btn-warning'>حفظ</button>
                        </div>
                        <?php  }   ?>

                    </div>

                    <?php  }else {   ?>

                    <div class='row justify-content-center align-items-center'>
                        <div class='col-auto' style='padding-left: 2px'>
                            <input   <?php  if (!empty($bills_crystal))  echo 'disabled'   ?>     style="width:200px " placeholder="رقم فاتورة كرستال" id='numberBill_<?php echo $number_bill ?>'  value='<?php echo $bills_crystal   ?>' type='text' class='form-control withBill' name='crystal_bill' required>
                        </div>
                    </div>

                    <?php  }   ?>

                </div>
            </div>


            <script>


                function saveBill(number_bill) {

                    if($('#numberBill_'+number_bill).val())
                    {

                        $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill",{number_bill:number_bill,crystal_bill:$('#numberBill_'+number_bill).val()}, function( data ) {
                            if (data ==='1')
                            {
                                alert('تم اضافة فاتورة كرستال');
                                $("#row_"+number_bill+" td").eq(6).text($('#numberBill_'+number_bill).val());
                                $('#btn_in_bill_'+number_bill).addClass('addBill')
                            }

                        });

                    }else {

                        alert('حقل فاتورة كرستال فارغ !')
                    }

                }

            </script>


            <table class="requ_on table table-striped" border>
                <thead>


                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">السيريال</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت التجهيز </th>
                    <th scope="col">   ملاحظة </th>


                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td>  <span    onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $rows['title'] ?>">  <?php  echo $rows['title'] ?> </span> </td>
                        <td>   <span    onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $this->langControl($rows['table']) ?>"> <?php  echo $this->langControl($rows['table']) ?> </span>   </td>
                        <td   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['code']  ?>"><?php  echo $rows['code'] ?></td>
                        <td   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['enter_serial']  ?>"><?php  echo $rows['enter_serial'] ?></td>
                        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['size']  ?>"><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['color_name']  ?>"><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['number']  ?>"><?php  echo $rows['number'] ?></td>
                        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $rows['price']  ?>"><?php  echo $rows['price']   ?>  </td>
                        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  date('Y-m-d h:i:s A',$rows['date_prepared'])  ?>"><?php  echo date('Y-m-d h:i:s A',$rows['date_prepared']) ?></td>
                        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo   $rows['note']   ?>"><?php   $rows['note']  ?></td>

                    </tr>
                <?php  }  ?>

                </tbody>
            </table>
        <?php  } else  {    ?>
            <div class="alert alert-warning" role="alert">
                لا يوجد طلب جديد
            </div>
        <?php   }  ?>






        <br>
        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-primary"     id="bill_sale" onclick="print_bill_sale_sale()"> <i class="fa fa-print"></i> <span> طباعة فاتورة مبيع  </span></button>
            </div>
            <div class="col-auto">
                <button class="btn btn-warning"     id="bill_casher" onclick="print_bill_casher()"> <i class="fa fa-print"></i> <span> طباعة فاتورة كاشير  </span></button>
            </div>
        </div>



    </div>

</div>

</div>

<script>


    JsBarcode(".barcode", "<?php echo $number_bill ?>", {
        height: 40,
        displayValue: true
    });

    main ();
    function main (){

        document.getElementById ("write_amount").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1))  ?>);
        document.getElementById ("write_amount2").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1))  ?>);

    }

    JsBarcode(".barcode_amount", "<?php echo $price1    ?>", {
        height: 40,
        displayValue: true
    });

    function print_bill_sale_sale() {
        $('.print_bill_casher'). removeClass('casher');
        $('.print_bill_sale'). addClass('sale');
        window.print();
    }

    function print_bill_casher() {
        $('.print_bill_sale'). removeClass('sale');
        $('.print_bill_casher'). addClass('casher');
        window.print();
    }


</script>
<style>


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
    table.requ_on.table.table-striped {
        border: 1px solid #dee2e6;
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
</style>


<style>
    .not_prepared td{
        background-color: gainsboro !important;
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
            display: block !important;
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
            display: block !important;
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



<hr>



<br>
<br>
<br>
<br>



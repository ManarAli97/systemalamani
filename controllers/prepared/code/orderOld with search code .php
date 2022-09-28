
<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale">
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


                                <script>
                                    main ();
                                    function main (){

                                        document.getElementById ("write_amount").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1))  ?>);
                                        document.getElementById ("write_amount2").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1))  ?>);

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

                            JsBarcode(".barcode_amount", "<?php echo $price1    ?>", {
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

<div class="row">
    <div class="col-12" style="padding: 3px">
        <div class="print_bill_casher">
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
                        <span>البائع:</span> <span>  <?php echo $_SESSION['usernamelogin'] ?>  </span>
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


        <td>
            <span   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php echo $result['name'] ?>">  <?php echo $result['name'] ?></span>
        </td>


        <td    style="background: <?php  if ($result['type_customer_12'] == 1)  echo '#4CAF50'; else echo 'red';?> "> <?php echo $result['type_customer'] ?>   </td>
        <td>   <div  style="direction: ltr;">

				<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>

                    <span   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php echo $result['phone'] ?>">  <?php echo $result['phone'] ?></span>

				<?php }else{ ?>

                    <span   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>"> <?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?></span>


				<?php  }  ?>

            </div> </td>

        <td> <?php echo $result['city'] ?>  </td>
        <td> <?php echo $result['address'] ?>  </td>
    </tr>

    </tbody>
</table>

<hr>
<div class="row">

    <div class="col-12">

        <?php  if (!empty($request)) { ?>
            <div class="row justify-content-between">
                <div class="col-12 infoBillOpen">
                   <span>رقم الفاتورة:</span>  <span><?php echo $number_bill ?></span> //         <span>  مجموع الفاتورة:</span>  <span id="number_bill_reload"> <?php echo $price1 ?> </span><span>د.ع</span>
                   <hr>
                </div>

                <div class="col-12">
                   <form  id="checkedCode"  action="<?php echo url .'/'.$this->folder ?>/tajhez" method="post">

                       <div class="row justify-content-end">
                           <div class="col-auto">
                               <input  autocomplete="off" type="text" id="code_checked" onkeyup="resetForm()"  class="form-control" placeholder="ادخل باركود المادة" name="code" required>
                               <input type="hidden" id="realCode"  name="realCode"  class="form-control"  >
                           </div>
                           <div class="col-auto" id="addLocation">

                           </div>
                           <div class="col-auto">
                               <button type="submit" class="btn btn-warning" id="goOk" name="submit" value="submit">  موافق   </button>
                           </div>
                       </div>
                   </form>
                </div>

                
            </div>
            <hr>
            <table class="requ_on table table-striped" border>
                <thead>

                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">الموقع</th>
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>
                    <th scope="col">   حالة التجهيز  </th>
                    <th  style="display: none"  >  متغيرات  </th>

                    <th  class="retn"  scope="col">   زيادة / نقصان   </th>

                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>


                    <?php if (in_array($rows['table'],$categ) || $this->admin($this->userid) ==true ) {  ?>

                    <tr   <?php  if ($this->checkNewItemInBill($result['id'],$rows['id_item'],$number_bill )) { ?>  style="background: #f7ff0052" <?php } ?>  class="retn" id="row_<?php  echo $rows['id'] ?>">

                        <td style="padding: 0 6px;">

							<?php if (!empty($rows['location'])) { ?>
                                <table class="table table-bordered location_code" >
                                    <tbody>
                                    <tr>
                                        <td style="background: #ffc107 !important;">   م </td>
                                        <td  style="background: #ffc107 !important;">  ك </td>
                                    </tr>
									<?php foreach ($rows['location'] as $loct) {    ?>
                                        <tr>
                                            <td>  <?php echo $loct['location'] ?> </td>
                                            <td>  <?php echo $loct['quantity'] ?> </td>

                                        </tr>
									<?php  } ?>

                                    </tbody>
                                </table>
                                <style>
                                    .location_code
                                    {
                                        margin: 0;
                                    }
                                    .location_code td, .location_code th {
                                        border: 1px solid #dee2e6;
                                        background: #fff;
                                        padding: 0;
                                    }
                                </style>

							<?php  } ?>
                        </td>


                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><?php  echo $rows['title'] ?></td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <td>
                            <span   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $rows['code'] ?>">  <?php  echo $rows['code'] ?></span>
                        </td>
                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>  </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                        <?php  if ($rows['prepared'] ==1) {  ?>
                            <td class="jhz_<?php  echo $rows['code'] ?>">

								<?php  echo $this->chPrp($rows['id_member_r'],$rows['code'],$rows['number_bill'],$rows['table'],2) ?>

                            </td>
						<?php   }  else {  ?>
                            <td>

                                <i   class="fa fa-check-circle done_prepared"></i>
                            </td>
						<?php  }  ?>

                        <td  style="display: none">
                            <input   type="hidden" id="input_<?php  echo $rows['code'] ?>"  value="<?php  echo $rows['number'] ?>" >
                            <input type="hidden" id="output_<?php  echo $rows['code'] ?>"  value="<?php  echo $this->chPrp($rows['id_member_r'],$rows['code'],$rows['number_bill'],$rows['table'],2) ?>" >
                        </td>


                        <td  style="display: none">
                            <input   type="hidden" id="input_<?php  echo $rows['code'] ?>"  value="<?php  echo $rows['number'] ?>" >
                            <input type="hidden" id="output_<?php  echo $rows['code'] ?>"  value="0" >
                        </td>




						<?php  if ($rows['prepared'] ==1) {  ?>
                        <td   class="jhz_btn_<?php  echo $rows['code'] ?>"   style="text-align: center">
                            <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
                            <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $rows['id'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                         </td>
                            <?php  }  ?>
                    </tr>
                    <?php  } ?>
                <?php  }  ?>


                <?php   foreach ($request as $rows)  {  ?>

                    <?php if (!in_array($rows['table'],$categ) && $this->admin($this->userid) !=true ) {  ?>


                        <tr  disabled="disabled" class="retn notMyModel"  <?php  if ($this->checkNewItemInBill($result['id'],$rows['id_item'],$number_bill )) { ?>  style="background: #f7ff0052" <?php } ?>  class="retn" id="row_<?php  echo $rows['id'] ?>">

                            <td style="padding: 0 6px;">

								<?php if (!empty($rows['location'])) { ?>
                                    <table class="table table-bordered location_code" >
                                        <tbody>
                                        <tr>
                                            <td style="background: #ffc107 !important;">   م </td>
                                            <td  style="background: #ffc107 !important;">  ك </td>
                                        </tr>
										<?php foreach ($rows['location'] as $loct) {    ?>
                                            <tr>
                                                <td>  <?php echo $loct['location'] ?> </td>
                                                <td>  <?php echo $loct['quantity'] ?> </td>

                                            </tr>
										<?php  } ?>

                                        </tbody>
                                    </table>
                                    <style>
                                        .location_code
                                        {
                                            margin: 0;
                                        }
                                        .location_code td, .location_code th {
                                            border: 1px solid #dee2e6;
                                            background: #fff;
                                            padding: 0;
                                        }
                                    </style>

								<?php  } ?>
                            </td>

                            <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                            <td><?php  echo $rows['title'] ?></td>
                            <td><?php  echo $this->langControl($rows['table']) ?></td>
                            <td><?php  echo $rows['code'] ?></td>
                            <td><?php  echo $rows['size'] ?></td>
                            <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                            <td><?php  echo $rows['color_name']   ?>  </td>
                            <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                            <td><?php  echo $rows['price']   ?>  </td>
                            <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                            <td>
                                <?php  if ($rows['prepared'] ==2) {  ?>

                                    <i   class="fa fa-check-circle done_prepared"></i>

                                <?php  }else{    ?>
                                    <i   class="fa fa-minus-circle note_prepared"></i>
                                <?php  }    ?>

                            </td>
						<?php  if ($rows['prepared'] ==1) {  ?>
                            <td style="text-align: center">
                                <button disabled type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
                                <button disabled type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                            </td>
						<?php  } ?>
                        </tr>
                        <?php  } ?>

                <?php  }  ?>

                </tbody>
            </table>
        <?php  } else  {    ?>
            <div class="alert alert-warning" role="alert">
                لا يوجد طلب جديد
            </div>
        <?php   }  ?>
        <br>




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




<script>
    $(document).ready(function() {
        $("input#code_checked").select();
    });



    // this is the id of the form
    $("#checkedCode").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        number_bill =<?php echo $number_bill ?>;
        id_user =<?php echo $result['id'] ?>;
        if ($('#realCode').val()) {
            code = $('#realCode').val();
        } else {
            code = $('#code_checked').val();
        }

            $.get( "<?php echo url .'/'.$this->folder ?>/alixcol/"+ id_user + "/" + code +  "/" + number_bill, function( data ) {

                if (data==='notFoundCode')
                {
                    alert('الباركود غير موجود او قد تم تجهيز المادة')
                }else
                {

                    if ($('input#input_' + data).val() !== $('#output_' + data).val()) {
                        var num = Number($('#output_' + data).val()) + Number(1)
                        $('input#output_' + data).val(num);
                        $('.jhz_' + data).text(num);
                    }
                     $("input#code_checked").select();

                    if ($('input#input_'+data).val() === $('#output_'+data).val())
                    {

                        var codeGet;
                        var number_code;
                        var table;
                        $.ajax({
                            type: "POST",
                            url: url + "/" + id_user + "/" + code +  "/" + number_bill,
                            data: form.serialize() + "&id_user=" + id_user + "&number_bill=" + number_bill, // serializes the form's elements.
                            success: function (response) {

                                console.log(response)
                                resp = response.split('#');
                                var data = '';

                                if (resp.length === 4) {
                                    data = resp[0];
                                    codeGet = resp[1];
                                    number_code = resp[2];
                                    table = resp[3];
                                } else if (resp.length === 3) {
                                    data = resp[0];
                                    codeGet = resp[1];
                                    table = resp[2];
                                } else if (resp.length === 2) {
                                    data = resp[0];
                                    table = resp[1];
                                } else {
                                    codeGet = resp[0];
                                }

                                var $html = '';


                                $('#realCode').val(codeGet);


                                if (data === "notFoundCode") {
                                    alert("الباركود غير صحيح يرجى التأكد");
                                } else if (data === "location") {


                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/location")
                                    $("#addLocation").show().html(`<input type="text"  autocomplete="off"  class="form-control location_checked"  placeholder="ادخل موقع المادة مثلا:1,2" name="location" required> <div class="locationItem"></div>`);
                                    $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                        code: codeGet,
                                        table: table
                                    }, function (data) {
                                        $(".locationItem").html(data);
                                    });

                                    $("#goOk").click();

                                } else if (data === "Location2_enterSerial") {


                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").show().html(`<label> ادخل  موقع  المادة </label> <input  autocomplete="off" type="text"  class="form-control location_checked" placeholder="ادخل موقع المادة مثلا:1,2" name="location" required> <div class="locationItem2"></div>`);

                                    $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                        code: codeGet,
                                        table: table
                                    }, function (data) {
                                        $(".locationItem2").html(data);
                                    });
                                    $("#barcodeBdel").empty();

                                    $(".list_serial").empty();
                                    if (number_code > 1) {
                                        for (var i = 1; i < number_code; i++) {
                                            $html += `
                             <label>  ادخال سيريال  المادة ${Number(i) + Number(1)}</label>
                            <input  autocomplete="off" type="text" required  class="form-control" name="enter_serial[]">
                           `;
                                        }

                                        $(".list_serial").html($html);
                                    }


                                    $('#model_enterSerial2location').modal('show');


                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez")
                                    $("#addLocation").hide().empty();


                                } else if (data === 'enterSerialOnly') {
                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").empty();
                                    $("#barcodeBdel").empty();


                                    $(".list_serial").empty();
                                    if (number_code > 1) {
                                        for (var i = 1; i < number_code; i++) {
                                            $html += `
                             <label>  ادخال سيريال  المادة ${Number(i) + Number(1)}</label>
                            <input  autocomplete="off" type="text" required  class="form-control" name="enter_serial[]">
                           `;
                                        }

                                        $(".list_serial").html($html);
                                    }


                                    $('#model_enterSerial2location').modal('show');

                                } else if (data === "notLocation") {
                                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                                } else if (data === "not_enough") {
                                    alert("الكمية غير كافية في هذا الموقع")
                                } else if (codeGet === $('#realCode').val()) {

                                    $(".jhz_" + codeGet).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                    $(".jhz_btn_" + codeGet).empty();

                                    $("#code_checked").val('');
                                    $('#realCode').val('');
                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez")
                                    $("#addLocation").hide().empty();
                                    number_bill_reload()
                                } else {
                                    alert("فشل تجهيز المادة")
                                }

                            }
                        });

                        $(document).ready(function () {
                            $("input#code_checked").select();
                        });

                    }
                }

            });

    });

    function resetForm() {
        $("#checkedCode").attr('action',"<?php echo url .'/'.$this->folder ?>/tajhez")
        $("#addLocation").hide().empty();
        $('#realCode').val('');
    }

    function selectLOcation ()
    {


        var val = [];
        $('.locationList:checked').each(function(i){
            val[i] = $(this).val();
        });
        var x = val.toString('-');
        $(".location_checked").val(x)

    }



    // this is the id of the form
    $("#enterSerial2from").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        number_bill=<?php echo $number_bill ?>;
        id_user=<?php echo $result['id'] ?>;
        if($('#realCode').val())
        {
            code=$('#realCode').val();
        }else
        {
            code=$('#code_checked').val();
        }
        var form = $(this);
        var url = form.attr('action');


        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+"&id_user="+id_user+"&number_bill="+number_bill+"&code="+code, // serializes the form's elements.
            success: function(data)
            {

                console.log(data)
                if (data ==="notFoundSerial")
                {
                    alert('الباركود البديل غير صحيح يرجى التأكد');
                }else  if (data ==="notFoundCode"){
                   alert("الباركود غير صحيح")
                }
                else if (data  === "notLocation")
                {
                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                }
               else if (data === "not_enough")
                {
                    alert("الكمية غير كافية في هذا الموقع")
                }
                else if (data === $('#realCode').val())
                {
                    $('#model_enterSerial2location').modal('hide')
                    $('#addLocationSerial').empty();
                    $('#barcodeBdel').empty();
                    $('#addLocationSerial2').empty();
                    $(".location_checked").val();
                    $(".jhz_"+data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                    $(".jhz_btn_"+data).empty();
                    $("#code_checked").val('');
                    $('#realCode').val('');
                    number_bill_reload()
                }else
                {
                    alert("فشل تجهيز المادة")
                }
            }
        });

        $(document).ready(function() {
            $("input#code_checked").select();
        });
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




    function  return_order_minus(id_order,table,code,id_user,color,number_bill) {

            if ($('#number_item_' + id_order).text()  === '1')
            {
                if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟  ')) {

                    $('#minus_x_'+id_order).attr('disabled','disabled');

                    $.get( "<?php  echo url . '/' . $this->folder ?>/setBill/" + id_user +  "/" + number_bill+"/"+code, function( data ) {
                        if (data)
                        {
                            alert('يرجى توجية الزبون الى المحاسب لستلام المرتجع.')
                            $.ajax({
                                type: 'GET',
                                url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + code + "/" + id_user,
                                cache: false,
                                data: {color:color,number_bill:number_bill},
                                success: function (response) {

                                    console.log(response)
                                    if (response) {
                                        number_bill_reload();
                                        if (isNaN(response)) {
                                            window.location = "<?php echo url ?>/home"
                                        } else {
                                            $('#row_' + id_order).remove();
                                            $('#number_item_' + id_order).html(response);

                                        }
                                    }else
                                    {
                                        alert('حدث خطا')
                                    }

                                    $('#minus_x_'+id_order).removeAttr('disabled');
                                }
                            });



                        }else
                        {
                            alert('حدث خطا')
                        }
                    });


                }

            }else {

                if (confirm(' هل تريد تنقيص المادة  ؟ ')) {
                    alert('يرجى توجية الزبون الى المحاسب لستلام المرتجع.')
                    $('#minus_x_' + id_order).attr('disabled', 'disabled');

                    $.ajax({
                        type: 'GET',
                        url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + code + "/" + id_user,
                        cache: false,
                        data: {color:color,number_bill:number_bill},
                        success: function (response) {
                            if (response) {
                                number_bill_reload();
                                if (isNaN(response)) {
                                    window.location = "<?php echo url ?>/home"
                                } else {
                                    // $('#number_item_' + id_order).html(response);

                                    $.get("<?php  echo url . '/' . $this->folder ?>/setBill/" + id_user + "/" + number_bill + "/" + code, function (data) {
                                        if (data) {
                                            $('#number_item_' + id_order).html(response);
                                        } else {
                                            alert('حدث خطا')
                                        }
                                    });

                                }
                            } else {
                                alert('حدث خطا')
                            }
                            $('#minus_x_' + id_order).removeAttr('disabled');

                        }
                    });
                }return false;
            }
    }

    function  return_order_plus(id_order,table,code,id_user,color,id_row,number_bill) {

        if (confirm(' هل تريد  زيادة المادة  ؟ ')) {
            $('#plus_x_' + id_order).attr('disabled', 'disabled');

            $.ajax({
                type: 'GET',
                url: "<?php  echo url . '/' . $this->folder ?>/return_order_plus/" + table + "/" + code + "/" + id_user + "/" + id_row,
                cache: false,
                data: {id_order: id_order,color: color,number_bill:number_bill},
                success: function (response) {
                    if (response) {
                        number_bill_reload();
                        if (isNaN(response)) {
                            window.location = "<?php echo url ?>/home"
                        } else {
                            alert('يرجى توجية الزبون الى المحاسب لدفع مبلغ زيادة الطلب')
                        }

                    } else {
                        alert('حدث خطا')
                    }

                    $('#plus_x_' + id_order).removeAttr('disabled');

                }
            });

        }return false;

    }

</script>


<div class="modal" id="model_enterSerial2location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="post" id="enterSerial2from" action="<?php  echo url  .'/'.$this->folder?>/enterSerial2location">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تفاصيل المادة  </h5>
            </div>

                <div class="modal-body">

                <label>باركود المادة </label>
                <label  style="background: #e9ecef;" class="form-control" id="barcode_show2" ></label>
                <br>

                <div id="barcodeBdel">

                </div>


                    <label>  ادخال سيريال  المادة 1</label>
                    <input  autocomplete="off" type="text" required  class="form-control" name="enter_serial[]">
                    <div class="list_serial">

                    </div>

                <br>

                <div id="addLocationSerial2">

                </div>


            </div>

            <div class="modal-footer" style="display: block;text-align: center">
                <button type="submit" name="submit"   class="btn btn-success"> موافق  </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>

            </div>

    </form>

        </div>
    </div>

</div>


<hr>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">  بحث  </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"> بحث بستخدام الرمز </a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <br>





            <fieldset class="fieldset">

                <legend class="legend">  بحث عن مادة </legend>

                <div class="row align-items-end">
                    <div class="col-auto form-group">
                        <label> اختر القسم  </label>
                        <select  name="cat" id="fullsearch" class="custom-select mr-sm-2"     required>
                            <option value=""  selected    >  اختر القسم  </option>
							<?php  foreach ($this->category_website as $key  => $c ) { ?>
                                <option value="<?php echo $key ?>"><?php  echo $c ?></option>
							<?php }  ?>

                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>بحث</label>
                        <input  onkeyup="smartSearch(this)" class="form-control empty_search_text" type="text"  placeholder="اسم المادة - رمز المادة - باركود بديل ">
                        <div class="search_data"></div>
                    </div>

                </div>

            </fieldset>

            <br>

            <div class="result_data_mobile">
             <form id="addBySearchTitle" action="<?php  echo url  .'/'.$this->folder?>/add_item_to_order/<?php echo $result['id'] ?>" method="post"  >
                <table class="table table-striped">

                    <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>اسم المادة</th>
                        <th> اللون  </th>
                        <th> الكود  </th>
                        <th> الكمية المتوفرة  </th>
                        <th> السعر  الحالي (د.ع)  </th>
                        <th>  السعر الحالي ($) </th>
                        <th>الكمية</th>

                        <th> حذف  </th>
                    </tr>
                    </thead>
                    <tbody class="load_data"></tbody>



                </table>

                <hr>

                <div class="text-center">

                    <button disabled id="save_data" class="btn btn-primary" type="submit"> حفظ </button>

                </div>
                </form>
            </div>


            <script>

                function smartSearch(e) {

                    var val = $(e).val();
                    if (val) {

                        var cat = $('#fullsearch').val();
                        if (cat) {

                            $.get("<?php  echo url . '/' . $this->folder ?>/smartsearch", {
                                val: val,cat:cat,
                            }, function (data) {
                                if (data) {
                                    $(".search_data").html(data).show();
                                } else {
                                    $(".search_data").empty().hide();
                                }

                            });
                        }else
                        {
                            alert('اختر القسم')
                        }
                    }else
                    {
                        $( ".search_data" ).empty().hide();
                    }

                }

                function getDetails_mobile(e) {

                    var cat = $('#fullsearch').val();
                    $.get( "<?php echo url .'/'.$this->folder ?>/getdata",{id:$(e).val(),model:cat}, function( data ) {
                        if (data)
                        {

                            $( ".load_data" ).prepend(data);
                            $( ".search_data" ).empty().hide();
                            check_data()
                        }
                    });

                    $( ".search_data" ).empty().hide();
                    $( ".empty_search_text" ).val('');


                }

                function check_data() {

                    if ($(".load_data").text().length > 10) {
                        $('#save_data').removeAttr('disabled');
                    }else
                    {
                        $('#save_data').attr('disabled','disabled');

                    }

                }

                $("#addBySearchTitle").submit(function(e) {

                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);
                    var url = form.attr('action');

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize()+"&number_bill=<?php echo $number_bill ?>" , // serializes the form's elements.
                        success: function(data)
                        {

                            console.log(data);
                            if (data === 'add')
                            {
                                alert('تمت اضافة العناصر الى الطلب يرجى توجية الزبون الى المحاسب');
                                window.location='';
                                $('.save_data').removeClass('disabled');

                            }else
                            {
                                alert(' لا توجد مواد مضافة ');
                                $('.save_data').removeClass('disabled');
                            }


                        }
                    });


                });




            </script>


            <style >


                .sub_table
                {
                    margin-bottom: 15px;
                }
                .sub_table:last-child
                {
                    margin-bottom: 0;
                }


                .sub_table td
                {
                    background: #ffffff;
                }


                .search_name,.search_phone,.search_qr,.search_data
                {
                    position: absolute;
                    width: 100%;
                    top: 70px;
                    padding-left: 46px;
                    z-index: 100000;
                }

                .not_found_faq {
                    background: #fff;
                    border: 1px solid #d1bb96;
                    padding: 7px 5px;
                    z-index: 10000;
                }

                .content_search {
                    border: 1px solid #d1bb96;
                }
                button.btn.row_search {
                    display: block;
                    background: white;
                    width: 100%;
                    border-radius: 0;
                    border-bottom: 1px solid #d1bb96;
                    text-align: right;
                }

                button.btn.row_search:hover {
                    background: #14a0ad;
                    color: #ffffff;
                }


                button.btn.row_search:last-child {

                    border-bottom: 0;
                }



                .fieldset
                {
                    border: 1px solid #d6d6d6;
                    padding: 21px 18px;
                    background: #ecedee;
                    border-radius: 5px;
                    margin-bottom: 15px;
                }

                .fieldset legend
                {
                    border: 1px solid #d6d6d6;
                    width: auto;
                    padding: 5px 15px;
                    border-radius: 5px;
                    background: #f8f9fa;
                    font-size: 18px;
                }

            </style>






        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                 <br>
            <form id="searchSerial"   action="<?php  echo url  .'/'.$this->folder?>/search_serial" method="post">
                <div class="row">
                    <div class="col-auto">

                        <select  name="cat" id="cat_serial" class="custom-select mr-sm-2"     required>
                            <option value=""  selected    >  اختر القسم  </option>
							<?php  foreach ($this->category_website as $key  => $c ) { ?>
                                <option value="<?php echo $key ?>"><?php  echo $c ?></option>
							<?php }  ?>

                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        <input  autocomplete="off" type="text"  name="serial"  class="form-control" id="serial" placeholder="ادخل باركود بديل" required>
                    </div>

                    <div class="col-auto">
                        <button      type="submit" class="btn btn-primary mb-2">بحث</button>
                    </div>

                </div>
            </form>
            <form  id="IdFormAddProd"  action="<?php  echo url  .'/'.$this->folder?>/add_item_to_order/<?php echo $result['id'] ?>" method="post">

                <div class="form-row align-items-center">

                    <div class="col-auto">
                        الكود
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-5">
                        <input  autocomplete="off"  type="text"    class="form-control" id="code" placeholder="الكود" required>
                    </div>


                    <div class="col-auto">
                        <select  class="custom-select mr-sm-2" id="cat_site"  onchange="settingCat()" required>
                            <option   selected    >  اختر القسم  </option>
							<?php  foreach ($this->category_website as $key  => $c ) { ?>
                                <option value="<?php echo $key ?>"><?php  echo $c ?></option>
							<?php }  ?>

                        </select>
                    </div>

                    <div class="col-auto">
                        <div class="add_color"></div>
                    </div>


                    <div class="col-auto">
                        <button onclick="codeData()"  style="    margin: 0 !important;" type="button" class="btn btn-primary mb-2">بحث</button>
                    </div>
                </div>



                <br>
                <div class="form_add">

                    <table class="table table-striped   table_style3">
                        <thead>
                        <tr>

                            <th scope="col">اسم الجهاز</th>
                            <th scope="col">اللون</th>
                            <th scope="col">اسم اللون</th>
                            <th scope="col">السعر</th>
                            <th scope="col">حجم الذاكرة</th>
                            <th scope="col">المتوفر </th>
                            <th scope="col">    صورة  </th>
                            <th scope="col">    الكمية  </th>
                            <th scope="col">    حذف  </th>
                        </tr>
                        </thead>
                        <tbody  class="data_get">

                        </tbody >
                    </table>



                    <div class="add_to_order text-center">
                        <button type="submit" name="submit" class="btn btn-warning">ارسال الطلبات الى المحاسب</button>
                    </div>

                </div>
            </form>




        </div>

    </div>











<script>


    function settingCat(cat=null) {

        if (cat ==null)
        {
            cat=$('#cat_site option:selected').val();
        }

        code=$('#code').val();

        if (code) {

          if (cat === 'accessories') {
                $.get("<?php echo url . '/' . $this->folder ?>/color_list/" + code + '/' + cat, function (data) {

                    $('.add_color').html(data);
                });

            } else {
                $('.add_color').empty();
            }
        }else
        {
            $('#cat_site option:first').prop('selected',true);
            alert('يرجى كتابة كود المادة قبل اختيار القسم')
        }
    }



    function codeData(cat=null)
    {

        code=$("#code").val();
        if (cat ==null)
        {
            cat=$('#cat_site option:selected').val();
        }


        if (code) {
              if (cat === 'accessories')
            {


                color = $('#color_name_acc option:selected').val();

                if (color)
                {
                    $.ajax({
                        url: "<?php  echo url . '/' . $this->folder?>/get",
                        type: 'post',
                        data: {code: code, cat: cat, color: color},
                        success: function (data) {

                            if (data)
                            {
                                $('.form_add').show();
                                $('.data_get').append(data);
                            }else
                            {
                                alert('لا توجد مواد')
                            }

                        }
                    });
                }else
                {
                    alert('يجب اختيار اسم لون المادة الموجود في كرستال')
                }

            }


            else {
                $('.add_color').empty();
                $.ajax({
                    url: "<?php  echo url . '/' . $this->folder?>/get",
                    type: 'post',
                    data: {code: code, cat: cat},
                    success: function (data) {

                        if (data)
                        {
                            $('.form_add').show();
                            $('.data_get').append(data);
                        }else
                        {
                            alert('لا توجد مواد')
                        }


                    }
                });
            }
        }else
        {
            alert('اضف كود المنتج')
        }

    }


    $("#IdFormAddProd").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $('.add_to_order').addClass('disabled');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+"&number_bill=<?php echo $number_bill?>" , // serializes the form's elements.
            success: function(data)
            {

                console.log(data);
                 if (data === 'add')
                {
                    alert('تمت اضافة العناصر الى الطلب يرجى توجية الزبون الى المحاسب');
                    window.location='';
                    $('.add_to_order').removeClass('disabled');

                }else
                {
                    alert(' لا توجد مواد مضافة ');
                    $('.add_to_order').removeClass('disabled');
                }


            }
        });


    });


    $("#searchSerial").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $('.add_to_order').addClass('disabled');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(datas)
            {
                 if (datas)
                 {

                     $('#code').val(datas);
                     cat=$('#cat_serial option:selected').val();
                     $("#cat_site option[value='"+cat+"']").attr("selected","selected");
                     settingCat(cat);
                     codeData(cat);
                     $("#serial").select();
                 }else {
                     $("#serial").select();
                     alert('لايوجد جهاز بهذا الباركود او السيريال')
                 }

            }
        });


    });



</script>


<br>
<br>
<br>
<br>




</div>
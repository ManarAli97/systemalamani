<!--تجهيز d3-->


<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale">
			<?php  if (!empty($requestPrint)) { ?>

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
                        <td style="width: 100px;"> حجم الذاكرة</td>

                        <td style="width: 40px;"> اللون  </td>
                        <td style="width: 40px;">  الكمية </td>

                        <td style="width: 100px;">السعر</td>
                        <td style="width: 160px;">السعر الاجمالي</td>

                    </tr>

					<?php   foreach ($requestPrint as $rows)  {  ?>
                        <tr class="<?php  if ($rows['prepared']==1) echo 'not_prepared'?>" >
                            <td style="font-size:20px" ><?php  echo $rows['code'] ?></td>
                            <td  ><?php  echo $rows['title'] ?></td>
                            <td  ><?php  echo $rows['size'] ?></td>
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
                                    <span>   مجموع القائمة دينار  : </span> <span> <?php echo number_format( $price1Offer) ?> </span>
                                </div>
                            </div>
                            <div class="col-auto">

                                <div class="amonut_write">
                                    <span>    المبلغ فقط  : </span> <span id="write_amount"></span>
                                </div>


                                <script>
                                    main ();
                                    function main (){

                                        document.getElementById ("write_amount").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1Offer))  ?>);
                                        document.getElementById ("write_amount2").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$price1Offer))  ?>);

                                    }
                                </script>

                            </div>
                        </div>

                            <div class="row justify-content-between">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span> عدد الانواع:</span>  <span> <?php echo $number_typeOffer ?> </span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span> مجموع المواد: </span> <span> <?php echo $sum_materialOffer ?> </span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span>منضم الفاتورة:</span> <span> <?php echo $_SESSION['usernamelogin'] ?> </span>
                                </div>
                            </div>


                    </div>

                    <div class="col-auto">
                        <svg class="barcode_amount"></svg>
                        <script>

                            JsBarcode(".barcode_amount", "<?php echo number_format( $price1Offer)     ?>", {
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

                <div style="border-top:1px solid #5a5a5a;margin-top:15px;padding-top: 5px;font-size: 18px !important;font-weight:bold  " class="text-center">

                    زبائننا الكرام ، كي يسهل عليكم ركن دراجاتكم او سياراتكم ننصحكم عند زيارتنا الدخول من الباب الخلفية للشركة

                </div>

            <?php   }  ?>
        </div>

    </div>
</div>



<div class="row">
    <div class="col-12 python_print" style="padding: 3px">
        <div class="print_bill_casher">
            <?php  if (!empty($requestPrint)) { ?>
                <div class="title_company">

                    <img src="<?php echo $this->static_file_site ?>/image/site/bill_title3.png">
                </div>


                <div style="text-align: left;margin-bottom: 5px;font-size: 18px" > <span>السوق الالكتروني</span>  <span>  alamani.iq  </span> </div>




                <table  style="width: 100%;border-collapse: collapse;"  >
                    <tbody>

                    <tr>

                        <td style="text-align: right; ;font-size: 18px;"  >
                            <div class="date_bill">  <span>التاريخ: </span>  <span> <?php echo date('d-m-Y',$date)  ?> </span> </div>
                            <div class="time_bill"><span>الوقت:</span> <span> <?php echo date('H:i',$date)  ?> </span> </div>
                        </td>
                        <td style="text-align: left; ">
                            <span><svg class="barcode"></svg></span> <span>:NO</span>
                        </td>

                    </tr>

                    </tbody>
                </table>

                <div class="customer_name" style="margin-bottom: 15px ;font-size: 20px;" >

                    <span> حضرة السيد: </span> <span>  <?php echo $result['name'] ?>  </span>

                </div>

                <table border='1' class="  tableBill  tableBill_casher  table-bordered  "  style="width: 100%;border-collapse: collapse;"  >
                    <thead>
                    <tr>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>اسم المادة</th>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  نوع الجهاز </th>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  حجم الذاكره </th>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px'>  اللون </th>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px'>  الكمية  </th>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px'>السعر  </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php    foreach ($requestPrint as $key => $rows)  {  ?>
                        <tr  class="<?php  if ($rows['prepared']==1) echo 'not_prepared'?>" >
                            <td style='padding : 0.65rem !important;font-size: 18px'><?php  echo $rows['title'] ?></td>
                            <?php if($rows['table'] == 'product_savers')  {?><td style='padding : 0.65rem !important;font-size: 18px'><?php  echo $rows['name_device_customer'] ?></td>
                            <?php } elseif(($rows['table'] == 'accessories') && ($rows['name_categ_acc_customer'] != '')) { ?><td style='padding : 0.65rem !important;font-size: 18px'> <?php  echo $rows['name_categ_acc_customer'] ?> <br/><br/></td>
                            <?php } else{  ?><td></td><?php }?>

                            <td style='padding : 0.65rem !important;font-size: 18px'><?php  echo $rows['size'] ?></td>
                            <td style='padding : 0.65rem !important;font-size: 18px'><?php  echo $rows['color_name']   ?>  </td>
                            <td style='padding : 0.65rem !important;font-size: 18px'><?php  echo $rows['number'] ?></td>
                            <td  style="font-size:20px;padding : 0.65rem !important" ><?php  echo str_replace( 'د.ع','', $rows['price'] )  ?>  </td>
                        </tr>
                    <?php  }  ?>
                    </tbody>
                </table>

                <?php if (!empty($html_list))  {  ?>
                    <div style="text-align: left;font-size: 20px!important;">
                        <?php echo $html_list ?>
                    </div>
                <?php } ?>




                          <table style="width: 100%;border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <td  > <span>    عدد المواد: </span> <span>  <?php echo  $number_typeOffer ?>  </span></td>
                        <td><span>     مجموع الكمية : </span> <span>  <?php echo  $sum_materialOffer ?>  </span></td>
                        <td><span>البائع:</span> <span>  <?php echo $_SESSION['usernamelogin'] ?>  </span></td>
                    </tr>
                    </tbody>
                </table>



                <div   style="margin: 15px 0 ;font-size: 24px" >
                    <span>  مجموع الفاتورة: </span> <span> <?php echo number_format( $price1Offer)   ?></span> <span> دينار </span>

                </div>

                <div  style="text-align: center">
                    <svg class="barcode_amount"></svg>
                </div>

                <div style="margin: 15px 0;margin-bottom: 35px ;font-size: 20px;" >
                    <span>     المبلغ فقط: </span> <span id="write_amount2"> </span> <span> دينار </span>

                </div>

                <hr>
                <div style="text-align: center"  class="text-center">

                    <div style="padding: 2px"> نسعى دوما بأن تكون تجربة جميع زبائننا معنا تتحقق مقولتنا  </div>
                    <div style="padding: 2px">  "وعند الاماني تتحقق الاماني"   </div>
                    <div style="padding: 2px"> حال وجود اي ملاحظات نرجو ارسالها عبر السوق الالكتروني لشركتنا:  </div>
                    <div style="font-size: 28px; padding: 2px">   alamani.iq  </div>
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


<div class="row">

    <div class="col-12">

        <?php  if (!empty($request)) { ?>
            <div class="row justify-content-between">

                <div class="col-12">
                    <form  id="checkedCode"  action="<?php echo url .'/'.$this->folder ?>/tajhez3" method="post">

                        <div class="row justify-content-end">
                            <?php  if ($this->ch_smart_prepared($this->userid)) {  ?>
                                <div class="col-auto">
                                    <button  type="button" id="btn_smart_prepared" onclick="smart_prepared(<?php echo $n_bill ?>,<?php echo $id ?>)"  class="btn btn-primary"  >التجهيز الذكي</button>
                                </div>
                            <?php } ?>

                            <div class="col-auto">
                                <input  autocomplete="off" type="text" id="code_checked" onkeyup="resetForm();setTimeStamp(this)" class="form-control" placeholder="ادخل باركود المادة"   required>
                                <input type="hidden" id="realCode"  name="realCode"  class="form-control"  >
                            </div>
                            <div class="col-auto" id="addLocation">

                            </div>
                            <div class="col-auto"  style="margin-left: 5px">
                                <button id="goOk" type="submit" class="btn btn-warning" name="submit" value="submit">تجهيز</button>
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
                    <th scope="col">    القسم </th>
                    <th scope="col"> نوع الجهاز </th>
                    <th scope="col">code</th>
                    <th scope="col">السيريلات المقترحة</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>
                    <th scope="col"> حالة التجهيز  </th>
                    <th style="display: none" >  المتغير  </th>
                    <th scope="col">  ملاحظة  </th>

                    <th scope="col">   زيادة /نقصان </th>


                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>

                    <tr  <?php  if ($this->checkNewItemInBill($result['id'],$rows['id_item'],$number_bill )) { ?>  style="background: #f7ff0052" <?php } ?>   class="retn" id="row_<?php  echo $rows['id'] ?>">

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
                        <td><?php  echo $rows['title'] ?>

                            <?php  if ($rows['offers']) {  ?>
                                <div class="offers_" style="font-size: 10px; background: #8bc34a6b; border-radius: 5px;">
                                    <?php  echo  $this->details_offer($rows['id_offer'],'title')?>
                                </div>
                            <?php } ?>

                            <?php  if ($rows['computer_assembly']) {  ?>
                                <div class="offers_" style="font-size: 10px; background: #ff9800; border-radius: 5px;">
                                    <?php  echo  $this->details_computer_assembly($rows['id_computer_assembly'],'title')?>
                                </div>
                            <?php } ?>

                        </td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <?php  if($rows['table'] == 'product_savers')  {?>
                            <td><p style="color: red; font-weight:bold"> الزبون:</p> <?php  echo $rows['name_device_customer'] ?> <br/><br/>
                                <hr style='background-color:black'>
                                <p style="color: red;font-weight:bold"> الواقع: </p> <?php  echo $rows['name_device'] ?>
                            </td>
                            <!-- manar -->
                        <?php } elseif(($rows['table'] == 'accessories') && ($rows['name_categ_acc_customer'] != '')) { ?>
                            <td><p style="color: red; font-weight:bold"> الزبون:</p> <?php  echo $rows['name_categ_acc_customer'] ?> <br/><br/>
                                <hr style='background-color:black'>
                                <p style="color: red;font-weight:bold"> الواقع: </p> <?php  echo $rows['name_categ_acc'] ?>
                            </td>

                        <?php } else{  ?>
                            <td>
                            </td>

                        <?php }?>


                        <td>
                            <span  onclick="copy_text2(this,'<?php  echo $rows["code"] ?>')"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $rows['code'] ?>">  <?php  echo $rows['code'] ?></span>
                        </td>

                        <td>
                            <?php  if ($rows['listSerial']) {  ?>
                                <?php  foreach ($rows['listSerial'] as $key => $serial) { ?>
                                    <span class="badge badge-success d-block mb-1">  <?php echo $serial ?></span>
                                <?php } ?>
                            <?php } ?>
                        </td>

                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>

                            <?php  if ($rows['price_type'] > 0) { ?>
                                <span class="type_price_account" > <?php  echo  $this->price_type[$rows['price_type']]; ?> </span>
                            <?php  } ?>


                        </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                        <?php  if ($rows['prepared'] ==1) {  ?>
                            <td class="jhz_<?php  echo $rows['code'] ?>">

								<?php  echo $this->chPrp($rows['id_member_r'],$rows['code'],$rows['number_bill'],$rows['table'],1) ?>

                            </td>
						<?php   }  else {  ?>
                            <td>

                                <i   class="fa fa-check-circle done_prepared"></i>
                            </td>
						<?php  }  ?>

                        <td  style="display: none">
                            <input   type="hidden" id="input_<?php  echo $rows['code'] ?>"  value="<?php  echo $rows['number'] ?>" >
                            <input type="hidden" id="output_<?php  echo $rows['code'] ?>"  value="<?php  echo $this->chPrp($rows['id_member_r'],$rows['code'],$rows['number_bill'],$rows['table'],1) ?>" >
                        </td>

                        <td><?php  echo $rows['note'] ?>


                            <div class="list_serial_enter<?php echo $rows['code'] ?>"></div>
                        </td>



                        <?php  if ($rows['prepared'] ==1) {  ?>
                        <td  class="jhz_btn_<?php  echo $rows['code'] ?>"  style="text-align: center">

                            <?php  if (!$rows['offers']) {  ?>

                            <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus3(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $rows['id'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                            <?php  }  ?>
                            <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus3(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-minus-circle"></i>    </button>

                        </td>
						<?php  }  ?>
                    </tr>

                <?php  }  ?>


                </tbody>
            </table>



            <div class="row write_note_bill">
                <div class="col">
                    <span id="save_note_bill_done" style="color: #0a7817"></span>
                    <input value="<?php echo $notebill ?>" class="form-control" oninput="save_note_bill(this,'<?php echo $number_bill ?>','<?php echo $id ?>')" placeholder="كتابة ملاحظة" type="text" name="note_prepared">

                    <script>
                        function save_note_bill(e,bill,id)
                        {
                            $.get( "<?php  echo url .'/'.$this->folder?>/save_note_bill",{note:$(e).val(),bill:bill,id:id}, function( data ) {

                                $( "#save_note_bill_done" ).html( 'تم الحفظ' );

                            });
                        }

                    </script>
                </div>
            </div>



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
                <button class="btn btn-warning"     id="bill_casher" onclick="print_bill_casher()"> <i class="fa fa-print"></i> <span> طباعة فاتورة كاشير  </span>
                    <span id="spinner" style="vertical-align: unset;display: none" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>


    </div>


</div>



<hr>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">  بحث  </a>
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

                        <button disabled id="save_data" class="btn btn-primary" type="submit">   اضافة الى الطلب </button>

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


                    if (confirm('هل انت متأكد؟')) {
                        var form = $(this);
                        var url = form.attr('action');

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize() + "&number_bill=<?php echo $number_bill ?>", // serializes the form's elements.
                            success: function (data) {

                                if (data === 'add') {
                                    alert('تمت اضافة العناصر الى الطلب يرجى  محاسبت الطلب من خانة قيد المحاسبة');
                                    window.location = '';
                                    $('.save_data').removeClass('disabled');

                                } else {
                                    alert(' لا توجد مواد مضافة ');
                                    $('.save_data').removeClass('disabled');
                                }


                            }
                        });
                    } return false;

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
        .write_note_bill
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


    .outSerial {
        background: #aaddbb;
        border-radius: 11px;
        margin-bottom: 2px;
    }

</style>


    <div style="z-index: 15000000000 ; background: #00000069;" class="modal fade " id="edit_save_serial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تعديل السيريال </h5>
                </div>
                <div class="modal-body">
                    اضغط موافق اذا تريد الحفظ غير ذالك اضغط تعديل او خارج الرسالة
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="edit_save_serial_prepared()" class="btn btn-primary">موافق</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">تعديل</button>
                </div>
            </div>
        </div>
    </div>




    <script>


    function smart_prepared(number_bill,id)
    {

        $('#btn_smart_prepared').attr('disabled','disabled').html(`

         <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
جاري التجهيز الذكي ....

        `)

        $.get( "<?php  echo url ?>/withdraw_return/smart_prepared",{number_bill:number_bill,id:id}, function( data ) {


          setTimeout(function () {
              if (data===data)
              {

                  $('#row'+number_bill).click();

                  $('#btn_smart_prepared').removeAttr('disabled').html(`
          التجهيز الذكي
                `);



              }else {

                  alert('فشلت عملية التجهيز الذكي')

              }
          },500);



        });

    }



    var serialList=[];
    var thisCode;
    var  code;
    var  check_serial_prepared='false';

    var date_now=0;
    var con=0;
    var flagProcessing=0;
    function setTimeStamp(e) {
        flagProcessing=0;
        if (con == 0) {
            var dt = new Date();
            date_now = dt.getSeconds();
            console.log(date_now);
            con = 1;
        }
    }



    function copy_text2(e,code) {
        new Clipboard('.'+$(e).attr('class'));
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
        flagProcessing=1;
        $.get( "<?php  echo url  ?>/processing_report/insert_data",{number_bill:<?php echo $number_bill  ?>,code:code,note:"نسخ رمز المادة من الفاتورة"}, function( data ) {

        });
    }




    $(document).ready(function() {
        $("input#code_checked").select()
    });

    // this is the id of the form
    $("#checkedCode").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        number_bill=<?php echo $number_bill ?>;
        id_user=<?php echo $result['id'] ?>;

        check_serial_prepared='false'

        // if($('#realCode').val())
        // {
        //     code=$('#realCode').val();
        // }else
        // {
        //     code=$('#code_checked').val();
        // }

        code=$('#code_checked').val();


        setTimeout(function () {
            if (flagProcessing==0) {
                $.get("<?php  echo url  ?>/processing_report/insert_data", {
                    number_bill:<?php echo $number_bill  ?>,
                    code: code,
                    note: 1,
                    date_now: date_now,
                }, function (data) {
                    flagProcessing=0 ;
                });
            }else
            {
                flagProcessing=0 ;
            }

            date_now=0;
            con=0;
        },3);

        var form = $(this);
        var url = form.attr('action');


        $.get( "<?php echo url .'/'.$this->folder ?>/alixcol3/"+ id_user + "/" + code +  "/" + number_bill, function( response_data ) {


            console.log(response_data)

            if (response_data === 'notFoundCode') {
                alert('الباركود غير موجود او قد تم تجهيز المادة')
            }

            else if (response_data==='notFoundSerial')
            {
                alert('السيريال غير موجود')
            }
            else {

                var  respo=JSON.parse(response_data)


                var   data=respo.code;
                if (!thisCode)
                {
                    thisCode=data;
                }

                check_serial_prepared=respo.serial_prepared;
                code=data;
                var   serial=respo.serial;
                var codeGet;
                var number_code;
                var table;
                if (respo.pass === 'true') {

                    if(data === thisCode) {
                        if (($('input#input_' + data).val() !== $('#output_' + data).val())) {

                            if (check_serial_prepared ==='false') {

                            var num = Number($('#output_' + data).val()) + Number(1)
                            $('input#output_' + data).val(num);
                            $('.jhz_' + data).text(num);
                            }else {

                                if (jQuery.inArray(serial, serialList) !== -1) {
                                    alert('السيريال مدخل للمادة ذات الباركود ' + data)
                                } else {

                                    serialList.push(serial);

                                    var serialPrint = '';
                                    jQuery.each(serialList, function (i, val) {
                                        serialPrint += `<div class="outSerial">${val}</div>`;
                                    });

                                    $(".list_serial_enter" + data).html(serialPrint)
                                    var num = Number($('#output_' + data).val()) + Number(1)
                                    $('input#output_' + data).val(num);
                                    $('.jhz_' + data).text(num);
                                }

                            }


                        }
                    }else {
                        alert('يرجى تجهيز  كمية كل المادة  ' + code + '  قبل الانتقال الى مادة اخرى ')
                    }



                    $("input#code_checked").select()

                    if ($('input#input_' + data).val() === $('#output_' + data).val()) {


                        $.ajax({
                            type: "POST",
                            url: url + "/" + id_user + "/" + code + "/" + number_bill,
                            data: form.serialize() + "&id_user=" + id_user + "&number_bill=" + number_bill+"&code=" + code+ "&enter_serial="+serialList, // serializes the form's elements.
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


                                // $('#realCode').val(codeGet);


                                if (data === "notFoundCode") {
                                    alert("الباركود غير صحيح يرجى التأكد");
                                }


                                else if (data==='notFoundSerial')
                                {
                                    alert('السيريال غير موجود')
                                }
                                else if (data === "location") {


                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/location3");
                                    $("#addLocation").show().html(`<input  data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني"  autocomplete="off" type="text" id="input_location" class="form-control location_checked"   name="location" required> <div class="locationItem"></div>`);
                                    $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                        code: codeGet,
                                        table: table
                                    }, function (data) {
                                        $(".locationItem").html(data);
                                    });

                                    $("#input_location").select();

                                    $("#goOk").click();
                                } else if (data === "Location2_enterSerial") {

                                    if (check_serial_prepared ==='false') {

                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").show().html(`<label> ادخل  موقع  المادة </label> <input  data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني"  autocomplete="off" type="text"  class="form-control location_checked"  name="location" required> <div class="locationItem2"></div>`);

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


                                    $('#model_enterSerial2location').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    $('.model_edit_serial').val(table)

                                    $('#enter_serial_1').select()

                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez3")
                                    $("#addLocation").hide().empty();


                                    }else {


                                        $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/enterSerial2location3");
                                        $("#addLocation").show().html(`<input type="text"   data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني" autocomplete="off"  class="form-control location_checked"  name="location" required> <div class="locationItem"></div>`);
                                        $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                            code: codeGet,
                                            table: table
                                        }, function (data) {
                                            $(".locationItem").html(data);
                                        });

                                        $("#goOk").click();


                                    }


                                } else if (data === 'enterSerialOnly') {
                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").empty();
                                    $("#barcodeBdel").empty();


                                    if (check_serial_prepared ==='false') {


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


                                    $('#model_enterSerial2location').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    $('.model_edit_serial').val(table)

                                    $('#enter_serial_1').select()


                                    }else {


                                        $.ajax({
                                            type: "POST",
                                            url: "<?php  echo url . '/' . $this->folder?>/enterSerial2location3",
                                            data: {
                                                id_user: id_user,
                                                code: code,
                                                number_bill: number_bill,
                                                enter_serial: serialList
                                            }, // serializes the form's elements.
                                            success: function (data) {

                                                console.log(data)
                                                if (data === "notFoundSerial") {
                                                    alert('السيريال غير موجود');
                                                } else if (data === "notFoundCode") {
                                                    alert("الباركود غير صحيح")
                                                } else if (data === "notLocation") {
                                                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                                                } else if (data === "not_enough") {
                                                    alert("الكمية غير كافية في هذا الموقع")
                                                    $("#addLocationSerial2 .location_checked").select();
                                                } else if (data === "hide_location") {
                                                    alert("لا يمكن التجهيز من الموقع المختار")
                                                    $("#addLocation .location_checked").select();
                                                } else if (data === code) {
                                                    $('#model_enterSerial2location').modal('hide')
                                                    $('#addLocationSerial').empty();
                                                    $('#barcodeBdel').empty();
                                                    $('#addLocationSerial2').empty();
                                                    $(".location_checked").val();
                                                    $(".jhz_" + data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                                    $(".jhz_btn_" + data).empty();
                                                    $("#code_checked").val('');
                                                    $('#realCode').val('');
                                                    resetParmt()
                                                    number_bill_reload()
                                                } else {
                                                    // alert("فشل تجهيز المادة ")
                                                    $('#model_enterSerial2location').modal('hide')
                                                    $('#addLocationSerial').empty();
                                                    $('#barcodeBdel').empty();
                                                    $('#addLocationSerial2').empty();
                                                    $(".location_checked").val();
                                                    $(".jhz_" + data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                                    $(".jhz_btn_" + data).empty();
                                                    $("#code_checked").val('');
                                                    $('#realCode').val('');
                                                    resetParmt()
                                                    number_bill_reload()
                                                }
                                            }
                                        });


                                    }


                                } else if (data === "notLocation") {
                                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                                } else if (data === "not_enough") {
                                    alert("الكمية غير كافية في هذا الموقع1")
                                    $("#addLocation .location_checked").select();

                                } else if (data === "hide_location") {
                                    alert("لا يمكن التجهيز من الموقع المختار")
                                    $("#addLocation .location_checked").select();
                                }else if (codeGet === code) {
                                    $(".jhz_" + codeGet).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                    $(".jhz_btn_" + codeGet).empty();
                                    $("#code_checked").val('');
                                    $('#realCode').val('');
                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez3")
                                    $("#addLocation").hide().empty();
                                    resetParmt()
                                    number_bill_reload()
                                } else {
                                    alert("فشل تجهيز المادة")
                                }

                            }
                        });


                    }

                }else
                {
                    $('.jhz_' + data).text($('input#input_' + data).val());
                     $.ajax({
                            type: "POST",
                            url: url + "/" + id_user + "/" + code + "/" + number_bill,
                         data: form.serialize() + "&id_user=" + id_user + "&number_bill=" + number_bill+"&code=" + code+ "&enter_serial="+serialList, // serializes the form's elements.
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


                                // $('#realCode').val(codeGet);


                                if (data === "notFoundCode") {
                                    alert("الباركود غير صحيح يرجى التأكد");
                                }


                                else if (data==='notFoundSerial')
                                {
                                    alert('السيريال غير موجود')
                                }
                                else if (data === "location") {

                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/location3");
                                    $("#addLocation").show().html(`<input  data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني"  autocomplete="off" type="text"  class="form-control location_checked"   name="location" required> <div class="locationItem"></div>`);
                                    $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                        code: codeGet,
                                        table: table
                                    }, function (data) {
                                        $(".locationItem").html(data);
                                    });

                                    $("#goOk").click();

                                } else if (data === "Location2_enterSerial") {


                                    if (check_serial_prepared ==='false') {


                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").show().html(`<label> ادخل  موقع  المادة </label> <input  data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني"  autocomplete="off" type="text"  class="form-control location_checked"  name="location" required> <div class="locationItem2"></div>`);

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


                                    $('#model_enterSerial2location').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    $('.model_edit_serial').val(table)

                                    $('#enter_serial_1').select()

                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez3")
                                    $("#addLocation").hide().empty();


                                    }else {


                                        $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/enterSerial2location3");
                                        $("#addLocation").show().html(`<input type="text"   data-toggle="tooltip" data-placement="top" title="الموقع الاول + الموقع الثاني + الموقع الثالث ..." onblur="read_barcode_location(this)"  placeholder="الموقع الاول + الموقع الثاني" autocomplete="off"  class="form-control location_checked"  name="location" required> <div class="locationItem"></div>`);
                                        $.get("<?php  echo url . '/' . $this->folder?>/location_get", {
                                            code: codeGet,
                                            table: table
                                        }, function (data) {
                                            $(".locationItem").html(data);
                                        });

                                        $("#goOk").click();

                                    }

                                } else if (data === 'enterSerialOnly') {
                                    $("#barcode_show2").text($("#code_checked").val());
                                    $("#addLocationSerial2").empty();
                                    $("#barcodeBdel").empty();
                                    if (check_serial_prepared ==='false') {
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


                                    $('#model_enterSerial2location').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    $('.model_edit_serial').val(table)

                                    $('#enter_serial_1').select()


                                    }else {

                                        $.ajax({
                                            type: "POST",
                                            url: "<?php  echo url . '/' . $this->folder?>/enterSerial2location3",
                                            data: {
                                                id_user: id_user,
                                                code: id_user,
                                                number_bill: number_bill,
                                                enter_serial: serialList
                                            }, // serializes the form's elements.
                                            success: function (data) {

                                                console.log(data)
                                                if (data === "notFoundSerial") {
                                                    alert('السيريال غير موجود');
                                                } else if (data === "notFoundCode") {
                                                    alert("الباركود غير صحيح")
                                                } else if (data === "notLocation") {
                                                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                                                } else if (data === "not_enough") {
                                                    alert("الكمية غير كافية في هذا الموقع")
                                                    $("#addLocationSerial2 .location_checked").select();
                                                } else if (data === "hide_location") {
                                                    alert("لا يمكن التجهيز من الموقع المختار")
                                                    $("#addLocation .location_checked").select();
                                                } else if (data === code) {
                                                    $('#model_enterSerial2location').modal('hide')
                                                    $('#addLocationSerial').empty();
                                                    $('#barcodeBdel').empty();
                                                    $('#addLocationSerial2').empty();
                                                    $(".location_checked").val();
                                                    $(".jhz_" + data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                                    $(".jhz_btn_" + data).empty();
                                                    $("#code_checked").val('');
                                                    $('#realCode').val('');
                                                    resetParmt()
                                                    number_bill_reload()
                                                } else {
                                                    // alert("فشل تجهيز المادة ")
                                                    $('#model_enterSerial2location').modal('hide')
                                                    $('#addLocationSerial').empty();
                                                    $('#barcodeBdel').empty();
                                                    $('#addLocationSerial2').empty();
                                                    $(".location_checked").val();
                                                    $(".jhz_" + data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                                    $(".jhz_btn_" + data).empty();
                                                    $("#code_checked").val('');
                                                    $('#realCode').val('');
                                                    resetParmt()
                                                    number_bill_reload()
                                                }
                                            }
                                        });

                                    }


                                } else if (data === "notLocation") {
                                    alert(" موقع المادة غير صحيح لو غير موجود لهذا الباركود ")
                                } else if (data === "not_enough") {
                                    alert("الكمية غير كافية في هذا الموقع ")
                                    $("#addLocation .location_checked").select();

                                }else if (data === "hide_location") {
                                    alert("لا يمكن التجهيز من الموقع المختار")
                                    $("#addLocation .location_checked").select();
                                } else if (codeGet === code) {
                                    $(".jhz_" + codeGet).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                                    $(".jhz_btn_" + codeGet).empty();
                                    $("#code_checked").val('');
                                    $('#realCode').val('');
                                    $("#checkedCode").attr('action', "<?php echo url . '/' . $this->folder ?>/tajhez3")
                                    $("#addLocation").hide().empty();
                                    resetParmt()
                                    number_bill_reload()
                                } else {
                                    alert("فشل تجهيز المادة")
                                }

                            }
                        });


                }


            }
        });





    });



    function resetForm() {
        $("#checkedCode").attr('action',"<?php echo url .'/'.$this->folder ?>/tajhez3")
        $("#addLocation").hide().empty();
        $('#realCode').val('');
    }
    function selectLOcation ()
    {
        var val = [];
        $('.locationList:checked').each(function(i){
            val[i] = $(this).val();
        });
        var x = val.join('+');
        $(".location_checked").val(x)
    }


    var edit_serial='0';

    // this is the id of the form
    $("#enterSerial2from").submit(function(e) {
    	$(this).find(':input[type=submit]').prop('disabled', true);
        e.preventDefault(); // avoid to execute the actual submit of the form.
        number_bill=<?php echo $number_bill ?>;
        id_user=<?php echo $result['id'] ?>;
        // if($('#realCode').val())
        // {
        //     code=$('#realCode').val();
        // }else
        // {
        //     code=$('#code_checked').val();
        // }
        var form = $(this);
        var url = form.attr('action');



        if (check_serial_prepared ==='false') {

        var edit_model_serl=$('.model_edit_serial').val()
        var myarray=['mobile','computer'];
        if(jQuery.inArray(edit_model_serl, myarray) === -1)
        {
            edit_serial='1'
        }


        sendSerialData= form.serialize() + "&id_user=" + id_user + "&number_bill=" + number_bill + "&code=" + code

        }else {
            edit_serial = '1'

            sendSerialData = form.serialize() + "&id_user=" + id_user + "&number_bill=" + number_bill + "&code=" + code + "&enter_serial=" + serialList;

        }

        console.log(serialList)


        if (edit_serial==='1') {



            $.ajax({
            type: "POST",
            url: url,
            data: sendSerialData, // serializes the form's elements.
            success: function(data)
            {


                if (data ==="notFoundSerial")
                {
                    alert('السيريال غير موجود');
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
                    $("#addLocationSerial2 .location_checked").select();

                }else if (data === "hide_location") {
                    alert("لا يمكن التجهيز من الموقع المختار")
                    $("#addLocation .location_checked").select();
                }
                else if (data === code)
                {
                    $('#model_enterSerial2location').modal('hide')
                    $('#addLocationSerial').empty();
                    $('#barcodeBdel').empty();
                    $('#addLocationSerial2').empty();
                    $(".location_checked").val()
                    $(".jhz_"+data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                    $(".jhz_btn_"+data).empty();
                    $("#code_checked").val('');
                    $('#realCode').val('');
                    resetParmt()
                    number_bill_reload()
                }else
                {
                    // alert("فشل تجهيز المادة ")
                    $('#model_enterSerial2location').modal('hide')
                    $('#addLocationSerial').empty();
                    $('#barcodeBdel').empty();
                    $('#addLocationSerial2').empty();
                    $(".location_checked").val();
                    $(".jhz_" + data).html(`<i   class="fa fa-check-circle done_prepared"></i>`)
                    $(".jhz_btn_" + data).empty();
                    $("#code_checked").val('');
                    $('#realCode').val('');
                    resetParmt()
                    number_bill_reload()
                }
            }
        });
            $(document).ready(function () {
                $("input#code_checked").select()
            });
            edit_serial='0'
        }else {


            $('#edit_save_serial').modal('show');

            return false
        }

    });


    function edit_save_serial_prepared() {

        edit_serial='1';
        $('#serial_prepared').click()

        $('#edit_save_serial').modal('hide');
        $('#model_enterSerial2location').modal('hide')
        $('.modal-backdrop').remove()



    }




    function print_bill_sale_sale() {
        $('.print_bill_casher'). removeClass('casher');
        $('.print_bill_sale'). addClass('sale');

        window.print();
    }


    function print_bill_casher() {




 <?php if ($_SESSION['print']) {   ?>


        $('#spinner'). show();
        var bill = $('.python_print').html();

        $.post( "<?php  echo url  ?>/bill_print",{bill:bill}, function( data ) {
            if (data)
            {

                $('#spinner'). hide();
                $('.body_print_bill'). hide();
                $('.result'). empty();

            }else{
                $('.spinner'). hide();
                alert('لا يمكن الطباعة')
            }

        });

        <?php  } else{  ?>
        $('#spinner'). hide();
        $('.print_bill_sale'). removeClass('sale');
        $('.print_bill_casher'). addClass('casher');

        window.print();
        <?php  if (!in_array('games',$this->catgUser) ) {   ?>
        window.print();
        <?php  } ?>

      <?php  } ?>

    }





    function tajhez3(s,id_cart,id,id_user,table,code,color) {
        var serial='';
        if (s===1)
        {
            serial=$('#serial_'+id_cart).val();
            if (serial)
            {
                $.get( "<?php echo url .'/'.$this->folder ?>/serial",{id:id,serial:serial,table:table,code:code,color:color}, function( data ) {


                    if (data==='true')
                    {

                        $.get( "<?php echo url .'/'.$this->folder ?>/tajhez3",{id_cart:id_cart,id:id,id_user:id_user,serial:serial,table:table,number_bill:<?php echo $number_bill ?>}, function( data ) {

                            if (data==='1')
                            {

                                    $('.jhz_'+id_cart).html('<i   class="fa fa-check-circle done_prepared"></i>');

                            }else
                            {
                                $('.jhz_'+id_cart).html('<i   class="fa fa-minus-circle note_prepared"></i>');
                                alert('فشلت عملية التجهيز')
                            }
                        });

                    }else
                    {
                        $('.boxCh_'+id_cart).show();
                        $('.result_serial_'+id_cart).html('<i style="color: red" class="fa fa-times-circle"></i>')
                    }
                });

            }else
            {
                alert('يجب ادخال الباركود او السيريال')
            }

        }else
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/tajhez3",{id_cart:id_cart,id:id,id_user:id_user,serial:serial,table:table,number_bill:<?php echo $number_bill ?>}, function( data ) {
                if (data==='1')
                {

                        $('.jhz_'+id_cart).html('<i   class="fa fa-check-circle done_prepared"></i>');


                }else
                {
                    $('.jhz_'+id_cart).html('<i   class="fa fa-minus-circle note_prepared"></i>');
                    alert('فشلت عملية التجهيز')
                }
            });
        }
    }

    function checkBarCode(id_cart,id,table,code,color) {
        var  serial=$('#serial_'+id_cart).val();
        $('.boxCh_'+id_cart).show();
        if (serial)
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/serial",{id:id,serial:serial,table:table,code:code,color:color}, function( data ) {
                if (data==='true')
                {

                    $('.result_serial_'+id_cart).html('<i style="color: green" class="fa fa-check-circle"></i>')
                }else
                {
                    $('.result_serial_'+id_cart).html('<i style="color: red" class="fa fa-times-circle"></i>')
                }
            });
        }else {
            alert('يجب كتابة الباركود او السيريال')
        }
    }


    function  return_order_minus3(id_order,table,colde,id_user,color,number_bill) {



        if ($('#number_item_' + id_order).text()  === '1')
        {
            if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus3/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {color:color,number_bill:number_bill},
                    success: function (response) {


                        if (response) {

                            if (response === '-1')
                            {
                               alert('المبلغ الذي معك غير كافي للسترجاع')
                            }else {

                                number_bill_reload();
                                if (isNaN(response)) {
                                    window.location = "<?php echo url ?>/home"
                                } else {
                                    $('#number_item_' + id_order).html(response);
                                    $('#row_' + id_order).remove();
                                }
                            }

                        }else
                        {
                            alert('حدث خطا')
                        }

                        $('#minus_x_'+id_order).removeAttr('disabled');
                    }
                });

            }

        }else {
            $('#minus_x_'+id_order).attr('disabled','disabled');

            if (confirm('هل انت متأكد؟'))
            {

               $.ajax({
                type: 'GET',
                url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus3/" + table + "/" + colde + "/" + id_user,
                cache: false,
                data: {color:color,number_bill:number_bill},
                success: function (response) {

                    if (response) {

                        if (response === '-1')
                        {
                            alert('المبلغ الذي معك غير كافي للسترجاع')
                        }else {
                            number_bill_reload();
                            if (isNaN(response)) {
                                window.location = "<?php echo url ?>/home"
                            } else {
                                $('#number_item_' + id_order).html(response);
                            }
                        }

                    }else
                    {
                        alert('حدث خطا1')
                    }
                    $('#minus_x_'+id_order).removeAttr('disabled');

                }
            });

            }else  return false

        }
    }

    function  return_order_plus3(id_order,table,colde,id_user,color,id_row,number_bill) {

        $('#plus_x_'+id_order).attr('disabled','disabled');

        $.ajax({
            type: 'GET',
            url: "<?php  echo url . '/' . $this->folder ?>/return_order_plus3/" + table + "/" + colde + "/" + id_user+ "/" + id_row,
            cache: false,
            data: {color:color,number_bill:number_bill},
            success: function (response) {


                if (response){
                    number_bill_reload();
                    if (isNaN(response))
                    {
                       window.location="<?php echo url ?>/home"
                    }else {
                        alert('تم زيادة الكمية يرجى الذهاب الى خانة قيد المحاسبة لتأكيد الدفع')
                    }

                }else
                {
                    alert('حدث خطا')
                }

                $('#plus_x_'+id_order).removeAttr('disabled');

            }
        });




    }

    function read_barcode_location(e) {
        var  loct=$(e).val();
        if (loct)
        {
            $(e).val(loct + " + ");
        }

    }

</script>



<div class="modal" id="model_enterSerial2location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input  type="hidden" class="model_edit_serial">

                <form method="post" id="enterSerial2from" action="<?php  echo url  .'/'.$this->folder?>/enterSerial2location3">


                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">  تفاصيل المادة  </h5>
                </div>

                <div class="modal-body">

                    <label>باركود المادة </label>
                    <label  style="background: #e9ecef;" class="form-control" id="barcode_show2" ></label>
                    <br>

                    <div id="barcodeBdel">

                    </div>


                    <div class="input_serial_check">
                        <label>  ادخال سيريال  المادة 1</label>
                        <input   id="enter_serial_1"  autocomplete="off" type="text" required  class="form-control" name="enter_serial[]">
                        <div class="list_serial">

                        </div>

                        <br>
                    </div>

                    <div id="addLocationSerial2">

                    </div>


                </div>

                <div class="modal-footer" style="display: block;text-align: center">
                    <button type="submit" name="submit" id="serial_prepared"   class="btn btn-success"> موافق  </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>

                </div>

            </form>

            </div>
        </div>

</div>




<hr>


<br>
<br>
<br>
<br>


</div>
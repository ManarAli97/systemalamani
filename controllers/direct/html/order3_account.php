
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
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  نوع الجهاز </th>
                        <td style="width: 40px;"> حجم الذاكرة  </td>
                        <td style="width: 40px;"> اللون  </td>
                        <td style="width: 40px;">  الكمية </td>

                        <td style="width: 100px;">السعر</td>
                        <td style="width: 160px;">السعر الاجمالي</td>

                    </tr>

					<?php   foreach ($requestPrint as $rows)  {  ?>
                        <tr class="not_prepared" >
                            <td style="font-size:20px" ><?php  echo $rows['code'] ?></td>
                            <td  ><p id="title2"></p></td>


                            <?php if($rows['table'] == 'product_savers')  {?>
                                <td><?php  echo $rows['name_device_customer'] ?></td>
                            <?php } elseif($rows['table'] == 'accessories') { ?>
                                <td> <p id="title1"></p> <br/><br/></td>
                            <?php } else{  ?>
                                <td></td>
                            <?php }?>


                            <td  ><?php  echo $rows['size'] ?></td>
                            <td><?php  echo $rows['color_name']   ?>  </td>
                            <td><?php  echo $rows['number'] ?></td>
                            <td  style="font-size:21px" ><?php  echo str_replace( 'د.ع','', $rows['price'] )  ?>  </td>
                            <td style="font-size:21px" ><?php  echo number_format((int)trim(str_replace($this->comma,'',$rows['price'])) * (int)$rows['number'])    ?>  </td>


                        </tr>

					<?php  }  ?>


                    </tbody>
                </table>


                <div class="row justify-content-between">

                    <div class="col">

                        <div class="row">
                            <div class="col-auto">

                                <div class="sumbill_denar">
                                    <span>   مجموع القائمة دينار  : </span> <span> <?php echo number_format($price1Offer) ?> </span>
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

                            JsBarcode(".barcode_amount", "<?php echo  number_format($price1Offer)    ?>", {
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

                        <td style="text-align: right;;font-size: 18px; "  >
                            <div class="date_bill">  <span>التاريخ: </span>  <span> <?php echo date('d-m-Y',$date)  ?> </span> </div>
                            <div class="time_bill"><span>الوقت:</span> <span> <?php echo date('H:i',$date)  ?> </span> </div>
                        </td>
                        <td style="text-align: left; ">
                            <span><svg class="barcode"></svg></span> <span>:NO</span>
                        </td>

                    </tr>

                    </tbody>
                </table>



                <div class="customer_name" style="margin-bottom: 15px;font-size: 20px;" >

                    <span> حضرة السيد: </span> <span>  <?php echo $result['name'] ?>  </span>

                </div>



                <table border='1' class="  tableBill  tableBill_casher  table-bordered  "  style="width: 100%;border-collapse: collapse;"  >
                    <tbody>
                    <tr>
                        <td style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>اسم المادة</td>
                        <th style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  نوع الجهاز </th>
                        <td style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  حجم الذاكره </td>
                        <td style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  اللون </td>
                        <td style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>  الكمية  </td>
                        <td style='padding : 0.65rem !important;font-weight: bold;font-size: 20px;'>السعر  </td>

                    </tr>
                    <?php    foreach ($requestPrint as $key => $rows)  {  ?>
                        <tr  class="<?php  if ($rows['prepared']==1) echo 'not_prepared'?>" >
                            <td style='padding : 0.65rem !important;font-size: 20px;'><p id="title4"></p></td>

                            <?php if($rows['table'] == 'product_savers')  {?>
                                <td><?php  echo $rows['name_device_customer'] ?></td>
                            <?php } elseif($rows['table'] == 'accessories') { ?>
                                <td> <p id="title3"></p> <br/><br/></td>
                            <?php } else{  ?>
                                <td></td>
                            <?php }?>


                            <td style='padding : 0.65rem !important;font-size: 20px;'><?php  echo $rows['size'] ?></td>
                            <td style='padding : 0.65rem !important;font-size: 20px;'><?php  echo $rows['color_name']   ?>  </td>
                            <td style='padding : 0.65rem !important;font-size: 20px;'><?php  echo $rows['number'] ?></td>
                            <td  style="font-size:20px;padding : 0.65rem !important" ><?php  echo str_replace( 'د.ع','', $rows['price'] )  ?>  </td>
                        </tr>
                    <?php  }  ?>
                    </tbody>
                </table>



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
                    <span>  مجموع الفاتورة: </span> <span> <?php echo  number_format($price1Offer)  ?></span> <span> دينار </span>

                </div>

                <div   style="text-align: center">
                    <svg class="barcode_amount"></svg>
                </div>

                <div style="margin: 15px 0;margin-bottom: 35px ;font-size: 20px;" >
                    <span>     المبلغ فقط: </span> <span id="write_amount2"> </span> <span> دينار </span>

                </div>

                <hr>
                <div  style="text-align: center"  >

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





    <table class="table table-striped text-center" border="1">
        <thead>
        <tr class="table-info">
            <th   scope="col">رقم الفاتورة</th>
            <th   scope="col"> مجموع الفاتورة </th>
            <th   scope="col"> اجراء  </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"><?php echo $number_bill ?></th>
            <th scope="row"> <span id="number_bill_reload"> <?php echo  number_format($price1Offer) ?> </span><span>د.ع</span></th>
            <td>

                    <div class="row align-items-center justify-content-center">


                        <div class="col-3   r_x  progs_r_x">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"  aria-valuemax="100" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="col-auto rejected_processing r_x">
                            <button  onclick="open_why_rejected()"  class="btn btn-warning  rejected_processing_x "> <span>     الغاء الطلب  </span>  </button>   <span  class="error"> </span>
                        </div>

                        <div class="col-3  d_x progs_d_x">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemax="100" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="col-auto done_processing d_x">
                            <button  onclick="processing_request(<?php echo $number_bill ?>)"  class="btn btn-success  processing_request "> <span>   تمت المحاسبه </span>  </button>   <span  class="error"> </span>
                        </div>
                    </div>


            </td>
        </tr>


        </tbody>
    </table>



<!-- manar -->
    <hr>
<div class="row">

    <div class="col-12">

        <?php  if (!empty($request)) { ?>

            <table class="requ_on table table-striped" border>
                <thead>


                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">صورة</th>
                    <th  scope="col">اسم المنتج</th>
                    <th scope="col"> نوع الجهاز </th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>
                    <th scope="col">   ملاحظة </th>

                    <th  class="retn"  scope="col">   زيادة / نقصان   </th>

                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><p id="title"></p>

                            <?php  if ($rows['offers']) {  ?>
                                <div class="offers_" style="font-size: 10px; background: #8bc34a6b; border-radius: 5px;">
                                    <?php  echo  $this->details_offer($rows['id_offer'],'title')?>
                                </div>
                            <?php } ?>
                        </td>
                        <?php if($rows['table'] == 'product_savers')  {?>
                                <td><?php  echo $rows['name_device_customer'] ?></td>
                            <?php } elseif(($rows['table'] == 'accessories') && (!empty($nameCatAcc))) { ?>
                                <td>

                                    <select class="custom-select dropdown_filter" name="category" id="category"  required>
                                        <option value="">   نوع الجهاز  </option>
                                        <?php foreach ($nameCatAcc as $key => $catg) {   ?>
                                            <option    value="<?php  echo $catg['title']?>"><?php  echo $catg['title']?></option>
                                        <?php  } ?>

                                    </select>

                                <br/><br/></td>
                            <?php } else{  ?>
                                <td></td>
                            <?php }?>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <td><?php  echo $rows['code'] ?></td>
                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>

                        <td>

                            <?php  if ($this->checkEditPrice($this->userid)) {  ?>

                                <div class="input-group mb-2">
                                    <input style="   min-width: 80px;" onkeyup="add_comma(this)" class="form-control" id="new_price_<?php  echo $rows['id_item'] . $rows['table']. $rows['code']?>"  value="<?php  echo  trim(str_replace('د.ع','', $rows['price'] ))?>">

                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding: 0">
                                            <button style="border-radius: 0;height: 100%;" class="btn btn-danger btn-sm" onclick="edit_price(<?php  echo $rows['id_member_r'] ?>,<?php  echo $rows['id_item'] ?>,<?php  echo $rows['number_bill'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>','<?php  echo $rows['color_name'] ?>')"   > <i class="fa fa-save"></i>  </button>
                                        </div>
                                    </div>
                                </div>

                            <?php  }  else {  ?>
                                <?php  echo $rows['price']   ?>

                            <?php }  ?>

                            <?php  if ($rows['price_type'] > 0) { ?>
                                <span class="type_price_account" > <?php  echo  $this->price_type[$rows['price_type']]; ?> </span>
                            <?php  } ?>


                        </td>


                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                        <td><?php  echo  $rows['note']  ?></td>

                        <td style="text-align: center" id="remove_plus_minus">
                            <?php  if (!$rows['offers']) {  ?>
                            <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus3(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php  echo $rows['id'] ?>','<?php  echo $number_bill ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                            <?php  }  ?>
                            <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php echo $number_bill ?>')">  <i   class="fa fa-minus-circle"></i>    </button>

                        </td>
                    </tr>
                <?php  }  ?>

                </tbody>
            </table>


            <br>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <button class="btn btn-primary" disabled   id="bill_sale" onclick="print_bill_sale_sale()"> <i class="fa fa-print"></i> <span> طباعة فاتورة مبيع  </span></button>
                </div>
                <div class="col-auto">
                    <button class="btn btn-warning"     id="bill_casher" onclick="print_bill_casher()"> <i class="fa fa-print"></i> <span> طباعة فاتورة كاشير  </span>
                        <span id="spinner" style="vertical-align: unset;display: none" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                    </button>
                </div>
            </div>

        <?php  } else  {    ?>
            <div class="alert alert-warning" role="alert">
                لا يوجد طلب جديد
            </div>
        <?php   }  ?>
    </div>

</div>


<script>

    $('#category').on('change',function() {
        var nameGategory = $("#category").val();
        $('#title').text(nameGategory);
        $('#title1').text(nameGategory);
        $('#title2').text(nameGategory);
        $('#title3').text(nameGategory);
        $('#title4').text(nameGategory);

        if($("#category").val() != ''){
            $("#bill_casher").attr("disabled", false);
            $(".processing_request ").attr("disabled", false);
        }else{
            $("#bill_casher").attr("disabled", true);
            $(".processing_request ").attr("disabled", true);
        }
    });
    if($("#category").val() == ''){
        $("#bill_casher").attr("disabled", true);
        $(".processing_request ").attr("disabled", true);
    }else{
        $("#bill_casher").attr("disabled", false);
        $(".processing_request ").attr("disabled", false);
    }

    function edit_price (id_member_r1,id_item1,number_bill1,table1,code1,color_name1) {
        var new_price=$("#new_price_"+id_item1+table1+code1).val();


        if (new_price)
        {
            if (confirm('هل انت متأكد من تغير السعر؟'))
            {

                $.get( "<?php  echo url .'/'. $this->folder ?>/edit_price",

                    {price:new_price,
                        id_member_r:id_member_r1,
                        id_item:id_item1,
                        number_bill:number_bill1,
                        table:table1,
                        code:code1,
                        color_name:color_name1}
                    , function( data ) {

                        if (data ==='xprice')
                        {
                            alert('السعر غير صحيح')
                        }else if (data === 'not_found'){
                            alert('المادة غير موجودة في الفاتورة')
                        }else if(data==='xchange_price')
                        {
                            alert('لا يمكن تغير السعر لهذة المادة!')
                        }else if (data ==='edit')
                        {
                            alert('تم تغير السعر')
                        }else if (data === 'not_edit')
                        {
                            alert(' لم يتم تغير السعر ')
                        }else
                        {
                            alert('حدث خطاء يرجى المحاولة مرة ثانية')
                        }
                        getOrder(id_member_r1,number_bill1)
                    });

            } return false;

        }else {
            alert('يرجى ادخال السعر')
        }

    }


    function add_comma(e)
    {
        valu=$(e).val();
        $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }


    function print_bill_sale_sale() {
        $('.print_bill_casher'). removeClass('casher');
        $('.print_bill_sale'). addClass('sale');

        window.print();
    }

    function print_bill_casher() {


 <?php  if ($_SESSION['print']) {   ?>


       $('#spinner'). show();
       var bill = $('.python_print').html();

        $.post( "<?php  echo url  ?>/bill_print",{bill:bill}, function( data ) {
            if (data)
            {
                window.location='<?php echo url  .'/'. $this->folder ?>/direct3'
                $('#spinner'). hide();
                $('.body_print_bill'). hide();
                $('.result'). empty();

            }else{
                $('.spinner'). hide();
                alert('لا يمكن الطباعة')
            }

        });

        <?php  } else {  ?>
        $('#spinner'). hide();
        $('.print_bill_sale'). removeClass('sale');
        $('.print_bill_casher'). addClass('casher');

        window.print();
        <?php  if (!in_array('games',$this->catgUser) ) {   ?>
        window.print();
        <?php  } ?>
        window.location='<?php echo url  .'/'. $this->folder ?>/direct3'
 <?php  } ?>

    }



</script>


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


<script>



    function  processing_request(number_bill) {

            $.ajax({
                type: 'GET',
                url: '<?php echo url .'/'.$this->folder ?>/processing_request3_account/<?php echo $result["id"]?>',
                cache: false,
                data: { number_bill: number_bill},
                success: function (result) {



                    $('#exampleModal_delivery_service').modal('hide');
                    if (result === '1') {


                        $('#exampleFormControlTextarea1').val('');

                        $('.r_x').hide();
                        $('.progs_d_x').css('display', 'block');
                        setTimeout(function () {
                            $('.retn').remove();
                            $('.progs_d_x').hide();
                            $('.done_processing').html('');
                        }, 1000);

                        $('#remove_plus_minus').empty()
                        $('#bill_sale').removeAttr('disabled')
                        $('#bill_casher').removeAttr('disabled')
                        print_bill_casher();
                    }else if (result==='accounted')
                    {
                        alert('تمت محاسبة الفاتورة من قبل محاسب اخر')
                        window.location=''

                    }  else {
                        $('.progs_d_x').css('display', 'block');
                        setTimeout(function () {
                            $('.progs_d_x').hide();
                            $('.error').html('فشل');
                        }, 1000);
                    }
                   // reloadData()
                },
            });


    }




    function open_why_rejected() {
        $('#exampleModal_model_why_rejected').modal('show')
    }

    function  processing_request_rejected() {

        why_rej=$('#why_rejected').val();

        if (why_rej)
        {
            $.ajax({
                type: 'GET',
                url: '<?php echo url  .'/'.$this->folder?>/processing_request_rejected/<?php echo $result["id"]?>/<?php echo $number_bill ?>',
                cache: false,
                data: {why_rej:why_rej},
                success: function (result) {

                    console.log(result);

                    if (result==='1')
                    {
                        $('#exampleModal_model_why_rejected').modal('hide');
                        $.get( "<?php  echo url .'/'.$this->folder ?>/delete_note/<?php   echo $result['id'] ?>", function( data ) {

                            $('#exampleFormControlTextarea1').val('');
                        });

                        $('.d_x').hide();
                        $('.progs_r_x').css('display','block');
                        setTimeout(function(){
                            $('.retn').remove();
                            $('.progs_r_x').hide();
                            $('.rejected_processing').html('<button  class="btn btn- btn-link  rejected_processing_x "> <i style="color:red " class="fa fa-check-circle"></i> <span>    تم الغاء الطلب    </span>  </button>');
                        }, 1000);
                        reloadData()

                    }else
                    {
                        $('#exampleModal_model_why_rejected').modal('hide');
                        $('.progs_r_x').css('display','block');
                        setTimeout(function(){
                            $('.progs_r_x').hide();
                            $('.error').html('فشل');
                        }, 1000);
                    }

                },
            });


        }else
        {
            alert('يجب كتابة سبب الغاء الطلب')
        }


    }


    function  return_order_minus(id_order,table,colde,id_user,color,number_bill) {

            if ($('#number_item_' + id_order).text()  === '1')
            {
                if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                    $('#minus_x_'+id_order).attr('disabled','disabled');

                    $.ajax({
                        type: 'GET',
                        url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                        cache: false,
                        data: {id_order:id_order,color:color,number_bill:number_bill},
                        success: function (response) {

                            if (response) {
                                number_bill_reload();
                                if (isNaN(response)) {
                                    window.location = "<?php echo url ?>/home"
                                } else {
                                    alert('تم نقصان الكمية')
                                    $('#number_item_' + id_order).html(response);
                                    $('#row_' + id_order).remove();
                                }
                            }else
                            {
                                alert('حدث خطا')
                            }

                            $('#minus_x_'+id_order).removeAttr('disabled');
                        }
                    });
                    reloadData()
                }

            }else {
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {id_order:id_order,color:color,number_bill:number_bill},
                    success: function (response) {
                        if (response) {
                            number_bill_reload();
                            if (isNaN(response))
                            {
                                 window.location="<?php echo url ?>/home"
                            }else
                            {
                                alert('تم نقصان الكمية')
                                $('#number_item_' + id_order).html(response);
                            }
                        }else
                        {
                            alert('حدث خطا')
                        }
                        $('#minus_x_'+id_order).removeAttr('disabled');

                    }
                });

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
                        alert('تم زيادة الكمية ')
                    }

                }else
                {
                    alert('حدث خطا')
                }

                $('#plus_x_'+id_order).removeAttr('disabled');

            }
        });




    }

</script>



<div class="modal fade" id="exampleModal_model_why_rejected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">   سبب الغاء الطلب  </h5>
            </div>
            <div class="modal-body">

                <textarea id="why_rejected" class="form-control"  rows="3" required></textarea>

            </div>
            <div class="modal-footer">
                <button  onclick="processing_request_rejected()"  type="button" class="btn btn-secondary"  > موافق </button>
            </div>

        </div>
    </div>
</div>






<hr>



<br>
<br>
<br>
<br>


</div>
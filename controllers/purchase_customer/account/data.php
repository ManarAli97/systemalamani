<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale">
            <?php  if (!empty($bill)) { ?>

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
                                    <span>الوقت:</span> <span>  <?php echo date('H:i',time())  ?></span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span>   شراء  </span>
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

                        <td style="width: 40px;">  الكمية </td>

                        <td style="width: 100px;">السعر</td>
                        <td style="width: 160px;">السعر الاجمالي</td>

                    </tr>

                    <?php   foreach ($bill as $rows)  {  ?>
                        <tr  >
                            <td style="font-size:20px" ><?php  echo $rows['code'] ?></td>
                            <td  ><?php  echo $rows['title'] ?></td>

                            <td><?php  echo $rows['quantity'] ?></td>
                            <td style="font-size:21px" ><?php  echo number_format($rows['price_purchase']) ?>   </td>
                            <td style="font-size:21px" ><?php  echo number_format((int)trim(str_replace($this->comma,'',$rows['price_purchase'])) * (int)$rows['quantity'])    ?>  </td>


                        </tr>

                    <?php  }  ?>


                    </tbody>
                </table>


                <div class="row justify-content-between">

                    <div class="col">

                        <div class="row">
                            <div class="col-auto">

                                <div class="sumbill_denar">
                                    <span>   مجموع القائمة دينار  : </span> <span> <?php echo number_format( $sum )  ?> </span>
                                </div>
                            </div>
                            <div class="col-auto">

                                <div class="amonut_write">
                                    <span>    المبلغ فقط  : </span> <span id="write_amountA5"></span>
                                </div>


                                <script>
                                    main ();
                                    function main (){

                                        document.getElementById ("write_amountA5").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$sum))  ?>);

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

                            JsBarcode(".barcode_amount", "<?php echo $sum    ?>", {
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
    <div class="col-sm-12   python_print">
        <div class="print_bill_casher">
            <?php  if (!empty($bill)) { ?>

                <div class="title_company">

                    <img src="<?php echo $this->static_file_site ?>/image/site/bill_title3.png">
                </div>
                <div style="text-align: left;margin-bottom: 8px;font-size: 18px" > <span>السوق الالكتروني</span>  <span>  alamani.iq  </span> </div>



                <div class="customer_name" style="margin-bottom: 15px;font-size: 20px;" >

                    <span> حضرة السيد: </span> <span>  <?php echo $result['name'] ?>  </span> <span>المحترم</span>

                </div>



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

                <div style="text-align: center;margin-bottom: 15px;font-weight: bold;font-size: 18px">
                    شراء
                </div>

                <table border='1' class="  tableBill  tableBill_casher  table-bordered  "  style="width: 100%;border-collapse: collapse;"   >

                    <tbody>

                    <tr>
                        <td style="width: 100px;  padding : 0.65rem !important;font-weight: bold;font-size: 20px;">  رمز المادة </td>
                        <td>اسم المادة</td>

                        <td style="width: 40px;padding : 0.65rem !important;font-weight: bold;font-size: 20px;">  الكمية </td>

                        <td style="width: 100px;padding : 0.65rem !important;font-weight: bold;font-size: 20px;">السعر</td>


                    </tr>

                    <?php   foreach ($bill as $rows)  {  ?>
                        <tr  >
                            <td  style="padding : 0.65rem !important;font-size: 18px;" ><?php  echo $rows['code'] ?></td>
                            <td  style="padding : 0.65rem !important;font-size: 18px;" ><?php  echo $rows['title'] ?></td>

                            <td  style="padding : 0.65rem !important;font-size: 18px;" ><?php  echo $rows['quantity'] ?></td>
                            <td style="padding : 0.65rem !important;font-size: 18px;"><?php  echo number_format($rows['price_purchase']) ?>   </td>

                        </tr>

                    <?php  }  ?>


                    </tbody>
                </table>



                <table style="width: 100%;border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <td   style=' font-size: 18px;text-align: right'  > <span>     مجموع القائمة : </span> <span>  <?php echo number_format( $sum )  ?> </span> <span>دينار</span> </td>
                    </tr>
                    <tr>
                        <td    style=' font-size: 18px;text-align: right;padding-top: 8px;padding-left: 8px'   >
                            <div class="amonut_write">
                                <span>    المبلغ فقط    </span> <span id="write_amount"></span> <span>لا غير</span>
                            </div>


                            <script>
                                main ();
                                function main (){

                                    document.getElementById ("write_amount").innerHTML =  tafqeet (<?php echo (int)trim(str_replace($this->comma,'',$sum))  ?>);


                                }
                            </script>

                        </td>
                    </tr>
                    </tbody>
                </table>



                <table style="width: 100%;border-collapse: collapse;">
                    <tbody>
                    <tr>
                        <td    > <span>    عدد الانواع: </span> <span>  <?php echo  $number_type ?>  </span></td>
                        <td   > <span>     مجموع المواد: </span> <span>  <?php echo  $sum_material ?>  </span></td>

                        <td      ><span>منضم الفاتورة:</span> <span>  <?php echo $_SESSION['usernamelogin'] ?>  </span></td>
                    </tr>
                    </tbody>
                </table>

                <div style="text-align: center;margin-top: 5px">
                    <svg class="barcode_amount"></svg>
                    <script>

                        JsBarcode(".barcode_amount", "<?php echo $sum    ?>", {
                            height: 40,
                            displayValue: true
                        });

                    </script>
                </div>



                <div style="text-align:center;border-top:1px solid #5a5a5a;padding-top: 5px " class="text-center">


                    <div style="font-size: 16px !important;">
                        نسعى دوما بأن تكون تجربة جميع زبائننا معنا تتحقق مقولتنا
                        "وعند الاماني تتحقق الاماني"
                    </div>

                    <div style="font-size: 14px !important;">
                        حال وجود اي ملاحظات نرجو ارسالها عبر السوق الالكتروني لشركتنا:
                        <span style="font-size: 18px !important;font-weight: bold">  alamani.iq</span>
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


<div class="hide_print">
    <div class="row align-items-end justify-content-end">

        <div class="col-auto">
            <button class="btn btn-warning" onclick="payToCustomer(<?php  echo $id_customer?>,<?php  echo $number_bill?>)"  > دفع الى الزبون </button>
        </div>
        <div class="col-auto">
            <button class="btn btn-dark"     id="bill_sale" onclick="print_bill_sale_casher()"> <i class="fa fa-print"></i> <span> طباعة فاتورة كاشير  </span></button>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary"     id="bill_sale" onclick="print_bill_sale_sale()"> <i class="fa fa-print"></i> <span> طباعة فاتورة  A5  </span></button>
        </div>
        <div class="col-auto">
            <button class="btn btn-danger"     id="bill_sale" onclick="cancel_bill(<?php  echo $id_customer?>,<?php  echo $number_bill?>)">  <span>     الغاء الشراء    </span></button>
        </div>

    </div>
    <hr>
    <div class="row align-items-end   justify-content-between">

     <div class="col-auto">
         <div class="row   ">
        <div class="col-auto">
            <div class="infoBill"> <span>رقم الفاتورة </span> : <span> <?php  echo $number_bill?> </span> </div>
        </div>
        <div class="col-auto">
            <div class="infoBill"> <span> مجموع الفاتورة </span> : <span> <?php echo number_format($sum)  ?> د.ع </span> </div>

            </div>
        </div>

    </div>
     <div class="col-auto">
         <div class="row   ">
        <div class="col-auto">
            <div  > <span> التاريخ والوقت </span> : <span>  <?php echo date('d-m-Y h:i:s a', $result2['date']  )  ?> </span> </div>
        </div>
        <div class="col-auto">
            <div  > <span> منشئ الفاتورة </span> : <span> <?php echo $this->UserInfo($result2['userid'])    ?> </span> </div>

            </div>
        </div>


    </div>

    </div>
</div>
<br>
<table class="table table-striped">
    <thead>
    <tr>

        <th scope="col">صورة</th>
        <th scope="col">اسم المادة</th>
        <th scope="col">الباركود</th>
        <th scope="col"> الكمية </th>
        <th scope="col">سعر الشراء</th>
        <th scope="col">سعر البيع</th>
        <th scope="col">ملاحظة</th>

    </tr>
    </thead>
    <tbody>

    <?php foreach ($bill  as $data ) {   ?>

        <tr>
            <td> <img width="40" src="<?php echo $data['image'] ?>"> </td>
            <td> <?php echo $data['title'] ?> </td>
            <td> <?php echo $data['code'] ?> </td>
            <td>

                <?php  if ($this->checkEditPrice($this->userid)) {  ?>

                    <div class="input-group mb-2">
                        <input  type="number" class="form-control" id="new_quantity<?php  echo $data['id'] ?>" min="1"  value="<?php  echo $data['quantity']  ?>">

                        <div class="input-group-prepend">
                            <div class="input-group-text" style="padding: 0">
                                <button style="border-radius: 0;height: 100%;" class="btn btn-danger btn-sm" onclick="new_quantity(<?php  echo $data['id_customer'] ?>,<?php  echo $data['id'] ?>,<?php  echo $data['number_bill'] ?>,'<?php  echo $data['table'] ?>')"   > <i class="fa fa-save"></i>  </button>
                            </div>
                        </div>
                    </div>

                <?php  }  else {  ?>
                    <?php echo $data['quantity'] ?>

                <?php }  ?>



            </td>
            <td>

                <?php  if ($this->checkEditPrice($this->userid)) {  ?>

                    <div class="input-group mb-2">
                        <input  onkeyup="add_comma(this)" class="form-control" id="new_price_purchase<?php  echo $data['id'] ?>"  value="<?php  echo  trim(str_replace('د.ع','', number_format($data['price_purchase']) ))?>">

                        <div class="input-group-prepend">
                            <div class="input-group-text" style="padding: 0">
                                <span class="type_price"> د.ع </span>
                                <button style="border-radius: 0;height: 100%;" class="btn btn-danger btn-sm" onclick="new_price_purchase(<?php  echo $data['id_customer'] ?>,<?php  echo $data['id'] ?>,<?php  echo $data['number_bill'] ?>,'<?php  echo $data['table'] ?>')"   > <i class="fa fa-save"></i>  </button>
                            </div>
                        </div>
                    </div>

                <?php  }  else {  ?>
                    <?php echo number_format($data['price_purchase']) ?> د.ع

                <?php }  ?>


            </td>
            <td>


                <?php  if ($this->checkEditPrice($this->userid)) {  ?>

                    <div class="input-group mb-2">
                        <input  type="text" class="form-control" id="new_price_sale<?php  echo $data['id'] ?>"  value="<?php  echo  $data['price_sale'] ?>">

                        <div class="input-group-prepend">
                            <div class="input-group-text" style="padding: 0">
                                <span class="type_price"> $ </span>
                                <button style="border-radius: 0;height: 100%;" class="btn btn-danger btn-sm" onclick="new_price_sale(<?php  echo $data['id_customer'] ?>,<?php  echo $data['id'] ?>,<?php  echo $data['number_bill'] ?>,'<?php  echo $data['table'] ?>')"   > <i class="fa fa-save"></i>  </button>
                            </div>
                        </div>
                    </div>

                <?php  }  else {  ?>
                    <?php echo $data['price_sale'] ?> $

                <?php }  ?>



            </td>
            <td> <?php echo $data['note'] ?> </td>

        </tr>
    <?php }  ?>

    </tbody>
</table>


<script>


    function new_price_purchase (id_customer,id_row,number_bill,table) {
        var new_price=$("#new_price_purchase"+id_row).val();

        if (new_price)
        {
            if (confirm('هل انت متأكد من تغير السعر؟'))
            {

                $.get( "<?php  echo url .'/'. $this->folder ?>/new_price_purchase",

                    {   price:new_price,
                        id_customer:id_customer,
                        id_row:id_row,
                        number_bill:number_bill,
                        table:table,
                    }
                    , function( data ) {

                        console.log(data)

                        if (data ==='xprice')
                        {
                            alert('السعر غير صحيح')
                        }else if (data === 'not_found'){
                            alert('المادة غير موجودة في الفاتورة')
                        }else if (data ==='edit')
                        {
                            alert('تم تغير السعر')
                        }else
                        {
                            alert('حدث خطاء يرجى المحاولة مرة ثانية')
                        }
                        $('#bill'+number_bill).click();
                    });

            } return false;

        }else {
            alert('يرجى ادخال السعر')
        }

    }


    function new_price_sale (id_customer,id_row,number_bill,table) {
        var new_price_sale=$("#new_price_sale"+id_row).val();

        if (new_price_sale)
        {
            if (confirm('هل انت متأكد من تغير سعر البيع؟'))
            {

                $.get( "<?php  echo url .'/'. $this->folder ?>/new_price_sale",

                    {   price:new_price_sale,
                        id_customer:id_customer,
                        id_row:id_row,
                        number_bill:number_bill,
                        table:table,
                    }
                    , function( data ) {

                        console.log(data)

                        if (data ==='xprice')
                        {
                            alert('السعر غير صحيح')
                        }else if (data === 'not_found'){
                            alert('المادة غير موجودة في الفاتورة')
                        }else if (data ==='edit')
                        {
                            alert('تم تغير السعر')
                        }else
                        {
                            alert('حدث خطاء يرجى المحاولة مرة ثانية')
                        }
                        $('#bill'+number_bill).click();
                    });

            } return false;

        }else {
            alert('يرجى ادخال السعر')
        }

    }


    function new_quantity (id_customer,id_row,number_bill,table) {
        var new_quantity=$("#new_quantity"+id_row).val();

        if (new_quantity)
        {
            if (confirm('هل انت متأكد من تغير الكمية؟'))
            {

                $.get( "<?php  echo url .'/'. $this->folder ?>/new_quantity",

                    {   quantity:new_quantity,
                        id_customer:id_customer,
                        id_row:id_row,
                        number_bill:number_bill,
                        table:table,
                    }
                    , function( data ) {

                        console.log(data)

                        if (data ==='xquantity')
                        {
                            alert('الكمية غير صحيح')
                        }else if (data === 'not_found'){
                            alert('المادة غير موجودة في الفاتورة')
                        }else if (data ==='edit')
                        {
                            alert('تم تغير الكمية')
                        }else
                        {
                            alert('حدث خطاء يرجى المحاولة مرة ثانية')
                        }
                        $('#bill'+number_bill).click();
                    });

            } return false;

        }else {
            alert('يرجى ادخال السعر')
        }

    }


    function cancel_bill (id_customer,number_bill) {

        if (confirm('هل انت متأكد   ؟'))
        {

            $.get( "<?php  echo url .'/'. $this->folder ?>/cancel_bill",

                {
                    id_customer:id_customer,
                    number_bill:number_bill
                }
                , function( data ) {
                    if (data === 'true') {
                        $('.result').empty();
                        $('#bill' + number_bill).remove();
                    } else {
                        alert('فشل الغاء الفاتورة اعد المحاولة')
                    }
                }
                );
        }return false
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

    function print_bill_sale_casher() {
        $('.print_bill_sale'). removeClass('sale');
        $('.print_bill_casher'). addClass('casher');


        window.print();
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










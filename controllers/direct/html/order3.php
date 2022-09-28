<!--x page-->

<div class="row">
    <div class="col-12">
        <div class="print_bill">
            <?php  if (!empty($request)) { ?>

                <div class="header_bill">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <span class="title_compny_bill" > شركة الاماني للتجارة العامة</span>
                        </div>

                        <div class="col-auto">
                            <img class="logo_bill"  src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-between align-items-center">

                    <div class="col-auto">
                        <div class="customer_name">
                            <span>  حضرة السيد/السيدة :</span> <span>  <?php echo $result['name'] ?> </span> </div>
                        <div class="customer_name">
                            <span>   رقم الهاتف :</span> <span>  <?php echo $result['phone'] ?> </span>
                        </div>
                    </div>


                    <div class="col-auto">
                        <div class="info_bill">
                            <span> رقم الفاتورة: </span> <span> <?php echo $number_bill ?> </span>
                        </div>
                        <div class="info_bill">
                            <span>   مجموع الفاتورة: </span> <span> <?php echo $price1 ?> </span> <span>د.ع</span>
                        </div>

                        <div class="info_bill">
                            <span> تاريخ الفاتورة: </span> <span> <?php echo $date ?> </span>
                        </div>

                    </div>
                </div>

                <table class="tableBill table-bordered table table-striped"   >
                    <thead>
                    <tr>
                        <th> صورة المادة</th>
                        <th>اسم المادة</th>
                        <th>قياس المادة</th>
                        <th>لون المادة</th>
                        <th>العدد</th>
                        <th>السعر</th>


                    </tr>

                    </thead>
                    <tbody>
                    <?php   foreach ($request as $rows)  {  ?>
                        <tr>
                            <td> <img class="image_prod"   alt="image" title="image"  src="<?php  echo $rows['img'] ?>"></td>
                            <td><?php  echo $rows['title'] ?></td>
                            <td><?php  echo $rows['size'] ?></td>
                            <td><?php  echo $rows['color_name']   ?>  </td>
                            <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                            <td><?php  echo $rows['price']   ?>  </td>

                        </tr>

                    <?php  }  ?>


                    </tbody>
                </table>


            <?php   }  ?>
        </div>



    </div>
</div>


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
<div class="row">

    <div class="col-12">

        <?php  if (!empty($request)) { ?>
            <div class="row justify-content-between">
                <div class="col-auto infoBillOpen">
                   <span>رقم الفاتورة:</span>  <span><?php echo $number_bill ?></span> //         <span>  مجموع الفاتورة:</span>  <span id="number_bill_reload"> <?php echo $price1 ?> </span><span>د.ع</span>

                </div>


                <div class="col-auto">
                    <button class="btn btn-info tajhezDirect" onclick="tajhezDirect('<?php echo $number_bill ?>',<?php echo $result['id'] ?>)">  محاسبة وتجهيز  </button>
                </div>

            </div>
            <table class="requ_on table table-striped" border>
                <thead>


                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">code</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>
                    <th scope="col">   زيادة /نقصان </th>


                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>

                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><?php  echo $rows['title'] ?></td>
                        <td><?php  echo $rows['code'] ?></td>
                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>  </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                        <td style="text-align: center">
                            <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
                            <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                        </td>
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
                <button class="btn btn-warning" onclick="print_bill()"> <i class="fa fa-print"></i> <span>طباعة</span></button>
            </div>
        </div>
    </div>


</div>




<style>

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


    .print_bill
    {
        border:2px solid #cccccc !important;
        padding: 8px;
        border-radius: 5px !important;
        display: none;

    }

    .header_bill
    {
        border: 2px solid #cccccc;
        padding: 7px 13px;
        margin-bottom: 18px;
        background: #f2f2f2 !important;
        border-radius: 5px;
        font-size: 22px;
        font-weight: bold;
    }
    .info_bill {
        border: 1px solid #bcdcc4 !important;
        margin-bottom: 6px;
        padding: 2px 11px;
        border-radius: 5px;
        background: #ebfff0 !important;
    }
    .customer_name
    {
        font-size: 18px;
        font-weight: bold;
    }

    .notMyModel
    {
        opacity: 0.3;
    }


    .image_prod
    {

        height: 50px;
    }



    .tableBill.table-bordered td, .tableBill.table-bordered th {
        border: 2px solid #dee2e6 !important;
    }



    table.requ_on td  {
        vertical-align: middle;
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



    @media print {
        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

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


        .print_bill {
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill * {
            position: relative;
            visibility: visible;
        }



    }





</style>




<script>



    function print_bill() {
        window.print();
    }



    function tajhezDirect(number_bill,id_user) {


        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/tajhez3",{number_bill:number_bill,id_user:id_user}, function( data ) {
                if (data==='1')
                {
                    if (confirm("تم تجهيز الفاتورة بنجاح هل تريد طباعة فاتورة؟"))
                    {
                        $('.tajhezDirect').remove();
                        window.print();
                    }else {
                        $('.tajhezDirect').remove();
                    }

                }else
                {
                    alert('فشلت عملية التجهيز')
                }
            });
        }

        }




    function  return_order_minus(id_order,table,colde,id_user,color) {



        if ($('#number_item_' + id_order).text()  === '1')
        {
            if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {color:color},
                    success: function (response) {

                        if (response) {
                            number_bill_reload();
                            if (isNaN(response)) {
                                window.location = "<?php echo url ?>/home"
                            } else {
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
                data: {color:color},
                success: function (response) {
                    if (response) {
                        number_bill_reload();
                        if (isNaN(response))
                        {
                            window.location="<?php echo url ?>/home"
                        }else
                        {
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

    function  return_order_plus(id_order,table,colde,id_user,color) {

        $('#plus_x_'+id_order).attr('disabled','disabled');

        $.ajax({
            type: 'GET',
            url: "<?php  echo url . '/' . $this->folder ?>/return_order_plus/" + table + "/" + colde + "/" + id_user,
            cache: false,
            data: {color:color},
            success: function (response) {


                if (response){
                    number_bill_reload();
                    if (isNaN(response))
                    {
                        window.location="<?php echo url ?>/home"
                    }else {
                        $('#number_item_' + id_order).html(response);
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



<hr>


<br>
<br>
<br>
<br>



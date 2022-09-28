<!-- for d2-->
<div class="container-fluid">

    <?php  if ($result['active_wholesale_price'] == 1) { ?>
        <p><span style="background: #4CAF50;
                padding: 5px 20px;
                color: #fff;border-radius: 10px" > حساب جملة </span> </p>
    <?php  } ?>

    <table class="table table-striped table-dark set_text_table" <?php  if ($result['active_wholesale_price'] == 1) echo 'style="background: #4CAF50"'?> >
        <thead>
        <tr>

            <th scope="col">الاسم </th>
            <th scope="col">اسم المستخدم </th>
            <th scope="col">حالة الزبون </th>
            <th scope="col"> الموبايل </th>
            <th scope="col">  المحافظة </th>
            <th scope="col"> العنوان </th>

        </tr>
        </thead>
        <tbody>
        <tr>

            <td><?php echo $result['name'] ?>  </td>


            <td>   <div  style="direction: ltr;">

					<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
						<?php echo  $result['username'] ?>
					<?php }else{ ?>
						<?php echo substr($result['username'], 0, 3) . "*****" . substr($result['username'], 8) ?>
					<?php  }  ?>

                </div>
            </td>

            <td    style="background: <?php  if ($result['type_customer_12'] == 1)  echo '#4CAF50'; else echo 'red';?> "> <?php echo $result['type_customer'] ?>   </td>
            <td>   <div   style="direction: ltr;">

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

            <?php if (!empty($date_req_done)) { ?>
            <?php  foreach ($date_req_done as $key => $date_done) {  ?>

                <div class="retn_<?php echo $date_done['number_bill'] ?>">


                    <div class="date_req ">
                        <div class="row justify-content-between">


                            <div class="col-auto">
                                <span> رقم الفاتورة  :  </span>  <?php echo  $date_done['number_bill']  ?>   //    <span>  مجموع االفاتورة    :  </span>  <span class="sum_bill_<?php echo  $date_done['number_bill']  ?>"><?php echo  $date_done['sum']  ?></span>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-calendar"></i>  <?php echo  date('A h:i:s  Y-m-d ',$date_done['date_req']) ?>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-danger" onclick="cancel_order(<?php echo  $this->userid  ?>,<?php echo  $date_done['number_bill']  ?>)"> الغاء الفاتورة </button>
                            </div>


                        </div>
                        <style>
                            .progs_r_x_<?php echo $date_done['number_bill'] ?>
                            {
                                display: none;
                            }
                        </style>

                    </div>

                    <table class="requ_on table table-striped" border >
                        <thead>


                        <tr  class="d_table"  >
                            <th scope="col">صورة</th>
                            <th scope="col">اسم المنتج</th>
                            <th scope="col">code</th>
                            <th scope="col">القياس</th>
                            <th scope="col">اللون</th>
                            <th scope="col">اسم اللون</th>
                            <th scope="col">العدد</th>
                            <th scope="col">السعر</th>
                            <th scope="col">تاريخ</th>
                            <th scope="col">الوقت</th>
                            <th scope="col">ملاحظة</th>
                            <th scope="col">    </th>

                        </tr>

                        </thead>
                        <tbody>


                        <?php   foreach ($date_done[$date_done['number_bill']] as $rows)  {  ?>
                            <tr id="row_<?php  echo $rows['id'] ?>">
                                <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                                <td><?php  echo $rows['title'] ?></td>
                                <td><?php  echo $rows['code'] ?></td>
                                <td><?php  echo $rows['size'] ?></td>
                                <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                                <td><?php  echo $rows['color_name']   ?>  </td>
                                <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                                <td><?php  echo $rows['price']   ?>  </td>
                                <td><?php  echo date('Y-m-d',$rows['date']) ?></td>
                                <td><?php  echo date('h:i:s A',$rows['date']) ?></td>
                                <td><?php  echo  $rows['note']  ?></td>

                                <td style="text-align: center">
                                    <?php  if ($row['review_item'])  { ?>
                                     <?php  } else{ ?>
                                        مسترجع
                                    <?php  } ?>
                                </td>


                            </tr>
                        <?php  }  ?>



                        </tbody>
                    </table>
                    <?php if ($date_done['note_prepared']) {  ?>
                        <span>ملاحظة المجهز</span> // <span><?php  echo $date_done['note_prepared'] ?></span>
                    <?php } ?>
                </div>

                    <br>

                    <div class="text-center">

                        <button onclick="print_bill(<?php echo  $result['id'] ?>,<?php echo $date_done['number_bill'] ?>)"  class="btn btn-primary" > طباعه </button>

                    </div>
                    <hr>
            <?php  }   ?>
            <?php  } else  {    ?>
                <div class="alert alert-warning" role="alert">
                    لا توجد فواتير
                </div>
            <?php   }  ?>
        </div>
    </div>





</div>


<script>



    function print_bill(id,number_bill) {
        $( ".body_print_bill" ).show();
        $( ".body_print_bill .outPill" ).empty();
        $.get( "<?php  echo url .'/'.$this->folder ?>/details/"+id+"/"+number_bill, function( data ) {
            $( ".body_print_bill .outPill" ).html( data );
        });

    }

</script>



<br>
<br>
<br>

<script>
    function  return_order_minus(id_order,table,code,id_user,color,number_bill) {



        if ($('#number_item_' + id_order).text()  === '1')
        {
            if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                alert('يرجى توجية الزبون الى المحاسب لستلام المرتجع.')
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.get( "<?php  echo url . '/' . $this->folder ?>/setBill/" + id_user +  "/" + number_bill+"/"+code, function( data ) {

                    if (data)
                    {

                       $.ajax({
                            type: 'GET',
                            url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + code + "/" + id_user+"/2",
                            cache: false,
                            data: {color:color,number_bill:number_bill},
                            success: function (response) {

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
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + code + "/" + id_user+"/2",
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


    function cancel_order(id,n_bill) {

        if (confirm("هل انت متأكد "))
        {
            $.get( "<?php  echo url .'/'.$this->folder?>/cancel_order/"+id+"/"+n_bill+"/<?php echo $result['id']?>", function( data ) {
                alert("تم الغاء الطلب بنجاح");
                window.location='';
            });

        }

    }



</script>


<style>


    .rejected_processing_x,   .rejected_processing_x:hover
    {
        color: #ffffff;
    }



    .processing_request,   .processing_request:hover
    {
        color: #ffffff;
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
    .table {
        margin-bottom: 0;
    }
    .note_req {
        background: #ffc1077d;
        padding: 6px 10px;
        border-radius: 0 0 14px 14px;
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


    .set_text_table
    {
        text-align:center;
    }

    .d_table
    {
        background: #4CAF50;
    }

    .d_table th
    {
        font-weight: unset;
        color: #ffffff;
    }

    .date_req {
        background: #009688;
        color: #fff;
        padding: 0px 9px;
        font-size: 18px;
        margin-top: 34px;
        border-radius: 14px 14px 0 0;
    }



    .d_table_rej
    {
        background: #607D8B;
    }

    .d_table_rej th
    {
        font-weight: unset;
        color: #ffffff;
    }

    .date_req_rej {
        background: #F44336;
        color: #fff;
        padding: 0px 9px;
        font-size: 18px;
        margin-top: 34px;
        border-radius: 14px 14px 0 0;
    }

    .error0
    {
        color: red;
    }
    .error_r_0
    {
        color: #ffffff;
    }
</style>





<br>
    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/prepared_requests">  ضرورة تجهيز الطلبات </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > عرض الطلب </li>
                    <li class="breadcrumb-item active" aria-current="page" >  <?php echo $result['name'] ?>  </li>
                </ol>
            </nav>

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
                <td> <?php echo $result['phone'] ?>  </td>
                <td> <?php echo $result['city'] ?>  </td>
                <td> <?php echo $result['address'] ?>  </td>
            </tr>

            </tbody>
        </table>
          <?php  if (!empty($answer)) { ?>
        <br>

            <div class="status_customer">

                <fieldset>
                    <legend> سبب اقتناع او عدم اقتناع الزبون </legend>

                    <?php  if (empty($answer['choose']) && empty($answer['note'])) { ?>
                        <div class="chooser_customer" style="margin-bottom: 20px;"> <span style="font-weight: bold">  اقتنع بعد مشاهدتة فيديو الحقيقة  </span>   </div>
                    <?php  }  ?>

                    <?php  if (!empty($answer['choose'])) { ?>
                        <div class="chooser_customer" style="margin-bottom: 20px;"> <span style="font-weight: bold"> رائي الزبون بشعار الشركة (الجودة و الضمان و السعر المميز): </span>   <span>  <?php echo $answer['choose']?> </span> </div>
                    <?php  }  ?>
                    <?php  if (!empty($answer['note'])) { ?>
                        <div class="note_customer"> <span style="font-weight: bold"> السبب: </span>   <span>  <?php echo $answer['note']?> </span> </div>

                    <?php  }  ?>
                </fieldset>
            </div>

           <?php  }  ?>

         <hr>
        <div class="row">

            <div class="col-12">

              <?php  if (!empty($request)) { ?>
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            طلب موكد ضرورة التجهيز
                        </div>
                        <div class="col-7">


                            <div class="row align-items-center justify-content-between">


                            <div class="col-auto">
                                <div class="col-auto" style="font-size: 18px;font-weight: bold">
                                    <span> رقم الفاتورة في كرستال :  </span>  <?php echo  $dataOrder['number_bill']  ?>
                                </div>
                            </div>


                                <div class="col-auto done_processing d_x">
                                    <button  onclick="done_delivery(<?php echo $dataOrder['number_bill']  ?>,<?php echo $dataOrder['id_member_r']  ?>,<?php echo $dataOrder['date_d_r'] ?>)"  class="btn btn- btn-success  processing_request "> <span>    تأكيد التجهيز  </span>  </button>   <span  class="error"> </span>
                                </div>
                            </div>

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

                            <th  class="retn"  scope="col">   ملاحظة الزيادة والنقصان </th>

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
                                    <?php  echo $rows['mpx'] ?>
                                 </td>
                            </tr>
                        <?php  }  ?>

                        </tbody>
                    </table>
                <?php  } else  {    ?>
                    <div class="alert alert-warning" role="alert">
                        تم التجهيز
                    </div>
                <?php   }  ?>
            </div>

        </div>




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




    <script>





        function done_delivery(number_bill,id_member_r,date_d_r) {
            if (confirm(' هل انت متأكد من  اكمال تجهيز الطلب ذو رقم الفاتورة:' + number_bill)) {


                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url  ?>/delivery_user/done_delivery",
                    cache: false,
                    data: {number_bill:number_bill,id_member_r:id_member_r,date_d_r:date_d_r},
                    success: function (response) {

                        if (response)
                        {
                            $('.retn_' + date_d_r).remove();
                            window.location='';
                        }else
                        {
                            alert('حدث خطا')
                        }
                    }
                });

            }

        }




    </script>






<hr>



<style>
 .table_style3
 {
     border: 1px solid #ecedee;
 }
</style>

<br>
<br>
<br>
<br>


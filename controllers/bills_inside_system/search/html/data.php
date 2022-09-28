<div class="row">

    <div class="col-12">

        <?php  if (!empty($request)) { ?>





            <table class="table table-striped text-center" border="1">
                <thead>
                <tr class="table-info">
                    <th   scope="col">  اسم الزبون </th>
                    <th   scope="col">   رقم الهاتف   </th>
                    <th   scope="col">رقم الفاتورة</th>
                    <th   scope="col"> مجموع الفاتورة </th>
                    <th   scope="col">   المحاسب </th>
                    <th   scope="col">   تاريخ المحاسبة  </th>
                    <th   scope="col">   المجهز </th>
                    <th   scope="col">   تاريخ التجهيز  </th>
                    <th   scope="col">   منشئ الطلب (البائع) </th>
                    <th   scope="col">   تاريخ الطلب  </th>
                    <th   scope="col">   رقم فاتورة كرستال  </th>
                    <th   scope="col">   رقم  المجموعة </th>
                    <th   scope="col">  حالة الفاتورة </th>
                    <?php  if ($cancel) { ?>
                    <th   scope="col"> الغاء الطب بواسطة </th>
                    <th   scope="col">  سبب  الغاء الطلب  </th>
                    <?php } ?>


                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"><?php echo $name_customer ?></th>
                    <th scope="row">


                        <?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
                            <?php echo  $phone ?>
                        <?php }else{ ?>
                            <?php echo substr($phone, 0, 3) . "*****" . substr($phone, 8) ?>
                        <?php  }  ?>



                        </th>

                    <th scope="row"><?php echo $number_bill ?></th>
                    <th scope="row">

                        <?php  if ($edit_price == 1) { ?>
                        <span style="color: red;font-weight: bold" id="number_bill_reload"> <?php echo number_format($price1Offer)  ?> </span><span>د.ع</span>
                       <hr>
                            <span style="color: red">تم تغير السعر</span>
                            <hr>
                           <span style="color: red"> <?php  echo $user_edit_price ?> </span>

                        <?php  } else { ?>

                            <span id="number_bill_reload"> <?php echo number_format($price1Offer)  ?> </span><span>د.ع</span>

                        <?php  } ?>

                    </th>
                    <th scope="row">
                        <?php
                       if ($accountant)
                       {
                           echo $accountant;
                       }else
                       {
                           echo 'قيد المحاسبة';
                       }
                        ?>
                    </th>
                    <th scope="row">
                        <?php
                       if ($date_accountant)
                       {
                           echo $date_accountant;
                       }else
                       {
                           echo 'قيد المحاسبة';
                       }
                        ?>
                    </th>

                    <th scope="row">
                        <?php
                       if ($prepared)
                       {
                           echo $prepared;
                       }else
                       {
                           echo 'قيد التجهيز';
                       }
                        ?>
                    </th>
                    <th scope="row">
                        <?php
                       if ($date_prepared)
                       {
                           echo $date_prepared;
                       }else
                       {
                           echo 'قيد التجهيز';
                       }
                        ?>
                    </th>
                    <th scope="row">
                        <?php

                           echo $sellers;

                        ?>
                    </th>
                    <th scope="row">
                        <?php

                           echo $date_sellers;

                        ?>
                    </th>
                    <th scope="row">
                        <?php

                           echo $crystal_bill;

                        ?>
                    </th>
                    <th scope="row">
                        <?php

                           echo $group_bill;

                        ?>
                    </th>
                    <th scope="row"   <?php  if ($cancel) { ?>  style="background: red;color: #ffffFF"  <?php } ?> >
                        <?php

                           echo $status_bill;

                        ?>
                    </th>
                    <?php  if ($cancel) { ?>
                    <th scope="row"    >
                        <?php

                           echo $cancel_user ;

                        ?>
                    </th>
                    <th scope="row"    >
                        <?php

                           echo  $why_cancel;

                        ?>
                    </th>
                    <?php } ?>
                 </tr>


                </tbody>
            </table>

        <?php  if ($note_prepared) { ?>
            <div class="mb-3 mt-3" style="font-weight: bold">
              <span>ملاحظة المجهز</span> // <span><?php echo $note_prepared ?> </span>
            </div>
            <?php } ?>
            <table class="requ_on table table-striped" border="1">
                <thead>


                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">اسم الزبون</th>
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت الطلب </th>
                    <th scope="col">  المجهز </th>
                    <th scope="col">  اضافة للفاتورة </th>
                    <th scope="col">  الموقع </th>
                    <th scope="col">  ملاحظة </th>



                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><?php  echo $this->customerInfo($rows['id_member_r']);  ?></td>
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td>
                            <?php  echo $rows['title'] ?>
                            <?php  if ($rows['offers']) {  ?>
                                <div class="offers_" style="font-size: 10px; background: #8bc34a6b; border-radius: 5px;">
                                    <?php  echo  $this->details_offer($rows['id_offer'],'title')?>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>

                        <td>
                            <span   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $rows['code'] ?>">  <?php  echo $rows['code'] ?></span>
                        </td>
                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td>

                            <?php  if ($rows['edit_price'] ==1) { ?>

                                <span style="color: red"   data-toggle="tooltip" data-placement="top" title="تم تغير السعر"   > <?php  echo $rows['price']   ?> </span>


                            <?php  } else { ?>
                                <?php  echo $rows['price']   ?>

                            <?php } ?>

                            <?php  if ($rows['price_type'] > 0) { ?>
                                <span class="type_price_account" > <?php  echo  $this->price_type[$rows['price_type']]; ?> </span>
                            <?php  } ?>

                        </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>
                        <td><?php

                            if ($rows['id_prepared'])
                            {
                              echo  $this->UserInfo($rows['id_prepared']);

                            }else
                            {
                               echo $this->UserInfo($rows['user_direct']);
                            }

                            ?></td>
                        <td><?php

                            if ($rows['user_direct'])
                            {
                                echo  $this->UserInfo($rows['user_direct']);

                            }else
                            {
                                echo $this->UserInfo($rows['id_prepared']);
                            }

                            ?>
                        </td>
                        <td><?php  echo  $rows['location']  ?></td>
                        <td><?php  echo  $rows['note']  ?></td>

                    </tr>
                <?php  }  ?>

                </tbody>
            </table>


        <?php  } else  {    ?>
            <div class="alert alert-warning" role="alert">
                لا يوجد طلب جديد
            </div>
        <?php   }  ?>
    </div>

</div>




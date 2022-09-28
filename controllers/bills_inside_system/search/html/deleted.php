

<table class="table table-bordered table-striped "     >
    <thead>
    <tr>

        <th scope="col"> اسم الزبون </th>

        <th scope="col"> الموبايل </th>
        <th scope="col"> رقم الفاتورة </th>
        <th scope="col">   مبلغ المواد المحذوفة من الفاتورة </th>
        <th scope="col"> حالة الفاتورة </th>
        <th scope="col"> حالة الفاتورة </th>
        <th scope="col"> حالة الفاتورة </th>


    </tr>
    </thead>
    <tbody>
    <tr>

        <td><?php echo $name_customer ?>  </td>
         <td   style="direction: ltr;">
            <div>

				<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
					<?php echo  $phone ?>
				<?php }else{ ?>
					<?php echo substr($phone, 0, 3) . "*****" . substr($phone, 8) ?>
				<?php  }  ?>

            </div>


        </td>
        <td>
         <?php  echo  $number_bill ?>

        </td>
        <td>
         <?php  echo  $price1 ?>

        </td>
        <td>
            <?php  if ($check_account) {  ?>
                تمت المحاسبة
            <?php } else {  ?>
                قيد المحاسبة

            <?php  } ?>
        </td>

        <td>
          قيد التجهيز

        </td>
        <td>
            مواد محذوفة من الفاتورة

        </td>
    </tr>

    </tbody>
</table>

<hr>
<div class="row">

    <div class="col-12"  id="reloadPage">

        <?php  if (!empty($deleted)) { ?>

            <table class=" table table-striped  table-bordered"  >
                <thead>


                <tr style="background: #f44336;color: #ffffff">
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>
                    <th scope="col">  المحاسب  </th>
                    <th scope="col">  المجهز  </th>
                    <th scope="col">  المحاسب الذي ارجع المبلغ   </th>


                </tr>

                </thead>
                <tbody>


                <?php   foreach ($deleted as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><?php  echo $rows['title'] ?></td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <td><?php  echo $rows['code'] ?></td>
                        <td><?php  echo $rows['color']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>  </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date']) ?></td>
                        <td><?php  echo $this->UserInfo($rows['id_accountant_user']);   ?>  </td>
                        <td><?php  echo $this->UserInfo($rows['id_user']);   ?>  </td>
                        <td><?php  echo $this->UserInfo($rows['delete_user']);   ?>  </td>

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





<hr>



<br>
<br>
<br>
<br>



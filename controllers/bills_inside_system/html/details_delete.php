

<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="<?php echo url .'/'.$this->folder?>"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات الملغية </li>

            </ol>

        </nav>

    </div>

</div>


<div class="row">

    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder?>/bills_deleted" role="button"    class="btn btn-primary btn-sm">   رجوع </a>
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

        <th scope="col"> الموبايل </th>


    </tr>
    </thead>
    <tbody>
    <tr>

        <td><?php echo $result['name'] ?>  </td>
         <td   style="direction: ltr;">
            <div>

				<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
					<?php echo  $result['phone'] ?>
				<?php }else{ ?>
					<?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
				<?php  }  ?>

            </div>


        </td>

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
                <div class="col-7">

                    <div class="row align-items-center justify-content-end">


                        <div class="col-3   r_x  progs_r_x">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"  aria-valuemax="100" style="width:100%"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <table class="requ_on table table-striped" border>
                <thead>


                <tr style="background: #125da9;color: #ffffff">
                    <th scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th scope="col">  القسم </th>
                    <th scope="col">code</th>
                    <th scope="col">اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>


                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><?php  echo $rows['title'] ?></td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <td><?php  echo $rows['code'] ?></td>
                        <td><?php  echo $rows['color']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>  </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date']) ?></td>

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



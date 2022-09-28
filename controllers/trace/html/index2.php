
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <a href="<?php  echo url .'/'.$this->folder ?>/list_trace"> <?php  echo $this->langControl('trace')?> </a> </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('details') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الفاتورة:</span> <?php echo $result['number_bill'] ?>  </li>
            </ol>
        </nav>

    </div>
</div>



<hr>


<span class="badge badge-primary"> بيانات قبل التعديل على الفاتورة </span>
<span class="badge badge-warning">  بيانات بعد التعديل على الفاتورة </span>
<?php  foreach ($data as $key => $outData) {   ?>




    <div class="infoTrace">



                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"> رقم العملية </th>
                        <th scope="col">  رقم الفاتورة </th>
                        <th scope="col" class="table-primary"> مبلغ الفاتورة قبل التعديل </th>
                        <th scope="col"  class="table-warning"> مبلغ الفاتورة بعد التعديل </th>
                        <th scope="col"> الوقت </th>
                        <th scope="col"> التاريخ </th>
                        <th scope="col"> العمليه </th>
                        <th scope="col"> ملاحظة </th>
                        <th scope="col"> الادمن </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row"><?php echo $key+1   ?> </th>
                        <td>  <?php echo $outData['number_bill'] ?> </td>
                        <td class="table-primary"> <?php echo $outData['sumBillOld'] ?> </td>
                        <td class="table-warning"> <?php echo $outData['sumBillNew'] ?> </td>
                        <td><?php echo date('h:i:s A',$outData['date'])  ?></td>
                        <td><?php echo date('Y-m-d',$outData['date'])  ?></td>
                        <td><?php echo  $outData['operation']   ?></td>
                        <td><?php echo  $outData['note']   ?></td>
                        <td><?php echo  $outData['userName']   ?> </td>
                    </tr>

                    </tbody>
                </table>






    <table class="table table-striped table-primary" border>
        <thead>

        <tr style="background: #125da9;color: #ffffff">
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
            <th scope="col">  المحاسبة  </th>
            <th scope="col">  التجهيز  </th>


        </tr>

        </thead>
        <tbody>


		<?php   foreach ($outData['oldFilter_Data'] as $rows_old)  {  ?>
            <tr class="retn" id="row_<?php  echo $rows_old['id'] ?>">
                <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows_old['img'] ?>"></td>
                <td><?php  echo $rows_old['title'] ?></td>
                <td><?php  echo $this->langControl($rows_old['table']) ?></td>
                <td><?php  echo $rows_old['code'] ?></td>
                <td><?php  echo $rows_old['size'] ?></td>
                <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows_old['color'] ?>">  </span></td>
                <td><?php  echo $rows_old['name_color']   ?>  </td>
                <td id="number_item_<?php  echo $rows_old['id'] ?>"><?php  echo $rows_old['number'] ?></td>
                <td><?php  echo $rows_old['price']   ?>  </td>
                <td><?php  echo date('Y-m-d h:i:s A',$rows_old['date_req']) ?></td>

                <?php if ( $rows_old['accountant'] == 0 ) {  ?>
                    <td>قيد المحاسبة</td>
                <?php  } else {  ?>
                    <td> <i class="fa-check-circle" style="color: green;font-family: FontAwesome"></i>  </td>
                <?php  } ?>

                <?php if ( $rows_old['prepared'] == 0 ) {  ?>
                    <td>قيد التجهيز</td>
				<?php  } else if ($rows_old['prepared'] == 1) {  ?>
                    <td>قيد التجهيز</td>
				<?php  } else {  ?>
                    <td> <i class="fa-check-circle" style="color: green;font-family: FontAwesome"></i>  </td>
                <?php  } ?>

            </tr>
		<?php  }  ?>

        </tbody>
    </table>

    <table   class="table table-striped table-warning" border>
        <thead>


        <tr style="background: #125da9;color: #ffffff">
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
            <th scope="col">  المحاسبة  </th>
            <th scope="col">  التجهيز  </th>

        </tr>

        </thead>
        <tbody>


		<?php   foreach ($outData['newFilter_Data'] as $rows_new)  {  ?>
            <tr class="retn" id="row_<?php  echo $rows_new['id'] ?>">
                <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows_new['img'] ?>"></td>
                <td><?php  echo $rows_new['title'] ?></td>
                <td><?php  echo $this->langControl($rows_new['table']) ?></td>
                <td><?php  echo $rows_new['code'] ?></td>
                <td><?php  echo $rows_new['size'] ?></td>
                <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows_new['color'] ?>">  </span></td>
                <td><?php  echo $rows_new['name_color']   ?>  </td>
                <td id="number_item_<?php  echo $rows_new['id'] ?>"><?php  echo $rows_new['number'] ?></td>
                <td><?php  echo $rows_new['price']   ?>  </td>
                <td><?php  echo date('Y-m-d h:i:s A',$rows_new['date_req']) ?></td>

				<?php if ( $rows_new['accountant'] == 0 ) {  ?>
                    <td>قيد المحاسبة</td>
				<?php  } else {  ?>
                    <td> <i class="fa-check-circle" style="color: green;font-family: FontAwesome"></i>  </td>
				<?php  } ?>

				<?php if ( $rows_new['prepared'] == 0 ) {  ?>
                    <td>قيد التجهيز</td>
				<?php  } else if ($rows_new['prepared'] == 1) {  ?>
                    <td>قيد التجهيز</td>
				<?php  } else {  ?>
                    <td> <i class="fa-check-circle" style="color: green;font-family: FontAwesome"></i>  </td>
				<?php  } ?>

            </tr>
		<?php  }  ?>

        </tbody>
    </table>


    </div>




<?php  } ?>




<style>

    .infoTrace {
        border: 3px solid #ecedee;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 29px;
        background: #dee2e629;
    }

    .infoTrace:nth-child(even) {
        background: #ffffff;
        padding-top: 20px;
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







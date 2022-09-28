
<table class="table table-striped table-dark set_text_table"  style="margin-top: 10px" >
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
		<td>   <div style="direction: ltr;">

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


<table class="table table-striped table-bordered text-center">
    <tbody>
    <tr>
        <th style="width: 100px !important;">#</th>
        <th>اسم المحاسب </th>
        <th>اسم حساب الموظف</th>
        <th>صورة</th>
        <th>اسم المادة</th>
        <th>الباركود</th>
        <th>لون المادة</th>
        <th>سعر المرتجع </th>
        <th> السعر الحالي </th>
        <th>تاريخ الشراء</th>
        <th>تاريخ الاسترجاع</th>
		<th>  ملاحظة </th>

    </tr>
    </tbody>
    <tbody>

	<?php foreach ($rewind_active as $key=> $item) { ?>
        <tr>
            <td> <?php echo $key+1 ?>  </td>
            <td><?php  echo  $item['username_acc'] ?></td>
            <td><?php  echo  $item['username'] ?></td>
            <td><img width="40" src="<?php echo $this->save_file . $item['image'] ?>"></td>
            <td><?php  echo  $item['item_name'] ?></td>
            <td><?php  echo $item['code'] ?></td>
            <td><?php  echo $item['color'] ?></td>
            <td><?php  echo number_format($item['price_new']) ?>  د.ع </td>
			<td><?php  echo $item['now_price'] ?>  د.ع </td>
            <td>   <?php echo  date('Y-m-d h:i:s A',$item['date_buy'])  ?> </td>
            <td>   <?php echo  date('Y-m-d h:i:s A',$item['date'])  ?> </td>
			<td><?php  echo $item['note'] ?></td>

		</tr>

	<?php  } ?>
    <tr class="sum_bill">
        <td style="text-align: right" colspan="7">  مجموع المبلغ المرتجع  </td>
        <td> <strong> <?php echo number_format( $price )  ?>   د.ع  </strong> </td>
        <td>   </td>
        <td>   </td>
        <td>   </td>
        <td>   </td>
    </tr>
    </tbody>


</table>



<hr>


<style>


	.sum_bill td
	{
		background:#cce5ff;
	}

</style>




























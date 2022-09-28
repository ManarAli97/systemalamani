
<table class="table table-bordered">
    <thead>
    <tr>

        <th scope="col">سعر الفاتورة الاصلي</th>
        <th scope="col"> سعر الفاتروة بعد نقصان الطلب او تبديل المنتج</th>
        <th scope="col">الفرق (راجع الى الزبون)</th>
        <th scope="col">  ملاحظة  </th>
    </tr>
    </thead>
    <tbody>
    <tr>

        <td> <?php  echo  number_format( (int) $result['sum_bill'] )?>    <span>د.ع</span></td>
        <td>  <?php     echo number_format($this->setBill($id,$number_bill))   ?>   <span>د.ع</span></td>
        <td>   <?php  echo number_format( $result['minus_bill'] ) ?>   <span>د.ع</span></td>
        <td>   <textarea name="noteminus" class="form-control" id="noteminus"><?php  echo  $result['note'] ?></textarea> </td>

    </tr>


    </tbody>
</table>

<div class="row justify-content-center">
    <div class="col-auto">
        <button class="btn btn-primary"  onclick="action_minus(<?php  echo  $result['id_member_r'] ?>,'<?php  echo $result['number_bill'] ?>')">موافق</button>
    </div>

</div>

<br>
<br>

<table class="requ_on table table-striped" border>
    <thead>


    <tr style="background: #125da9;color: #ffffff">
        <th scope="col">صورة</th>
        <th scope="col">اسم المنتج</th>
        <th scope="col">  القسم </th>
        <th scope="col">code</th>
        <th scope="col">اسم اللون</th>
        <th scope="col">العدد</th>
        <th scope="col">السعر</th>
        <th scope="col">التاريخ والوقت</th>


    </tr>

    </thead>
    <tbody>


	<?php   foreach ($item as $rows)  {  ?>
        <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
            <td><img class="image_prod" width="50"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
            <td><?php  echo $rows['title'] ?></td>
            <td><?php  echo $this->langControl($rows['table']) ?></td>
            <td><?php  echo $rows['code'] ?></td>
            <td><?php  echo $rows['color']   ?>  </td>
            <td><?php  echo $rows['number'] ?></td>
            <td><?php  echo $rows['price']   ?>  </td>
            <td><?php  echo date('Y-m-d h:i:s A',$rows['date']) ?></td>

        </tr>
	<?php  }  ?>

    </tbody>
</table>

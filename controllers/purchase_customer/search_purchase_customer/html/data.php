
<table class="table table-bordered">
    <thead>
    <tr>

        <th scope="col">اسم الزبون</th>
        <th scope="col">رقم الزبون</th>
        <th scope="col">رقم الفاتورة</th>
        <th scope="col">رقم  فاتورة كرستال</th>
        <th scope="col">   مجموع الفاتورة   </th>
        <th scope="col">  المحاسب  </th>
        <th scope="col">    منشئ الفاتورة   </th>
        <th  scope="col">  تاريخ الشراء </th>
        <th  scope="col"> تاريخ المحاسبة </th>
    </tr>
    </thead>
    <tbody>
    <tr>

        <td   onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $result['name']  ?>"> <?php echo $result['name'] ?> </td>
        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $result['phone']  ?>">  <?php echo $result['phone'] ?>   </td>
        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $result['number_bill']  ?>">  <?php echo $result['number_bill'] ?>   </td>
        <td>
            <?php if ($this->permit('enter_bill', $this->folder)) { ?>

                <div class='row justify-content-center'>
                    <div class='col-auto' style='padding-left: 2px'>
                        <input style="width: 200px" id='numberBill_<?php echo $result['number_bill'] ?>'  value='<?php echo $result['crystal_bill'] ?>' type='text' class='form-control withBill' name='crystal_bill' required>
                    </div>
                    <div class='col-auto' style='padding-right: 2px'>
                        <button type='submit' id='btn_in_bill_<?php echo $result['number_bill'] ?>' onclick=saveBill('<?php echo $result['number_bill'] ?>')  name='submit' class='btn btn-warning'>حفظ</button>
                    </div>
                </div>
            <?php } else { echo  $result['crystal_bill'];  } ?>
        </td>
        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo number_format($sum) ?>">   <span> <?php echo number_format($sum)  ?> د.ع </span> </td>


        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $this->UserInfo($result['userid'])   ?>" > <?php echo $this->UserInfo($result['userid'])  ?> </td>
        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo $this->UserInfo( $result['user_purchase']  ) ?>" > <?php echo $this->UserInfo( $result['user_purchase']  )  ?> </td>


        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  date('Y-m-d h:i A', $result['date'])  ?>">  <?php echo date('Y-m-d h:i A', $result['date'])?>   </td>
       <?php  if ($result['active'] == 1) {  ?>
        <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  date('Y-m-d h:i A', $result['date_account'])  ?>">  <?php echo date('Y-m-d h:i A', $result['date_account'])?>   </td>
        <?php } else {  ?>
        <td style="color: #ffffFF;background: #ff0000">  قيد المحاسبه </td>
        <?php } ?>
    </tr>

    </tbody>
</table>
<script>



    function saveBill(number_bill) {

        if($('#numberBill_'+number_bill).val())
        {

            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill",{number_bill:number_bill,crystal_bill:$('#numberBill_'+number_bill).val()}, function( data ) {
                if (data ==='1')
                {
                    alert('تم اضافة فاتورة كرستال');

                }

            });

        }else {

            alert('حقل فاتورة كرستال فارغ !')
        }

    }


</script>

<br>
<br>

<table class="table table-striped">
    <thead>
    <tr>

        <th scope="col">صورة</th>
        <th scope="col">اسم المادة</th>
        <th scope="col">الباركود</th>
        <th scope="col">سيريال</th>
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
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['title']  ?>"> <?php echo $data['title'] ?> </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['code']  ?>"> <?php echo $data['code'] ?> </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['serial']  ?>"> <?php echo $data['serial'] ?> </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['quantity']  ?>"> <?php echo $data['quantity'] ?> </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['price_purchase']  ?>"> <?php echo number_format($data['price_purchase']) ?> د.ع </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['price_sale']  ?>"> <?php echo $data['price_sale'] ?> $ </td>
            <td  onclick="copy_text(this)"  class="copyToClipboard"   title="نسخ" data-clipboard-text="<?php  echo  $data['note']  ?>"> <?php echo $data['note'] ?> </td>

        </tr>
    <?php }  ?>

    </tbody>
</table>
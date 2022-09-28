
<?php if (!empty($data)) { ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">صورة</th>
        <th scope="col">القسم</th>
        <th scope="col">اسم الزبون</th>
        <th scope="col">رقم الفاتورة</th>
        <th scope="col">الكود</th>
        <th scope="col">اللون</th>
        <th scope="col">سيريال</th>
        <th scope="col">السعر</th>
        <th scope="col">تاريخ البيع</th>
        <th scope="col">  وقت البيع </th>
        <th scope="col"> الحاله </th>
        <th scope="col"> كتابة ملاحظة </th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $key => $d)  {  ?>

    <tr>
        <th scope="row"> <?php echo $key + 1 ?>  </th>
        <td><img width="40" src="<?php  echo $this->save_file.$d['image'] ?>"></td>
        <td><?php  echo $this->langSite($d['table']) ?></td>
        <td  style="color: red"><?php  echo $this->customerInfo($d['id_member_r']) ?></td>
        <td style="color: red"> <?php  echo  $d['number_bill']  ?></td>
        <td><?php  echo $d['code'] ?></td>
        <td><?php  echo $d['name_color'] ?></td>
        <td><?php  echo $d['enter_serial'] ?></td>
        <td><?php  echo $d['price'] ?></td>
        <td><?php  echo date('Y-m-d' , $d['date_accountant'] ) ?></td>
        <td><?php  echo date('h:i:s A' , $d['date_accountant'] ) ?></td>
        <td>
        <?php  if ( $d['cancel'] ==0)  echo 'مباع';else echo 'ملغي'?>

        </td>
        <td>
            <div style="font-size: 15px">
                <span> الكاتب </span>: <span id="writer_note_<?php  echo $d['id'] ?>"><?php  echo $this->userInfo($d['user_note_search_serial']) ?></span></div>
               <textarea id="id_save_note_<?php  echo $d['id'] ?>" name="note_search_serial" class="form-control" required><?php echo $d['note_search_serial'] ?></textarea>
                   <div class="text-center mt-2">
                       <button onclick="save_note(<?php  echo $d['id'] ?>)" type="submit" class="btn btn-primary" >حفظ</button>
                   </div>


        </td>

    </tr>
 <?php  }  ?>

    </tbody>

</table>

<?php  }  else {  ?>

    <div class="alert alert-warning" role="alert">
      لا توجد بيانات لهذا السيريال
    </div>

<?php  }   ?>


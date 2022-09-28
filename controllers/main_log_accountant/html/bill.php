

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('main_log_accountant') ?> </a></li>
                <li class="breadcrumb-item">  عرض الفواتير  </li>
                <li class="breadcrumb-item">   <?php echo  $result['username'] ?>  </li>
            </ol>
        </nav>

    </div>

</div>




<div class="row">

    <div class="col-12">

        <?php  foreach ($date_req_done as $key => $date_done) {  ?>

            <div class="retn_<?php echo $date_done['number_bill'] ?>">


                <div class="date_req ">
                    <div class="row justify-content-between">


                        <div class="col-auto">
                            <span>  اسم الزبون    :  </span>  <?php echo  $date_done['customer_name']  ?>
                        </div>
                        <div class="col-auto">
                            <span> رقم الفاتورة  :  </span>  <?php echo  $date_done['number_bill']  ?>   //    <span>  مجموع االفاتورة    :  </span>  <span class="sum_bill_<?php echo $date_done['number_bill'] ?>"> <?php echo  $date_done['sum']  ?> </span>
                        </div>

                        <div class="col-auto">
                            <i class="fa fa-calendar"></i>  <?php echo  date('A h:i:s  Y-m-d ',$date_done['date_req']) ?>
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
                            <td   id="number_item_<?php  echo $rows['id'] ?>" ><?php  echo $rows['number'] ?></td>
                            <td><?php  echo $rows['price']   ?>  </td>
                            <td><?php  echo date('Y-m-d',$rows['date']) ?></td>
                            <td><?php  echo date('h:i:s A',$rows['date']) ?></td>
                            <td><?php  echo  $rows['note']  ?></td>

                        </tr>
                    <?php  }  ?>



                    </tbody>
                </table>

            </div>

        <?php  }   ?>

    </div>
</div>



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



<br>
<br>
<br>
<br>



<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('my_requests') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>





<div class="container-fluid">




    <hr>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="req-tab-1" data-toggle="tab" href="#req_1" role="tab" aria-controls="home" aria-selected="true">   طلبات قيد التوصيل </a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="req_1" role="tabpanel" aria-labelledby="req-tab-1">

            <div class="row">

                <div class="col-12">

                    <?php  if (!empty($date_req_done)) {  ?>

                    <?php  foreach ($date_req_done as $key => $date_done) {  ?>

                        <div class="retn_<?php echo $date_done['date_d_r'] ?>">


                            <div class="date_req ">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                      <span>   رقم الفاتورة في كريستال : </span> <span> <?php echo $date_done['number_bill']  ?> </span>
                                    </div>

                                    <div class="col-auto">
                                        <i class="fa fa-calendar"></i>  <?php echo  date('A h:i:s  Y-m-d ',$date_done['date_req']) ?>
                                    </div>

                                    <div class="col-auto">

                                        <button class="btn done_delivery" onclick="done_delivery(<?php  echo $this->userid ?>,<?php echo $date_done['number_bill']  ?>,<?php echo $date_done['id_member_r']  ?>,<?php echo $date_done['date_d_r'] ?>)"> تم التوصيل </button>
                                    </div>
                                </div>

                            </div>

                            <table class="requ_on table table-striped" border >
                                <thead>


                                <tr  class="d_table"  >
                                    <th scope="col">صورة</th>
                                    <th scope="col">اسم المنتج</th>
                                    <th scope="col">code</th>
                                    <th scope="col">القياس</th>
                                    <th scope="col">الون</th>
                                    <th scope="col">العدد</th>
                                    <th scope="col">السعر</th>
                                    <th scope="col">تاريخ</th>
                                    <th scope="col">الوقت</th>
                                    <th scope="col">سبب الزيادة والنقصان</th>
                                </tr>

                                </thead>
                                <tbody>


                                <?php   foreach ($date_done[$date_done['date_d_r']] as $rows)  {  ?>
                                    <tr>
                                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                                        <td><?php  echo $rows['title'] ?></td>
                                        <td><?php  echo $rows['code'] ?></td>
                                        <td><?php  echo $rows['size'] ?></td>
                                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                                        <td><?php  echo $rows['number'] ?></td>
                                        <td><?php  echo $rows['price']   ?>  </td>
                                        <td><?php  echo date('Y-m-d',$rows['date']) ?></td>
                                        <td><?php  echo date('h:i:s A',$rows['date']) ?></td>
                                        <td><?php  echo $rows['mpx']  ?></td>
                                    </tr>
                                <?php  }  ?>



                                </tbody>
                            </table>

                        </div>

                    <?php  }   ?>

                    <?php  } else {  ?>
                        <br>
                        <br>
                        <div class="alert alert-danger" role="alert">
                             لا توجد طلبات قيد التوصيل
                        </div>

                    <?php  } ?>

                </div>
            </div>


        </div>



    </div>





</div>
<br>
<br>
<br>


<script>


        function done_delivery(userid,number_bill,id_member_r,date_d_r) {
            if (confirm(' هل انت متأكد من توصيل الطلب ذو رقم الفاتورة:' + number_bill)) {


                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/done_delivery",
                    cache: false,
                    data: {userid: userid,number_bill:number_bill,id_member_r:id_member_r,date_d_r:date_d_r},
                    success: function (response) {
                        if (isNaN(response))
                        {
                         //   window.location="<?php echo url ?>/home"
                        }else {

                            $('.retn_' + date_d_r).remove();
                        }
                    }
                });

            }

        }





</script>

<style>

    .btn.done_delivery {

        padding: 0px 6px;
        background: #ff3c00;
        color: #fff;
        margin: 4px 0;

    }



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




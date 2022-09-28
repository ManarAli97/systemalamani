

<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/subscribers"><?php  echo $this->langControl('registration') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلب </li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php echo $result['name'] ?>  </li>
            </ol>
        </nav>

    </div>
</div>

<div class="container-fluid">

    <?php  if ($result['active_wholesale_price'] == 1) { ?>
        <p><span style="background: #4CAF50;
                padding: 5px 20px;
                color: #fff;border-radius: 10px" > حساب جملة </span> </p>
    <?php  } ?>

    <table class="table table-striped table-dark set_text_table" <?php  if ($result['active_wholesale_price'] == 1) echo 'style="background: #4CAF50"'?> >
        <thead>
        <tr>

            <th scope="col">الاسم </th>
            <th scope="col">اسم المستخدم </th>
            <th scope="col">حالة الزبون </th>
            <th scope="col"> الموبايل </th>
            <th scope="col">  المحافظة </th>
            <th scope="col"> العنوان </th>

        </tr>
        </thead>
        <tbody>
        <tr>

            <td><?php echo $result['name'] ?>  </td>
            <td> <?php echo $result['username'] ?> </td>
            <td    style="background: <?php  if ($result['type_customer_12'] == 1)  echo '#4CAF50'; else echo 'red';?> "> <?php echo $result['type_customer'] ?>   </td>
            <td> <?php echo $result['phone'] ?>  </td>
            <td> <?php echo $result['city'] ?>  </td>
            <td> <?php echo $result['address'] ?>  </td>
        </tr>

        </tbody>
    </table>


    <?php  if (!empty($answer)) { ?>
        <br>

        <div class="status_customer">

            <fieldset>
                <legend> سبب اقتناع او عدم اقتناع الزبون </legend>

                <?php  if (empty($answer['choose']) && empty($answer['note'])) { ?>
                    <div class="chooser_customer" style="margin-bottom: 20px;"> <span style="font-weight: bold">  اقتنع بعد مشاهدتة فيديو الحقيقة  </span>   </div>
                <?php  }  ?>

                <?php  if (!empty($answer['choose'])) { ?>
                    <div class="chooser_customer" style="margin-bottom: 20px;"> <span style="font-weight: bold"> رائي الزبون بشعار الشركة (الجودة و الضمان و السعر المميز): </span>   <span>  <?php echo $answer['choose']?> </span> </div>
                <?php  }  ?>
                <?php  if (!empty($answer['note'])) { ?>
                    <div class="note_customer"> <span style="font-weight: bold"> السبب: </span>   <span>  <?php echo $answer['note']?> </span> </div>

                <?php  }  ?>
            </fieldset>
        </div>

    <?php  }  ?>


    <hr>



    <form action="<?php echo url.'/'.$this->folder?>/details_client/<?php echo $id ?>" method="get">

        <div class="row align-items-end">
            <div class="col-auto">
                من تاريخ
                <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
            </div>
            <div class="col-auto">
                الى تاريخ
                <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-warning" >بحث</button>
                <a href="<?php echo url.'/'.$this->folder?>/details_client/<?php echo $id ?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
            </div>
        </div>

    </form>

    <br>


    <hr>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="req-tab-1" data-toggle="tab" href="#req_1" role="tab" aria-controls="home" aria-selected="true">طلبات تم توصيلها او جهزت (مقبولة)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="req-tab-2" data-toggle="tab" href="#req_2" role="tab" aria-controls="profile" aria-selected="false"> طلبات تم الغائها</a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="req_1" role="tabpanel" aria-labelledby="req-tab-1">

            <div class="row">

                <div class="col-12">

                    <?php  foreach ($date_req_done as $key => $date_done) {  ?>

                        <div class="retn_<?php echo $date_done['date_req'] ?>">


                    <div class="date_req ">
                        <div class="row justify-content-between">


                            <div class="col-auto">
                                 <span> رقم الفاتورة   :  </span>  <?php echo  $date_done['number_bill']  ?>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-calendar"></i>  <?php echo  date('A h:i:s  Y-m-d ',$date_done['date_req']) ?>
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
                                <th scope="col">اللون</th>
                                <th scope="col">اسم اللون</th>
                                <th scope="col">العدد</th>
                                <th scope="col">السعر</th>
                                <th scope="col">تاريخ</th>
                                <th scope="col">الوقت</th>
                                <th scope="col">سبب الزيادة والنقصان</th>
                            </tr>

                            </thead>
                            <tbody>


                            <?php   foreach ($date_done[$date_done['number_bill']] as $rows)  {  ?>
                                <tr>
                                    <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                                    <td><?php  echo $rows['title'] ?></td>
                                    <td><?php  echo $rows['code'] ?></td>
                                    <td><?php  echo $rows['size'] ?></td>
                                    <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                                    <td><?php  echo $rows['name_color']   ?>  </td>
                                    <td><?php  echo $rows['number'] ?></td>
                                    <td><?php  echo $rows['price']   ?>  </td>
                                    <td><?php  echo date('Y-m-d',$rows['date_req']) ?></td>
                                    <td><?php  echo date('h:i:s A',$rows['date_req']) ?></td>
                                    <td><?php  echo $rows['mpx']  ?></td>
                                </tr>
                            <?php  }  ?>



                            </tbody>
                        </table>

                   </div>

                    <?php  }   ?>

                </div>
            </div>


        </div>



        <div class="tab-pane fade" id="req_2" role="tabpanel" aria-labelledby="req-tab-2">
            <div class="row">

                <div class="col-12">


                    <?php  foreach ($date_req_reject as $key => $date_rej) {  ?>
                    <div class="retn_r<?php echo $date_rej['number_bill'] ?>">

                        <div class="date_req_rej ">
                            <div class="row justify-content-between">


                                <div class="col-auto">
                                    <span> رقم الفاتورة     :  </span>  <?php echo  $date_rej['number_bill']  ?>
                                </div>

                                <div class="col-auto">
                                    <i class="fa fa-calendar"></i>  <?php echo  date('A h:i:s  Y-m-d ',$date_rej['date_req']) ?>
                                </div>

                            </div>


                        </div>



                        <table class="requ_on table table-striped" border >
                            <thead>


                            <tr  class="d_table_rej"  >
                                <th scope="col">صورة</th>
                                <th scope="col">اسم المنتج</th>
                                <th scope="col">code</th>
                                <th scope="col">القياس</th>
                                <th scope="col">الون</th>
                                <th scope="col">اسم اللون</th>
                                <th scope="col">العدد</th>
                                <th scope="col">السعر</th>
                                <th scope="col">تاريخ</th>
                                <th scope="col">الوقت</th>
                                <th scope="col">سبب الزيادة او النقصان</th>
                            </tr>

                            </thead>
                            <tbody>


                            <?php   foreach ($date_rej[$date_rej['number_bill']] as $rows)  {  ?>
                                <tr>
                                    <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                                    <td><?php  echo $rows['title'] ?></td>
                                    <td><?php  echo $rows['code'] ?></td>
                                    <td><?php  echo $rows['size'] ?></td>
                                    <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                                    <td><?php  echo $rows['name_color']   ?>  </td>
                                   <td><?php  echo $rows['number'] ?></td>
                                    <td><?php  echo $rows['price']   ?>  </td>
                                    <td><?php  echo date('Y-m-d',$rows['date']) ?></td>
                                    <td><?php  echo date('h:i:s A',$rows['date']) ?></td>
                                    <td><?php  echo $rows['mpx'] ?></td>
                                </tr>
                            <?php  }  ?>



                            </tbody>
                        </table>

                        <div class="note_req">
                           <span> ملاحظة // </span> <?php echo   $date_rej['why_rejected'] ?>
                        </div>

                    </div>
                    <?php  }   ?>

                </div>

            </div>

        </div>

    </div>











</div>
<br>
<br>
<br>


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




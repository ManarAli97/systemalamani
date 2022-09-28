



<div class="container-fluid">

    <?php  if ($result['active_wholesale_price'] == 1) { ?>
        <p><span style="background: #4CAF50;
                padding: 5px 20px;
                color: #fff;border-radius: 10px" > حساب جملة </span> </p>
    <?php  } ?>



    <br>

    <?php $sumAllBillCustomer=0  ?>
    <?php foreach ($date_req_done as $key => $bills) { ?>

    <?php    $sumAllBillCustomer=$sumAllBillCustomer+ (int)str_replace($this->comma,'',$this->sunAllBillCustomerAccount($result['id'],$bills['number_bill']))  ?>
    <?php }  ?>


    <div class="alert alert-primary" role="alert">
       <span> مجموع جميع الفواتير :  </span>      <?php echo  number_format( $sumAllBillCustomer )  ?>  د.ع
    </div>


    <div class="row">

        <div class="col-12">

            <?php  foreach ($date_req_done as $key => $date_done) {  ?>

                <div class="retn_<?php echo $date_done['number_bill'] ?>">


                    <div class="date_req ">
                        <div class="row justify-content-between">


                            <div class="col-auto">
                                <span> رقم الفاتورة  :  </span>  <?php echo  $date_done['number_bill']  ?>   //    <span>  مجموع االفاتورة    :  </span>  <span class="sum_bill_<?php echo $date_done['number_bill'] ?>"> <?php echo  $date_done['sum']  ?> </span>
                            </div>

                            <div class="col-auto">
                                  <span> تاريخ المحاسبة </span> || <?php echo  date('A h:i  Y-m-d ',$date_done['date_accountant']) ?>
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
                            <th  class="retn"  scope="col">    استرجاع  </th>
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
                                <td><?php  echo $rows['note'] ?></td>

                                <td style="text-align: center">
                                    <?php  if ($rows['prepared']==1)  {  ?>

										<?php  if ($rows['cancel']==0) { ?>

											<?php  if ($rows['review_item'])  { ?>
                                                <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus_after_accept(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php echo $date_done['number_bill'] ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
											<?php  } else{ ?>
                                                مسترجع
											<?php  } ?>

										<?php   }  ?>


									<?php  }  ?>

                                </td>
                            </tr>
                        <?php  }  ?>



                        </tbody>
                    </table>
                    <div class="note_req">
                        <span>  المحاسب // </span>     <span> <?php echo $this->UserInfo( $date_done['id_accountant_user'] ) ?>  </span>       </div>
                </div>

                <br>

                <div class="text-center">

                    <button onclick="print_bill(<?php echo  $result['id'] ?>,<?php echo $date_done['number_bill'] ?>)"  class="btn btn-primary" > طباعه </button>

                </div>
                <hr>
            <?php  }   ?>

        </div>
    </div>





</div>




<script>



    function print_bill(id,number_bill) {
        $( ".body_print_bill" ).show();
        $( ".body_print_bill .outPill" ).empty();

        $.get( "<?php  echo url .'/'.$this->folder ?>/details/"+id+"/"+number_bill, function( data ) {
            $( ".body_print_bill .outPill" ).html( data );
        });

    }

</script>



<br>
<br>
<br>


<script>


    function  return_order_minus_after_accept(id_order,table,colde,id_user,color,number_bill) {



        if ($('#number_item_' + id_order).text()  === '1')
        {
            if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus_after_accept/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {color:color,number_bill:number_bill},
                    success: function (response) {

                        if (response) {

                                $('.sum_bill_' + number_bill).html(response);

                                $('#row_' + id_order).remove();

                        }else
                        {
                            alert('حدث خطا')
                        }

                        $('#minus_x_'+id_order).removeAttr('disabled');
                    }
                });

            }

        }else {


            if (confirm("هل انت متأكد من استرجاع؟")) {


                $('#minus_x_' + id_order).attr('disabled', 'disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus_after_accept/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {color: color, number_bill: number_bill},
                    success: function (response) {
                        if (response) {

                            $('.sum_bill_' + number_bill).html(response);
                            n = $('td#number_item_' + id_order).text();
                            $('#number_item_' + id_order).html(Number(n) - 1);

                        } else {
                            alert('حدث خطا')
                        }
                        $('#minus_x_' + id_order).removeAttr('disabled');
                    }
                });
            } return false;
        }
    }





</script>






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






<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/under_accounting"><?php  echo $this->langControl('under_accounting') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات </li>

            </ol>

        </nav>

    </div>
    <div class="col-auto">
        <div style="cursor: pointer" onclick="sun_total_money()" class="sumAllMoney"  data-toggle="tooltip" data-placement="top" title="  اضغط هنا لعرض المجموع الكلي " >
            <span> حساب المجموع الكلي </span>
        </div>
    </div>


</div>

<script>

    function  sun_total_money () {
        $( ".sumAllMoney" ).html(`
         <span>  جاري  حساب المبلغ   : </span>  <img style="width:18px" src="<?php echo $this->static_file_site ?>/image/site/loding.gif">
        ` );
        $.get( "<?php  echo url .'/'.$this->folder ?>/sun_total_money", function( data ) {
            if (data)
            {
                $( ".sumAllMoney" ).html(`
         <span>  المبلغ الكلي   : </span> <span>  ${data}  </span> <span> د.ع</span>
        ` );
            }
        });
    }

</script>



<div class="row">

    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder?>/under_accounting" role="button"    class="btn btn-primary btn-sm">   رجوع </a>
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
        <td>  <div  style="direction: ltr;">

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
                        <div class="col-auto rejected_processing r_x">
                            <button  onclick="open_why_rejected()"  class="btn btn- btn-link  rejected_processing_x "> <span>     الغاء الطلب  </span>  </button>   <span  class="error"> </span>
                        </div>

                        <div class="col-3  d_x progs_d_x">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemax="100" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="col-auto done_processing d_x">
                            <button  onclick="processing_request(<?php echo $number_bill ?>)"  class="btn btn- btn-link  processing_request "> <span>   تمت المحاسبه </span>  </button>   <span  class="error"> </span>
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
                    <th scope="col">القياس</th>
                    <th scope="col">اللون</th>
                    <th scope="col">اسم اللون</th>
                    <th scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">التاريخ والوقت</th>

                    <th  class="retn"  scope="col">   زيادة / نقصان   </th>

                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request as $rows)  {  ?>
                    <tr class="retn" id="row_<?php  echo $rows['id'] ?>">
                        <td><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                        <td><?php  echo $rows['title'] ?></td>
                        <td><?php  echo $this->langControl($rows['table']) ?></td>
                        <td><?php  echo $rows['code'] ?></td>
                        <td><?php  echo $rows['size'] ?></td>
                        <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                        <td><?php  echo $rows['color_name']   ?>  </td>
                        <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                        <td><?php  echo $rows['price']   ?>  </td>
                        <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>

                        <td style="text-align: center">
                            <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>','<?php echo $number_bill ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
                            <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>',<?php echo $number_bill ?>)">  <i   class="fa fa-plus-circle"></i>    </button>
                         </td>
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




<script>



    function  processing_request(number_bill) {

            $.ajax({
                type: 'GET',
                url: '<?php echo url .'/'.$this->folder ?>/processing_request/<?php echo $result["id"]?>',
                cache: false,
                data: {date_req:<?php  echo $date_req?>,  number_bill: number_bill},
                success: function (result) {
                    $('#exampleModal_delivery_service').modal('hide');
                    if (result === '1') {

                        $('#exampleFormControlTextarea1').val('');

                        $('.r_x').hide();
                        $('.progs_d_x').css('display', 'block');
                        setTimeout(function () {
                            $('.retn').remove();
                            $('.progs_d_x').hide();
                            $('.done_processing').html('');
                        }, 1000);
                    } else {
                        $('.progs_d_x').css('display', 'block');
                        setTimeout(function () {
                            $('.progs_d_x').hide();
                            $('.error').html('فشل');
                        }, 1000);
                    }
                    reloadData()
                },
            });


    }




    function open_why_rejected() {
        $('#exampleModal_model_why_rejected').modal('show')
    }

    function  processing_request_rejected() {

        why_rej=$('#why_rejected').val();

        if (why_rej)
        {
            $.ajax({
                type: 'GET',
                url: '<?php echo url  .'/'.$this->folder?>/processing_request_rejected/<?php echo $result["id"]?>',
                cache: false,
                data: {why_rej:why_rej,date_req:<?php  echo $date_req?>},
                success: function (result) {

                    console.log(result);

                    if (result==='1')
                    {
                        $('#exampleModal_model_why_rejected').modal('hide');
                        $.get( "<?php  echo url .'/'.$this->folder ?>/delete_note/<?php   echo $result['id'] ?>", function( data ) {

                            $('#exampleFormControlTextarea1').val('');
                        });

                        $('.d_x').hide();
                        $('.progs_r_x').css('display','block');
                        setTimeout(function(){
                            $('.retn').remove();
                            $('.progs_r_x').hide();
                            $('.rejected_processing').html('<button  class="btn btn- btn-link  rejected_processing_x "> <i style="color:red " class="fa fa-check-circle"></i> <span>    تم الغاء الطلب    </span>  </button>');
                        }, 1000);
                        reloadData()

                    }else
                    {
                        $('#exampleModal_model_why_rejected').modal('hide');
                        $('.progs_r_x').css('display','block');
                        setTimeout(function(){
                            $('.progs_r_x').hide();
                            $('.error').html('فشل');
                        }, 1000);
                    }

                },
            });


        }else
        {
            alert('يجب كتابة سبب الغاء الطلب')
        }


    }


    function  return_order_minus(id_order,table,colde,id_user,color,number_bill) {



            if ($('#number_item_' + id_order).text()  === '1')
            {
                if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                    $('#minus_x_'+id_order).attr('disabled','disabled');

                    $.ajax({
                        type: 'GET',
                        url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                        cache: false,
                        data: {color:color,number_bill:number_bill},
                        success: function (response) {

                            if (response) {
                                reloadData()
                                if (isNaN(response)) {
                                    window.location = "<?php echo url ?>/home"
                                } else {
                                    $('#number_item_' + id_order).html(response);
                                    $('#row_' + id_order).remove();
                                }
                            }else
                            {
                                alert('حدث خطا')
                            }

                            $('#minus_x_'+id_order).removeAttr('disabled');
                        }
                    });
                    reloadData()
                }

            }else {
                $('#minus_x_'+id_order).attr('disabled','disabled');

                $.ajax({
                    type: 'GET',
                    url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                    cache: false,
                    data: {color:color,number_bill:number_bill},
                    success: function (response) {
                        if (response) {
                            reloadData()
                            if (isNaN(response))
                            {
                                 window.location="<?php echo url ?>/home"
                            }else
                            {
                                $('#number_item_' + id_order).html(response);
                            }
                        }else
                        {
                            alert('حدث خطا')
                        }
                        $('#minus_x_'+id_order).removeAttr('disabled');

                    }
                });

            }
    }

    function  return_order_plus(id_order,table,colde,id_user,color,number_bill) {

            $('#plus_x_'+id_order).attr('disabled','disabled');

            $.ajax({
                type: 'GET',
                url: "<?php  echo url . '/' . $this->folder ?>/return_order_plus/" + table + "/" + colde + "/" + id_user,
                cache: false,
                data: {color:color,number_bill:number_bill},
                success: function (response) {

                    if (response){
                        reloadData()
                        if (isNaN(response))
                        {
                            window.location="<?php echo url ?>/home"
                        }else {
                            $('#number_item_' + id_order).html(response);
                        }

                    }else
                    {
                        alert('حدث خطا')
                    }

                    $('#plus_x_'+id_order).removeAttr('disabled');

                }
            });




    }
    function reloadData() {

        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#reloadPage').children();
            $('#reloadPage').empty().html(founddata);
        });
    }

</script>



<div class="modal fade" id="exampleModal_model_why_rejected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">   سبب الغاء الطلب  </h5>
            </div>
            <div class="modal-body">

                <textarea id="why_rejected" class="form-control"  rows="3" required></textarea>

            </div>
            <div class="modal-footer">
                <button  onclick="processing_request_rejected()"  type="button" class="btn btn-secondary"  > موافق </button>
            </div>

        </div>
    </div>
</div>






<hr>



<br>
<br>
<br>
<br>



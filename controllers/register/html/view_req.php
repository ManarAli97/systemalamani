
<br>
    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/all_active_buy">عرض الطلبات الحالية </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > عرض الطلب </li>
                    <li class="breadcrumb-item active" aria-current="page" >  <?php echo $result['name'] ?>  </li>
                </ol>
            </nav>

        </div>
    </div>


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
        <div class="row">

            <div class="col-12">

              <?php  if (!empty($request)) { ?>
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            طلب جديد
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
                                    <button  onclick="processing_request_delivery_service()"  class="btn btn- btn-link  processing_request "> <span>    تأكيد الطلب  </span>  </button>   <span  class="error"> </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <table class="requ_on table table-striped" border>
                        <thead>


                        <tr style="background: #125da9;color: #ffffff">
                            <th scope="col">صورة</th>
                            <th scope="col">اسم المنتج</th>
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
                                <td><?php  echo $rows['code'] ?></td>
                                <td><?php  echo $rows['size'] ?></td>
                                <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                                <td><?php  echo $rows['color_name']   ?>  </td>
                                <td id="number_item_<?php  echo $rows['id'] ?>"><?php  echo $rows['number'] ?></td>
                                <td><?php  echo $rows['price']   ?>  </td>
                                <td><?php  echo date('Y-m-d h:i:s A',$rows['date_req']) ?></td>

                                <td style="text-align: center">
                                    <button type="button" id="minus_x_<?php  echo $rows['id'] ?>"  class="btn btn-danger  btn_pross" onclick="return_order_minus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>')">  <i   class="fa fa-minus-circle"></i>    </button>
                                    <button type="button"  id="plus_x_<?php  echo $rows['id'] ?>"  class="btn btn-success btn_pross" onclick="return_order_plus(<?php  echo $rows['id'] ?>,'<?php  echo $rows['table'] ?>','<?php  echo $rows['code'] ?>',<?php echo $result['id'] ?>,'<?php  echo $rows['color_name'] ?>')">  <i   class="fa fa-plus-circle"></i>    </button>
                                    <textarea  style="margin-top: 2px"  class="form-control" id="exampleFormControlTextarea1_textMP_<?php  echo $rows['id'] ?>" data-toggle="tooltip" data-placement="right"    title="يرجى كتابة الملاحظة قبل عملية الزيادة او النقصان" placeholder="يرجى كتابة الملاحظة قبل عملية الزيادة او النقصان"><?php  echo $rows['mpx'] ?></textarea>
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

        function processing_request_delivery_service() {


            $('#exampleModal_delivery_service').modal('show')



        }


        function  processing_request() {


            number_bill=$('#number_bill').val();


                if (number_bill) {

                    $.ajax({
                        type: 'GET',
                        url: '<?php echo url  ?>/register/processing_request/<?php echo $result["id"]?>',
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
                                    $('.done_processing').html('<button  class="btn btn- btn-link  processing_request "> <i style="color:green " class="fa fa-check-circle"></i> <span>     تجهيز </span>  </button>');
                                }, 1000);
                            } else {
                                $('.progs_d_x').css('display', 'block');
                                setTimeout(function () {
                                    $('.progs_d_x').hide();
                                    $('.error').html('فشل');
                                }, 1000);
                            }

                        },
                    });
                } else {
                    alert('يجب ادخال رقم الفاتورة')
                }

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
                     url: '<?php echo url  ?>/register/processing_request_rejected/<?php echo $result["id"]?>',
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


        function  return_order_minus(id_order,table,colde,id_user,color) {




            mpx=$('#exampleFormControlTextarea1_textMP_'+id_order).val();

            if (mpx && mpx !==' ')
            {

                if ($('#number_item_' + id_order).text()  === '1')
                {
                    if (confirm('  هل تريد استرجاع اخر مادة الى المخزن ؟ ')) {
                        $('#minus_x_'+id_order).attr('disabled','disabled');

                        $.ajax({
                            type: 'GET',
                            url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                            cache: false,
                            data: {mpx: mpx,color:color},
                            success: function (response) {

                                if (response) {

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

                    }

                }else {
                    $('#minus_x_'+id_order).attr('disabled','disabled');

                    $.ajax({
                        type: 'GET',
                        url: "<?php  echo url . '/' . $this->folder ?>/return_order_minus/" + table + "/" + colde + "/" + id_user,
                        cache: false,
                        data: {mpx: mpx,color:color},
                        success: function (response) {
                            if (response) {
                            if (isNaN(response))
                            {
                              //  window.location="<?php echo url ?>/home"
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

            }else
            {
                alert('يجب كتابة سبب النقصان.')
            }


        }

        function  return_order_plus(id_order,table,colde,id_user,color) {


             mpx=$('#exampleFormControlTextarea1_textMP_'+id_order).val();

            if (mpx && mpx !==' ')
             {
                 $('#plus_x_'+id_order).attr('disabled','disabled');

                 $.ajax({
                     type: 'GET',
                     url: "<?php  echo url . '/' . $this->folder ?>/return_order_plus/" + table + "/" + colde + "/" + id_user,
                     cache: false,
                     data: {mpx: mpx,color:color},
                     success: function (response) {


                         if (response){
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

             }else
             {
                 alert('يجب كتابة سبب الزيادة.')
             }




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


    <div class="modal fade" id="exampleModal_delivery_service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">   ادخل رقم الفاتورة </h5>
                </div>
                <div class="modal-body">

                    <label class="mr-sm-2" for="number_bill"> رقم الفاتورة في كرستال   </label>
                   <input type="text"  id="number_bill" class="form-control">


                </div>
                <div class="modal-footer">
                    <button  onclick="processing_request()"   type="button" class="btn btn-secondary"  > موافق </button>
                </div>

            </div>
        </div>
    </div>



<script>
    window.onbeforeunload = function (e) {
        e = e || window.event;

        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = 'Sure?';
        }

        // For Safari
        return 'Sure?';
    };
</script>

<hr>

<form  id="IdFormAddProd"  action="<?php  echo url  .'/'.$this->folder?>/add_item_to_order" method="post">

    <input type="hidden" value="<?php  echo $id ?>"  name="id_member_r">

    <div class="form-row align-items-center">

        <div class="col-auto">
            الكود
        </div>

        <div class="col-lg-3 col-md-4 col-sm-5">
            <input type="text" name="code"   class="form-control" id="code" placeholder="الكود" required>
        </div>

        <div class="col-auto">

            <select name="cat" class="custom-select mr-sm-2" id="cat_site"  onchange="settingCat()" required>
                <option   selected    >  اختر القسم  </option>
                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                    <option value="<?php echo $key ?>"><?php  echo $c ?></option>
                <?php }  ?>
                <option   value="savers"   >   <?php  echo  $this->langControl('savers') ?>  </option>
            </select>
        </div>

        <div class="col-auto">
            <div class="add_color"></div>
        </div>


        <div class="col-auto">
            <button onclick="codeData()"  style="    margin: 0 !important;" type="button" class="btn btn-primary mb-2">بحث</button>
        </div>
    </div>



<br>



<div class="data_get"></div>

</form>


<script>


    function settingCat() {
        cat=$('#cat_site option:selected').val();
        if (cat==='savers')
        {
            $('.add_color').html(`<input type="text" name="color"   class="form-control" id="add_color" placeholder="لون المادة في كرستال" required>`);

        }else {
            $('.add_color').empty();
        }
    }


    function codeData()
    {

        code=$("#code").val();
        cat=$('#cat_site option:selected').val();

        if (code) {

            if (cat === 'savers') {

                color = $("#add_color").val();

                if (color)
                {
                    $.ajax({
                        url: "<?php  echo url . '/' . $this->folder?>/get",
                        type: 'post',
                        data: {code: code, cat: cat, color: color},
                        success: function (data) {

                            $('.data_get').html(data);

                        }
                    });
                }else
                {
                    alert('يجب اضافة اسم لون المادة الموجود في كرستال')
                }


            } else {
                $('.add_color').empty();
                $.ajax({
                    url: "<?php  echo url . '/' . $this->folder?>/get",
                    type: 'post',
                    data: {code: code, cat: cat},
                    success: function (data) {

                        $('.data_get').html(data);

                    }
                });
            }
        }else
        {
            alert('اضف كود المنتج')
        }
    }


    $("#IdFormAddProd").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $('.add_to_order').addClass('disabled');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize() , // serializes the form's elements.
            success: function(data)
            {
                 console.log(data);

                if (data==='add')
                {
                    alert('تمت اضفة العنصر الى الطلب ');
                    window.location='';
                    $('.add_to_order').removeClass('disabled');

                }else if (data==='not_enough')
                {
                    alert('الكمية غير متوفرة');
                    $('.add_to_order').removeClass('disabled');
                }else
                {
                    alert('لم اجد تفاصيل لهذا الرمز يرجى التأكد منة ');
                    $('.add_to_order').removeClass('disabled');
                }


            }
        });


    });



</script>

<style>
 .table_style3
 {
     border: 1px solid #ecedee;
 }
</style>

<br>
<br>
<br>
<br>

<br>
<br>
<br>
<br>


<?php  $this->publicHeader('المسابقة اليومية');  ?>

    <div class="container">
    <div class="row">
    <div class="col-lg-3">

        <?php $this->menu->menu() ?>


    </div>

        <div class="col-lg-9">

            <br>


            <nav aria-label="breadcrumb" class="path_bread">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="<?php echo url ?>"><i class="fa fa-home"></i> </a></li>
                    <li class="breadcrumb-item active"><span> المسابقة اليومية   </span></li>

                </ol>
            </nav>




                <div class="row">
                    <div class="col-12">
                        <div class="define_questions">
                            <div>المسابقة اليومية</div>
                            هي عبارة عن اسئلة سهلة و لطيفة تتجدد يوميا عند الساعة 12 منتصف الليل الغاية منها اضافة بعض من المتعة و الحماس لزبائننا و متابعينا الكرام ،
                            اصحاب الاجابة الصحيحة بها يدخلون بقرعة اسبوعية بعدد اجاباتهم الصحيحة اليومية و يكون بها ثلاث فائزين بمبلغ تسوق بقيمة 25 الف دينار يستطيعون بهذا المبلغ التسوق اما بنفس القيمة او بقيمة اكبر من مبلغ الجائزة مع دفع الفارق و سيحصلون على خدمة توصيل مجانية (محددة بضوابط)،
                            امنياتنا للجميع بالفوز فالمسابقة مستمرة و فرص الفوز مستمرة ان شاء الله تعالى .
                        </div>
                    </div>

                    <style>
                        .define_questions {
                            text-align: justify;
                            margin: 5px;
                            margin-bottom: 13px;
                            border: 1px solid #dee1e4;
                            padding: 5px;
                            box-shadow: 3px 4px 6px 0 #ced0d1;
                        }
                        .define_questions div {
                         font-weight: bold;
                        }
                    </style>

                    <div class="col-lg-12 col-md-12 ">

                        <?php  if (!empty($qu)) {  ?>
                        <?php  foreach ($qu as $print){?>

                            <form id="idForm" action="<?php  echo url .'/'.$this->folder?>/form/<?php  echo $print['id'] ?>" style="padding: 5px" method="post">


                                <?php  if (!empty($print['image'])) {  ?>
                                    <div class="image_q">
                                        <img src="<?php echo  $this->save_file .'questions/'.$print['image'] ?>">
                                    </div>

                                <?php }  ?>



                                <div class="resultQues">
                                </div>

                                <div class="question">
                                    <?php  echo $print['questions'] ?>
                                </div>

                                <?php  foreach ( $print['answer'] as $answer ) { ?>

                                    <div class="custom-control custom-radio answer_button">
                                        <input  type="radio" value="<?php  echo $answer['id']?>" id="customRadio1_<?php  echo $answer['answer']?>" name="id_ans" class="custom-control-input no_c">
                                        <label class="custom-control-label" for="customRadio1_<?php  echo $answer['answer']?>">
                                            <?php  echo $answer['answer']?>

                                        </label>
                                    </div>
                                <?php  }  ?>

                                <hr>

                                <div class="row justify-content-center">
                                    <div class="col-auto">
                                        <button type="submit" class="btn send_answer" name="submit" ><span>ارسال الاجابة</span> <i class="fa fa-send" ></i>
                                    </div>

                                </div>

                                <div class="prev_questions">
                                    <span> للتعرف على الاجابات الصحيحة للاسئلة السابقة </span>  <a href="https://alamani.iq/pages/details/8"> اضغط هنا  </a>
                                </div>


                            </form>

                        <?php }  ?>
                        <?php  } else{   ?>

                            <div class="alert alert-warning" role="alert">
                                انتهت المسابقة .
                            </div>
                        <?php  }  ?>

                    </div>
                </div>



                <style>
                    .prev_questions
                    {
                        text-align: center;
                        margin-top: 15px;
                    }

                    .prev_questions a
                    {
                        color: #007bff;
                        font-weight: bold;
                    }
                    .er
                    {
                        background: #ff0000ba;
                        padding: 8px 16px;
                        margin-bottom: 5px;
                        color: #fff;
                        border-radius: 15px;
                    }

                    i.fa.fa-times-circle.close_messg {
                        left: 5px;
                        position: absolute;
                        top: 4px;
                    }
                    .h
                    {
                        width: 37px;
                        position: absolute;
                        top: -15px;
                        left: -4px;
                    }
                    .prev_slider,.next_slider
                    {
                        position: relative;
                    }
                    .prev_slider span,.next_slider span
                    {
                        position: absolute;
                        background: black;
                        padding: 1px 5px;
                        border-radius: 6px;
                        right: -10px;
                        bottom: -36px;
                    }
                    .prev_slider span:before
                    {
                        content: '';
                        width: 11px;
                        height: 11px;
                        background: black;
                        position: absolute;
                        transform: rotate(45deg);
                        top: -4px;
                        right: 22px;
                        z-index: -1;;

                    }


                    .next_slider span:before
                    {
                        content: '';
                        width: 11px;
                        height: 11px;
                        background: black;
                        position: absolute;
                        transform: rotate(45deg);
                        top: -4px;
                        right: 20px;
                        z-index: -1;

                    }
                </style>



                <script>
                    $("#idForm").submit(function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var url = form.attr('action');
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize()+'&submit=submit',
                            success: function(data)
                            {

                                var response = JSON.parse(data);
                                if(response.error) {
                                    var str = '';
                                    for (var prop in response.error) {
                                        str +=`<div>${response.error[prop]}</div>`;
                                    }
                                    $('.resultQues').html(`<div class="er"> ${str} </div>`);
                                }

                                else if (response.failed)
                                {
                                    $('.resultQues').html('<div style="background-color: #dc3545;color: #ffffff;text-align: center;border-radius: 15px;margin-bottom: 5px;position: relative;padding: 0 1px;">'+response.failed['failed']+' <i onclick="close_ms()" class="fa fa-times-circle close_messg"></i> </div>')
                                }
                                else  if (response.done)
                                {
                                    $('#done').html(response.done['done']);
                                    $('#exampleModal_questions').modal('show');
                                    $('.resultQues div').empty();
                                    $('.rest').val('');
                                    $(".no_c").prop( "checked", false );

                                }else {
                                    $('.resultQues').html('<div style="background-color: #dc3545;color: #ffffff;text-align: center;border-radius: 15px;margin-bottom: 5px;position: relative;padding: 0 1px;">'+response.xcolx['xcolx']+' <i onclick="close_ms()" class="fa fa-times-circle close_messg"></i> </div>')

                                }


                            }
                        });


                    });

                    function close_ms() {
                        $('.resultQues div').empty();
                    }

                    $('.prev_r').css('display','none');
                    $('.next_r').css('display','block');

                    $('.next_slider').on('click',function () {
                        $('.next_r').css('display','none');
                        $('.prev_r').css('display','block');
                    });

                    $('.prev_slider').on('click',function () {
                        $('.prev_r').css('display','none');
                        $('.next_r').css('display','block');
                    })

                </script>


                <div class="modal fade" id="exampleModal_questions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <div class="col-auto">
                                    <h5  class="modal-title" id="done"> تم ارسال اجابتك بنجاح.</h5>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>




        </div>


    </div>
    </div>




    <script>

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<style>

    .r1
    {
        height: 150px;
    }
    .r2
    {
        height: 150px;
    }

    .r3
    {
        width: 100%;
    }


    .form_q
    {

        padding: 5px;
    }
    .layout
    {
        padding: 5px;
    }
    .info_s
    {
        border: 1px solid #006837;
        text-align: center;
        background: #ffff;
        font-size: 25px;
        margin-bottom: 21px;
    }

    .label_n{
        font-size: 18px;
        font-weight: bold;

    }

    .textbox_n
    {
        border: 1px solid  #006837;
    }


    .btn_prev_next
    {
        padding: 0 12px;
    }

    .x_line
    {
        border-bottom: 2px solid #635a538f;
    }

    .prev_slider
    {
        width: 39px;
        height: 39px;
        border-radius: 50%;
        padding-top: 7px;
        border: 2px solid #635a538f;
    }
    .next_slider
    {
        width: 39px;
        height: 39px;
        border-radius: 50%;
        padding-top: 7px;
        border: 2px solid #635a538f;
    }

    .x_op,.x_op:hover
    {
        opacity: 1;
    }


    .x_op.carousel-control-prev
    {

    }
    .x_op.carousel-control-next
    {

    }

    .x_padding
    {
        padding: 0;
    }

    .logo_
    {
        text-align: left;

    }

    .logo_ img
    {
        height: 150px;
    }



    .question_week

    {
        border: 1px solid #006837;
        text-align: center;
        background: #ffff;
        font-size: 25px;
        margin-bottom: 21px;
        padding: 3px 5px;
    }



    .question

    {
        border: 1px solid #283581;
        text-align: center;
        background: #283581;
        font-size: 20px;
        margin-bottom: 21px;
        padding: 3px 5px;
        font-weight: bold;
        color: #fff;

    }

    .answer_button
    {
        margin-bottom: 15px;
    }


    .answer_button .custom-control-label::before
    {
        background-color: #283581;
        top: 0.30rem;
        cursor: pointer;
    }
    .answer_button label.custom-control-label {
        font-size: 18px;
        background: #283581;
        padding: 0px 10px;
        border-radius: 13px;
        color: white;
        cursor: pointer;
    }


    .answer_button .custom-control-label::after
    {
        top: .30rem;
        cursor: pointer;
    }


    .font_text_m
    {
        text-align: left;
    }


    @media (max-width:992px ) {
        .r1
        {
            height: 100px;
        }
        .r2
        {
            height:100px;
        }
        .logo_ {
            text-align: left;
            margin-top: 39px;
        }

    }



    @media (max-width:768px ) {
        .r2
        {
            height: auto;
            width: 100%;
        }

        .font_text_m
        {
            text-align: center;
        }


        .question_week,.question,.answer_button label.custom-control-label
        {
            font-size: 17px;
        }


    }

    .m_r
    {
        background: #006938;
        color: #fff;
        text-align: center;
        margin-top: 15px;
        padding: 9px;
        font-size: 25px;
        border-radius: 42px;
    }


    .r4
    {
        margin-top: 30px;
        width: 100%;
    }


    .send_answer
    {
        background: #283581;
        color: #fff;
        border-radius: 0;
    }

    .loginFromHer
    {
        color: #ffffff;
    }
    a.loginFromHer {
        background: #006837;
        color: #ffffff !important;
        border-radius: 14px;
        padding: 0 9px;
        border-left: 3px solid #fff;
        border-right: 3px solid #fff;
    }

    .image_q {
        margin-bottom: 28px;
        border: 1px solid #dee1e4;
        padding: 5px;
        box-shadow: 3px 4px 6px 0 #ced0d1;
    }
    .image_q img {
    width: 100%;
    }

</style>
<br>
<br>
<br>
<?php $this->publicFooter(); ?>
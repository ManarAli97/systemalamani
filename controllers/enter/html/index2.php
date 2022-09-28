<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
	<meta charset="UTF-8">
	<!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<title> تسجيل الدخول </title>
	<link rel="icon"   href="<?php echo $this->static_file_site ?>/image/site/logo_notif.png">


	<!--jquery -->
	<script src="<?php echo $this->static_file_site ?>/js/jquery.min.js"></script>

	<!--bootstrap-->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/bootstrap/css/bootstrap.min.css" >
	<script src="<?php echo $this->static_file_site ?>/bootstrap/js/popper.min.js"></script>
	<script src="<?php echo $this->static_file_site ?>/bootstrap/js/bootstrap.min.js"  ></script>

	<!--css range-->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range_input2/jquery.range.css">

	<!--custom css -->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/css/default1.css"/>

	<!--custom js-->
	<script src="<?php echo $this->static_file_site ?>/js/custom.js"></script>


	<!--bootstrap-toggle-->
	<link href="<?php echo $this->static_file_site ?>/bootstrap/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="<?php echo $this->static_file_site ?>/bootstrap/toggle/js/bootstrap-toggle.min.js"></script>

	<!--upload file-->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/dist2/font-awesome.min.css"/>


	<!--dataTables-->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/datatable/css/dataTables.bootstrap4.min.css">
	<script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->static_file_site ?>/datatable/js/dataTables.bootstrap4.min.js"></script>


	<!--editor css -->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/editor/froala/css/froala_style.css"/>


	<!--      pagenation-->
	<script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>
	<script src="<?php echo $this->static_file_control ?>/zoom/jquery.elevatezoom.js"></script>

	<!--    swiper-->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/swiper/swiper.min.css">
	<script src="<?php echo $this->static_file_site ?>/js/qrcode.min.js"></script>

	<!--  range -->
	<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/range/jquery-ui.css" type="text/css" media="all" />
	<script src="<?php echo $this->static_file_site ?>/range/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->static_file_site ?>/range/price_range_script.js"></script>





	<script>

        var myarr_non = ['NON','non','UNKNOWN','unknown','Unknown','Non','بلا','',' ','  '];

	</script>


	<style>

		@media  only screen and  (max-width: 980px) and  (min-width: 700px)
		{
			.container {
				max-width: 970px;
			}

			.style_btn_like_mb {
				width: 48%;
			}
			.comparison {
				width: 48%;
			}
			.xcartp {
				padding: 0 15px;
			}
		}


		@media  only screen and  (max-width: 700px) and  (min-width: 500px)
		{
			.container {
				max-width: 970px;
			}
		}
		@media (max-width: 570px)
		{
			.xcartp {
				padding: 0 15px;
				margin-bottom: 5px;
			}
		}


	</style>



</head>
<body   style="overflow-x: hidden;">




<div class="register_new modal bd-example-modal-xl " id="exampleModal_register_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<video  class="bg_video" autoplay muted loop id="myVideo">
		<source src="<?php echo $this->static_file_site ?>/image/site/bg.mp4" type="video/mp4">
		Your browser does not support HTML5 video.
	</video>

	<!--        <div style="position: fixed;background: white;padding: 0 9px;color: #808080;left: 0;"> <span>version:</span> <span> --><?php // echo $this->version ?><!--</span></div>-->
	<div class="modal-dialog modal-xl withModelRegister" role="document">


		<div class="modal-content" style="border-radius: 0">

			<div class="search_phone">

				بحث عن رقم مسجل سابقا

				<form action="<?php  echo url  ?>/customers/phone"  method="post"  id="search_phone"   class="was-validated">
					<div class="status_register_hone"></div>
					<div class="row">
						<div class="col" style="padding-left: 0">
							<input class="form-control is-valid"  type="number" min="07000000000" max="07999999999" name="phone"  autocomplete="off" placeholder="رقم الهاتف" id="search_phone" required>
						</div>
						<div class="col-auto" style="padding-right: 0">
							<button type="submit" id="btn_search_phone" class="btn btn-primary">بحث</button>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">    تسجيل </h5>
			</div>
			<form action="<?php  echo url  ?>/customers/form"  method="post"  id="idFormReg"   class="was-validated">
				<div class="modal-body">
					<div class="field_form">


						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade  tabx1 show active" id="home" role="tabpanel" aria-labelledby="home-tab">


								<div class="form-group row">
									<label for="first_name" class="col-sm-3 col-form-label">  الاسم  </label>
									<div class="col-sm-9">
										<input   autocomplete="off"   type="text" class="form-control is-invalid"    name="first_name" id="first_name" placeholder="الاسم  " required >
									</div>
								</div>




								<div class="form-group row">
									<label for="title" class="col-sm-3 col-form-label">  اللقب    </label>
									<div class="col-sm-9">
										<input   autocomplete="off"   type="text" class="form-control " name="title" id="title" placeholder="اللقب"  required>
									</div>
								</div>


								<div class="form-group row">
									<label for="day" class="col-sm-3 col-form-label">  تاريخ الميلاد  </label>
									<div class="col-sm-9">


										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-4 col-4">
												<input  autocomplete="off"   type="number" class="form-control xcolalich no_required"  max="31" min="1" onkeyup="checkBrth()"  name="day" id="day" placeholder="يوم"  >
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-4">
												<input  autocomplete="off"   type="number" class="form-control xcolalich no_required" name="month"  onkeyup="checkBrth()"  max="12" min="1" id="month" placeholder="شهر"  >
											</div>
											<div class="col-lg-4 col-md-4 col-sm-4 col-4">
												<input  autocomplete="off"   type="number" class="form-control xcolalich no_required" name="year"  onkeyup="checkBrth()"  id="year" max="9999"  min="1900"   placeholder="سنه"  >
											</div>
										</div>


									</div>
								</div>

								<script>


                                    function checkBrth() {

                                        if ($('#day').val() || $('#month').val() || $('#year').val() )
                                        {
                                            $('#day').attr('required','required')
                                            $('#month').attr('required','required')
                                            $('#year').attr('required','required')
                                            $('.xcolalich').removeClass('no_required')

                                        }else
                                        {
                                            $('#day').removeAttr('required','required')
                                            $('#month').removeAttr('required','required')
                                            $('#year').removeAttr('required','required')
                                            $('.xcolalich').addClass('no_required')
                                        }


                                    }


								</script>

								<style>

									.form-control.no_required {
										border-color: #ced4da !important;
										padding-left:unset !important;
										background-image:unset !important;

									}

									.withModelRegister
									{
										max-width: unset !important;
										width: 100% !important;
										padding: 0 20px !important;
									}
								</style>



								<div class="form-group row align-items-center">
									<label for="phone" class="col-sm-3 col-form-label"> رقم الهاتف</label>
									<div class="col-sm-9">
										<div class="chphone"></div>
										<input type="number" class="form-control"  onkeyup="showResult(this.value)" autocomplete="off" name="phone"  min="07000000000" max="07999999999"  id="phone" placeholder="رقم الهاتف"  required>
									</div>
								</div>

								<div class="form-group row">
									<label for="city" class="col-sm-3 col-form-label"> المحافظة </label>
									<div class="col-sm-9">
										<select name="city"  id="input-country" class="custom-select" required>
											<?php  foreach ($city as $cy)  { ?>
												<option value="<?php  echo $cy ?>"  <?php  if ($cy == 'كربلاء' )  echo 'selected' ?> ><?php  echo $cy ?></option>
											<?php  }  ?>
										</select>
									</div>
								</div>


								<div class="form-group row">
									<label for="address" class="col-sm-3 col-form-label"> الحي</label>
									<div class="col-sm-9">
										<input  autocomplete="off"   type="text" class="form-control " name="address" id="address" placeholder="الحي"  required>
									</div>
								</div>
								<hr>


								<div class="form-group row">
									<div class="col-12">
										<label for="about_company" class="col-form-label">

											لاحظنا ان بعض زبائننا الكرام ليس لديهم معلومة عن المعنى الحقيقي لشعار شركتنا (جودة , ضمان , سعر مميز) فهل تعرف ماذا نقصد به؟

										</label>
									</div>
								</div>


								<div class="form-group row">
									<label for="about_company" class="col-sm-3 col-form-label"> </label>
									<div class="col-sm-9">

										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio"  value="1" id="about_company1" name="about_company" required class="custom-control-input">
											<label class="custom-control-label" for="about_company1">نعم</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" value="2" id="about_company2" name="about_company" required class="custom-control-input">
											<label class="custom-control-label" for="about_company2">كلا</label>
										</div>

									</div>
								</div>

								<div class="openChoose">


									<div class="forAnswerThat">
										احدى الاجوبة الاتية هي الحقيقة و التي تمثل المعنى الحقيقي للجودة و الضمان و السعر المميز اختر حسب معلوماتك
									</div>

									<div class="custom-control custom-radio custom-control-inline setForAnswer">
										<input type="radio"   value="1" id="forAnswerThat1" name="forAnswerThat" class="custom-control-input">
										<label class="custom-control-label" for="forAnswerThat1">
											1.	انك ستحصل على انسب سعر و افضل ضمان.

										</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline setForAnswer">
										<input type="radio" value="2" id="forAnswerThat2" name="forAnswerThat" class="custom-control-input">
										<label class="custom-control-label" for="forAnswerThat2">
											2.	ستحصل على انسب سعر و افضل ضمان و الجودة تعني انك اشتريت جهاز لماركة مشهورة.

										</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline setForAnswer">
										<input type="radio" value="3" id="forAnswerThat3" name="forAnswerThat" class="custom-control-input">
										<label class="custom-control-label" for="forAnswerThat3">

											3.	ستحصل على انسب سعر و افضل ضمان لجهاز غير مغشوش "اصلي" في زمن انتشر به الغش بشكل كبير جدا و خصوصا في عالم اجهزة الموبايل لان طرق الغش سهلة و مربحة جداً و تحتاج فقط لشخص غير ملتزم دينيا ليعمل بها و يكسب منها الاموال الحرام الطائلة و من تلك الطرق البسيطة هي استبدال ملحقات الاجهزة الاصلية بملحقات تجارية مشابهة للاصلية و اعادة اقفال كارتونة الجهاز بلاصق او نايلون يشابه لاصق و نايلون الجهاز الاصلي فيصبح فقط صاحب الاختصاص الذي لديه خبرة كافية يستطيع ان يميز الجهاز .
										</label>
									</div>



								</div>

							</div>

							<div class="tab-pane fade tabx2" id="contact" role="tabpanel" aria-labelledby="contact-tab">



								<video  id="myvideo_play" class="video_view"  >
									<source src="<?php  echo  $this->static_file_site ?>/image/site/video.mp4" type="video/mp4">
								</video>



								<div class="form-group row question_after_video">
									<label for="after_video" class="col-12 col-form-label">

										بعد مشاهدتك فديو الحقيقة هل انت مقتنع تماما ان ليس من مصلحتك البحث عن السعر الافضل دوما في بيئة كثر بها الغش بشكل فضيع جدا و يتوجب عليك من الان اختيار مكان تثق به للشراء منه.
									</label>
									<div class="col-sm-9">

										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio"  value="1" id="after_video1" name="after_video" class="custom-control-input">
											<label class="custom-control-label"  for="after_video1">نعم</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" value="2" id="after_video2" name="after_video" class="custom-control-input">
											<label class="custom-control-label" for="after_video2">كلا</label>
										</div>

									</div>
								</div>



								<div class="form-group row noteAfter_video">
									<label for="after_video" class="col-12 col-form-label">
										لماذا لست مقتنعاً اخبرنا كي نستفيد و نرتقي افضل بخدماتنا المقدمة لكم
									</label>
									<div class="col-12">

										<textarea rows="3" class="form-control"  name="note"></textarea>
									</div>
								</div>


							</div>
						</div>

						<div class="status_register"></div>


					</div>
				</div>
				<div class="modal-footer">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<!--                        -->
						<!--                        <li class="nav-item action1">-->
						<!--                            <a class="nav-link active" onclick="back_to_form()" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">رجوع</a>-->
						<!--                        </li>-->

						<li class="nav-item action2">
							<a class="btn button_model_register"  onclick="contine_form()"  >استمرار</a>
						</li>
						<li class="nav-item action3">
							<button type="submit" name="submit" class="btn button_model_register"> تسجيل </button>
						</li>
						<li class="nav-item action4">
							<button type="submit" name="submit" class="btn button_model_register">تسجيل </button>
						</li>
					</ul>


				</div>
			</form>


		</div>
	</div>
</div>




<style>

	.button_model_register
	{
		background: #283581;
		color: #ffff !important;
		border-radius: 0;
	}
	.openChoose
	{
		display: none;
	}
	.action1,.action2,.action4
	{
		display: none;
	}

	.setForAnswer
	{
		margin-bottom: 13px;
		border: 1px solid #bdbdbd;
		padding: 5px 34px;
		border-radius: 19px;
	}
	.forAnswerThat {
		margin-bottom: 16px;
	}

	.video_view
	{
		width: 100%;
	}

	.video_view::-webkit-media-controls {
		display:none !important;
	}

	.noteAfter_video
	{
		display: none;
	}

	.question_after_video
	{
		display: none;
	}
	.action4
	{
		display: none;
	}
	.setForAnswer label
	{
		color: #000000 !important;
	}

	.search_phone {
		padding: 19px 15px;
		border-bottom: 1px solid #cccccc;
		background: #f2f2f2;
	}
	input#search_phone {
		border-radius: 0;
	}

	button#btn_search_phone {
		border-radius: 0;
		background: #283581;
		color: #ffff;
		padding: 6px 26px;
	}

	.field_form input,
	.field_form textarea,
	.field_form select
	{
		border-radius: 0;
	}

	.xphonea
	{
		border: 1px solid red !important;
		box-shadow: 0 0 0 0.2rem rgba(167, 76, 40, 0.25) !important;

	}



</style>

<script>


    function showResult(phone)
    {

        $.get( "<?php  echo url  ?>/customers/chphone/"+phone, function( data ) {
            if (data==='found')
            {
                $('.chphone').html('<div class="phone_number_found">رقم الهاتف مسجل مسبقا يرجى الدخول مباشرتاً من خلال حقل البحث في الاعلى.</div>')
                $('#phone').addClass('xphonea')
            }else {
                $('.chphone').empty();
                $('#phone').removeClass('xphonea')
            }
        });

    }

    $(document).ready(function(){
        $('.video_view').on('ended',function(){

            closeFullscreen();
            setTimeout(function () {
                $('.question_after_video input').attr('required','required');
                $('.video_view').hide('fast');
                $('.question_after_video').show('fast');
                $('.action4').show('fast');
            },500);

        });
    });


    $('input[name="about_company"]').change(function() {
        val= $('input[name="about_company"]:checked').val();
        if (val==='1')
        {

            $('.setForAnswer input').prop('checked', false);
            $('.setForAnswer input').attr('required','required');


            $('.openChoose').show('fast');
            val2= $('input[name="forAnswerThat"]:checked').val();
            if (val2==='1' ||  val2==='2' )
            {

                $('.action1').hide();
                $('.action2').show();
                $('.action3').hide();
                $('.action4').hide();

            }else
            {
                $('.action1').hide();
                $('.action2').hide();
                $('.action3').show();
                $('.action4').hide();
            }


        }else
        {
            $('.setForAnswer input').removeAttr('required');
            $('.openChoose').hide('fast');

            $('.action1').hide();
            $('.action2').show();
            $('.action3').hide();
            $('.action4').hide();
        }

    });


    $('input[name="after_video"]').change(function() {
        val= $('input[name="after_video"]:checked').val();
        if (val==='1')
        {
            $('.noteAfter_video textarea').removeAttr('required');
            $('.noteAfter_video').hide('fast');
        }else
        {

            $('.noteAfter_video textarea').attr('required','required');
            $('.noteAfter_video').show('fast');
        }

    });


    $('input[name="forAnswerThat"]').change(function() {
        val2= $('input[name="forAnswerThat"]:checked').val();
        if (val2==='1' ||  val2==='2' )
        {

            $('.action1').hide();
            $('.action2').show();
            $('.action3').hide();
            $('.action4').hide();

        }else
        {
            $('.action1').hide();
            $('.action2').hide();
            $('.action3').show();
            $('.action4').hide();
        }

    });



    function contine_form() {
        if(validateForm())
        {
            $('.tabx1').removeClass('show active');
            $('.tabx2').addClass('show active');
            $('.action1').show();
            $('.action2').hide();
            openFullscreen();
            $('.video_view').get(0).play()

        }else {
            alert('يرجى التأكد من المعلومات المدخلة.')
        }

    }



    function openFullscreen() {
        var elem = document.getElementById("myvideo_play");
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }
    }

    function closeFullscreen() {
        var elem = document.getElementById("myvideo_play");
        if (elem.exitFullscreen) {
            elem.exitFullscreen();
        } else if (elem.mozCancelFullScreen) {
            elem.mozCancelFullScreen();
        } else if (elem.webkitExitFullscreen) {
            elem.webkitExitFullscreen();
        } else if (elem.msExitFullscreen) {
            elem.msExitFullscreen();
        }
    }



    function back_to_form()
    {
        val= $('input[name="about_company"]:checked').val();
        if (val==='1')
        {

            val2= $('input[name="forAnswerThat"]:checked').val();
            if (val2==='1' ||  val2==='2' )
            {
                $('.action1').hide();
                $('.action2').show();
                $('.action3').hide();
                $('.action4').hide();

            }else
            {
                $('.action1').hide();
                $('.action2').hide();
                $('.action3').show();
                $('.action4').hide();
            }



        }else
        {
            $('.openChoose').hide('slow');

            $('.action1').hide();
            $('.action2').show();
            $('.action3').hide();
            $('.action4').hide();
        }

    }


    $('#exampleModal_register_new').modal({
        backdrop: 'static',
        keyboard: false
    });



    $("#idFormReg").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (result) {
                var response = JSON.parse(result);
                if (response.error) {
                    for (var prop in response.error) {
                        $('*[name="' + prop + '"]').addClass('is-invalid');
                    }

                    $('.status_register').html(`
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                يرجى مراجعة بعض الحقول.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                    `)

                } else if (response.done) {

                    infoUrl="<?php  echo url ?>/customers/qr/"+response.done['done'];
                    var qrcode = new QRCode("qrcode");
                    qrcode.makeCode(infoUrl);

                    $('span.name_customer').text($('#first_name').val());
                    $('#exampleModal_hello_customer').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                } else {
                    $('.status_register').html(`
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               فشل الارسال.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                        `)
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })

    });


    function enterSite()
    {

        var timeleft = 100;
        var downloadTimer = setInterval(function(){
            if(timeleft <= 0){
                clearInterval(downloadTimer);
            }
            $('.progress_inter').css('width',100 - timeleft +'%');
            timeleft -= 1;
            if (timeleft===0)
            {
                window.location="<?php echo url ?>"
            }
        }, 25);

    }


    $("#search_phone").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (result) {
                var response = JSON.parse(result);
                if (response.error) {
                    $('.status_register_hone').html(`
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                   رقم الهاتف غير مسجل مسبقا يرجى تسجيل حساب .
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                    `)

                } else if (response.done) {

                    infoUrl="<?php  echo url ?>/customers/qr/"+response.done['done'];
                    var qrcode = new QRCode("qrcode");
                    qrcode.makeCode(infoUrl);

                    $('span.name_customer').text(response.done['first_name']);
                    $('#exampleModal_hello_customer').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                } else {
                    $('.status_register_hone').html(`
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               فشل الارسال.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                        `)
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })

    });


    function validateForm()
    {
        var fields = ["first_name","phone","address","title"];
        var i, l = fields.length;
        var fieldname;
        for (i = 0; i < l; i++) {
            fieldname = fields[i];
            if (document.forms["idFormReg"][fieldname].value === "" || document.forms["idFormReg"][fieldname].value === " " || document.forms["idFormReg"][fieldname].value === "  " || (document.forms["idFormReg"][fields[1]].value).length !==11 ) {
                return false;
            }
        }
        return true;
    }


</script>





<style>


	.register_new
	{
		background: black;

	}
	.register_new .bg_video
	{
		background: black;
		position: absolute;
		height: 100%;
	}

	#exampleModal_hello_customer
	{
		background: #08080899;
	}
	.phone_number_found {
		background: #FFC107;
		font-size: 14px;
		margin-bottom: 2px;
		padding: 3px 7px;
	}

</style>




<div class="modal fade" id="exampleModal_hello_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div style="width: 100%" class="row justify-content-between align-content-center">
					<div class="col-auto">
						<h5 style=" margin-top: 3px;   font-size: 26px;"  class="modal-title" id="exampleModalLabel"> <span>مرحبا</span>  <span class="name_customer"></span> </h5>
					</div>

					<div class="col-auto" style="padding: 0">
						<img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
					</div>
				</div>


			</div>
			<div class="modal-body" id="message_out">
				<div class="test1n">  شكرا لستخدامك شاشة الحقيقة يرجى الاحتفاظ برمز QR الخاص بك ذلك عن طريق اخذ لقطة شاشة واضحة له.    </div>
				<div class="logo_on_qr">
					<div id="qrcode"></div>
					<img class="img_logo_qr" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
				</div>
				<br>
				<div class="progress" style="height: 2px;">
					<div  class="progress-bar progress_inter" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>

			<div class="row justify-content-center">
				<div  class="col-12" style="margin-bottom: 5px;text-align: center"> هل تريد الدخول؟ </div>
				<div class="col-auto">
					<button class="btn btn-primary" onclick="enterSite()">نعم</button>
				</div>
				<div class="col-auto">
					<button class="btn btn-danger" onclick="window.location='<?php  echo url ?>/register/logout'">لا</button>
				</div>
			</div>
			<br>
		</div>
	</div>
</div>





<style>

	.test1n {
		margin-bottom: 6px;
		font-size: 20px;
		color: #28a745;
	}

	.text2n {
		font-size: 15px;
		margin-bottom: 18px;
		line-height: 2;
	}
	.text3n {
		font-size: 15px;
		line-height: 2;
	}
	.text2n a
	{
		border-radius: 13px;
		padding: 0 6px;
		background: #28a745b5;
		color: #fff;
		text-decoration: none !important;
	}

	.text3n a
	{
		border-radius: 13px;
		padding: 0 6px;
		background: #dc3545;
		color: #fff;
		text-decoration: none !important;
	}

	.close_pop_order
	{
		background: white;
		padding: 3px 13px;
		border: 1px solid #cacaca;
		box-shadow: 3px 2px 2px #a6a5a7;
		border-radius: 50px;
	}

	@media (max-width: 540px) {
		.text2n,.text3n {
			font-size:14px;

		}
		.text3n a {
			margin-right: 5px;
		}
	}


	button.btn.btn_send_search {
		background: #c5c5c5;
		border-radius: 0;
		width: 100%;
		color: #283581;
	}

	input.form-control.textbox_search {
		border-radius: 0;
	}
	select.form-control.form-control.dropdownCatg {
		padding: 0px 12px;
		border-radius: 0;
	}

	.categoryAndOffers
	{
		text-align: center;
		background: #c5c5c59e;
		color: #ffffff;
		padding: 8px 4px;
	}

	.bar_category
	{
		background: #283581;
		padding: 6px 0;
	}


	.bar_top
	{
		border-bottom: 1px solid #e3e3e3;
		height: 50px;
		transition: 0.3s;
	}


	.vodiapicker{
		display: none;
	}

	#a{

		margin: 0;
		padding: 0;
	}

	#a img, .btn-select img{
		width: 27px;

	}

	#a li{
		list-style: none;
		padding-top: 5px;
		padding-bottom: 2px;
		text-align: left;
		padding-right: 9px;
		cursor: pointer;
	}

	#a li:hover{
		background-color: #F4F3F3;
	}

	#a li img{
		margin: 5px;
	}

	#a li span, .btn-select li span{
		margin-left: 5px;
	}

	/* item list */

	.b{
		margin-top: -5px;
		display: none;
		width: 91px;
		box-shadow: 0 6px 12px rgba(0,0,0,.175);
		border: 1px solid rgba(0,0,0,.15);
		border-radius: 5px;
		position: absolute;
		background: #ffffff;
		z-index: 150000;
	}

	.open{
		display: show !important;
	}

	.btn-select{
		width: 91px;
		background-color: transparent;
		border: 1px solid transparent;
		margin-top: 6px;
		margin-bottom: 0;

	}
	.btn-select li{
		list-style: none;
		float: left;
		padding-bottom: 0px;
		padding-right: 7px;
	}

	.btn-select:hover li{
		margin-left: 0px;
	}

	.btn-select:hover{
		background-color: #F4F3F3;
		border: 1px solid transparent;
		box-shadow: inset 0 0px 0px 1px #ccc;


	}

	.btn-select:focus{
		outline:none;
	}

	a.nav-link.item_menu {
		color: rgba(0, 0, 0, .9) !important;
	}

	#qrcode img
	{
		display: initial !important;
	}

	.logo_on_qr
	{
		text-align: center;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.logo_on_qr .img_logo_qr
	{
		position: absolute;
		background: white;
		padding-right: 5px;
		width: 75px;
	}

</style>







</body>
</html>

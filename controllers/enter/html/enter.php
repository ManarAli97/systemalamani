<!DOCTYPE html>
<meta property="og:type" content="website"/>
<html dir="<?php echo $this->dirSite ?>">
<head>
	<meta charset="UTF-8">
	<!--    <meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0" />-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="mobile-web-app-capable" content="yes">
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
        /* body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background: #000;
} */
        .glow-on-hover {
    width: 220px;
    height: 50px;
    border: none;
    outline: none;
    /* color: #fff; */
    /* background: #111; */
    /* cursor: pointer; */
    position: relative;
    /* z-index: 0; */
    border-radius: 50%;

}

.glow-on-hover:before {
    content: '';
    background-color: #FFAB38;
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(4px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 1;
    transition: opacity .3s ease-in-out;
    border-radius: 50%;

}

.glow-on-hover:active {
    color: #000
}

/* .glow-on-hover:active:after {
    background: transparent;
} */

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: calc(100% );
    height: calc(100% );
    background: #66109C;
    left: 0px;
    top: 0px;
    border-radius: 50%;
    /* background-image: url(<?php //echo $this->static_file_site; ?>/image/site/testG.gif) ; */
    /* background-image: url('C:\\Users\\Alamani\\Downloads\\Telegram Desktop\\testG.gif') */
    background-position: center;
    background-size: 90%;
    background-repeat: no-repeat;
}

/* @keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
} */


	</style>



</head>
<body   style="overflow-x: hidden;position: relative">

<div class="background_register">

	<div class="video_center_screen">
        <div class="opacity_video">

        <video   class="bg_video" autoplay muted loop id="myVideo">
            <source src="<?php echo $this->static_file_site ?>/image/site/main_screen_2.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>

        </div>
	</div>
<div class="control_from_register">
<div class="container-fluid">
	<div class="row justify-content-end">
		<div class="col-lg-7 col-md-7   col-sm-7    col-7  ">
            <div class="minMneu">
                <div style class="listButton ">
                    <button  onclick=" selectHideQr()" class="btn btnRealScreen glow-on-hover rounded-circle "    ></button>

                </div>

                <div class="listButton">
                    <a  href="<?php  echo url .'/'. $this->folder ?>/home" class="btn btnRealLogin rounded-circle glow-on-hover"   ></a>
                </div>
                <div class="listButton">
                    <button  onclick="openQuestion()"  class="btn btnRealQuestion rounded-circle glow-on-hover"   ></button>
                </div>

                <div class="listButton">

                 <button class="btn btnRealRating rounded-circle glow-on-hover"  onclick="select_qr(1)" data-toggle="modal" data-target="#exampleModal_qr"  ></button>


                </div>
            </div>

            <div class="openQuestionDiv">
                <div class="back_menu">
                <button  onclick="closeOpenQuestion()"  class="btn "  > <span>رجوع</span>  <i class="fa fa-angle-double-left"></i>   </button>
              </div>

                <?php  foreach ($videos as $vd)  {  ?>
                <div class="list_question_video" ><button onclick="openFullscreen(<?php  echo $vd['id'] ?>)"  class="btn"><?php echo $vd['title'] ?></button></div>

                    <video  class="list_videoquest"   id="myvideo_<?php  echo $vd['id'] ?>">
                        <source src="<?php     echo $vd['video']  ?>" type="video/mp4">
                        <source src="rain.ogg" type="video/ogg">
                    </video>

                <?php  } ?>


            </div>

		</div>

	</div>
</div>
</div>

</div>


<form class="rprice" data-full_data="1" method="post" action="<?php echo url .'/'. $this->folder ?>/rprice?login=login&full_data=1">

    <div class="form-row align-items-center">
        <div class="col" style="position: relative">
            <input       autocomplete="off"  inputmode="none"     style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"      name="qr" class="form-control" id="hide_qr_defualt" placeholder="اضغط هنا ثم قم بتوجيه رمز QR الخاص بك نحو الكامرة"  required>
        </div>

    </div>
</form>


<div class="modal  " onclick="select_qr()" id="exampleModal_qr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تسجيل الدخول بستخدام رمز QR   </h5>

            </div>
            <div class="modal-body">
                <div class="iconqr" style="margin-bottom: 18px;text-align: center">
                    <img width="100" src="<?php echo $this->static_file_site ?>/image/site/qr.png">
                </div>

                <form class="rprice"  method="post" action="<?php echo url .'/'. $this->folder ?>/rprice">
                    <div class="error_qr"></div>
                    <div class="form-row align-items-center">
                        <div class="col" style="position: relative">
                            <input type="search"   inputmode="none"    style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"        autocomplete="off"   name="qr" class="form-control" id="qrcodeprice" placeholder="اضغط هنا ثم قم بتوجيه رمز QR الخاص بك نحو الكامرة"  required>
                        </div>

                    </div>
                </form>
                <input   style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"   inputmode="none"   class="form-control" id="qrcodeprice2"    >



            </div>
            <div class="modal-footer text-right d-block">
                اجعل رمز ال QR الخاص بك امام الكامره
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal_smile_delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width: 100%" class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <h5 style=" margin-top: 3px;   font-size: 20px;"  class="modal-title" id="exampleModalLabel">  تقييم  الموظفين  </h5>
                    </div>

                    <div class="col-auto" style="padding: 0">
                        <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                    </div>
                </div>

            </div>
            <div class="modal-body">
                <form id="staff_evaluation" action="<?php  echo url  ?>/staff_evaluation/add" method="post">
                <div class="xsmile">
                    <div class="number_empty_not_found"></div>
                    <div class=" mt-3">
                        <label for="number_empty">رقم الموظف</label>
                        <input type="number" oninput="$('.number_empty_not_found').empty()" placeholder="ادخل رقم الموظف" name="number" id="number_empty" class="form-control"   autocomplete="off" required>
                    </div>
                    <div class=" mt-3">
                        <label for="number_empty">ملاحظة</label>
                        <textarea id="note_empty" placeholder="اترك ملاحظة عن الموظف" name="note"  class="form-control"  ></textarea>
                    </div>
                    <div class="smile">
                        <div class="please_choose_smile"></div>
                        <div class="row justify-content-center" >
                            <div class="col-lg-8 col-md-10 col-sm-12">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <button  type="button"  class="btn smile3 select_smile" onclick="smile_emploay(this,3)"> <i class="fa fa-frown-o"></i>  </button>
                                        <div class="test3smile"> سيء </div>
                                    </div>
                                    <div class="col-auto">
                                        <button  type="button"  class="btn smile2 select_smile" onclick="smile_emploay(this,2)"> <i class="fa fa-meh-o"></i>  </button>
                                        <div class="test2smile"> مقبول </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn smile1 select_smile"    onclick="smile_emploay(this,1)"> <i class="fa fa-smile-o"></i>  </button>
                                        <div class="test1smile"> ممتاز </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="number_smile" id="number_smile">

                    </div>
                </div>
                <div class="msg_smile" >

                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button type="submit"    id="send_msg_smile" name="submit" class="btn btn-success">ارسال</button>

                            </div>
                        </div>

                </div>
                </form>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editInfoUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> لاحظنا هنالك نقص في معلوماتك  </h5>
            </div>
            <div class="modal-body ">
                <form id="editInfoCustomer"  method='post'>
               <div class="formEdit"></div>
                    <hr>
                    <div class="text-center">
                        <button class="btn btn-warning" type="submit" name="submit" >حفظ</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>






    var  vm=null;

    selectHideQr()
    $( document ).ready(function() {
        $('#hide_qr_defualt').select()
        $('.background_register').on("click",function () {
            selectHideQr()
        })


    });

    function selectHideQr()
    {

        $('#hide_qr_defualt').select()
    }

    $('#exampleModal_qr').on('hidden.bs.modal', function (e) {
        setTimeout(function () {
            selectHideQr()
        },100)
    });

    $('#exampleModal_smile_delivery').on('hidden.bs.modal', function (e) {
        setTimeout(function () {
            vm='';
            $.get( "<?php echo url ?>/register/logout", function( data ) {});

            selectHideQr()
        },100)
    });



    $("#staff_evaluation").submit(function(e) {

        var ns=$('#number_smile').val();
        if (ns)
        {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data ==='true')
                    {

                        vm=''

                        $.get( "<?php echo url ?>/register/logout", function( data ) {
                          if (data)
                          {
                              $("#exampleModal_smile_delivery").modal('hide');
                              selectHideQr()
                          }
                        });

                   }else if (data ==='number')
                    {
                        $('.number_empty_not_found').html(`<div class="please_choose_smile">رقم الموظف غير صحيح</div>`)

                    }else {
                        alert('يرجى تسجل الدخول')
                    }
                }
            });
        }else
        {

            $('.please_choose_smile').html(`<div class="please_choose_smile">يرجى اختيار احد الوجوه الظاهرة امامك</div>`)


        }return false;


    });



    function smile_emploay(e,id) {
        $('.please_choose_smile').empty();
        $('.select_smile').removeClass('active_select_smile');
        $('#number_smile').val(id);
        $(e).addClass('active_select_smile');

    }


    //function check_register()
    //{
    //    $.get( "<?php // echo url  ?>///customers/check_register", function( data ) {
    //
    //        if (data ==='true')
    //        {
    //            $('#exampleModal_smile_delivery').modal('show')
    //        }else {
    //            select_qr(1)
    //        }
    //    });
    //}



    function openQuestion() {
        $('.openQuestionDiv').show('show')
        $('.minMneu').hide('show')
    }

    function closeOpenQuestion() {
        $('.openQuestionDiv').hide('show')
        $('.minMneu').show('show')
        $('.list_videoquest').each(function() {
            $(this).get(0).pause();
        });
        selectHideQr()
    }

    $(document).on('keydown', function(e) {
        if (e.key === "Escape")
        {
            $('.list_videoquest').each(function() {
                $(this).get(0).load();
            });
        }

    });



    function openFullscreen(id) {

        $('.list_videoquest').each(function() {
            $(this).get(0).pause();
        });

        var elem = document.getElementById("myvideo_"+id)

        endVideo(id)
        elem.play()

        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
    }


       function endVideo(id) {
           $('#myvideo_'+id).on('ended', function () {
               closeFullscreen(id)
           });
       }


    function closeFullscreen(id) {
        var elem = document.getElementById("myvideo_"+id)
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





    function select_qr(v=null)
    {
        $(".error_qr").empty();
        if (v)
        {
            vm=v

        }else
        {
            vm=''
        }

        $("#qrcodeprice").val('');
        $(document).ready(function() {
            $("#qrcodeprice").select();
        });

    }

    function select_qr2()
    {

        $("#qrcodeprice2").val('');
        $(document).ready(function() {
            $("#qrcodeprice2").select();
        });

    }



    $(".rprice").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');


        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+"&submit=submit&screen="+localStorage.getItem("screen_user"), // serializes the form's elements.
            success: function(data)
            {

                if (data==='rqr')
                {
                    if (vm) {
                        select_qr(1)
                    }else
                    {
                        select_qr()

                    }
                    $(".error_qr").text('رمز QR الخاص بك غير صحيح!');
                } else
                {
                    select_qr2()

                    if (vm)
                    {

                        $('#number_empty').val('')
                        $('#note_empty').val('')
                        $('.select_smile').removeClass('active_select_smile')


                        $("#exampleModal_qr").modal('hide');
                        $("#exampleModal_smile_delivery").modal('show');

                    }else
                    {
                        res=JSON.parse(data)

                        if (res.full_data === '1')
                        {


                             localStorage.setItem("counter", 0);
                             localStorage.setItem("uuid", res.uid);
                             $(".error_qr").html("<span style='color: green'>جاري تسجيل الدخول ...</span>");
                             window.location="<?php echo url ?>"
                        }else
                        {
                           var col=res.col;
                            $('#editInfoUser').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            var html='';
                            $('#editInfoCustomer').attr('action',`<?php echo url . '/' . $this->folder ?>/edit?uid=${res.uid}&id=${res.id}&id_user_screen=${localStorage.getItem('screen_user_id')}`)
                           for (var key in col)
                           {

                               if (key==='city')
                               {
                                 html+=`
                                           <div class="form-group">
                                          <label style="font-size: 20px" for="city">المحافظة</label>
                                            <select name="city"  id="city" class="custom-select" required>
                                                <option value="" disabled="disabled" hidden="">حدد المحافظة</option>
                                                <option value="أربيل">أربيل</option>
                                                <option value="الأنبار">الأنبار</option>
                                                <option value="بابل">بابل</option>
                                                <option value="بغداد">بغداد</option>
                                                <option value="البصرة">البصرة</option>
                                                <option value="دهوك">دهوك</option>
                                                <option value="القادسية">القادسية</option>
                                                <option value="ديالى">ديالى</option>
                                                <option value="ذي قار">ذي قار</option>
                                                <option value="السليمانية">السليمانية</option>
                                                <option value="صلاح الدين">صلاح الدين</option>
                                                <option value="كركوك">كركوك</option>
                                                <option selected value="كربلاء المقدسة">كربلاء المقدسة</option>
                                                <option value="المثنى">المثنى</option>
                                                <option value="ميسان">ميسان</option>
                                                <option value="النجف الأشرف">النجف الأشرف</option>
                                                <option value="نينوى">نينوى</option>
                                                <option value="واسط">واسط</option>
                                            </select>
                                   </div>
                                 `
                               }else if (key ==='birthday')
                               {
                                   html+=`

                                   <div class="form-group">
                                    <label style="font-size: 20px;margin-button:-55px;"  >   تاريخ الميلاد  </label>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                    <label style="font-size: 20px" for="day">اليـوم</label>

                                                    <select  name="day" id="day" class="brth form-control " required>
                                                        <option value="">اليوم</option>
                                                        <?php   for($i = 1 ; $i <= 31 ;$i++) { ?>
                                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                    <label  for="month">الشهر</label>
                                                    <select  name="month" id="month" class=" form-control " required>
                                                        <option value="">الشهر</option>
                                                        <?php   for($x = 1 ; $x <= 12 ;$x++) { ?>
                                                            <option value="<?php echo $x ?>"><?php echo $x ?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                    <label style="font-size: 20px" for="year">السنة</label>
                                                    <input  autocomplete="off"   type="number" class="form-control xcolalich no_required" name="year"   id="year" max="<?php   echo date('Y', time()) ?>"  min="1920"   placeholder="السنة" required >
                                                </div>
                                            </div>
                                            </div>
                                   `

                               }else if  (key ==='gander')
                               {
                                   html+=`
                                   <div class="form-group">
                                      <label style="    font-size: 21px;margin-left: 22px;"> الجنس </label>
                                     <div class="custom-control custom-radio custom-control-inline">
                                         <input type="radio" id="customRadioInline1" name="gander" value="ذكر" class="custom-control-input" required>
                                        <label  class="custom-control-label" for="customRadioInline1">ذكر</label>
                                    </div>
                                   <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="gander" value="انثى" class="custom-control-input" required>
                                         <label  class="custom-control-label" for="customRadioInline2">انثى</label>
                                    </div>
                                    </div>
                                   `

                               }else
                               {

                               html+=` <div class="form-group">
                            <label for="example_${key}">${col[key]}</label>
                            <input type="text" name="${key}" class="form-control" id="example_${key}"  required>
                             </div>`;
                               }

                           }


                        $('.formEdit').html(html)

                        }

                    }


                }
            }
        });


    });


    $("#editInfoCustomer").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                if (data)
                {
                    localStorage.setItem("counter", 0);
                    localStorage.setItem("uuid", data);
                    window.location="<?php echo url ?>"
                }else
                {
                    alert('حدث خطأ في النظام اعد المحاولة.')
                    window.location=''
                }

            }
        });

    });

</script>


<style>

.please_choose_smile
{
    background: red;
    color: #ffffFF;
    border-radius: 5px;
    margin-top: 11px;
}

    .testsmile
    {
        font-size: 20px;
    }

    .smile
    {
        text-align: center;
    }
    .smile1
    {
        padding: 5px;
        background: transparent;
        font-size: 71px;
        color: #4CAF50 !important;
    }

    .smile2
    {
        padding: 5px;
        background: transparent;
        font-size: 71px;
        color: #FFC107 !important;
    }

    .smile3
    {
        padding: 5px;
        background: transparent;
        font-size: 71px;
        color: #FF5722 !important;
    }

    .select_smile
    {
        outline: none !important;
        box-shadow: none !important;
    }
    .active_select_smile i
    {
        border: 2px solid #009688;
        padding: 5px;
        border-radius: 5px;

    }

    a.btn.btnRegister {
        background: #3a357e;
        color: #fff;
        font-size: 23px;
        width: 100%;
    }
    .error_qr{
        color: red;
        margin-bottom: 5px;
    }

    .list_videoquest
    {
        width: 100%;
        z-index: 150000;
    }




    .list_videoquest::-webkit-media-controls {
        display:none !important;
    }



    .list_videoquest::-moz-range-track {
        display:none !important;
    }




    .back_menu
    {
        text-align: left;
        border-bottom: 1px solid #ffffFF;
        padding: 5px 15px;
        margin-bottom: 10px;
    }


    .back_menu button
    {
        color: #fff;
        font-size: 20px;
        background: #a46dff;
        padding: 2px 15px 4px 15px;
        border-radius: 50px;
    }


    .list_videoquest
    {
        width: 0;
        height: 0;
    }

    .list_question_video .btn
    {
        color: #ffffFF;
        font-size: 20px;
        background: #1e9888;
        width: 100%;

    }

    .listButton{
        text-align: center;
        margin-bottom: 25px;
        margin-top: 10px;
    }
    .listButton:last-child{

        margin-bottom: 10px;
    }

    .btnRealScreen
    {
        width:210px;
        height: 210px;
        background: #66109C;
        /* position : absolute; */
        background-image: url(<?php  echo $this->static_file_site ?>/image/site/RealScreen.gif) ;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;

    }
    .btnRealLogin
    {
        width:210px;
        height: 210px;
        background: #66109C;
        /* position : absolute; */
        background-image: url(<?php echo $this->static_file_site ?>/image/site/RealLogin.gif) ;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;

    }


    .btnRealQuestion
    {
        width:210px;
        height: 210px;
        background-color: #ffffff54;
        background-image: url(<?php echo $this->static_file_site ?>/image/site/RealQuestion.gif);
        background-size: 100% 100%;
    }

    .btnRealRating
    {
        width:210px;
        height: 210px;
        background: #66109C;
        /* position : absolute; */
        background-image: url(<?php echo $this->static_file_site ?>/image/site/RealRating.gif) ;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;

    }




    .text_after_video
    {
        font-size: 20px;
    }

    .control_slider_regiser {
        margin-top: 30px;
    }

     .btn.next_slider {
        background: #00abda;
        margin-top: 32px;
        border-radius: 36px;
        padding: 8px 23px;
        font-size: 25px;
        color: #fff;
        margin-right: 43px;
    }
     .btn.back_layer {
        background: #dc3545;
        margin-top: 23px;
        border-radius: 36px;
        padding: 8px 23px;
        font-size: 22px;
        color: #fff;

    }
    .btn.next_layer {
        background: #00abda;
        margin-top: 23px;
        border-radius: 36px;
        padding: 8px 23px;
        font-size: 22px;
        color: #fff;

    }
    .text_start
    {
        color: #ffffff;
        line-height: 1.7;
        font-family: Arial;
    }


    .real_screen {
        font-size: 55px;
        background: #CF2B8E;
        background: -webkit-linear-gradient(to left, #CF2B8E 0%, #FCB528 67%);
        background: -moz-linear-gradient(to left, #CF2B8E 0%, #FCB528 67%);
        background: linear-gradient(to left, #fb5695 0%, #fff258 67%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
    }

    .minMneu {

        /*height: 385px;*/
        width: 100%;
        overflow: auto;
    }

    .openQuestionDiv
    {

        /*height: 385px;*/
        width: 100%;
        overflow: auto;
        display: none;

    }

	.background_register
	{

		border: 1px solid;
		height: 100%;
		position: fixed;
		width: 100%;
		background: black;


	}

	.background_register .video_center_screen
	{

        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #000000;
        height: 100%;
        /*background-image: url(*/<?php //echo $this->static_file_site ?>/*/image/site/bg-new.gif);*/
        background-repeat: no-repeat;
        background-position: right;
        background-size: cover;

    }

    .opacity_video
    {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
        background: #00000038;
        opacity: 1;

    }

	.background_register .video_center_screen .bg_video
	{
        width: 100%;
        z-index: 11;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
	}
.control_from_register
{

	position: absolute;
	top: 0;
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
    z-index: 1111;
    color: #ffffff;
}



</style>




<style>






    .search_phone .text_phone {
        font-size: 23px;
        margin-top: 53px;
    }


    input#search_phone {
        height: 50px;
        font-size: 20px;
    }

    button#btn_search_phone {
        background: #ffc107;
        color: #ffff;
        padding: 0 26px;
        height: 50px;
        border: 0;
        font-size: 26px;
        border-radius: 10px 0 0 10px;
    }

    .field_form input,
    .field_form textarea,
    .field_form select
    {
        height: 50px;
        font-size: 20px;
    }

    .xphonea
    {
        border: 1px solid red !important;
        box-shadow: 0 0 0 0.2rem rgba(167, 76, 40, 0.25) !important;

    }

.btn_control_ly3
{
    margin-top: 0;
}
.btn_control_ly4
{
    margin-top: 0;
}

     .xmarg
    {
      margin-bottom: 0;
    }

    .text_register {
        font-size: 30px;
        margin-bottom: 12px;
    }

    .setForAnswer {
        margin-bottom: 5px;
        border: 1px solid #bdbdbd;
        padding: 5px 34px 3px 0;
        border-radius: 19px;
    }

    .setForAnswer label {
        color: #ffffff !important;
    }

    .about_company_style
    {
        color: #ffffff !important;
        font-size: 20px;

    }

    .about_company_style::before {
        right: -2.5rem;
        display: block;
        width: 25px;
        height: 25px;
    }

    .about_company_style::after {
        right: -40px;
        width: 25px;
        height: 25px;
    }

    .yes_or_no
    {
        margin: 0 25px;
    }
    .test1n {
        margin-bottom: 6px;
        font-size: 20px;
        color: #28a745;
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
    .phone_number_found {
        background: #FFC107;
        font-size: 14px;
        margin-bottom: 2px;
        padding: 3px 7px;
    }


    .video_view
    {
        width: 100%;
        z-index: 150000;
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

    .carousel-item {

        transition: -webkit-transform .3s ease-in-out;
        transition: transform .3s ease-in-out;
        transition: transform .3s ease-in-out, -webkit-transform .3s ease-in-out;
    }

</style>

<button type="button" onclick="select_qr_user()" class=" qr_user" data-toggle="modal" data-target="#exampleModal_qr_user">

</button>

<div class="modal  " onclick="select_qr_user()" id="exampleModal_qr_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="iconqr" style="margin-bottom: 18px;text-align: center">
                    <img width="100" src="<?php echo $this->static_file_site ?>/image/site/qr.png">
                </div>

                <form class="rq_user"  method="post" action="<?php echo url .'/'. $this->folder ?>/rq_user">
                    <div class="error_qr_user"></div>
                    <div class="form-row align-items-center">
                        <div class="col" style="position: relative">
                            <input type="search"          style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"      autocomplete="off"   name="qr" class="form-control" id="qrcodeprice_user" placeholder="اضغط هنا ثم قم بتوجيه رمز QR الخاص بك نحو الكامرة"  required>
                        </div>

                    </div>
                </form>
                <input  style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"  class="form-control" id="qrcodeprice2_user"    >



            </div>
            <div class="modal-footer text-right d-block">
                اجعل رمز ال QR الخاص بك امام الكامره
            </div>
        </div>
    </div>
</div>

<script>


    $('#exampleModal_qr_user').on('hidden.bs.modal', function (e) {
        setTimeout(function () {
            selectHideQr()
        },100)
    });

    function select_qr_user()
    {
        $("#qrcodeprice_user").val('');
        $(document).ready(function() {
            $("#qrcodeprice_user").select();
        });

    }

    function select_qr_user2()
    {

        $("#qrcodeprice2_user").val('');
        $(document).ready(function() {
            $("#qrcodeprice2_user").select();
        });

    }


    $(".rq_user").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+"&submit=submit", // serializes the form's elements.
            success: function(data)
            {
                if (data==='rqr')
                {
                    select_qr_user();
                    $(".error_qr_user").text('رمز QR الخاص بك غير صحيح!');
                }
                else
                {
                    select_qr_user2()

                    var response_user=JSON.parse(data);


                    localStorage.setItem("screen_user", response_user.username);
                    localStorage.setItem("screen_user_id", response_user.id);

                    $('#user_screen_fiexd').text(localStorage.getItem("screen_user")).show()
                    $('#exampleModal_qr_user').modal('hide')
                    selectHideQr()

                }
            }
        });


    });
    localStorage.removeItem('confirmation_order');

</script>

<style>

    .qr_user
    {
        border: 0;
        border-radius: 0;
        position: fixed;
        bottom: 0;
        z-index: 15000;
        width: 100px;
        height: 100px;
        background: #0e0e0e29;
        outline: unset !important;
        box-shadow: unset !important;
    }

    .error_qr_user
    {
        color: red;
    }

</style>

<a class="btn user_screen_fiexd" id="user_screen_fiexd"></a>

<style>

    a#user_screen_fiexd {
        position: fixed;
        bottom: 0;
        left: 0;
        background: #2a292a;
        border-radius: 0;
        padding: 1px 12px;
        color: #fff;
        display: none;
    }

    .underSetting {
        bottom: 34px;
    }

</style>

<script>


    if ( localStorage.getItem("screen_user"))
    {
        $('#user_screen_fiexd').text(localStorage.getItem("screen_user")).show()
    }

</script>


</body>
</html>

<?php  $this->publicHeader($this->langSite('resetpassword'));  ?>


    <div class="container">
    <div class="row">
    <div class="col-lg-3">

        <?php $this->menu->menu() ?>




    </div>

    <div class="col-lg-9">


    <br>


    <nav aria-label="breadcrumb" class="path_bread">
        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>

             <li class="breadcrumb-item   active "  aria-current="page" >  ضبط كلمة مرور جديدة  </li>


        </ol>
    </nav>



            <div class="row">

                <div class="col">


                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active title_tab" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">

                                التحقق من رقم الهاتف
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade checkedPhone show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                            <br>
                            <div class="resultPhone"></div>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <label   for="number"> ادخل الرقم الذي أنشات بة الحساب </label>
                                    <div class="input-group mb-2">
                                        <input type="text" id="number"  class="form-control"   placeholder="رقم الهاتف:07xxxxxxxxx">

                                    </div>
                                </div>

                                <div class="col-12">
                                    <br>
                                    <div id="recaptcha-container"></div>
                                </div>


                                <div class="col-12">
                                    <br>
                                    <button type="button" class="btn send_code_sms" onclick="phoneAuth();"> ارسال رمز التحقق  </button>
                                </div>

                            </div>

                            <br>

                            <div class="code_her_sms">


                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <label for="verificationCode" class="sr-only"> ادخل الرمز</label>
                                        <input type="text" id="verificationCode" class="form-control"  placeholder="ادخل الرمز المكون من 6 ارقام">
                                    </div>

                                    <div class="col-auto">
                                        <button type="button"  class="btn check_code_sms" onclick="codeverify();">  تحقق من الرمز </button>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="tab-pane fade resetP  " id="profile" role="tabpanel" aria-labelledby="profile-tab">


                             <div class="change_pass_result"></div>
                            <form id="reset_pass" action="<?php  echo url .'/'.$this->folder?>/reset_password" method="post">


                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                    <label for="exampleInputPassword1">كلمة السر الجديدة </label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة السر الجديدة" required>
                                    <br>

                                </div>
                                </div>

                                <div class="row">
                                    <div class="col-auto">
                                        <button type="submit" value="submit"  class="btn  btn-success save_password"> حفظ  </button>
                                    </div>
                                </div>


                            </form>


                        </div>

                    </div>



                    <script>


                        $("#reset_pass").submit(function(e) {

                            e.preventDefault();

                            var form = $(this);
                            var url = form.attr('action');

                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form.serialize() + '&submit=submit',
                                success: function (data) {

                                    if (data==='true')
                                    {
                                        $('.change_pass_result').html(`

                                                                        <div class="alert alert-success" role="alert">
                                                                       تم تغير كلمة المرور بنجاح . جاري تسجيل الدخول ....
                                                                        </div>
                                                            `);

                                        setTimeout(function () {
                                            window.location='<?php  echo url ?>';
                                        },3000)


                                    }else {

                                        $('.change_pass_result').html(`

                                                                        <div class="alert alert-warning" role="alert">
                                                                     حدث خطا يرجى المحاولة لاحقا .
                                                                        </div>
                                                            `)

                                    }

                                }

                            })
                        });


                    </script>






                    <!-- The core Firebase JS SDK is always required and must be listed first -->
                    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

                    <!-- TODO: Add SDKs for Firebase products that you want to use
                         https://firebase.google.com/docs/web/setup#config-web-app -->

                    <script>
                        // Your web app's Firebase configuration
                        var firebaseConfig = {
                            apiKey: "AIzaSyChkeEjNEbhze-i6DSLTglq6khJO4ZiELE",
                            authDomain: "alamani-co.firebaseapp.com",
                            databaseURL: "https://alamani-co.firebaseio.com",
                            projectId: "alamani-co",
                            storageBucket: "alamani-co.appspot.com",
                            messagingSenderId: "225203969248",
                            appId: "1:225203969248:web:5bc37cf59655e8fdb1c485",
                        };
                        // Initialize Firebase
                        firebase.initializeApp(firebaseConfig);


                    </script>


                    <script src="<?php echo $this->static_file_site ?>/js/NumberAuthentication.js" type="text/javascript"></script>




                </div>

            </div>


    </div>


    </div>
    </div>




<br>
<br>

<style>
    .code_her_sms
    {
        display: none;
    }

    div#myTabContent {
        border: 1px solid #e9ecef;
        border-top: 0;
        padding: 14px 22px;
        background: #e9ecef;
    }

    .send_code_sms
    {
        border: 2px solid #17a2b8;
        margin-bottom: 15px;
        background: #17a2b8;
        color: #ffff;
        border-radius: 5px;
    }

    .check_code_sms
    {
        border: 2px solid #495678;
        margin-bottom: 15px;
        background: #495678;
        color: #ffff;
        border-radius: 5px;
    }
    .save_password
    {
        border: 2px solid #495678;
        margin-bottom: 15px;
        background: #495678;
        color: #ffff;
        border-radius: 5px;
    }
    .title_tab
    {
        background-color: #e9ecef !important;
        border: 0 !important;
    }


    .code_her_sms
    {
        border-top: 1px solid #cecfd0;
        margin-top: 15px;
        padding-top: 15px;
    }
    .code_her_sms input
    {
        margin-bottom: 21px;
    }

</style>
<?php $this->publicFooter(); ?>
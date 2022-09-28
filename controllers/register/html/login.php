<?php  $this->publicHeader($this->langSite('login'));  ?>
<br>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <div class="box_login"  >
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="exampleModalLongTitle" style="color: black"> تسجيل دخول  </div>

                    </div>
                    <div class="modal-body">
                        <div class="result">

                        </div>
                        <form  class="loginform_pg"  method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1">رقم الهاتف</label>
                                <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">كلمة المرور</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <button type="submit"  class="btn btn-primary">تسجيل دخول</button>

                                </div>
                            </div>

                            <hr>
                            <div class="row ">
                                <div class="col-auto" style="margin-bottom: 15px">
                                    <a  href="<?php echo url ?>/register/register_user"  >  أنشاء حساب </a>
                                </div>
                                <div class="col-auto facebook_logo_btn">
                                    <fb:login-button  scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button loginFacebook" data-width="" data-size="medium" data-button-type="login_with" data-auto-logout-link="false"    >
                                    </fb:login-button>
                                </div>

                                <div class="col-12" style="text-align: left">
                                    <hr>
                                    <a  href="<?php echo url ?>/register/resetpassword"  >  هل نسيت كلمة المرور ؟ </a>
                                </div>
                            </div>



                        </form>


                    </div>

                </div>
            </div>

        </div>
    </div>

</div>


    <script>
        $(document).ready(function() {
            $('.loginform_pg').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '<?php echo url ?>/register/login',
                    data: $(this).serialize(),
                    success: function(data)
                    {
                        if (data === 'login') {
                            $('.result').html(
                                `
                                                                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                      <strong>   جاري الدخول ..... </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                            );
                            setTimeout(function(){   window.location = '<?php  echo url ?>'; }, 2000);

                        }
                        else if (data === 'not_login')
                        {

                            $('.result').html(
                                `
                                                                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                      <strong>  معلومات الدخول خطا يرجى المحاولة مرة اخرى. </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                            );

                        }else {
                            $('.result').html(
                                `
                                                                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                      <strong> بعض الحقول فارغة . </strong>
                                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                   `
                            );
                        }
                    }
                });
            });
        });
    </script>


<br>
<br>
<br>

<style>
    .Or_sig

    {
        text-align: center;
        padding: 7px 0;
    }

</style>

<?php $this->publicFooter(); ?>
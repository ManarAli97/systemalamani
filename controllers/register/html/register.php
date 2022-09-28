<?php  $this->publicHeader($this->langSite('register'));  ?>

<br>

<div class="container">
    <nav aria-label="breadcrumb" class="path_bread">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>
            <li class="breadcrumb-item active" aria-current="page">تسجيل  </li>
        </ol>
    </nav>
</div>


<br>




<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 col-sm-12">

    <ul class="nav nav-tabs align-items-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> تسجل من خلال الموقع  </a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
<br>

                    <?php if (!empty($this->success_form)) {   ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>  نجح الارسال </strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <script>
                            setTimeout(function(){
                                window.location='<?php  echo url ?>'
                            }, 3000);

                        </script>

                    <?php  }  ?>

                    <form action="<?php echo url .'/'.$this->folder ?>/register_user" method="post">



                        <fieldset class="fieldset_login">
                            <legend> معلومات تسجيل الدخول  </legend>


                            <div class="form-group row align-items-center">
                                <label for="input-phone" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('phone') ?></span>  <span style="color: red;font-size: 14px;" id="phone"></span>  <span class="star_red"> * </span> </label>
                                <div class="col-sm-9">

                                    <div id="length_phone"></div>
                                    <div class="input-group mb-2">

                                        <input type="text" name="phone"  value="<?php echo $data['phone'] ?>"  class="form-control" id="input-phone" placeholder="<?php echo $this->langSite('phone') ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-password" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('password') ?></span>  <span style="color: red;font-size: 14px;" id="password"></span>  <span class="star_red"> * </span> </label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control" id="input-password" placeholder="<?php echo $this->langSite('password') ?>">
                                </div>
                            </div>

                        </fieldset>

 <br>

                        <div class="form-group row">
                            <label for="input-name" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('full_name') ?></span> <span style="color: red;font-size: 14px;" id="name"></span>  <span class="star_red"> * </span> </label>
                            <div class="col-sm-9">
                                <input type="text"   value="<?php echo $data['name'] ?>"    name="name" class="form-control" id="input-name" placeholder="<?php echo $this->langSite('full_name') ?>">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-email" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('email') ?></span>  <span>  ( اختياري ) </span>    </label>
                            <div class="col-sm-9">
                                <input type="email"  value="<?php echo $data['email'] ?>"     name="email" class="form-control" id="input-email" placeholder="<?php echo $this->langSite('email') ?>">
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input-city" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('city') ?></span>  <span style="color: red;font-size: 14px;" id="city"></span>  <span class="star_red"> * </span>  </label>
                            <div class="col-sm-9">
                                <select name="city"  id="input-country" class="custom-select">
                                    <?php  foreach ($city as $cy)  { ?>
                                        <option value="<?php  echo $cy ?>"  <?php  if ($data['city'] == $cy )  echo 'selected' ?> > <?php  echo $cy ?></option>
                                    <?php  }  ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-address" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('address') ?></span>  <span style="color: red;font-size: 14px;" id="address"></span>  <span class="star_red"> * </span> </label>
                            <div class="col-sm-9">
                                <input type="text"  value="<?php echo $data['address'] ?>"    name="address" class="form-control" id="input-address" placeholder="<?php echo $this->langSite('address') ?>">
                            </div>
                        </div>


                        <div class="form-group row align-items-center">
                            <label for="input-wholesale_price" class="col-sm-3 col-form-label"><span>  نوع الحساب </span>  <span style="color: red;font-size: 14px;" id="wholesale_price"></span>  <span class="star_red"> * </span> </label>
                            <div class="col-sm-9">

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio"  id="customRadioInline1" name="wholesale_price" value="0" checked class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1"> حساب عادي  </label>
                                </div>
<!--                                <div class="custom-control custom-radio custom-control-inline">-->
<!--                                    <input type="radio" id="customRadioInline2" name="wholesale_price" value="1" class="custom-control-input">-->
<!--                                    <label class="custom-control-label" for="customRadioInline2">  حساب جملة  </label>-->
<!--                                </div>-->

                                <div class="note_wholesale_price_account">
                                    يخضع حساب الجملة الى ضوابط تحدد من قبل شركة.
                                </div>
                            </div>
                        </div>



                        <hr>

                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <input type="submit" class="btn btn-primary" name="submit" value="انشاء حساب ">
                            </div>
                        </div>

                        <div class="Or_sig">
                            او
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-auto facebook_logo_btn">
                                <fb:login-button  scope="public_profile,email" onlogin="checkLoginState();" class="fb-login-button loginFacebook" data-width="" data-size="medium" data-button-type="login_with" data-auto-logout-link="false"    >
                                </fb:login-button>
                            </div>

                        </div>



                    </form>



        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>

    </div>
        </div>
    </div>

</div>




<br>
<br>

<script>


    $('input[name="wholesale_price"]').change(function() {
        val= $('input[name="wholesale_price"]:checked').val();
        if (val==='0')
        {
            $('.note_wholesale_price_account').hide('fast');

        }else
        {
            $('.note_wholesale_price_account').show('fast');

        }

    });

</script>


<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {

                $('#'+prop).html('&nbsp;&nbsp;'+error[prop] );

                $("*[name='"+prop+"']").addClass('error_border_red');

                if (prop==='phone')
                {
                    $('#length_phone').html(error[prop]);
                }
        }


    </script>

<?php  } ?>
<style>

    .note_wholesale_price_account
    {
        border: 1px solid #c9c9c9;
        margin-top: 11px;
        padding: 8px 7px;
        background: #283581;
        color: #ffff;
        display: none;
    }

    #length_phone{
       color: red;
    }

    .error_border_red
    {
        border: 1px solid red !important;
        box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
    }

    .error_pop
    {
        display: block !important;
    }


    .star_red
    {
        color: red;
    }
.Or_sig

{
    text-align: center;
    padding: 7px 0;
}


    #myTabContent{
        border: 1px solid #dee2e6;
        border-top: 0;
        padding: 8px;
    }
</style>








<style>
     .facebook_logo_btn {
        padding: 0 6px 0 0;
    }
</style>




<?php $this->publicFooter(); ?>
<?php  $this->publicHeader($this->langSite('inbox'));  ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">

                <br>


                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item">   <?php echo  $this->langSite('inbox')  ?> </li>

                    </ol>
                </nav>



                <form  id="contactQ" action="<?php echo url ?>/contact/form" method="post">
                    <div class="row">

                        <div class="col-12 x_margin">

                            <label class="label_c" for="validationTextarea-message">   <span  class="reqc"  id="message" style="color: red">  </span>  </label>
                            <div class="resultContact"></div>
                            <div class="input-group  ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"> <i class="fa fa-envelope-o"></i> </div>
                                </div>
                                <textarea rows="8" name="message"   class="form-control ept" id="validationTextarea-message" placeholder=" اكتب الشكوى او المقترح هنا "  ></textarea>
                            </div>
                        </div>

                        <div class="col-12 button_send">
                            <br>
                            <button type="submit" class="btn    allStyleBtn" name="submit"><span><?php  echo $this->langSite('send')?></span>  <i class="fa fa-send"></i> </button>
                        </div>
                    </div>
                </form>

                <script>
                    $(function () {

                        $('#contactQ').on('submit', function (e) {

                            e.preventDefault();

                            $.ajax({
                                type: 'post',
                                url: '<?php echo url ?>/contact/form',
                                data: $('#contactQ').serialize()+'&submit=submit' ,
                                success: function (result) {
                                    console.log(result)
                                    console.log(result)
                                    var response = JSON.parse(result);
                                    if(response.error) {
                                        for (var prop in response.error) {
                                            $('#'+prop).html('مطلوب');
                                            $('*[name="'+prop+'"]').addClass('is-invalid');
                                        }

                                    }

                                    else if (response.done)
                                    {
                                        $('.resultContact').html(`

                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                             تم ارسال رسالتكم بنجاح شكرا لتواصلكم معنا .
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                        `);


                                        $('.reqc').empty();
                                        $('.ept').val('');
                                        $('.ept').removeClass('is-invalid');

                                        setTimeout(function () {
                                            $('.conModel').modal('hide')
                                        },2000)
                                    } else if (response.login)
                                    {
                                       alert('يرجى تسجيل الدخول')
                                    }
                                    else
                                    {
                                        $('.resultContact').html(`
                                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               فشل الارسال.
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>

                                        `)

                                    }
                                }
                            });

                        });

                    });
                </script>


            </div>
        </div>
    </div>


    <br>
    <br>

<style>

    .button_send
    {
        text-align: center;
    }
    .button_send .allStyleBtn
    {
        background: #283581;
        color: #ffff;
        border-radius: 0;
    }
</style>


<?php $this->publicFooter(); ?>
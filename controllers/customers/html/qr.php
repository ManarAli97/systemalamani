<?php  $this->publicHeader('تأكيد الطلب بستخدام QR');  ?>
    <style>
        .register_new,
        .modal-backdrop.show
        {
            display: none !important;
        }
        .modal-open
        {
            overflow: auto !important;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">

                <?php    $this->menu->menu() ?>



            </div>









            <div class="col-lg-9">


                <br>


                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>
                        <li class="breadcrumb-item   active "  aria-current="page" >  تأكيد الطلب بستخدام رمز QR  </li>
                        <?php if (!empty($result)) {   ?>
                        <li class="breadcrumb-item   active "  aria-current="page" > <?php echo $result['name'] ?></li>
                        <?php  }  ?>

                    </ol>
                </nav>


        <?php if (!empty($result)) {   ?>


            <?php  if (isset($_SESSION['direct'])) { ?>

                <?php  if ($_SESSION['direct']==1) { ?>

                    <div class="alert alert-success" role="alert">

                        <p>   تم تأكيد الطلب بنجاح عبر استخدام رمز QR  </p>
                        <p>   تم تحويل الطلب الى المحاسب يرجى ارشاد الزبون الى الكاشير للمحاسبة </p>
                        <hr>
                        <div style="text-align: center">
                        <a class="btn btn-primary" href="<?php  echo  url ?>">موافق</a>
                         </div>
                    </div>

                    <?php  } elseif ($_SESSION['direct']==2) {  ?>

                    <div class="alert alert-success" role="alert">

                        <p>   تم تأكيد الطلب بنجاح عبر استخدام رمز QR  </p>
                        <p>   تم تحويل الطلب الى المحاسب يرجى ارشاد الزبون الى الكاشير للمحاسبة ثم تسليم الطلب الية </p>
                        <p>   يرجى الضغط على مواقف لتجهز الطلب بعد المحاسبة </p>
                        <hr>
                        <div style="text-align: center">
                            <a class="btn btn-primary" href="<?php echo  url ?>/direct">موافق</a>
                        </div>
                    </div>

                         <?php  }elseif ($_SESSION['direct']==3) {   ?>


                        <div class="alert alert-success" role="alert">

                            <p>   تم تأكيد الطلب بنجاح عبر استخدام رمز QR  </p>
                            <p>   يرجى الضغط على موافق للمحاسبة </p>
                            <hr>
                            <div style="text-align: center">
                                <a class="btn btn-primary" href="<?php echo  url ?>/direct/direct3">موافق</a>
                            </div>
                        </div>

                        <?php  }else { ?>
                      <div class="alert alert-danger" role="alert">
                          <span>  يرجى تسجيل الدخول </span> <a href="<?php  echo url ?>/home">نسجيل الدخول</a>
                        </div>

                      <?php  } ?>

                 <?php  } else {  ?>

                <div class="alert alert-danger" role="alert">
                    <span>  يرجى تسجيل الدخول </span> <a href="<?php  echo url ?>/home">نسجيل الدخول</a>
                </div>

            <?php  }  ?>


        <?php  } else {  ?>

            <div class="alert alert-danger" role="alert">
                رمز ال QR غير صحيح
            </div>

        <?php  }  ?>

        </div>

    </div>
    </div>


<?php  $this->publicFooter();  ?>
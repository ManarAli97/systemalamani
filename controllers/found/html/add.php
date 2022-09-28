




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

                    <li class="breadcrumb-item">   اطلب مالم تجده </li>

                </ol>
            </nav>

            <div class="row">
                <div class="col">

                    <?php   if ($sendProd) { ?>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            تم ارسال  الطلب
                            <a type="button" href="<?php  echo url ?>" class="close"  >
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>

                    <?php   }  ?>



                    <form action="<?php echo url.'/'.$this->folder ?>/add" method="post" enctype="multipart/form-data">

                        <div class="box_notFound">


                                <div class="row">

                                    <div class="col-12">
                                        <label for="validationServer02"> رقم الهاتف  </label>
                                        <input  autocomplete="off"  name="title" type="text" class="form-control" id="validationServer02" >
                                        <br>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationServer03"> اكتب بالتفصيل ما تتمنى ان نوفره لك</label>
                                        <textarea    name="content" type="text" class="form-control" id="validationServer03" ></textarea>
                                        <br>
                                    </div>

                                    <div class="col-12">
                                         <label for="gallery-photo-add">    <span> ملاحظة / ان كان لديك فيديو او صورة او صوت تريد ارساله لنا تواصل عبر الواتساب مع الرقم 07722082209 .او عن طريق مسح الرمز<img style="width: 40px;" src="<?php echo  url."\\public\\ar\image\\site\\foundContactQR.jpg" ?>" alt="Card image cap"></span>  </label>
                                        <br>
                                        <input   name="image[]" type="file"   id="gallery-photo-add"   multiple />
                                    </div>

                                    <div class="col-12">
                                        <div class="gallery"></div>
                                    </div>

                                </div>


                           </div>


                        <hr>

                        <div class="container">
                            <div class="row justify-content-md-center ">
                                <div class="col-md-auto">
                                    <input  class="btn btn-primary"  value="ارسال"  type="submit" name="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                .sp_price
                {
                    display: none;
                }

            </style>
            <script>

                $(function() {
                    // Multiple images preview in browser
                    var imagesPreview = function(input, placeToInsertImagePreview) {

                        if (input.files) {
                            var filesAmount = input.files.length;

                            for (i = 0; i < filesAmount; i++) {
                                var reader = new FileReader();

                                reader.onload = function(event) {
                                    $($.parseHTML('<img style="width: 200px;margin: 20px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                }

                                reader.readAsDataURL(input.files[i]);
                            }
                        }

                    };

                    $('#gallery-photo-add').on('change', function() {
                        $('.gallery').empty();
                        imagesPreview(this, 'div.gallery');
                    });
                });



            </script>



            <style>

                .x_down div
                {
                    margin-bottom: 30px;
                }
                .code_m
                {
                    margin-top: 15px;
                }
                button.btn.add_new_sub_row {
                    padding: 0;
                    background: transparent;
                    color: #218838;
                    font-size: 25px;
                }
                button.btn.remove_sub_row {
                    padding: 0;
                    background: transparent;
                    color: red;
                    font-size: 25px;
                }

                .remove_div
                {
                    position: absolute;
                    left: 13px;
                    padding: 0;
                    top: -14px;
                    background: #f5f6f7;
                    border: 0;
                }

                .remove_div i
                {
                    color: red;
                    font-size: 28px;
                }
                .addPs
                {
                    color: #FFFFFF !important;
                }
                .x_down
                {
                    position: relative;
                    margin-bottom: 25px;
                    border: 1px solid #eeeff0;
                    border-bottom: 1px solid #d5d7d8;
                    padding-bottom: 22px;
                    background: #eeeff08a;
                }
            </style>



            <br>
            <br>




            <style>
                .note-popover .popover-content .dropdown-menu, .card-header.note-toolbar .dropdown-menu
                {

                    left: unset !important;
                }
                .custom-control {
                    position: relative;
                    display: -ms-inline-flexbox;
                    display: inline-flex;
                    min-height: 1.5rem;
                    padding-left: 1.5rem;
                    margin-right: 1rem;
                }
                .box_notFound
                {
                    background: white;
                    padding: 16px 11px;
                    border: 2px solid #d6d6d6;
                    border-radius: 5px;
                }
            </style>





            <?php if(!empty($this->error_form ))  { ?>
                <script>  $(document).ready(function() { $("#exampleModal").modal("show")  }); </script>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">خطأ</h5>

                            </div>
                            <div class="modal-body">
                                <?php $i=1; foreach($this->error_form as $key => $error)  { ?>

                                    <p> <span> <?php  echo $i;  ?> . </span> <?php  echo   $error ?> </p>

                                    <?php  $i++; } ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> اغلاق </button>

                            </div>
                        </div>
                    </div>
                </div>

            <?php  } ?>

    </div>
</div>
</div>

<br>
<br>



<?php $this->publicFooter(); ?>





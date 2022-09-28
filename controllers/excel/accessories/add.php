
<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/add_accessories"> رفع ملف اكسل الالكسسوارات </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

مثال على ملف الاكسل :

<table border="1" style="text-align: center">
    <thead>
    <tr>
        <th>الحقل الاول</th>
        <th>الحقل الثاني</th>
        <th>الحقل الثالث</th>
        <th>الحقل الرابع</th>
        <th>الحقل الخامس</th>
        <th>الحقل السادس</th>
        <th>الحقل السابع</th>
        <th>الحقل الثامن</th>


    </tr>
    </thead>
    <tbody>
    <tr>
        <td>الكود</td>
        <td>الكمية</td>
        <td>السعر بالدولار</td>
        <td>السعر بالدينار</td>
        <td>  رينج السعر الاقل </td>
        <td>  رينج الاسعار الاعلى </td>
        <td>   لون المادة </td>
        <td>  رقم الفاتورة  </td>

    </tr>

    </tbody>
</table>


<hr>




<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
		<?php  if ($this->permit('delete_and_replace',$this->folder)) {  ?>
            <a class="nav-item nav-link active title_normal" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">  رفع اعتيادي (حذف وستبدال) </a>
		<?php  } ?>
        <a class="nav-item nav-link title_cumulative <?php  if (!$this->permit('delete_and_replace',$this->folder)) echo 'active' ?>   " id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">  رفع تراكمي   </a>

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
	<?php  if ($this->permit('delete_and_replace',$this->folder)) {  ?>
    <div class="tab-pane fade show active normal" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


        <br>


        <form    action="<?php echo url.'/'.$this->folder ?>/add_accessories"  method="post" enctype="multipart/form-data">



            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <style>

                        .label_image
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                        .label_files
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                    </style>


                    <span style="color: red;font-size: 14px;" id="files_normal"> </span>
                    <br>

                    <textarea name="files_normal" id="files_data_normal" hidden  class="form-control"></textarea>
                    <label class="label_files" >    رفع ملف الاكسل فقط  </label>
                    <div class="fileupload-wrapper">
                        <div id="myUpload_files_normal">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <hr>

            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-auto">
                        <?php  if ($code_upload) {  ?>
                            <a   href="<?php echo url .'/'.$this->folder?>/code_not_upload/accessories" class="btn  btn-primary"  > لايمكن الرفع , توجد مواد غير مرفوعة </a>
                        <?php } else { ?>
                            <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">

                        <?php }  ?>

                    </div>
                </div>
            </div>


        </form>


        <script>


            $("#myUpload_files_normal").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_normal').val(response);
                        console.log(response)
                    }
                }
            );

            $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls')

        </script>


        <?php if(!empty($this->error_form ))  { ?>
            <script>

                var error=<?php echo $this->error_form ?>;
                for (var prop in error) {
                    $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
                    $("*[name='"+prop+"']").addClass('error_border_red');
                }
            </script>
            <style>
                .error_border_red
                {
                    border: 1px solid red !important;
                    box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
                }
            </style>
        <?php  } ?>




    </div>
    <?php } ?>

    <div class="tab-pane fade  cumulative  <?php  if (!$this->permit('delete_and_replace',$this->folder)) echo 'show active' ?> " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


        <br>


        <form    action="<?php echo url.'/'.$this->folder ?>/accessories_cumulative_upload"  method="post" enctype="multipart/form-data">


            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <style>

                        .label_image
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                        .label_files
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                    </style>


                    <span style="color: red;font-size: 14px;" id="files_accessories_cumulative_upload"> </span>
                    <br>

                    <textarea name="files_accessories_cumulative_upload" id="files_data_mobile_cumulative_upload" hidden  class="form-control"></textarea>
                    <label class="label_files" >    رفع ملف الاكسل فقط  </label>
                    <div class="fileupload-wrapper">
                        <div id="myUpload_files_accessories_cumulative_upload">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <hr>

            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-auto">
                        <?php  if ($code_upload) {  ?>
                            <a   href="<?php echo url .'/'.$this->folder?>/code_not_upload/accessories" class="btn  btn-primary"  > لايمكن الرفع , توجد مواد غير مرفوعة </a>
                        <?php } else { ?>
                            <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">

                        <?php }  ?>
                    </div>
                </div>
            </div>


        </form>


        <script>


            $("#myUpload_files_accessories_cumulative_upload").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_mobile_cumulative_upload').val(response);
                        console.log(response)
                    }
                }
            );

            $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls')

        </script>


        <?php if(!empty($this->error_form2 ))  { ?>
            <script>

                $('.title_cumulative').addClass('active');
                $('.title_normal').removeClass('active');

                $('.cumulative').addClass('show active');
                $('.normal').removeClass('show active');

                var error=<?php echo $this->error_form2 ?>;
                for (var prop in error) {
                    $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
                    $("*[name='"+prop+"']").addClass('error_border_red');
                }
            </script>
            <style>
                .error_border_red
                {
                    border: 1px solid red !important;
                    box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
                }
            </style>
        <?php  } ?>






    </div>

</div>





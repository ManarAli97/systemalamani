<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/add/<?php echo $model ?>"> رفع ملف اكسل  </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl($model) ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

    مثال على ملف الاكسل :

<table border="1" style="text-align: center">
    <thead>
    <tr>
        <th>رمز المادة </th>
        <th>الكمية</th>
        <th>السعر بالدولار</th>
        <th>  رقم الفاتورة  </th>

        <?php  if ($this->permit('wholesale_price',$this->folder))  {  ?>
        <th>   سعر الجملة  </th>
        <th>  سعر جملة الجملة  </th>
        <th>  سعر التكلفة  </th>
        <?php  } ?>

    </tr>
    </thead>

</table>

<hr>




<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">

        <a class="nav-item nav-link title_cumulative  active  " id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">  رفع تراكمي   </a>

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade  cumulative  show active " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

        <br>
       
        <form    action="<?php echo url.'/'.$this->folder ?>/cumulative_upload/<?php echo $model ?>"  method="post" enctype="multipart/form-data">


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


                    <span style="color: red;font-size: 14px;" id="files_cumulative_upload"> </span>
                    <br>

                    <textarea name="files_cumulative_upload" id="files_data_cumulative_upload" hidden  class="form-control"></textarea>
                    <label class="label_files" >    رفع ملف الاكسل فقط  </label>
                    <div class="fileupload-wrapper">
                        <div id="myUpload_files_cumulative_upload">
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
                            <a   href="<?php echo url .'/'.$this->folder?>/code_not_upload/<?php echo $model ?>" class="btn  btn-primary"  > لايمكن الرفع , توجد مواد غير مرفوعة </a>
                        <?php } else { ?>
                            <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">

                        <?php }  ?>
                    </div>
                </div>
            </div>


        </form>


        <script>


            $("#myUpload_files_cumulative_upload").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_cumulative_upload').val(response);
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





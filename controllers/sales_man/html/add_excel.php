<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"> عرض النواقص </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  رفع ملف اكسل النقوصات   </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

    ترتيب ملف اكسل النواقص على الشكل التالي
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


    </tr>
    </thead>
    <tbody>
    <tr>
        <td>القسم</td>
        <td>اسم المادة</td>
        <td> الكود </td>
        <td> اللون  </td>
        <td>  اخر سعر شراء </td>
        <td> الكمية المطلوبة </td>
        <td>   ملاحظة </td>

    </tr>

    </tbody>
</table>

<hr>




<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active title_normal" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">  رفع ملف اكسل بالواقص </a>

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active normal" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


<br>
<br>



        <form    action="<?php echo url.'/'.$this->folder ?>/excel"  method="post" enctype="multipart/form-data">



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


                    <span style="color: red;font-size: 14px;" id="excel"> </span>
                    <br>

                    <textarea name="excel" id="files_data_normal" hidden  class="form-control"></textarea>
                    <label class="label_files" >    رفع ملف الاكسل فقط  </label>
                    <div class="fileupload-wrapper">
                        <div id="myUpload_excel">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <hr>

            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-auto">
                        <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">
                    </div>
                </div>
            </div>


        </form>


        <script>


            $("#myUpload_excel").bootstrapFileUpload({
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

</div>





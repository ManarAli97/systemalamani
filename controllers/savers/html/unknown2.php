<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"> <?php echo $this->langControl($this->folder) ?>  </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  اضافة سريعة للمواد  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form    action="<?php echo url.'/'.$this->folder ?>/unknown2"  method="post" enctype="multipart/form-data">



<br>
<br>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">

            <table border="1" style="text-align: center">

                <tbody>
                <tr>

                    <td>الرمز</td>
                    <td>   اسم المادة </td>
                    <td>  المجموعة  </td>
                    <td>  الاسم الاتيني  </td>
                    <td>  اسم الجهاز  </td>
                    <td>  السلسله  </td>
                    <td>  الماركة  </td>

                </tr>

                </tbody>
            </table>

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
                <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">
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







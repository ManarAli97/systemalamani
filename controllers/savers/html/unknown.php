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


<form    action="<?php echo url.'/'.$this->folder ?>/unknown"  method="post" enctype="multipart/form-data">



    <div class="row align-items-end">

        <div class="col-lg-3 col-md-3">
            الماركة
            <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brandcat()"   required>
                <option>   اختر الماركة </option>
				<?php foreach ($category as $key => $catg) {   ?>
                    <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
				<?php  } ?>

            </select>
        </div>
        <div class="col-lg-3 col-md-3">
            السلسلة
            <select   onchange="typeDevice_public()" class="custom-select dropdown_filter"   id="nameDevice_public" required>
                <option>   اختر السلسلة </option>
            </select>
        </div>


        <div class="col-lg-4 col-md-4">
            الجهاز
            <select    class="custom-select dropdown_filter" name="cat"   id="typeDevice_publicx" required>

                <option>   اختر الجهاز  </option>
            </select>
        </div>

    </div>
    <script>


        function brandcat() {

            $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                $('#nameDevice_public').html(data);

                if (data)
                {
                    typeDevice_public($('#brand option:selected').val())
                }
            });
        }

        function typeDevice_public() {

            $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                $('#typeDevice_publicx').html(data);
            });

        }


    </script>

<br>
<br>
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


            <table border="1" style="text-align: center">

                <tbody>
                <tr>
                    <td>اسم المادة</td>
                    <td>  الباركود </td>
                    <td>  الاسم الاتيني </td>
                    <td>   اسم المجموعة   </td>
                    <td>  نقاط المادة  </td>


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







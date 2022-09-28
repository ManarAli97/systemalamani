<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('report_purchase') ?> </li>
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
        <th> القسم(موبايل,اكسسوار, حافظات,العاب) </th>
        <th> الكمية</th>
        <th> سعر الشراء</th>
        <th> سعر البيع $</th>
        <th>سعر البيع جملة $ </th>
        <th> سعر البيع جملة الجملة $</th>
    </tr>
    </thead>

</table>
<hr>


<form  action="<?php echo url.'/'.$this->folder ?>/upload_excel/<?php echo $id ?>"  method="post" enctype="multipart/form-data">
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




</div>

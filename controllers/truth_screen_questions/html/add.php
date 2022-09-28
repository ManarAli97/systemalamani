<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_truth_screen_questions"><?php  echo $this->langControl('truth_screen_questions') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/add" method="post"  >

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="title" class="form-control"  id="validationServer01"  value="<?php  echo $data['title']  ?>" type="text">
        </div>
    </div>
    <br>




    <style>

        .label_files
        {
            float: right;
            padding: 7px;
            background: #eeeff0;
        }
    </style>


    <span style="color: red;font-size: 14px;" id="files"> </span>
    <br>
        <label class="label_files" >  اضافة فيديو  </label>
        <textarea name="files" id="img" hidden class="form-control"><?php  echo $data['files']  ?></textarea>
        <div class="fileupload-wrapper">
            <div id="myUpload">
            </div>
        </div>

<hr>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="حفظ">
            </div>
        </div>
    </div>

</form>


<script>

    $("#myUpload").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            video: []
        },
        onUploadSuccess: function(response) {
            $('#img').val(response);
            console.log(response)
        }
    });
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

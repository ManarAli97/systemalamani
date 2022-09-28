<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/group"><?php  echo $this->langControl('group_user') ?> </a></li>
                <li class="breadcrumb-item"><?php  echo $this->langControl('add_group') ?> </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<form  id="randomInsert" action="<?php echo url ?>/user/add_group" method="post"  >
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label for="validationServer01">  <?php  echo $this->langControl('title_category') ?> <span style="color: red;font-size: 14px;" id="name"> </span>  </label>
            <input name="name" class="form-control"  id="validationServer01"  value="<?php  echo $data['name']  ?>" type="text">
        </div>
    </div>


    <br>
    <textarea name="files" id="img" hidden class="form-control"><?php  echo $data['files']  ?></textarea>
    <label class="label_files" >  <?php  echo $this->langControl('add') .' '. $this->langControl('image') ?>  </label>
    <div class="fileupload-wrapper">
        <div id="myUpload">
        </div>
    </div>

    <hr>

    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn " type="submit" name="submit" value="حفظ">
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
            images: []
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
        $("input[name='"+prop+"']").addClass('error_border_red');
    }
</script>
<?php  } ?>
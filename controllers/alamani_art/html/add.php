<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('alamani_art') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                    <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/add/<?php echo $id ?>" method="post"  >

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="title" class="form-control"  id="validationServer01"  value="<?php  echo $data['title']  ?>" type="text">
        </div>
    </div>
    <br>


    <div class="row align-items-center">
        <div class="col-auto">
            اختر القسم
        </div>
        <div class="col-lg-4">
            <select name="id_cat" class="form-control">
                <?php foreach ($category as $cag) {   ?>

                    <option value="<?php echo $cag['id'] ?>"><?php echo $cag['title'] ?> </option>

                <?php  }  ?>
            </select>
        </div>
    </div>


    <br>




    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span> (150 كلمة) </label>
            <div id="editor">
              <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                  <?php echo $data['content']  ?>
              </textarea>

            </div>

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
        <label class="label_files" >  <?php  echo $this->langControl('add') .' '. $this->langControl('images') ?>  </label>
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
        multiFile: true,
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

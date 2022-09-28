<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('mobile') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Add_new_category') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form  id="randomInsert" action="<?php echo url.'/'.$this->folder ?>/add_category/<?php  echo $id ?>" method="post"  >

        <div class="row    justi fy-conte nt-md-c enter">

            <div class="col-md-auto">

                <label><?php  echo $this->langControl('title_category') ?></label>
            </div>
            <div class="col-5   ">
                <input name="title" class="form-control"   value="<?php  echo $data['title']  ?>" type="text">
            </div>

        </div>

    <br>
        <div class="row    justi fy-conte nt-md-c enter">

            <div class="col-md-auto">

                <label>  رقم الترتيب   </label>
            </div>
            <div class="col-5   ">
                <input  name="order_cat" class="form-control"   value="<?php  echo $data['order_cat']  ?>" type="number">
            </div>

        </div>

    <br>
    <div class="row    justi fy-conte nt-md-c enter">

            <div class="col-md-auto">

                <label>   رمز الفئة     </label>
            </div>
            <div class="col-5   ">
                <input  name="code_cat" class="form-control"   value="<?php  echo $data['code_cat']  ?>" type="text">
            </div>

        </div>

        <br>
        <br>
        <textarea name="files" id="img" hidden class="form-control"><?php  echo $data['files']  ?></textarea>
        <div class="fileupload-wrapper">
            <div id="myUpload">
            </div>
        </div>

<hr>

    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
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
            images: []
        },
        onUploadSuccess: function(response) {
            $('#img').val(response);
            console.log(response)
        }
    });
</script>


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
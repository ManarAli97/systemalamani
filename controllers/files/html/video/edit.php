
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">  <?php  echo $this->langControl($this->folder) ?>  </h2>
            <p class="pageheader-text"></p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php  echo url ?>/home" class="breadcrumb-link"><?php  echo $this->langControl('cpanel') ?> </a></li>
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/video"><?php  echo $this->langControl('files_manger') ?> </a></li>
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/video"><?php  echo $this->langControl('videos') ?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('edit') ?>  </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>



<div class="card" style="width: 18rem;">

    <video class="card-img-top" id="new_video"   controls>
        <source src="<?php echo $result['url'] ?>"  type="video/mp4">
        <source src="movie.ogg" type="video/ogg">
        Your browser does not support the video tag.
    </video>


</div>



<div class="uploadvideo">
    <div class="inAdd">
        <div class="form-row">
            <div class="col-md-12 mb-12 lg-12">
                <div class="fileupload-wrapper">
                    <div id="myUploadvideo">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>






<script>



    $("#myUploadvideo").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image/<?php  echo $id ?>",
        inputName: 'image',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            video: []
        },
        onUploadSuccess: function(response) {
            console.log(response)

            if (response)
            {
               window.location='<?php  echo url .'/'.$this->folder ?>/video'
            }

        } ,
        onInit: function () {
            $('#myUploadvideo .btnAddFile').html(`<i class="glyphicon glyphicon-refresh"></i>  <span>&nbsp;   <?php echo $this->langSite('change_video') ?>   </span>`);
        },
        onUploadReset: function () {

            $('#myUploadvideo .fileupload-reset').remove();
            $('#myUploadvideo .label_files').remove();
            $('#myUploadvideo .fileupload-add').remove();
        }
    });




</script>
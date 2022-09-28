
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">  <?php  echo $this->langControl($this->folder) ?>  </h2>
            <p class="pageheader-text"></p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php  echo url ?>/home" class="breadcrumb-link"><?php  echo $this->langControl('cpanel') ?> </a></li>
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/image"><?php  echo $this->langControl('files_manger') ?> </a></li>
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/image"><?php  echo $this->langControl('images') ?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('edit') ?>  </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


 <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-12 card" style="padding: 0">
         <div class="card-img-top document_manager" style="background-image: url(<?php echo  $result['url'] ?>)" ></div>

        <div class="card-footer">
            <?php  echo $result['normal_name'] ?>
        </div>
    </div>
</div>
<div class="uploadImage">
    <div class="inAdd">
        <div class="form-row">
            <div class="col-md-12 mb-12 lg-12">
                <div class="fileupload-wrapper">
                    <div id="myUploadPdf">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>

    $("#myUploadPdf").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_files/<?php  echo $id ?>",
        inputName: 'files',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            archives: [],
            audio: [],
            files: [],
        },
        onUploadSuccess: function(response) {
            if (response)
            {
                window.location='<?php  echo url .'/'.$this->folder ?>/file'
            }

        } ,
        onInit: function () {
            $('#myUploadPdf .btnAddFile').html(`<i class="glyphicon glyphicon-refresh"></i>  <span>&nbsp;   <?php echo $this->langSite('change') ?>   </span>`);
        },
        onUploadReset: function () {

            $('#myUploadPdf .fileupload-reset').remove();
            $('#myUploadPdf .label_files').remove();
            $('#myUploadPdf .fileupload-add').remove();
        }
    });




</script>
<style>
    .document_manager
    {

        height: 250px;
        background-position: center;
        background-repeat:no-repeat ;
        background-size: 35%;
    }

</style>

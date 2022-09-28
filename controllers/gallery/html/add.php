<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('gallery') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                    <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add_gallery') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>




    <div class="row">
<div class="col">


          <style>


             .label_files
             {
                 float: right;
                 padding: 7px;
                 background: #eeeff0;
             }
         </style>

            <label class="label_files" >  <?php  echo $this->langControl('add') .' '.$this->langControl('image') ?>  </label>
            <div class="fileupload-wrapper">
             <div id="myUpload">
             </div>
         </div>

 </div>
    </div>



<br>
<br>
<br>
<br>





<script>

    $("#myUpload").bootstrapFileUpload({
        url: "<?php echo url .'/'.$this->folder ?>/upload_image/<?php echo $id?>",
        inputName: 'image',
        multiFile: true,
        multiUpload: true,
        maxSize:48,
        fileTypes: {
            images: []
        },
        onUploadSuccess: function(response) {
            $('#img').val(response);

            console.log(response);

        },
        onUploadComplete: function () {
            $('#myUpload .fileupload-reset').remove();
            $('.label_files').remove();
            $('#myUpload .fileupload-add').remove();

        },
    });
    $('#myUpload .fileupload-cancel').click(function () {

        $('#myUpload tbody').empty();

    });

</script>

<style>
    .note-popover .popover-content .dropdown-menu, .card-header.note-toolbar .dropdown-menu
    {

        left: unset !important;
    }
    .custom-control {
        position: relative;
        display: -ms-inline-flexbox;
        display: inline-flex;
        min-height: 1.5rem;
        padding-left: 1.5rem;
        margin-right: 1rem;
    }

</style>




















<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('dhuquk_ahlaa') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<form  action="<?php echo url.'/'.$this->folder ?>/edit_category/<?php echo $id  ?>" method="post">

                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <label for="validationServer01">  <?php  echo $this->langControl('title_category') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
                        <input name="title" class="form-control"  id="validationServer01"  value="<?php  echo $data['title']  ?>" type="text">
                    </div>
                </div>




<br>


    <div class="row    justi fy-conte nt-md-c enter">
            <?php if(!empty($get_file)) {  ?>
            <div class="col-auto" id="rem_img_<?php  echo $data['id']  ?>">

                <div class="card text-white  bg-success mb-3 mb-3" style=" max-width: 18rem;">

                    <div class="card-header">

                        <a class="btn delete_img"  style="float: left;margin: -10px;padding: 0;" data-toggle="modal" data-target="#exampleModalFile" data-whatever="<?php  echo $data['id']  ?>" data-title="<?php echo $get_file['rand_name'] ?>"  data-typef="<?php echo $get_file['file_type'] ?>"    >  <i class="fa fa-trash-o" style="font-size:30px"></i> </a>
                    </div>
                    <div class="card-body">
                        <img style="max-width: 15rem;" src="<?php echo $this->save_file .$get_file['rand_name'] ?>">
                    </div>
                </div>
            </div>
            <?php  }  ?>
        </div>

        <textarea name="files" id="img" hidden class="form-control"></textarea>
       <label class="label_files" >  <?php  echo $this->langControl('edit') .' '. $this->langControl('image') ?>  </label>
         <div class="fileupload-wrapper">
            <div id="myUpload">
            </div>
        </div>


    <hr>
    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >
            </div>
        </div>
    </div>

</form>

<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("input[name='"+prop+"']").addClass('error_border_red');
        }
    </script>
<?php  } ?>



<div class="modal fade" id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel_delete"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php  echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-warning"><?php  echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>



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
            $('#img').val(response)
        }
    });


    $('#exampleModalFile').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever') ;
        var title = button.data('title') ;
        var typef = button.data('typef') ;
        var modal = $(this);
        modal.find('.modal-title').text('<?php echo $this->langControl("are_you_sure")   ?> ?  ' );
        if (typef === 'image')
        {
            modal.find('.modal-body').html("<img class='img_model' src='<?php echo $this->save_file ?>"+title+"' style='width: 100%;'>");
        }
        else
        {
            modal.find('.modal-body').html("<video controls  class='img_model' src='<?php echo $this->save_file ?>"+title+"' style='width: 100%;'></video>");
        }

        modal.find('#save').val(recipient)
    });


    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url.'/'.$this->folder ?>/delete_image_cat/"+id, function( data ) {
            $('#rem_img_'+id).remove();
            $('#exampleModalFile').modal('hide');
        });
    });
</script>




<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"> <?php  echo $this->langControl('shortfalls') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<form  action="<?php echo url.'/'.$this->folder ?>/edit/<?php echo $id  ?>" method="post">

                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
                        <input name="title" class="form-control"  id="validationServer01"  value="<?php  echo $data['title']  ?>" type="text">
                    </div>
                </div>

    <br>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label for="validationServer02">  <?php  echo $this->langControl('link') ?> <span style="color: red;font-size: 14px;" id="link"> </span>  </label>
            <input name="link" class="form-control"  id="validationServer02"  value="<?php  echo $data['link']  ?>" type="text">
        </div>
    </div>
    <br>




    <br>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span>  </label>
            <div id="editor">
              <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                  <?php echo $data['content']  ?>
              </textarea>

            </div>

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

    <style>
        .label_files
        {
            float: right;
            padding: 7px;
            background: #eeeff0;
        }
    </style>
    <span style="color: red;font-size: 14px;" id="img"> </span>
    <br>
    <textarea name="files" id="img_cat" hidden class="form-control"></textarea>
       <label class="label_files" >  <?php  echo $this->langControl('edit') .' '. $this->langControl('image') ?>  </label>
         <div class="fileupload-wrapper">
            <div id="myUpload">
            </div>
        </div>


    <hr>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-auto">
                <input class="btn btn-info" type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >
            </div>
        </div>
    </div>

</form>

<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;

        console.log(error)

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
            $('#img_cat').val(response)
        }
    });


    $('#exampleModalFile').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever') ;
        var title = button.data('title') ;
        var typef = button.data('typef') ;
        var modal = $(this);
        modal.find('.modal-title').text('هل تريد حذف الملف ؟  ' );
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
        $.get( "<?php echo url.'/'.$this->folder ?>/delete_image/"+id, function( e ) {
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
            else
            {
                $('#rem_img_'+id).remove();
                $('#exampleModalFile').modal('hide');
            }

        });
    });
</script>


<br>
<br>
<br>
<br>

<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('network') ?> </a></li>
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

    <div class="row    justi fy-conte nt-md-c enter">

        <div class="col-md-auto">

            <label><?php  echo $this->langControl('title_category') ?> </label>
        </div>

        <div class="col-5   ">
            <input name="title" class="form-control"  value="<?php echo $data['title'] ?>" type="text">
        </div>
    </div>
    <br>


    <div class="row    justi fy-conte nt-md-c enter">

        <div class="col-md-auto">

            <label>   رقم الترتيب </label>
        </div>

        <div class="col-5   ">
            <input name="order_cat" class="form-control"  value="<?php echo $data['order_cat'] ?>" type="number">
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



    <div class="row">

        <?php if(!empty($get_file)) {  ?>

            <div class="col-md-auto">

                <label>    صوة القسم  </label>
            </div>


            <div class="col-5" id="rem_img_<?php  echo $data['id']  ?>">

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


    <br>
    <textarea name="files" id="img" hidden class="form-control"></textarea>
    <div class="fileupload-wrapper">
        <div id="myUpload">
        </div>
    </div>

    <hr>

    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn btn-primary" type="submit" name="submit"  value="حفظ">
            </div>
        </div>
    </div>

</form>


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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <?php  echo $this->langControl('close') ?> </button>

                </div>
            </div>
        </div>
    </div>

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
            console.log(response)
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
        $.get( "<?php echo url.'/'.$this->folder ?>/delete_image_cat/"+id, function( data ) {
            $('#rem_img_'+id).remove();
            $('#exampleModalFile').modal('hide');
        });
    });
</script>




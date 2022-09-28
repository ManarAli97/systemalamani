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


<form  action="<?php echo url.'/'.$this->folder ?>/edit/<?php echo $id  ?>" method="post">

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
            <select name="id_cat" class="form-control">sss
                <?php foreach ($category as $cag) {   ?>

                    <option value="<?php echo $cag['id'] ?>"  <?php    if ($cag['id'] == $data['id_cat']) echo 'selected' ?>   ><?php echo $cag['title'] ?> </option>

                <?php  }  ?>
            </select>
        </div>
    </div>


    <br>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span> (150 كلمة)  </label>
            <div id="editor">
              <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                  <?php echo $data['content']  ?>
              </textarea>

            </div>

        </div>
    </div>

    <br>

    <br>
    <br>
    <div class="row">

        <?php foreach ($get_image as $view_file)  { ?>
            <div class="col col-lg-3 card_img" id="rem_img_<?php echo  $view_file['id']?>">
                <a id="trash_<?php echo  $view_file['id']?>" class="btn delete_img"  data-toggle="modal" data-target="#exampleModalFile" data-whatever="<?php  echo $view_file['id']  ?>" data-title="<?php echo $view_file['rand_name'] ?>"  data-typef="<?php echo $view_file['file_type'] ?>"    >  <i class="fa fa-trash-o" style="font-size:30px"></i> </a>
                <div class="card"   onclick="select_card(this,'<?php echo $view_file['id']?>')"  >
                    <?php    if ($view_file['file_type']=='image') {  ?>

                        <img   class="card-img-top" src="<?php echo $this->save_file .$view_file['rand_name']?>" alt="Card image cap">
                    <?php  }elseif($view_file['file_type']=='video') { ?>
                        <video controls style="height: 150px;" class="card-img-top" src="<?php echo $this->save_file.$view_file['rand_name']?>" ></video>
                    <?php  } ?>
                </div>
            </div>
        <?php   } ?>
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
                <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >
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
        multiFile: true,
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
        $.get( "<?php echo url ?>/files/delete/"+id+"/<?php  echo $this->folder?>", function( e ) {

                $('#rem_img_'+id).remove();
                $('#exampleModalFile').modal('hide');

        });
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

    .card_img {
        position: relative;
    }

    .card_img .card{
        cursor: pointer;
        padding: 5px;
    }


    .card_img .card.selected {
        background-color: #e9ecef;
    }
    .delete_img
    {
        background: #dee2e6;
        position: absolute;
        z-index: 150;
        left: 0;
        margin-left: 16px;
        margin-top: 1px;
        border-radius: 0 0 51px 0;
        padding-bottom: 11px;
        padding-right: 15px;
        padding-top: 2px;
        padding-left: 6px;
        box-shadow: 3px 2px 4px 0px #717e8b;

    }

    .trash
    {
        display: none;
    }

    .files_ {
        background: #eeeff0ad;
        padding: 15px;
        position: relative;
        border-radius: 17px;
    }
    .files_ img
    {
        width: 44px;
    }
    .delete_file
    {
        color: red !important;
        border-left: 2px solid #8d8d93;
        border-radius: 0;
        margin-left: 12px;
    }
    .add_files
    {
        position: relative;
    }
    .label_image
    {
        float: right;
        padding: 7px;
        background: #eeeff0;
    }
    .label_files
    {
        float: right;
        padding: 7px;
        background: #eeeff0;
    }



</style>

<br>
<br>
<br>
<br>

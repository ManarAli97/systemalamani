


<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('parts_image') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                    <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit_parts') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $data['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

    <div class="row">
        <div class="col">

            <form action="<?php echo url.'/'.$this->folder ?>/edit_parts/<?php echo $id ?>" method="post">
                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <label for="validationServer01">   <span>  <?php  echo $this->langControl('title') ?> </span> <span style="color: red;font-size: 14px;" id="title"></span>    </label>
                        <input   value="<?php echo $data['title'] ?>" name="title" type="text" class="form-control is-valid" id="validationServer01"      >
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <label for="validationServer02"> <span>  <?php  echo $this->langControl('price') ?> </span> <span style="color: red;font-size: 14px;" id="price"></span>  </label>
                        <input   name="price" value="<?php echo  $data['price']  ?>" type="text" class="form-control is-valid" id="validationServer02"  >
                    </div>
                </div>


                <br>
                <br>
                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <fieldset class="fieldsetCatg" >
                            <legend> <?php  echo $this->langControl('categories') ?></legend>

                            <div class="panel panel-default">
                                <div class="panel-body">


                                    <?php foreach ($data_cat as $rowCat) {    ?>
                                    <div class="custom-control custom-radio">
                                        <input <?php echo $rowCat['checked'] ?> value="<?php echo $rowCat['id'] ?>"  type="radio" id="cat_<?php echo $rowCat['id'] ?>" name="id_cat"  class="custom-control-input">
                                        <label class="custom-control-label" for="cat_<?php echo $rowCat['id'] ?>"><?php echo $rowCat['title'] ?></label>
                                    </div>
                                    <?php   } ?>
                                </div>
                            </div>

                        </fieldset>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <br>
                <br>

                <div class="form-row">
                    <div class="col-md-12 mb-12 lg-12">
                        <label>   <?php  echo $this->langControl('details') ?>   <span style="color: red;font-size: 14px;" id="content"></span></label>


                        <div id="editor">

                      <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                          <?php echo $data['content']  ?>
                      </textarea>

                        </div>






                    </div>
                </div>

                <br>
                <br>
                <span style="color: red;font-size: 15px;" id="img"></span>
                <div class="row">
                    <?php foreach ($get_file as $view_file)  { ?>
                        <div class="col col-lg-3 card_img" id="rem_img_<?php echo  $view_file['id']?>">
                            <a id="trash_<?php echo  $view_file['id']?>" class="btn delete_img <?php echo  $view_file['trash']?>"  data-toggle="modal" data-target="#exampleModalFile" data-whatever="<?php  echo $view_file['id']  ?>" data-title="<?php echo $view_file['rand_name'] ?>"  data-typef="<?php echo $view_file['file_type'] ?>"    >  <i class="fa fa-trash-o" style="font-size:30px"></i> </a>
                            <div class="card  <?php echo $view_file['class']?>"   onclick="select_card(this,'<?php echo $view_file['id']?>')"  >
                               <?php    if ($view_file['file_type']=='image') {  ?>

                                <img style="height: 150px;" class="card-img-top" src="<?php echo $this->save_file .$view_file['rand_name']?>" alt="Card image cap">
                                <?php  }elseif($view_file['file_type']=='video') { ?>
                                <video controls style="height: 150px;" class="card-img-top" src="<?php echo $this->save_file.$view_file['rand_name']?>" ></video>
                                <?php  } ?>
                                <div class="card-body" style="  overflow: hidden;">
                                    <p class="card-text">
                                    <div class="custom-control custom-radio">
                                        <input <?php echo $view_file['checked']?>  type="radio" id="customRadio_<?php echo $view_file['id']?>"  value="<?php echo $view_file['id']?>" name="img" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio_<?php echo $view_file['id']?>">  <?php   echo $view_file['normal_name'] ?>  </label>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php   } ?>

                </div>

                <hr>
                <?php  if(!empty($media)) {  ?>
                    <label class="label_files" >  <?php  echo $this->langControl('new_upload') ?>  </label>

                    <div class="row">
                        <?php foreach ( $media as $md) { ?>
                            <?php  if ($md['file_type'] =='video') {   ?>
                                <div class="col-lg-auto">
                                    <video   style="width: 230px;margin-bottom: 22px;" controls src="<?php  echo $this->save_file. $md['rand_name'] ?>" preload="metadata"  ></video>
                                </div>
                            <?php  } else{  ?>
                                <div class="col-lg-auto">
                                    <img   style="width:230px;margin-bottom: 22px;"  src="<?php  echo $this->save_file. $md['rand_name'] ?>"  >
                                </div>

                            <?php }  } ?>
                    </div>
                <?php }  ?>
                <br>


                <textarea name="files" id="media_get" hidden class="form-control"><?php echo  $data['files']?></textarea>
                <label class="label_files" >  <?php  echo $this->langControl('add') .' '.$this->langControl('videos').' '.$this->langControl('and').' '. $this->langControl('images') ?>  </label>
                <div class="fileupload-wrapper"><div id="myUpload"> </div></div>

                <br>
                <br>

                <div class="form-row">
                    <div class="col-auto ">
                        <label for="validationServer02"> <?php  echo $this->langControl('date') ?>  </label>
                        <input name="date" type="datetime-local"   value="<?php echo  date('Y-m-d\TH:i:s', $data['date'])  ?>"  class="form-control is-valid" id="validationServer02"     required>
                    </div>
                </div>

                <br>
                <hr>
                <div class="container">
                    <div class="row justify-content-md-center ">
                        <div class="col-md-auto">
                            <input  class="btn btn-primary"  value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>






<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("input[name='"+prop+"']").addClass('error_border_red');
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









<div class="modal fade" id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-warning"><?php echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">


    $("#myUpload").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: true,
        multiUpload: true,
        fileTypes: {
            images: [],
            video: []
        },
        onUploadSuccess: function(response) {
            $('#media_get').val(response);
            console.log(response)
        },
        onUploadReset: function () {

            $('#myUpload .fileupload-reset').remove();
            $('.label_files').remove();
            $('#myUpload .fileupload-add').remove();
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
        console.log(id)
        $.get( "<?php echo url ?>/files/delete/"+id+"/<?php  echo $this->folder ?>", function( data ) {
            console.log(data)
            $('#rem_img_'+id).remove();
            $('#exampleModalFile').modal('hide')
        });
    });


    function select_card(e,id) {
        $('.card_img .card').removeClass('selected');
        $(e).addClass('selected');
        $('#customRadio_'+id).prop('checked', true);
        $('.btn.delete_img').removeClass('trash');
       // $('#trash_'+id).addClass('trash');

    }



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
</style>


<br>
<br>
<br>
<br>






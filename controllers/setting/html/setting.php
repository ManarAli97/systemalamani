<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php  echo $this->langControl('setting') ?></li>
                <li class="breadcrumb-item active"><?php  echo $this->langControl('information') ?> </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


    <div class="row align-items-center">

        <div class="col-auto">
            <input <?php  if ( $this->get('prepared_serial_or_code') == 1) echo 'checked' ?>   class='toggle-demo' onchange='switch_hide(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle'   data-onstyle='success' data-size='small'>


        </div>
        <div class="col-auto">
            <div>  <span>OFF</span> <span>تجهيز عن طريق الباركود او الباركود البديل  </span></div>
            <div> <span>ON</span> <span>تجهيز عن طريق السيريال </span> </div>


        </div>
    </div>
    <hr>


<script>

    function switch_hide(e) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/' .$this->folder?>/prepared_serial_or_code/"+vis, function(data){ })
    }


</script>


<form  action="<?php echo url.'/'.$this->folder ?>/update" method="post">

    <div class="form-group row">
        <label for="print_qr" class="col-sm-2 col-form-label">اسم طابعة طباعتة qr لخاص في الزبائن</label>
        <div class="col-auto">
            <input type="text" name="print_qr"    class="form-control" id="print_qr" value="<?php echo $this->get('print_qr') ?>" >
        </div>
    </div>

    <br>

    <div class="form-group row">
        <label for="inputnote" class="col-sm-2 col-form-label"><?php echo $this->langControl('note')?> </label>
        <div class="col-sm-10">
            <textarea type="text" name="note" rows="2"  class="form-control" id="inputnote" ><?php echo $this->get('note') ?></textarea>
        </div>
    </div>

    <br>

    <div class="form-group row">
        <label for="inputnumber_phone_first" class="col-sm-2 col-form-label"><?php echo $this->langControl('number_phone_first')?> </label>
        <div class="col-sm-4">
            <input type="text" name="number_phone_first" value="<?php echo $this->get('number_phone_first') ?>" class="form-control" id="input" >
        </div>

        <label for="inputnumber_phone_second" class="col-sm-2 col-form-label"><?php echo $this->langControl('number_phone_second')?> </label>
        <div class="col-sm-4">
            <input type="text" name="number_phone_second" value="<?php echo $this->get('number_phone_second') ?>" class="form-control" id="inputnumber_phone_second" >
        </div>
    </div>

    <br>

    <div class="form-group row">
        <label for="inputemail" class="col-sm-2 col-form-label"><?php echo $this->langControl('email')?> </label>
        <div class="col-sm-4">
            <input type="text" name="email" value="<?php echo $this->get('email','test@admin.com') ?>" class="form-control"  id="inputemail" >
        </div>

        <label for="inputaddress" class="col-sm-2 col-form-label"><?php echo $this->langControl('address')?> </label>
        <div class="col-sm-4">
            <input type="text" name="address" value="<?php echo $this->get('address') ?>" class="form-control" id="inputaddress" >
        </div>


    </div>
    <br>
    <div class="form-group row">
        <label for="inputemail_message" class="col-sm-2 col-form-label"><?php echo $this->langControl('email_message')?> </label>
        <div class="col-sm-4">
            <input type="text" name="email_message" value="<?php echo $this->get('email_message','info@admin.com') ?>" class="form-control"  id="inputemail_message" >
        </div>

        <label for="inputcopyright" class="col-sm-2 col-form-label"><?php echo $this->langControl('copyright')?> </label>
        <div class="col-sm-4">
            <input type="text" name="copyright" value="<?php echo $this->get('copyright') ?>" class="form-control" id="inputcopyright" >
        </div>
    </div>
    <br>

    <div class="form-group row">
        <label for="inputemail_message" class="col-sm-2 col-form-label">   وقت نهاية اليوم </label>
        <div class="col-sm-4">
         <select style="padding: 0 5px" name="hour" class="form-control" id="exampleFormControlSelect1">
            <option <?php  if ( $this->get('hour') == 0 ) echo 'selected'?>   value="0"  > +0 AM  </option>
            <option <?php  if ( $this->get('hour') == 3 ) echo 'selected'?>   value="3"  > +3 AM  </option>
            <option   <?php  if ( $this->get('hour') == 4 ) echo 'selected'?>  value="4" >  +4 AM   </option>
            <option  <?php  if ( $this->get('hour') == 5 ) echo 'selected'?>  value="5">    +5 AM  </option>
        </select>
         </div>


    </div>
    <br>

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label > <span> <?php  echo $this->langControl('aboutus') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span>  </label>

            <div id="editor">

              <textarea  name="aboutus" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                 <?php echo $this->get('aboutus') ?>
              </textarea>

            </div>

            <script>
                $(function () {
                    $('#edit')
                        .on('froalaEditor.initialized', function (e, editor) {
                            // $('#edit').parents('form').on('submit', function () {
                            //     console.log($('#edit').val());
                            //     return false;
                            // })
                        })

                        .froalaEditor({
                            enter: $.FroalaEditor.ENTER_P, placeholderText: null, language: '<?php echo $this->langControl ?>', direction: '<?php  echo $this->dirControl ?>'

                        })

                        .on('froalaEditor.image.beforeUpload', function (e, editor, files) {
                            if (files.length) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    var result = e.target.result;

                                    editor.image.insert(result, null, null, editor.image.get());
                                };

                                reader.readAsDataURL(files[0]);
                            }

                            return false;
                        })


                });
            </script>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <label for="inputamount_bill" class="col-sm-2 col-form-label"><?php echo $this->langControl('amount_bill')?> </label>
        <div class="col-sm-10">
            <input type="number" name="amount_bill"  value="<?php echo $this->get('amount_bill') ?>" class="form-control" id="inputamount_bill" >
        </div>
    </div>

    <hr>



    <div class="row    justi fy-conte nt-md-c enter">
        <?php if(!empty($get_file)) {  ?>
            <div class="col-auto" id="rem_img_<?php  echo $this->get('id_logo')  ?>">

                <div class="card text-white  bg-success mb-3 mb-3" style=" max-width: 18rem;">

                    <div class="card-header">

                        <a class="btn delete_img"  style="float: left;margin: -10px;padding: 0;" data-toggle="modal" data-target="#exampleModalFile" data-whatever="<?php  echo $this->get('id_logo')  ?>" data-title="<?php echo $get_file['rand_name'] ?>"  data-typef="<?php echo $get_file['file_type'] ?>"    >  <i class="fa fa-trash-o" style="font-size:30px"></i> </a>
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
    <label class="label_files" >  <?php  echo $this->langControl('edit') .' '. $this->langControl('logo_site') ?>  </label>
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

        $.get( "<?php echo url.'/'.$this->folder ?>/delete_logo/"+id, function( e ) {

            console.log(e)
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
<br>
<br>

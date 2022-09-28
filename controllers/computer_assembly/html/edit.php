<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_computer_assembly"><?php  echo $this->langControl('computer_assembly') ?> </a></li>
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
            <input  value="<?php echo $data['title'] ?>"   name="title" class="form-control"  id="validationServer01"   type="text" required>
        </div>
    </div>


    <br>

    <div class="description">
        <br>
        <label for="word_count">   <span> الشرح المختصر</span> //// <span>عدد الكلمات:  </span> <span id="display_count">0</span> كلمة.    المتبقي: <span id="word_left">100</span>  </label>
        <textarea  class="form-control" name="description" id="word_count"  rows="5"><?php echo  $data['description'] ?></textarea>

        <script>

            $(document).ready(function() {
                $("#word_count").on('keyup', function() {
                    var words = this.value.match(/\S+/g).length;
                    if (words > 100) {
                        alert("تجاوزت الحد المسموح بة من الكلمات");

                    }
                    else {
                        $('#display_count').text(words);
                        $('#word_left').text(100-words);
                    }
                });
            });
        </script>


    </div>
    <br>

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span>  </label>
            <div id="editor">
                <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>"><?php echo  $data['content'] ?></textarea>

            </div>

        </div>
    </div>

    <br>



<div class="row">
    <div class="col-lg-5 mb-5">
        <div class="uploadImage">
            <div class="inAdd">

                <label>صورة التجميعة الرئيسية</label>
                <div class="row">
                    <?php foreach ($image as $img)  { ?>
                        <div class="col-auto" >
                            <div class="image_upload" id="remove_file_<?php echo $img['id'] ?>"  >
                                <button  type="button" class="btn btn-danger btn_remove"  onclick="remove_file(<?php echo $data['id'] ?>,<?php echo $img['id'] ?>)"><i class="fa fa-times"></i> </button>

                                <img src="<?php echo $img['url'] ?>">
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <br>
                <textarea name="main_img" id="main_img" hidden class="form-control"></textarea>
                <div class="fileupload-wrapper">
                    <div id="myUpload_main_img">
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="col-lg-7">

        <div class="list_file">
            <div class="inAdd">
                <label > صور اضافية (اختياري) </label>



                <div class="row">
                    <?php foreach ($list as $list_v)  { ?>
                        <div class="col-lg-3 mb-3"  id="remove_file_<?php echo $list_v['id'] ?>" >
                            <div class="video_upload image_upload"  >

                                <button  type="button" class="btn btn-danger btn_remove"  onclick="remove_file(<?php echo $data['id'] ?>,<?php echo $list_v['id'] ?>)"><i class="fa fa-times"></i> </button>

                                <?php if ( $list_v['file_type']  == 'image')  {  ?>
                                    <img src="<?php echo $list_v['url'] ?>">

                                <?php  }  ?>

                            </div>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <textarea name="list_file" id="list_file" hidden class="form-control"></textarea>
                <div class="fileupload-wrapper">
                    <div id="myUploadlist_file">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


    <div class="row">
        <div class="col-12">
            <div class="inAdd" id="add_new_row">
                <strong>اضافة مواد التجميعة </strong>
                <hr>
                <?php foreach ($item as  $index => $outItem) { ?>
                <div class="row_computer_assembly"  id="row_database_<?php echo $outItem['id']  ?>" >
                    <div class="row">

                        <div class="col-lg-2">
                            <label>  القسم </label>
                            <select  onchange="getInfoCode(<?php  echo $outItem['id'] ?>)" name="model[<?php  echo $outItem['id'] ?>]"  id="model_<?php  echo $outItem['id'] ?>"  class="custom-select list_menu_categ" required>
                                <option value="" disabled selected>  اختر القسم    </option>
                                <?php  foreach ($this->category_website as $key => $cg) {   ?>
                                    <option <?php  if ($key == $outItem['model'] )  echo 'selected' ?>  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label>رمز المادة</label>
                            <input autocomplete="off" type="text" value="<?php  echo $outItem['code'] ?>" id="code_<?php  echo $outItem['id'] ?>"  onblur="getInfoCode(<?php  echo $outItem['id'] ?>)"  name="code[<?php  echo $outItem['id'] ?>]" class="form-control" >
                        </div>

                        <div class="col-lg-3">
                            <label>  اسم المادة  </label>
                            <input type="text"   autocomplete="off" value="<?php  echo $outItem['title'] ?>"  id="names_1"  name="names[<?php  echo $outItem['id'] ?>]" class="form-control" required>
                            <input type="hidden"  value="<?php  echo $outItem['id_item'] ?>"  id="id_item_1"  name="id_item[<?php  echo $outItem['id'] ?>]"  >
                            <input type="hidden"  value="<?php  echo $outItem['ids_cat'] ?>"  id="ids_cat_1"  name="ids_cat[<?php  echo $outItem['id'] ?>]"  >
                            <input type="hidden"  value="<?php  echo $outItem['img'] ?>"  id="img_1"  name="imgitem[<?php  echo $outItem['id'] ?>]"  >
                            <input  type="hidden"  value="<?php  echo $outItem['code_color'] ?>"  id="code_color_1"  name="code_color[<?php  echo $outItem['id'] ?>]"  >


                        </div>

                        <div class="col-auto">
                              <label>    السعر بالدولار  </label>
                            <input required style="width: 150px" class="form-control" value="<?php  echo $outItem['price'] ?>" type="number" id="price_1"  name="price[<?php  echo $outItem['id'] ?>]"   >
                        </div>
                        <div class="col-auto">
                              <label>    اللون  </label>
                            <input readonly style="width: 100px" class="form-control" value="<?php  echo $outItem['color'] ?>"  id="color_1"  name="color[<?php  echo $outItem['id'] ?>]"  >
                        </div>
                        <div class="col-auto">
                                <label>    الذاكرة   </label>
                            <input readonly  style="width: 100px" class="form-control"  value="<?php  echo $outItem['size'] ?>"  id="size_1"  name="size[<?php  echo $outItem['id'] ?>]"  >
                        </div>
                        <div class="col-auto mb-3">
                            <br>
                            <button type="button" onclick="add_new_sub_row(<?php  echo $outItem['id'] ?>)" class="btn  btn-warning"><span>بدائل</span> <i class="fa fa-plus"></i> </button>
                        </div>


                        <div class="col-12 mt-3 mb-3" id="sub_item_<?php  echo $outItem['id'] ?>">

                            <?php  if ($outItem['sub']) {  ?>

                                <?php  foreach ($outItem['sub'] as $sub) {  ?>

                            <div class="row align-items-end" id="row_database_<?php  echo     $sub['id']  ?>">

                                <div class="col-lg-2">
                                    <label>رمز المادة</label>
                                    <input  autocomplete="off"  type="text"  id="code_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>" value="<?php echo  $sub['code'] ?>"  onblur="getInfoCodeSub(<?php  echo $outItem['id'] ?>,<?php echo  $sub['id'] ?>)"  name="code_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]" class="form-control" required >
                                </div>

                                <div class="col-lg-3">
                                    <label>  اسم المادة  </label>
                                    <input type="text"  autocomplete="off" value="<?php echo $sub['title'] ?>" id="names_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="names_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]" class="form-control" required >
                                    <input type="hidden"  value="<?php echo $sub['id_item'] ?>" id="id_item_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="id_item_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >
                                    <input type="hidden" value="<?php echo $sub['ids_cat'] ?>" id="ids_cat_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="ids_cat_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >
                                    <input type="hidden"  value="<?php echo $sub['img'] ?>"  id="img_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="imgitem_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >

                                    <input type="hidden"  value="<?php  echo $sub['code_color'] ?>"   id="code_color_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="code_color_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >

                                </div>

                                <div class="col-auto" >
                                    <label>   السعر بالدولار  </label>
                                    <input style="width: 150px;" class="form-control"  required   value="<?php  echo $outItem['price'] ?>"   id="price_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="price_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"   type="number" >
                                </div>
                                <div class="col-auto" >
                                    <label>   اللون  </label>
                                    <input style="width: 100px;" class="form-control"  readonly   value="<?php  echo $outItem['color'] ?>"   id="color_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="color_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >
                                </div>
                                <div class="col-auto"  >
                                    <label>    الذاكرة </label>
                                    <input style="width: 100px;" class="form-control" readonly  value="<?php  echo $outItem['size'] ?>"  id="size_sub_<?php  echo $outItem['id'] ?>_<?php echo  $sub['id'] ?>"  name="size_sub[<?php  echo $outItem['id'] ?>][<?php echo  $sub['id'] ?>]"  >
                                </div>

                                <div class="col-auto"  >

                                    <button type="button"  class="btn btn-danger"  onclick="delete_row_database(<?php  echo $sub['id']  ?>,'<?php  echo $sub['code']  ?>','<?php  echo $sub['model']  ?>')"   ><i class="fa fa-times"></i> </button>
                                 </div>

                            </div>

                            <?php } ?>
                            <?php } ?>
                        </div>




                    </div>
                    <?php if ($index > 0) {   ?>
                    <button class="btn btn-danger delete_row"  onclick="delete_row_database(<?php  echo $outItem['id']  ?>,'<?php  echo $outItem['code']  ?>','<?php  echo $outItem['model']  ?>')" type="button"><i class="fa fa-times"></i> </button>
                     <?php } ?>
                </div>
                <?php  } ?>
            </div>
            <br>
            <button class="btn btn-warning"  onclick="add_new_row()" type="button">اضافة</button>


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



<div class="modal fade" id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel_delete"> </h5>


            </div>
            <div class="modal-body">
                هل تريد حذف الملف؟
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="localStorage.clear();"><?php  echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-warning" onclick="ok_remove()" ><?php  echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>



<script>

    
    
    
    function delete_row_database(id,code,model) {
        if (confirm(   ' هل انت متأكد من حذف رمز المادة = ' + code ))
        {

            $.get( "<?php  echo url .'/'. $this->folder ?>/delete_row_database",{id:id,code:code,model:model}, function( data ) {
              if (data ==='true')
              {
                  $( "#row_database_"+id ).remove();
              }else
              {
                  alert('لا يمكن حذف  المادة')
              }

            });

        } return false;
    }


    function delete_sub_row_html(id,row) {
        if (confirm(   ' هل انت متأكد   '   ))
        {
                  $( "#subRow_"+id+"_"+row).remove();


        } return false;
    }




    var sub= 1;
    function add_new_sub_row(id) {


        $('#sub_item_'+id).append(
            `

              <div class="row mt-2 align-items-end" id="subRow_${id}_${sub}">

                                <div class="col-lg-2">
                                    <label>رمز المادة</label>
                                    <input  autocomplete="off"  type="text"  id="code_sub_${id}_${sub}"  onblur="getInfoCodeSub('${id}',${sub})"  name="code_sub[${id}][x${sub}x]" class="form-control" required>
                                </div>

                                <div class="col-lg-3">
                                    <label>  اسم المادة  </label>
                                    <input type="text"  autocomplete="off" id="names_sub_${id}_${sub}"  name="names_sub[${id}][x${sub}x]" class="form-control"  required>
                                    <input type="hidden"  id="id_item_sub_${id}_${sub}"  name="id_item_sub[${id}][x${sub}x]"  >
                                    <input type="hidden"  id="ids_cat_sub_${id}_${sub}"  name="ids_cat_sub[${id}][x${sub}x]"  >
                                    <input type="hidden"  id="img_sub_${id}_${sub}"  name="imgitem_sub[${id}][x${sub}x]"  >

                                    <input type="hidden"  id="code_color_sub_${id}_${sub}"  name="code_color_sub[${id}][x${sub}x]"  >

                                </div>

                                <div class="col-auto" >
                                    <label>   السعر بالدولار  </label>
                                    <input style="width: 150px;" class="form-control"  type="number" id="price_sub_${id}_${sub}"  name="price_sub[${id}][x${sub}x]"  required>
                                </div>
                                <div class="col-auto" >
                                    <label>   اللون  </label>
                                    <input style="width: 100px;" class="form-control" readonly id="color_sub_${id}_${sub}"  name="color_sub[${id}][x${sub}x]"  >
                                </div>
                                <div class="col-auto"  >
                                    <label>    الذاكرة </label>
                                    <input style="width: 100px;" class="form-control" readonly id="size_sub_${id}_${sub}"  name="size_sub[${id}][x${sub}x]"  >
                                </div>


                                  <div class="col-auto"  >

                                    <button type="button"  class="btn btn-danger"  onclick="delete_sub_row_html(${id},${sub})"   ><i class="fa fa-times"></i> </button>
                                 </div>


                            </div>
             `

        )

        sub++;

    }





    function getInfoCodeSub(id,sub)
    {

        var model=$("#model_"+id +" :selected").val()

        if (model)
        {
            var code=$("#code_sub_"+id+"_"+sub).val()
            if (code){
                $.get( "<?php  echo url . '/' .$this->folder ?>/getInfoCode",{model:model,code:code}, function( data ) {
                    if (data)
                    {
                        var response=JSON.parse(data)

                        $("#names_sub_"+id+"_"+sub).val(response.title)
                        $("#ids_cat_sub_"+id+"_"+sub).val(response.id_cat)
                        $("#id_item_sub_"+id+"_"+sub).val(response.id)
                        $("#img_sub_"+id+"_"+sub).val(response.img)
                        $("#color_sub_"+id+"_"+sub).val(response.color)
                        $("#code_color_sub_"+id+"_"+sub).val(response.code_color)
                        $("#size_sub_"+id+"_"+sub).val(response.size)

                    }else
                    {
                        alert('لا توجد مادة لرمز المادة المدخل ')
                    }

                });
            }

        }
        else
        {
            alert('يجب اختيار القسم')
            // $("#code_"+id).val('')
        }

    }




    var row=<?php echo $lastIdIten ?>;
    var c=1;
    function add_new_row() {

        $('#add_new_row').append(`

                <div class="row_computer_assembly" id="new_row_${row}">

                    <div class="row">

                        <div class="col-lg-2">
                            <label>  القسم </label>
                        <select  onchange="getInfoCode('x${c}x')" name="model[x${c}x]"  id="model_x${c}x"  class="custom-select list_menu_categ" required>
                            <option value="" disabled selected>  اختر القسم    </option>
                            <?php  foreach ($this->category_website as $key => $cg) {   ?>
                                <option  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                            <?php  } ?>
                        </select>
                        </div>

                        <div class="col-lg-2">
                            <label>رمز المادة</label>
                            <input  autocomplete="off"  type="text"  id="code_x${c}x"  onblur="getInfoCode('x${c}x')"  name="code[x${c}x]" class="form-control" required>
                        </div>

                        <div class="col-lg-4">
                            <label>  اسم المادة  </label>
                            <input type="text"  autocomplete="off" id="names_x${c}x"  name="names[x${c}x]" class="form-control" required>
                            <input type="hidden"  id="id_item_x${c}x"  name="id_item[x${c}x]"  >
                            <input type="hidden"  id="ids_cat_x${c}x"  name="ids_cat[x${c}x]"  >
                            <input type="hidden"  id="img_x${c}x"  name="imgitem[x${c}x]"  >
                            <input type="hidden"  id="code_color_x${c}x"  name="code_color[x${c}x]"  >



                       </div>


                            <div class="col-auto">
                                    <label> السعر بالدولار  </label>
                                    <input style="width: 150px;" class="form-control"  type="number"  id="price_x${c}x"  name="price[x${c}x]"  required>
                              </div>

                            <div class="col-auto">
                                    <label>اللون  </label>
                                    <input style="width: 100px;" class="form-control" readonly id="color_x${c}x"  name="color[x${c}x]"  >
                              </div>
                              <div class="col-auto">
                               <label>   الذاكرة  </label>
                                 <input style="width: 100px;" class="form-control" readonly id="size_x${c}x"  name="size[x${c}x]"  >
                              </div>


                         <div class="col-auto mb-3">
                            <br>

                            <button type="button" onclick="add_new_sub_row('x${c}x')" class="btn  btn-warning"><span>بدائل</span> <i class="fa fa-plus"></i> </button>
                        </div>

                        <div class="col-12 mt-3 mb-3" id="sub_item_x${c}x"></div>



                    </div>
                       <button class="btn btn-danger delete_row"  onclick="delete_row(${row})" type="button"><i class="fa fa-times"></i> </button>
                </div>
        `)
        tags()
        $('.toggle-demo').bootstrapToggle();
        c++;
        row++;
    }


    function getInfoCode(id)
    {
        var model=$("#model_"+id +" :selected").val()

        if (model)
        {
            var code=$("#code_"+id).val()
            if (code){
                $.get( "<?php  echo url . '/' .$this->folder ?>/getInfoCode",{model:model,code:code}, function( data ) {
                    if (data)
                    {
                        var response=JSON.parse(data)

                        $("#names_"+id).val(response.title)
                        $("#ids_cat_"+id).val(response.id_cat)
                        $("#id_item_"+id).val(response.id)
                        $("#img_"+id).val(response.img)
                        $("#color_"+id).val(response.color)
                        $("#code_color_"+id).val(response.code_color)
                        $("#size_"+id).val(response.size)

                    }else
                    {
                        alert('لا توجد مادة لرمز المادة المدخل ')
                    }

                });
            }


            if(model==='savers')
            {
                $('.computer_assembly_cover'+id).show('fast');
                // $('.computer_assembly_cover'+id+" input") .attr('required','required')

            }else
            {
                $('.computer_assembly_cover'+id).hide('fast');
                // $('.computer_assembly_cover'+id+" input") .removeAttr('required')
            }



        }
        else
        {
            alert('يجب اختيار القسم')
            // $("#code_"+id).val('')
        }

    }

    function delete_row(id)
    {
        $("#new_row_"+id).remove();
    }


    $("#myUpload_main_img").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            images: []
        },

        onUploadSuccess: function(response) {
            console.log(response)
            $('#main_img').val(response);
            $('#myUpload_main_img .fileupload-reset').click();
        } ,
        onInit: function () {
            $('#myUpload_main_img .btnAddFile').html(`<i class="glyphicon glyphicon-refresh"></i>  <span>&nbsp;   تغير صورة التجميعة الرئيسية  </span>`);
        },
        onUploadReset: function () {

            $('#myUpload_main_img .fileupload-reset').remove();
            $('#myUpload_main_img .label_files').remove();
            $('#myUpload_main_img .fileupload-add').remove();
        }
    });



    $("#myUploadlist_file").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: true,
        multiUpload: true,
        fileTypes: {
            images: [],
        },
        onUploadSuccess: function(response) {
            console.log(response)
            $('#list_file').val(response);
            $('#myUploadlist_file .fileupload-reset').click();
        } ,
        onInit: function () {
            $('#myUploadlist_file .btnAddFile').html(`<i class="glyphicon glyphicon-plus"></i>  <span>&nbsp;   <?php echo $this->langSite('upload') ?>   </span>`);
        },
        onUploadReset: function () {

            $('#myUploadlist_file .fileupload-reset').remove();
            $('#myUploadlist_file .label_files').remove();
            $('#myUploadlist_file .fileupload-add').remove();
        }
    });





    function remove_file(id,id_file)
    {
        localStorage.setItem('id_item', id);
        localStorage.setItem('id_file', id_file);
        $('#exampleModalFile').modal('show');
    }

    function ok_remove()
    {

        $.get( "<?php echo url .'/'.$this->folder ?>/remove_file/"+localStorage.getItem('id_item')+"/"+localStorage.getItem('id_file'), function( data ) {
            if (data)
            {
                $('#remove_file_'+localStorage.getItem('id_file')).remove();
                localStorage.clear();
                $('#exampleModalFile').modal('hide');
            }else
            {
                alert('حدثت مشكلة؟')
                $('#exampleModalFile').modal('hide');
            }
        });
    }



    $("#idForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url:  $(this).attr('action'),
            cache:false,
            contentType: false,
            processData: false,
            data: formData, // serializes the form's elements.
            success: function(data)
            {

                console.log(data)
                // alert(' يجب رفع صورة رئيسية او صورة للمادة')
                if (data === '1')
                {
                    alert('يجب رفع صورة رئيسية للتجميعة')
                }else
                {
                    window.location="<?php echo  url .'/'.$this->folder ?>/list_computer_assembly"
                }

            }
        });


    });




</script>

<style>

    .btn_remove {
        position: absolute;
        left: 15px;
        top: 0;
        padding: 0px 6px;
        border-radius: 0 0 16px 0;
        z-index: 1000;
    }
    .image_upload img {
        width: 100%;
        height:200px;
    }
    .inAdd {
        border: 1px solid #d6d6d6;
        padding: 10px;
        margin: 19px 0;
        background: #ecedee;
    }
    .label_files
    {
        float: right;
        padding: 7px;
        background: #eeeff0;
    }

    .inAdd {
        border: 1px solid #d6d6d6;
        padding: 10px;
        margin: 19px 0;
        background: #ecedee;
    }

    .row_computer_assembly
    {
        border-bottom: 2px solid white;
        padding: 15px 0;
        position: relative;
    }
    button.btn.btn-danger.delete_row {
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 50%;
    }
</style>

<br>
<br>
<br>
<br>

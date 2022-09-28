<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_offers"><?php  echo $this->langControl('offers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form  id="idForm"  action="<?php echo url.'/'.$this->folder ?>/add_form" method="post" enctype="multipart/form-data"  >

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="title" class="form-control"  id="validationServer01"   type="text" required>
        </div>
    </div>
    <br>


    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
            <fieldset class="fieldsetCatg" >
                <legend>   فئة العرض  </legend>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php foreach ($data_cat as $rowCat) {    ?>
                            <div class="custom-control custom-checkbox">
                                <input   value="<?php echo $rowCat['id'] ?>"  type="checkbox" id="cat_<?php echo $rowCat['id'] ?>" name="id_offer_categories[]"  class="custom-control-input">
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


    <div class="row align-items-center">

        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="validationServer-total_price">  سعر الكلي (بالدولار) <span style="color: red;font-size: 14px;" id="total_price"> </span>  </label>
            <input name="total_price" class="form-control"  id="validationServer01"   type="text">
        </div>

        <div class="col-auto"><strong> او </strong></div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="validationServer-rate">   نسبة (بالدولار) <span style="color: red;font-size: 14px;" id="rate"> </span>  </label>

            <div class="input-group mb-2">
                <input name="rate" class="form-control"  id="validationServer01"   type="text">
                <div class="input-group-prepend">
                    <div class="input-group-text">  <strong>%</strong> </div>
                </div>
            </div>
        </div>

    </div>
    <br>





    <div class="form-row">
        <div class="col-auto">
            <label for="validationServer0-countdown">   العد التنازلي  </label>
        </div>

        <div class="col-auto">
            <input type="hidden"  name="countdown"  value="0"    >
            <input type="checkbox"  name="countdown"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"    checked  >
        </div>
    </div>

    <br>



    <div class="form-row">

        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
        <label for="validationServer-fromdate_normal">  من تاريخ   <span style="color: red;font-size: 14px;" id="fromdate_normal"> </span>  </label>
            <input name="fromdate_normal" class="form-control"  id="validationServer01"    type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  required>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="validationServer-todate_normal">  الى تاريخ  <span style="color: red;font-size: 14px;" id="todate_normal"> </span>  </label>
            <input name="todate_normal" class="form-control"  id="validationServer01"    type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  required>
        </div>
    </div>
    <br>

    <div class="description">
        <br>
        <label for="word_count">   <span> الشرح المختصر</span> //// <span>عدد الكلمات:  </span> <span id="display_count">0</span> كلمة.    المتبقي: <span id="word_left">100</span>  </label>
        <textarea class="form-control" name="description" id="word_count"  rows="5"></textarea>

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
              <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>"></textarea>

            </div>

        </div>
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

    <div class="row">
        <div class="col-lg-6 mb-2">

            <div class="inAdd">
                <span style="color: red;font-size: 14px;" id="files_main_img"> </span>

                <label class="label_files_main_img" >  اضافة صورة رئيسية للعرض </label>
                <textarea name="main_img" id="main_img" hidden class="form-control"></textarea>
                <div class="fileupload-wrapper">
                    <div id="myUpload_main_img">
                    </div>
                </div>
            </div>


        </div>

        <div class="col-lg-6">

            <div class="list_file">
                <div class="inAdd">
                    <label >  صور اضافية للعرض </label>

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
<strong>اضافة مواد للعرض </strong>
                <hr>
                <div class="row_offer"  >

                    <div class="row">

                        <div class="col-lg-2">
                            <label>  القسم </label>
                        <select  onchange="getInfoCode(1)" name="model[0]"  id="model_1"  class="custom-select list_menu_categ" required>
                            <option value="" disabled selected>  اختر القسم    </option>
                            <?php  foreach ($this->category_website as $key => $cg) {   ?>
                                <option  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                            <?php  } ?>
                        </select>
                        </div>

                        <div class="col-lg-2">
                            <label>رمز المادة</label>
                            <input  autocomplete="off"  type="text"  id="code_1"  onblur="getInfoCode(1)"  name="code[0]" class="form-control" >
                        </div>

                        <div class="col-lg-3">
                            <label>  اسم المادة  </label>
                            <input type="text"  autocomplete="off" id="names_1"  name="names[0]" class="form-control" >
                            <input type="hidden"  id="id_item_1"  name="id_item[0]"  >
                            <input type="hidden"  id="ids_cat_1"  name="ids_cat[0]"  >
                            <input type="hidden"  id="img_1"  name="imgitem[0]"  >

                            <input type="hidden"  id="code_color_1"  name="code_color[0]"  >

                            <div class="row">
                                <div class="col-6">
                                    اللون
                                    <input class="form-control" readonly id="color_1"  name="color[0]"  >
                                </div>
                                <div class="col-6">
                                    حجم الذاكرة
                                    <input class="form-control" readonly id="size_1"  name="size[0]"  >
                                </div>
                            </div>

                       <div  class="mt-2 offer_cover1" style="font-size: 12px;display: none">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer1_1" name="cover_type_offer[0]" value="1" class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer1_1">العرض الاول</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer2_1"  name="cover_type_offer[0]" value="2"  class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer2_1">العرض الثاني</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer3_1"  name="cover_type_offer[0]" value="3"  class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer3_1">العرض الثالث</label>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 tags_tags">
                                    باركود او اسم لاتيني
                                    <input class="form-control tags"  autocomplete="off"  id="latiniin_or_code_1"  name="latiniin_or_code[0]"      data-role="tagsinput"  >
                                </div>
                            </div>
                        </div>




                        </div>

                        <div class="col-lg-3">
                             <label> صوره  </label>
                         <input   name="image[]" type="file"   class="form-control"    />
                        </div>



                        <div class="col-lg-2">
<br>
                            <label> نشر  </label>

                            <input  type="hidden"  name="active[0]"  value="0"    >
                            <input type="checkbox" checked  id="validationServer-active-1" name="active[0]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"     >

                        </div>



                    </div>

                </div>

            </div>
            <br>
            <button class="btn btn-warning"   onclick="add_new_row()" type="button">اضافة</button>


        </div>
    </div>


<hr>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-auto">
                <input class="btn btn-primary " type="submit" name="submit" value="حفظ">
            </div>
        </div>
    </div>

</form>
<br>
<br>
<br>
<br>
<br>

<script>

    var row=2;
    var c=1;
    function add_new_row() {

        $('#add_new_row').append(`

                <div class="row_offer" id="new_row_${row}">

                    <div class="row">

                        <div class="col-lg-2">
                            <label>  القسم </label>
                        <select  onchange="getInfoCode(${row})" name="model[${c}]"  id="model_${row}"  class="custom-select list_menu_categ" required>
                            <option value="" disabled selected>  اختر القسم    </option>
                            <?php  foreach ($this->category_website as $key => $cg) {   ?>
                                <option  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                            <?php  } ?>
                        </select>
                        </div>

                        <div class="col-lg-2">
                            <label>رمز المادة</label>
                            <input  autocomplete="off"  type="text"  id="code_${row}"  onblur="getInfoCode(${row})"  name="code[${c}]" class="form-control" >
                        </div>

                        <div class="col-lg-3">
                            <label>  اسم المادة  </label>
                            <input type="text"  autocomplete="off" id="names_${row}"  name="names[${c}]" class="form-control" >
                            <input type="hidden"  id="id_item_${row}"  name="id_item[${c}]"  >
                            <input type="hidden"  id="ids_cat_${row}"  name="ids_cat[${c}]"  >
                            <input type="hidden"  id="img_${row}"  name="imgitem[${c}]"  >

                        <input type="hidden"  id="code_color_${row}"  name="code_color[${c}]"  >

                        <div class="row">
                              <div class="col-6">
                             اللون
                                    <input class="form-control" readonly id="color_${row}"  name="color[${c}]"  >
                              </div>
                              <div class="col-6">
                              حجم الذاكرة
                                 <input class="form-control" readonly id="size_${row}"  name="size[${c}]"  >
                              </div>
                          </div>


                       <div  class="mt-2 offer_cover${row}" style="font-size: 12px;display: none">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer1_${row}" name="cover_type_offer[${c}]" value="1" class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer1_${row}">العرض الاول</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer2_${row}"  name="cover_type_offer[${c}]" value="2"  class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer2_${row}">العرض الثاني</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="cover_type_offer3_${row}"  name="cover_type_offer[${c}]" value="3"  class="custom-control-input">
                                <label class="custom-control-label" for="cover_type_offer3_${row}">العرض الثالث</label>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 tags_tags">
                                    باركود او اسم لاتيني
                                    <input class="form-control tags"  autocomplete="off"  id="latiniin_or_code_${row}"  name="latiniin_or_code[${c}]"    data-role="tagsinput"  >
                                </div>
                            </div>
                        </div>





                        </div>

                        <div class="col-lg-3">
                             <label> صوره  </label>
                         <input   name="image[]" type="file"   class="form-control"    />
                        </div>



                        <div class="col-lg-2">
                            <br>
                            <label> نشر  </label>

                            <input type="hidden"  name="active[${c}]"  value="0"    >
                            <input class="toggle-demo" type="checkbox" checked  id="validationServer-active-1" name="active[${c}]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"     >

                        </div>



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
              $('.offer_cover'+id).show('fast');
              // $('.offer_cover'+id+" input") .attr('required','required')

          }else
          {
              $('.offer_cover'+id).hide('fast');
              // $('.offer_cover'+id+" input") .removeAttr('required')
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
            $('#myUpload_main_img .btnAddFile').html(`<i class="glyphicon glyphicon-plus"></i>  <span>&nbsp;   <?php echo $this->langSite('upload') ?>   </span>`);
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
                    alert('يجب رفع صورة رئيسية للعرض')
                }else
                {
                 window.location="<?php echo  url .'/'.$this->folder ?>/list_offers"
                }

            }
        });


    });


</script>


<?php if(!empty($this->error_form ))  { ?>
<script>

    var error=<?php echo $this->error_form ?>;
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
<style>

    .offer_cover
    {
        display: none;
    }

    .inAdd {
        border: 1px solid #d6d6d6;
        padding: 10px;
        margin: 19px 0;
        background: #ecedee;
    }

    .row_offer
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
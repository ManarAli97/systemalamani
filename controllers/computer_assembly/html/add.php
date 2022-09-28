<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_computer_assembly"><?php  echo $this->langControl('computer_assembly') ?> </a></li>

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

                <label class="label_files_main_img" >  اضافة صورة رئيسية للتجميعة </label>
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
                    <label >  صور اضافية  للتجميعة </label>

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
              <strong>اضافة مواد  التجميعة </strong>
                <hr>
                <div class="row_computer_assembly"  >

                    <div class="row">

                        <div class="col-lg-2">
                            <label>  القسم </label>
                        <select  onchange="getInfoCode(0)" name="model[0]"  id="model_0"  class="custom-select list_menu_categ" required>
                            <option value="" disabled selected>  اختر القسم    </option>
                            <?php  foreach ($this->category_website as $key => $cg) {   ?>
                                <option  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                            <?php  } ?>
                        </select>
                        </div>

                        <div class="col-lg-2">
                            <label>رمز المادة</label>
                            <input  autocomplete="off"  type="text"  id="code_0"  onblur="getInfoCode(0)"  name="code[0]" class="form-control" >
                        </div>

                        <div class="col-lg-3">
                            <label>  اسم المادة  </label>
                            <input type="text"  autocomplete="off" id="names_0"  name="names[0]" class="form-control" >
                            <input type="hidden"  id="id_item_0"  name="id_item[0]"  >
                            <input type="hidden"  id="ids_cat_0"  name="ids_cat[0]"  >
                            <input type="hidden"  id="img_0"  name="imgitem[0]"  >

                            <input type="hidden"  id="code_color_0"  name="code_color[0]"  >

                        </div>

                        <div class="col-auto" >
                              <label> السعر بالدولار </label>
                            <input style="width:150px;" class="form-control"  required id="price_0"  name="price[0]"  type="number" >
                        </div>
                        <div class="col-auto" >
                              <label>   اللون  </label>
                            <input style="width: 100px;" class="form-control" readonly id="color_0"  name="color[0]"  >
                        </div>
                        <div class="col-auto"  >
                               <label>    الذاكرة </label>
                            <input style="width: 100px;" class="form-control" readonly id="size_0"  name="size[0]"  >
                        </div>

                        <div class="col-auto mb-3">
                            <br>
                            <button type="button" onclick="add_new_sub_row(0)" class="btn  btn-warning"><span>بدائل</span> <i class="fa fa-plus"></i> </button>
                        </div>

                        <div class="col-12 mt-3 mb-3" id="sub_item_0">



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

    var sub= 0;
    function add_new_sub_row(id) {


        $('#sub_item_'+id).append(
            `

                   <div class="row mt-2 align-items-end" id="subRow_${id}_${sub}">

                                <div class="col-lg-2">
                                    <label>رمز المادة</label>
                                    <input  autocomplete="off"  type="text"  id="code_sub_${id}_${sub}"  onblur="getInfoCodeSub(${id},${sub})"  name="code_sub[${id}][]" class="form-control" >
                                </div>

                                <div class="col-lg-3">
                                    <label>  اسم المادة  </label>
                                    <input type="text"  autocomplete="off" id="names_sub_${id}_${sub}"  name="names_sub[${id}][]" class="form-control" >
                                    <input type="hidden"  id="id_item_sub_${id}_${sub}"  name="id_item_sub[${id}][]"  >
                                    <input type="hidden"  id="ids_cat_sub_${id}_${sub}"  name="ids_cat_sub[${id}][]"  >
                                    <input type="hidden"  id="img_sub_${id}_${sub}"  name="imgitem_sub[${id}][]"  >

                                    <input type="hidden"  id="code_color_sub_${id}_${sub}"  name="code_color_sub[${id}][]"  >

                                </div>

                                <div class="col-auto" >
                                    <label>   السعر بالدولار  </label>
                                    <input style="width: 150px;" class="form-control" required id="price_sub_${id}_${sub}"  name="price_sub[${id}][]"  >
                                </div>
                                <div class="col-auto" >
                                    <label>   اللون  </label>
                                    <input style="width: 100px;" class="form-control" readonly id="color_sub_${id}_${sub}"  name="color_sub[${id}][]"  >
                                </div>
                                <div class="col-auto"  >
                                    <label>    الذاكرة </label>
                                    <input style="width: 100px;" class="form-control" readonly id="size_sub_${id}_${sub}"  name="size_sub[${id}][]"  >
                                </div>

                                  <div class="col-auto"  >

                                    <button type="button"  class="btn btn-danger"  onclick="delete_sub_row_html(${id},${sub})"   ><i class="fa fa-times"></i> </button>
                                 </div>

                            </div>
             `

        )

        sub++;

    }


    function delete_sub_row_html(id,row) {
        if (confirm(   ' هل انت متأكد    '   ))
        {
            $( "#subRow_"+id+"_"+row).remove();


        } return false;
    }


    var row=1;
    var c=1;
    function add_new_row() {

        sub=0;

        $('#add_new_row').append(`

                <div class="row_computer_assembly" id="new_row_${row}">

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

                        </div>

                                <div class="col-auto">
                                    <label> السعر بالدولار  </label>
                                    <input style="width: 150px;" required class="form-control"   id="price_${row}"  name="price[${c}]"  >
                              </div>
                                <div class="col-auto">
                                    <label>اللون  </label>
                                    <input style="width: 100px;" class="form-control" readonly id="color_${row}"  name="color[${c}]"  >
                              </div>
                              <div class="col-auto">
                               <label>   الذاكرة  </label>
                                 <input style="width: 100px;" class="form-control" readonly id="size_${row}"  name="size[${c}]"  >
                              </div>


                         <div class="col-auto mb-3">
                            <br>

                            <button type="button" onclick="add_new_sub_row(${c})" class="btn  btn-warning"><span>بدائل</span> <i class="fa fa-plus"></i> </button>
                        </div>

                        <div class="col-12 mt-3 mb-3" id="sub_item_${c}"></div>


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

      }

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
                    alert('يجب رفع صورة رئيسية للتجميعة')
                }else
                {
                 window.location="<?php echo  url .'/'.$this->folder ?>/list_computer_assembly"
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

    .computer_assembly_cover
    {
        display: none;
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

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_product_savers"><?php  echo $this->langControl('product_savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<?php  if($id==null) {  ?>
    <script>
        localStorage.removeItem('cats1admin');
        localStorage.removeItem('cats2admin');
    </script>
<?php  }  ?>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/add_product_savers/<?php echo $id ?>/<?php echo $all ?>" method="post" enctype="multipart/form-data">



            <div class="row">

                <div class="col-lg-3 col-md-3">
                    الماركة
                    <select class="custom-select dropdown_filter"   id="brand"   onchange="brandx()"   required>
                        <option value="">   اختر الماركة </option>
						<?php foreach ($category as $key => $catg) {   ?>
                            <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
						<?php  } ?>

                    </select>
                </div>
                <div class="col-lg-3 col-md-3">
                    السلسلة
                    <select onchange="typeDevice_public()" class="custom-select dropdown_filter"     id="nameDevice_public" required>
                        <option value="">   اختر السلسلة </option>
                    </select>
                </div>


                <div class="col-lg-4 col-md-4">
                    الجهاز
                    <select    class="custom-select dropdown_filter"   id="typeDevice_publicx" name="devise"  required>

                        <option value="">   اختر الجهاز  </option>
                    </select>
                </div>


            </div>


            <br>

            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="latiniin: red;font-size: 14px;" id="content"></span>  </label>
                    <div id="editor">
              <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>"></textarea>

                    </div>

                </div>
            </div>

            <br>


            ادخال الحافظات
            <div class="row">
                <div class="col">

                    <div class="row x_down">

                        <div class="col-12 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('title') ?>  </label>
                            <input   name="title[0]" type="text"  class="form-control " id="validationServer01"  value=""  required/>
                        </div>




                        <div class="col-12 margin_text">

                            <br>
                            <table class="table table-bordered table-striped  ">

                                <tbody>


                                <tr>
                                    <td>

                                        <div class="form-row  align-items-center">

                                            <div class="col-auto">
                                                <input type="hidden"  name="serial_flag[0]"  value="0"    >
                                                <input type="checkbox"  name="serial_flag[0]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"    >
                                            </div>
                                            <div class="col-auto">
                                                <label for="validationServer02">  <?php  echo $this->langControl('serial') ?>  </label>
                                            </div>

                                        </div>

                                    </td>
                                    <td>
                                        <div class="form-row  align-items-center">

                                            <div class="col-auto">
                                                <input type="hidden"  name="locationTag[0]"  value="0"    >
                                                <input type="checkbox" checked name="locationTag[0]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"     >
                                            </div>
                                            <div class="col-auto">
                                                <label for="validationServer02">  <?php  echo $this->langControl('location') ?>  </label>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-row">


                                            <div class="col-auto">
                                                <input type="hidden"  name="enter_serial[0]"  value="0"    >
                                                <input type="checkbox"  id="active_enter_serial" name="enter_serial[0]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"    >
                                            </div>
                                            <div class="col-auto">
                                                <label for="validationServer0active_enter_serial">  <?php  echo $this->langControl('active_enter_serial') ?>  </label>
                                            </div>
                                        </div>

                                    </td>
                                    <td>

                                        <div class="form-row">
                                            <div class="col-auto">
                                                <label for="validationServer0change_price">  <?php  echo $this->langControl('change_price_bill') ?>  </label>
                                            </div>

                                            <div class="col-auto">
                                                <input type="hidden"  name="change_price[0]"  value="0"    >
                                                <input type="checkbox"  id="validationServer0change_price" name="change_price[0]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"     >
                                            </div>
                                        </div>


                                    </td>
                                  <td>
                                    <div class="col-auto">

                                       <label for="validationServer0stop"> ماده خدميه</label>

                                        <input type="hidden"  name="is_service"  value="0"    >
                                        <input type="checkbox"  id="is_service" name="is_service"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ( $data['is_service'] == 1 ) echo 'checked'?>  >
                                     </div>
                                    </td>
                                </tr>
								
                                </tbody>
                            </table>


                            <br>
                        </div>


                        <div class="col-12 tags_tags">
                            <label for="input-tags" class="col-sm-12 col-form-label"><span>كلمات دارجة في البحث عن المنتج</span>    </label>
                            <input type="text"  name="tags[0]" class="form-control tags tags"     data-role="tagsinput" />
                            <br>  <br>
                        </div>


                        <div class="col-12 tags_tags">

                        <label for="input-tags" class="col-sm-12 col-form-label"><span> باركودات بديلة </span>    </label>
                        <input type="text"  name="serial[0]" class="form-control tags serial"     data-role="tagsinput" />
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('code') ?>  </label>
                            <input   name="code[0]"  oninput="check_code(this)"  type="text"  class="form-control " id="validationServer01"  value=""  required/>
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('point') ?>  </label>
                            <input   name="point[0]"     type="text"  class="form-control " id="validationServer01"  value=""   />
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer0_latiniin"> <?php  echo $this->langControl('latiniin') ?>  </label>
                            <input   name="latiniin[0]" type="text"  class="form-control " id="validationServer0_latiniin"  value=""  required/>
                        </div>
						 <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer011"> نسبة  </label>
                            <input   name="note[0]" type="text"  class="form-control " id="validationServer011"  value="0" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3  margin_text align-self-end">
                            <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                            <input   name="image[0]" type="file"  class=""   value=""  required/>
                        </div>

                        <div class="col-12 mt-5">

                            <div class="row mb-5">
                                <div class="col-lg-3">
                                    <h6>نوع المادة</h6>

                                    <?php  foreach ($cover_material as $key => $covm) {  ?>
                                        <div>
                                        <div class="custom-control custom-radio">
                                        <input type="radio" id="cover_material0_<?php echo $key ?>" value="<?php  echo $covm['number'] ?>" name="cover_material[0]" class="custom-control-input">
                                        <label class="custom-control-label" for="cover_material0_<?php echo $key ?>"><?php  echo $covm['number'] ?>-<?php  echo $covm['cover_material'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>
                                <div class="col-lg-3">
                                    <h6>نوع الحافظة</h6>

                                    <?php  foreach ($type_cover as $key => $type_c) {  ?>
                                        <div>
                                        <div class="custom-control custom-radio">
                                        <input type="radio" id="type_cover0_<?php echo $key ?>" value="<?php  echo $type_c['number'] ?>" name="type_cover[0]" class="custom-control-input">
                                        <label class="custom-control-label" for="type_cover0_<?php echo $key ?>"><?php  echo $type_c['number'] ?>-<?php  echo $type_c['type_cover'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>

                                <div class="col-lg-3">
                                    <h6> الميزة  </h6>

                                    <?php  foreach ($feature_cover as $key => $featc) {  ?>
                                        <div>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="feature_cover0_<?php echo $key ?>" value="<?php  echo $featc['number'] ?>" name="feature_cover[0][]" class="custom-control-input">
                                        <label class="custom-control-label" for="feature_cover0_<?php echo $key ?>"><?php  echo $featc['number'] ?>-<?php  echo $featc['feature_cover'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>

                            </div>

                        </div>


                    </div>

                    <div class="blockPs AddButton">
                    </div>

                    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add')?> <i class="fa fa-plus-circle"></i> </a>


                </div>
            </div>
            <br>


            <hr>
            <br>
            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary" id="save_btn_card" type="submit" name="submit" value="حفظ">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>

    var upxcol;
    count = 0;
    $('.addPs').click(function() {

        count += 1;
        upxcol = 'new'+count;
        id_div = 'id_r_'+count;
        sub_add = 'sub_add_'+count;

        $('.blockPs:last').before(`<div class="blockPs">
                             <div  id="${id_div}" class="row x_down">

                            <div class="col-12 margin_text  ">
                                <label for="validationServer01"> <?php  echo $this->langControl('title') ?>  </label>
                                <input   name="title[${id_div}]" type="text"  class="form-control " id="validationServer01"  value=""  required/>
                            </div>



                        <div class="col-12 margin_text">

                            <br>
                            <table class="table table-bordered table-striped  ">

                                <tbody>


                                <tr>
                                    <td>
                                        <div class="form-row  align-items-center">

                                            <div class="col-auto">
                                                <input type="hidden"  name="serial_flag[${id_div}]"  value="0"    >
                                                <input class="toggle-demo" type="checkbox" id="validationServer1-${id_div}"  name="serial_flag[${id_div}]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"    >
                                            </div>
                                                 <div class="col-auto">
                                                <label for="validationServer1-${id_div}">  <?php  echo $this->langControl('serial') ?>  </label>
                                            </div>

                                        </div>

                                    </td>
                                    <td>
                                        <div class="form-row  align-items-center">

                                              <div class="col-auto">
                                                <input type="hidden"  name="locationTag[${id_div}]"  value="0"    >
                                                <input class="toggle-demo" checked type="checkbox" id="validationServer2-${id_div}"  name="locationTag[${id_div}]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"     >
                                            </div>
                                               <div class="col-auto">
                                                <label for="validationServer2-${id_div}">  <?php  echo $this->langControl('location') ?>  </label>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-row">


                                            <div class="col-auto">
                                                <input type="hidden"  name="enter_serial[${id_div}]"  value="0"    >
                                                <input class="toggle-demo" type="checkbox"  id="validationServer3-${id_div}" name="enter_serial[${id_div}]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"    >
                                            </div>
                                              <div class="col-auto">
                                                <label for="validationServer3-${id_div}">  <?php  echo $this->langControl('active_enter_serial') ?>  </label>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="form-row">


                                            <div class="col-auto">
                                                <input type="hidden"  name="change_price[${id_div}]"  value="0"    >
                                                <input class="toggle-demo" type="checkbox"  id="validationServer4-${id_div}" name="change_price[${id_div}]"  value="1" data-toggle="toggle" data-style="ios" data-size="small"    >
                                            </div>
                                              <div class="col-auto">
                                                <label for="validationServer4-${id_div}">  <?php  echo $this->langControl('active_change_price') ?>  </label>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                </tbody>
                            </table>


                            <br>
                        </div>
                            <br>
                     <div class="col-12 tags_tags">
                            <label for="input-tags" class="col-sm-12 col-form-label"><span>كلمات دارجة في البحث عن المنتج</span>    </label>
                            <input type="text"  name="tags[${id_div}]" class="form-control tags tags"     data-role="tagsinput" />
                        <br>  <br>
                        </div>

                        <div class="col-12 tags_tags">


                                    <label for="input-tags" class="col-sm-12 col-form-label"><span> باركودات بديلة </span>    </label>

                                    <input type="text"  name="serial[${id_div}]" class="form-control tags serial"     data-role="tagsinput" />

                             <br>

                        </div>


                            <div class="col-lg-3 col-md-3 col-sm-3 margin_text">
                                <label for="validationServer01"> <?php  echo $this->langControl('code') ?>  </label>
                                <input   name="code[${id_div}]"  oninput="check_code(this)"  type="text"  class="form-control " id="validationServer01"  value=""  required/>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 margin_text">
                                <label for="validationServer01"> <?php  echo $this->langControl('point') ?>  </label>
                                <input   name="point[${id_div}]"    type="text"  class="form-control " id="validationServer01"  value=""   />
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 margin_text">
                                <label for="validationServer0_latiniin"> <?php  echo $this->langControl('latiniin') ?>  </label>
                                <input   name="latiniin[${id_div}]" type="text"  class="form-control " id="validationServer0_latiniin"  value=""  required/>
                            </div>
							 <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                                <label for="validationServer011"> نسبة  </label>
                                <input   name="note[${id_div}]" type="text"  class="form-control " id="validationServer011"  value=""  required/>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 margin_text align-self-end">
                                   <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                                <input   name="image[${id_div}]" type="file"    id="validationServer0_image"  value=""  required/>
                            </div>



                        <div class="col-12 mt-5">

                            <div class="row mb-5">
                                <div class="col-lg-3">
                                    <h6>نوع المادة</h6>

                                    <?php  foreach ($cover_material as $key => $covm) {  ?>
                                        <div>
                                        <div class="custom-control custom-radio">
                                        <input type="radio" id="cover_material${id_div}_<?php echo $key ?>" value="<?php  echo $covm['number'] ?>" name="cover_material[${id_div}]" class="custom-control-input">
                                        <label class="custom-control-label" for="cover_material${id_div}_<?php echo $key ?>"><?php  echo $covm['number'] ?>-<?php  echo $covm['cover_material'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>
                                <div class="col-lg-3">
                                    <h6>نوع الحافظة</h6>

                                    <?php  foreach ($type_cover as $key => $type_c) {  ?>
                                        <div>
                                        <div class="custom-control custom-radio">
                                        <input type="radio" id="type_cover${id_div}_<?php echo $key ?>" value="<?php  echo $type_c['number'] ?>" name="type_cover[${id_div}]" class="custom-control-input">
                                        <label class="custom-control-label" for="type_cover${id_div}_<?php echo $key ?>"><?php  echo $type_c['number'] ?>-<?php  echo $type_c['type_cover'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>

                                <div class="col-lg-3">
                                    <h6> الميزة  </h6>

                                    <?php  foreach ($feature_cover as $key => $featc) {  ?>
                                        <div>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="feature_cover${id_div}_<?php echo $key ?>" value="<?php  echo $featc['number'] ?>" name="feature_cover[${id_div}][]" class="custom-control-input">
                                        <label class="custom-control-label" for="feature_cover${id_div}_<?php echo $key ?>"><?php  echo $featc['number'] ?>-<?php  echo $featc['feature_cover'] ?></label>
                                    </div>
                                    </div>
                                    <?php  } ?>

                                </div>

                            </div>

                        </div>




                         <button class="btn remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </button>
                       </div>
                       </div>`);

        tags()
        $('.toggle-demo').bootstrapToggle();

                // for (i=0;i<name_country.length;i++)
                // {
                //     $(".custom-select.new_select_"+count+" option[value="+name_country[i]+"]").css('display','none');
                //
                // }



    });


    function remove_div(id) {
        $(id).remove();
    }
</script>
<script>


    function check_code(e) {
        var  code = $(e).val() ;

        $.get( "<?php  echo url.'/'.$this->folder?>/check_code",{code:code}, function( data ) {
            if (data === '1')
            {
                alert('رمز المادة موجود!')
                $(e).addClass('error_code')
                $('#save_btn_card').attr('disabled', 'disabled')
            }else
            {
                $(e).removeClass('error_code')
                $('#save_btn_card').removeAttr("disabled")

            }
        });
    }


    $(document).ready(function(){

        $("#brand option").each(function(){
            if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                $(this).attr("selected","selected");
                brandx();
            }
        });
    });


    function brandx() {

        $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
            $('#nameDevice_public').html(data);

            if (data)
            {

                $("#nameDevice_public option").each(function(){
                    if($(this).val()===localStorage.getItem("cats2admin")){ // EDITED THIS LINE
                        $(this).attr("selected","selected");
                    }
                });

                typeDevice_public($('#brand option:selected').val())

            }
        });

        localStorage.setItem("cats1admin",  $('#brand option:selected').val() );

    }

    function typeDevice_public() {

        $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
            $('#typeDevice_publicx').html(data);



            cats3="<?php  echo $id ?>";
            $("#typeDevice_publicx option").each(function(){
                if($(this).val()===cats3){ // EDITED THIS LINE
                    $(this).attr("selected","selected");
                }
            });

        });

        localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

    }
</script>
<br>
<br>


<style>

    .margin_text
    {
        margin-top: 15px;
    }
    .code_m
    {
        margin-top: 15px;
    }
    button.btn.add_new_sub_row {
        padding: 0;
        background: transparent;
        color: #218838;
        font-size: 25px;
    }
    button.btn.remove_sub_row {
        padding: 0;
        background: transparent;
        color: red;
        font-size: 25px;
    }

    .remove_div
    {
        position: absolute;
        left: 13px;
        padding: 0;
        top: -14px;
        background: #f5f6f7;
        border: 0;
    }

    .remove_div i
    {
        color: red;
        font-size: 28px;
    }
    .addPs
    {
        color: #FFFFFF !important;
    }
    .x_down
    {
        position: relative;
        margin-bottom: 25px;
        border: 1px solid #eeeff0;
        border-bottom: 1px solid #d5d7d8;
        padding-bottom: 22px;
        background: #eeeff08a;
    }
</style>



<style>
    .latiniinProduct {
        width: 40px;
        height: 40px;
        border: 1px solid #e4e4e4;
        border-radius: 50%;
    }
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

<br>
<br>
<br>
<br>


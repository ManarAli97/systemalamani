<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_product_savers"><?php  echo $this->langControl('product_savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $result['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit_product_savers/<?php echo $id ?>/<?php echo $all ?>" method="post" enctype="multipart/form-data">

            <br>


            <div class="row align-items-end">

                <div class="col-lg-3 col-md-3">
                    الماركة
                    <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brandcat()"   required>
                        <option>   اختر الماركة </option>
                        <?php foreach ($category as $key => $catg) {   ?>
                            <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                        <?php  } ?>

                    </select>
                </div>
                <div class="col-lg-3 col-md-3">
                    السلسلة
                    <select onchange="typeDevice_publicx()" class="custom-select dropdown_filter" name="nameDevice_public"   id="nameDevice_public" required>
                        <option>   اختر السلسلة </option>
                    </select>
                </div>


                <div class="col-lg-4 col-md-4">
                    الجهاز
                    <select    class="custom-select dropdown_filter" name="id_device"   id="typeDevice_public" required>

                        <option>   اختر الجهاز  </option>
                    </select>
                </div>


            </div>

            <script>

                $(document).ready(function(){

                    $("#brand option").each(function(){
                        if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                            $(this).attr("selected","selected");
                            brandcat();
                        }
                    });
                });


                function brandcat() {


                    $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                        $('#nameDevice_public').html(data);

                        if (data)
                        {

                            $("#nameDevice_public option").each(function(){
                                if($(this).val()===localStorage.getItem("cats2admin")){ // EDITED THIS LINE
                                    $(this).attr("selected","selected");
                                }
                            });

                            typeDevice_publicx($('#brand option:selected').val())


                        }
                    });

                    localStorage.setItem("cats1admin",  $('#brand option:selected').val() );


                }

                function typeDevice_publicx() {

                    $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                        $('#typeDevice_public').html(data);



                        cats3="<?php  echo $result['id_device'] ?>";
                        $("#typeDevice_public option").each(function(){
                            if($(this).val()===cats3){ // EDITED THIS LINE
                                $(this).attr("selected","selected");
                            }
                        });

                    });

                    localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

                }

                function colorDevice_public() {

                    if ($('#brand option:selected').val())
                    {
                        window.location="<?php echo url . '/' . $this->folder ?>/open_savers/"+$('#typeDevice_public option:selected').val()

                    }else {
                        alert('يجب اختيار الماركة')
                    }


                }


            </script>



            <br>




            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label > <span> <?php  echo $this->langControl('details') ?> </span> <span style="color: red;font-size: 14px;" id="content"></span>  </label>
                    <div id="editor">
                    <textarea  name="content" id='edit' style="margin-top: 30px;" placeholder="<?php echo $this->langControl('write_her') ?>">
                  <?php echo $result['content']  ?>
                 </textarea>

                    </div>

                </div>
            </div>

            <br>

            <div class="row">
                <div class="col">

                    <div class="row x_down">

                        <div class="col-12 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('title') ?>  </label>
                            <input   name="title" type="text"  class="form-control is-valid" id="validationServer01"  value="<?php echo $result['title']  ?>"  required/>
                        </div>
                        <div class="col-12 margin_text">

                            <br>
                            <table class="table table-bordered table-striped  ">

                                <tbody>


                                <tr>
                                    <td>

                                        <div class="form-row  align-items-center">
                                            <div class="col-auto">
                                                <label for="validationServer02">  <?php  echo $this->langControl('serial') ?>  </label>
                                            </div>

                                            <div class="col-auto">
                                                <input type="hidden"  name="serial_flag"  value="0"    >
                                                <input type="checkbox"  name="serial_flag"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($result['serial_flag'] == 1 ) echo 'checked'?>  >
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="form-row  align-items-center">
                                            <div class="col-auto">
                                                <label for="validationServer02">  <?php  echo $this->langControl('location') ?>  </label>
                                            </div>

                                            <div class="col-auto">
                                                <input type="hidden"  name="locationTag"  value="0"    >
                                                <input type="checkbox"  name="locationTag"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($result['locationTag'] == 1 ) echo 'checked'?>  >
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-row">
                                            <div class="col-auto">
                                                <label for="validationServer0active_enter_serial">  <?php  echo $this->langControl('active_enter_serial') ?>  </label>
                                            </div>

                                            <div class="col-auto">
                                                <input type="hidden"  name="enter_serial"  value="0"    >
                                                <input type="checkbox"  id="active_enter_serial" name="enter_serial"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($result['enter_serial'] == 1 ) echo 'checked'?>  >
                                            </div>
                                        </div>

                                    </td>
                                    <td>

                                        <div class="form-row">
                                            <div class="col-auto">
                                                <label for="validationServer0change_price">  <?php  echo $this->langControl('change_price_bill') ?>  </label>
                                            </div>

                                            <div class="col-auto">
                                                <input type="hidden"  name="change_price"  value="0"    >
                                                <input type="checkbox"  id="validationServer0change_price" name="change_price"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($result['change_price'] == 1 ) echo 'checked'?>  >
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                      <div class="col-auto">

                     						<label for="validationServer0stop"> ماده خدميه</label>

                                       	 	<input type="hidden"  name="is_service"  value="0"    >
                                        	<input type="checkbox"  id="is_service" name="is_service"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ( $result['is_service'] == 1 ) echo 'checked'?>  >
                                      </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                          <br>
                        </div>

                        <div class="col-12 tags_tags">
                        <label for="input-tags" class="col-sm-12 col-form-label"><span>كلمات دارجة في البحث عن المنتج</span>    </label>
                        <input type="text"  name="tags" class="form-control tags tags"  value="<?php echo $result['tags']  ?>"   data-role="tagsinput" />
                            <br><br>
                        </div>


                        <div class="col-12 tags_tags">
                        <label for="input-tags" class="col-sm-12 col-form-label"><span> باركودات بديلة </span>    </label>
                        <input type="text"  name="serial" class="form-control tags serial"  value="<?php echo $result['serial']  ?>"   data-role="tagsinput" />
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('code') ?>  </label>
                            <input   name="code" oninput="check_code(this)"   type="text"  class="form-control is-valid" id="validationServer01"  value="<?php echo $result['code']  ?>"  required/>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer01"> <?php  echo $this->langControl('point') ?>  </label>
                            <input   name="point"    type="text"  class="form-control " id="validationServer01"  value="<?php echo $result['point']  ?>"  />
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer0_latiniin"> <?php  echo $this->langControl('latiniin') ?>  </label>
                            <input   name="latiniin" type="text"  class="form-control is-valid" id="validationServer0_latiniin"  value="<?php echo $result['latiniin']  ?>"  required/>
                        </div>
						<div class="col-lg-2 col-md-3 col-sm-3 margin_text">
                            <label for="validationServer011">نسبة </label>
                            <input   name="note"    type="text"  class="form-control " id="validationServer011"  value="<?php echo $result['note']  ?>"  />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3  margin_text align-self-end">
                            <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                            <input   name="image[]" type="file"  class=""   value=""  />
                        </div>
                        <div class="col-auto  align-self-end">
                             <img id="image_device_<?php echo $result['id'] ?>" width="70px" src="<?php  echo $this->save_file . $result['img'] ?>">

                            <button type="button" class="btn btn-primary btn-sm crop_image" id="btn_crop_image_<?php echo $result['id'] ?>"   data-ids="<?php echo $result['id'] ?>"  img="<?php  echo $result['img'] ?>" data-id="<?php  echo $result['id'] ?>" data-table="<?php  echo $this->product_savers ?>"  url="<?php  echo $this->save_file . $result['img'] ?>" ><i class="fa fa-crop"></i>   <span>قص الصورة</span>   </button>

                        </div>



                        <div class="col-12 mt-5">

                            <div class="row mb-5">
                                <div class="col-lg-3">
                                    <h6>نوع المادة</h6>

                                    <?php  foreach ($cover_material as $key => $covm) {  ?>
                                        <div>
                                            <div class="custom-control custom-radio">
                                                <input  type="radio"  <?php  if ($covm['number']  == $result['cover_material'])  echo 'checked' ?>  id="cover_material0_<?php echo $key ?>" value="<?php  echo $covm['number'] ?>" name="cover_material" class="custom-control-input">
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
                                                <input  <?php  if ($type_c['number']  == $result['type_cover'])  echo 'checked' ?>  type="radio" id="type_cover0_<?php echo $key ?>" value="<?php  echo $type_c['number'] ?>" name="type_cover" class="custom-control-input">
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
                                                <input <?php  if (in_array($featc['number'],explode(',',$result['feature_cover'])) )  echo 'checked' ?>  type="checkbox" id="feature_cover0_<?php echo $key ?>" value="<?php  echo $featc['number'] ?>" name="feature_cover[]" class="custom-control-input">
                                                <label class="custom-control-label" for="feature_cover0_<?php echo $key ?>"><?php  echo $featc['number'] ?>-<?php  echo $featc['feature_cover'] ?></label>
                                            </div>
                                        </div>
                                    <?php  } ?>

                                </div>

                            </div>

                        </div>




                    </div>

                </div>
            </div>



            <br>

            <br>



            <hr>


            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary"   type="submit" name="submit" value="حفظ">
                    
                            <?php    if ($this->permit('copy_row', $this->folder)) {  ?>
                            <button  class="btn btn-warning   " onclick="copy_row(<?php  echo  $id ?>)"  type="button"  >  <i class="fa fa-clone"></i> <span>تكرار</span>  </button>

                            <script>

                                function copy_row(id) {

                                    if (confirm('هل انت متأكد؟'))
                                    {
                                        $.get("<?php  echo url.'/'.$this->folder?>/copy_row/"+id, function(data){
                                            if (data)
                                            {
                                                alert('تم التكرار')
                                                if (confirm(' هل تريد الذهاب الى العنصر المكرر '))
                                                {
                                                    window.location="<?php  echo url .'/'.$this->folder ?>/edit_product_savers/" +data
                                                } return false;

                                            }
                                        })
                                    }

                                }
                            </script>
                        <?php } ?>
                    
                    
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


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

</script>



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






<style>
    .margin_text
    {
        margin-top: 15px;
    }
    .category_div{
        background: #17a2b8;
        margin: 23px 4px;
        padding: 8px;
        color: #fff;
    }

    .code_m
    {
        margin-top: 5px;
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
    .colorProduct {
        width: 40px;
        height: 40px;
        border: 1px solid #e4e4e4;
        border-radius: 50%;
    }
</style>
<br>
<br>
<br>
<br>


<br>
<br>
<br>
<br>




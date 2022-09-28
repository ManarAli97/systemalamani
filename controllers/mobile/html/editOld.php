


<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('mobile') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                    <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $data['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit_mobile/<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label for="validationServer01"> <?php  echo $this->langControl('title') ?>  </label>
                    <input   value="<?php echo $data['title'] ?>" name="title" type="text" class="form-control " id="validationServer01"      >
                </div>
            </div>



            <br>
            <table class="table table-bordered table-striped  ">

                <tbody>

                <tr>
                    <td>

                        <div class="form-row">
                            <div class="col-auto">
                                <label for="validationServer02">  <?php  echo $this->langControl('bast_it') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="bast_it"  value="0"    >
                                <input type="checkbox"  name="bast_it"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['bast_it'] == 1 ) echo 'checked'?>  >
                            </div>
                        </div>

                    </td>

                    <td>

                        <div class="form-row  align-items-center">
                            <div class="col-auto">
                                <label for="validationServer02">  <?php  echo $this->langControl('cuts') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="cuts"  value="0"    >
                                <input type="checkbox"  onchange="special_price(this)" name="cuts"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['cuts'] == 1 ) echo 'checked'?>  >
                            </div>

                            <div class="col-auto sp_price" style="display:<?php  if ($data['cuts'] == 1 ) echo 'block'?>"  >
                                <input value="<?php echo  $data['price_cuts']  ?>"  name="price_cuts" type="text"  placeholder="سعر العرض الخاص"  class="form-control "   >
                            </div>

                        </div>
                    </td>

                </tr>

                <tr>
                    <td>
                        <div class="form-row">
                            <div class="col-auto">
                                <label for="validationServer02">  <?php  echo $this->langControl('serial') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="serial_flag"  value="0"    >
                                <input type="checkbox"  name="serial_flag"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['serial_flag'] == 1 ) echo 'checked'?>  >
                            </div>
                        </div>


                    </td>
                    <td>
                        <div class="form-row">
                            <div class="col-auto">
                                <label for="validationServer02">  <?php  echo $this->langControl('price_dollars') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="price_dollars"  value="0"    >
                                <input type="checkbox"  name="price_dollars"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['price_dollars'] == 1 ) echo 'checked'?>  >
                            </div>
                        </div>


                    </td>

                </tr>

                <tr>
                    <td>
                        <div class="form-row">
                            <div class="col-auto">
                                <label for="validationServer0locaton">  <?php  echo $this->langControl('location') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="location"  value="0"    >
                                <input type="checkbox"  name="location"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['location'] == 1 ) echo 'checked'?>  >
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
                                <input type="checkbox"  id="active_enter_serial" name="enter_serial"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['enter_serial'] == 1 ) echo 'checked'?>  >
                            </div>
                        </div>
                    </td>

                </tr>

                <tr>
                    <td>
                        <div class="form-row">
                            <div class="col-auto">
                                <label for="validationServer0stop">  <?php  echo $this->langControl('stop_product') ?>  </label>
                            </div>

                            <div class="col-auto">
                                <input type="hidden"  name="stop"  value="0"    >
                                <input type="checkbox"  id="stop" name="stop"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['stop'] == 1 ) echo 'checked'?>  >
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
                                <input type="checkbox"  id="validationServer0change_price" name="change_price"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['change_price'] == 1 ) echo 'checked'?>  >
                            </div>
                        </div>


                    </td>

                </tr>

                </tbody>
            </table>


            <br>

            <div class="form-row">
                <div class="col-auto">
                    <label for="inputState"> <?php  echo $this->langControl('categories') ?> </label>
                   <div class="form-group select_drop"  style="width: 100%" >
                        <select  name="id_cat"  id="inputState" class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                            <?php foreach ($data_cat as $rowCat) {    ?>
                                <option   value="<?php echo $rowCat['id'] ?>"  <?php  if ($rowCat['id']==$data['id_cat'])  echo 'selected' ?> ><?php echo $rowCat['title'] ?></option>
                            <?php   } ?>

                        </select>
                    </div>

                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                        width: 392px !important;
                    }
                </style>
            </div>

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

            <div class="description">
                <br>
                <label for="word_count">   <span> الشرح المختصر</span> //// <span>عدد الكلمات:  </span> <span id="display_count">0</span> كلمة.    المتبقي: <span id="word_left">100</span>  </label>
                <textarea class="form-control" name="description" id="word_count"  rows="5"><?php echo $data['description']  ?></textarea>

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

            <fieldset style="border: 1px solid #b9bbbd;padding: 13px 10px;">
                <legend style="font-size: 16px; border: 1px solid #b9bbbd;border-radius: 15px;width: auto;padding: 0 15px;" >  مواصفات </legend>
                <?php  if (!empty($specifications)) { ?>
                <div class="row">
                    <?php foreach ($specifications as $specific) {   ?>
                        <div class="col-lg-4 col-md-6" style="margin-bottom: 30px">

                            <div style="margin-bottom: 7px;font-weight: bold;">
                                <?php  echo $specific['title'] ?>
                            </div>
                            <?php  foreach ($specific['items'] as $key => $itms ) {  ?>
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"  value="<?php  echo $itms['id']?>" id="customCheckbox_<?php  echo  $itms['id']  ?>"   name="specifications[]"  <?php if (in_array($itms['id'],$specifications_id))  echo 'checked'?>   class="custom-control-input">
                                        <label class="custom-control-label" for="customCheckbox_<?php  echo  $itms['id']  ?>">  <?php  echo $itms['item']?> </label>
                                    </div>
                                </div>
                            <?php  }  ?>

                        </div>

                    <?php } ?>

                </div>
                <?php  } else{  ?>
                <input type="hidden"  value=""   name="specifications[]" class="custom-control-input">
                <?php } ?>


            </fieldset>

            <br>



            <div class="form-group row">
                <label for="input-tags" class="col-sm-12 col-form-label"><span>  كلمات دارجة في البحث عن المنتج </span> <span style="color: red;font-size: 14px;" id="tags"></span>    </label>
                <div class="col-sm-12 tags_tags">
                    <input type="text"  name="tags" class="form-control tags" id="input-tags"  value="<?php echo $data['tags'] ?>" data-role="tagsinput" />
                </div>
            </div>


            <br>


            <div class="row">



                <div class="col-auto">
                    <label for="model">    حدد نوع الجهاز   (لربط الاكسسوارات والحافظات مع الجهاز) </label>
                    <div class="form-group select_drop"   >
                        <select    id="framework" name="id_device"   class="form-control"  required  >

                            <?php  foreach ($device_name as $device) {   ?>
                                <option value="<?php echo $device['id'] ?>"  <?php if ( $device['id'] == $data['id_device']  )  echo 'selected'?> >   <?php echo $device['name_device'] ?>  </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <style>
                    .multiselect-container.dropdown-menu.show {
                        height: 500px !important;
                        overflow-x: auto !important;
                        background: white;
                    }
                    span.input-group-addon {
                        border: 1px solid;
                        padding: 5px 4px;
                        color: #ced4da;
                    }
                    button.btn.btn-default.multiselect-clear-filter {
                        border: 1px solid !important;
                        margin-left: 7px;
                        color: #ced4da;
                    }
                </style>
                <script>



                    $(document).ready(function(){
                        $('#framework').multiselect({
                            nonSelectedText: 'حدد بعض الاقسام لعرض موادها',
                            enableFiltering: true,
                            enableCaseInsensitiveFiltering: false,
                            buttonWidth:'400px',



                        });

                    });
                </script>




<!--             -->
<!--             -->
<!--                <div class="col-lg-6 col-sm-12" style="margin-bottom: 30px;position: relative">-->
<!--                    <label>تحديد قسم لواسق الجهاز</label>-->
<!--                    <input class="form-control" id="name_accessories" value="--><?php //echo $data['name_accessories'] ?><!--" onkeyup="get_name_accessories(this)" name="name_accessories">-->
<!--                    <input class="form-control"  type="hidden" id="id_accessories"  value="--><?php //echo $data['id_accessories'] ?><!--" name="id_accessories">-->
<!---->
<!--                    <div class="result_name_accessories"><div class="list-group"></div></div>-->
<!---->
<!--                </div>-->
<!--                <div class="col-lg-6 col-sm-12">-->
<!--                    <label>تحديد قسم   حافظات الجهاز   </label>-->
<!---->
<!--                    <input class="form-control" id="name_savers" value="--><?php //echo $data['name_savers'] ?><!--" onkeyup="get_name_savers(this)" name="name_savers">-->
<!--                    <input class="form-control"  type="hidden" id="id_savers"  value="--><?php //echo $data['id_savers'] ?><!--" name="id_savers">-->
<!---->
<!--                    <div class="result_name_savers"><div class="list-group"></div></div>-->
<!--                </div>-->
<!--                -->
<!--                -->

            </div>

            
            <script>
                

                function get_name_accessories(e) {
                    if ($(e).val())
                    {
                        $.get( "<?php echo url .'/'.$this->folder ?>/name_accessories/",{q:$(e).val()}, function( dataacc ) {
                            $( ".result_name_accessories" ).show()
                            if (dataacc)
                            {
                                $( ".result_name_accessories .list-group" ).empty().show().html( dataacc );

                            }else
                            {
                                $( ".result_name_accessories .list-group" ).text('لا يوجد شي')
                            }
                        });
                    }else {
                        $( ".result_name_accessories .list-group" ).empty() ;
                        $( ".result_name_accessories" ).hide()
                    }

                }

                function thisCatAcc(d) {

                    $('#id_accessories').val($(d).data('id'));
                    $('#name_accessories').val($(d).data('title'));
                    $( ".result_name_accessories .list-group" ).empty() ;
                    $( ".result_name_accessories" ).hide()
                }


                function get_name_savers(s) {
                    if ($(s).val())
                    {
                        $.get( "<?php echo url .'/'.$this->folder ?>/name_savers/",{q:$(s).val()}, function( datasav) {
                            $( ".result_name_savers" ).show()
                            if (datasav)
                            {
                                $( ".result_name_savers .list-group" ).empty().show().html( datasav );

                            }else
                            {
                                $( ".result_name_savers .list-group" ).text('لا يوجد شي')
                            }
                        });
                    }else {
                        $( ".result_name_savers .list-group" ).empty() ;
                        $( ".result_name_savers" ).hide()
                    }

                }

                function thisCatSav(d) {

                    $('#id_savers').val($(d).data('id'));
                    $('#name_savers').val($(d).data('title'));
                    $( ".result_name_savers .list-group" ).empty() ;
                    $( ".result_name_savers" ).hide()
                }


            </script>

            <style>
                .result_name_accessories ,.result_name_savers
                {
                    position: absolute;
                    z-index: 15000;
                    width: 80%;
                    max-height: 200px;
                    overflow: auto;
                }


            </style>


            <br>

            <div class="row">
                <div class="col">
                    <?php  foreach ($color as $key => $c_data) {  ?>
                    <div class="row x_down removeRow_<?php  echo $c_data['id'] ?>">



                        <div class="col-lg-3 col-md-3 col-sm-3 align-self-end">
                            <label for="validationServer01"> <?php  echo $this->langControl('name_color') ?>  </label>
                            <input   name="name_color[<?php echo $c_data['id'] ?>]" type="text"   class="form-control " id="validationServer01"  value="<?php echo $c_data['color'] ?>"  required/>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 align-self-end">
                            <label for="validationServer0_color"> <?php  echo $this->langControl('color') ?>  </label>
                            <input   name="color[<?php echo $c_data['id'] ?>]" type="color"  class="form-control " id="validationServer0_color"  value="<?php echo $c_data['code_color'] ?>"  required/>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3  align-self-end">
                            <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                            <input   name="image[<?php echo $c_data['id'] ?>]" type="file"     />
                        </div>



                        <div class="col-auto  align-self-end">

                            <img id="image_device_<?php echo $c_data['id'] ?>" width="70px" src="<?php  echo $this->save_file . $c_data['img'] ?>">

                            <button type="button" class="btn btn-primary btn-sm crop_image" id="btn_crop_image_<?php echo $c_data['id'] ?>"   data-ids="<?php echo $c_data['id'] ?>"  img="<?php  echo $c_data['img'] ?>" data-id="<?php  echo $c_data['id'] ?>" data-table="<?php  echo $this->color ?>"  url="<?php  echo $this->save_file . $c_data['img'] ?>" ><i class="fa fa-crop"></i>   <span>قص الصورة</span>   </button>

                        </div>
                        <div class="col-12">

                                <button type="button" class="btn add_new_sub_row" onclick="xxx(<?php  echo $c_data['id'] ?>,'first_<?php echo $key ?>')">  <i class="fa fa-plus-circle"></i> </button>

                            <div class="new_sub_row_first_<?php echo $key ?>">
                                <?php  foreach ($c_data['code'] as $index => $c_code) { ?>

                                    <div class="row code_m removeRow_Code_<?php  echo $c_code['id'] ?>">

                                <div class="col-lg-3 ">
                                   <?php  echo $this->langControl('code') ?>
                                    <input    name="code[<?php  echo $c_data['id'] ?>][<?php  echo $c_code['id'] ?>]" type="text"  class="form-control " id="validationServer0_code"  placeholder="<?php  echo $this->langControl('code') ?>" value="<?php  echo $c_code['code'] ?>" required />
                                </div>
                                <div class="col-lg-3 ">
                                   <?php  echo $this->langControl('point') ?>
                                    <input    name="point[<?php  echo $c_data['id'] ?>][<?php  echo $c_code['id'] ?>]" type="text"  class="form-control " id="validationServer0_point"  placeholder="<?php  echo $this->langControl('point') ?>" value="<?php  echo $c_code['point'] ?>"  />
                                </div>

                                <div class="col-lg-3 ">
                                   <?php  echo $this->langControl('size') ?>
                                    <input    name="size[<?php  echo $c_data['id'] ?>][<?php  echo $c_code['id'] ?>]" type="text"  class="form-control " id="validationServer0_code"  placeholder="<?php  echo $this->langControl('size') ?>" value="<?php  echo $c_code['size'] ?>" required />
                                </div>

                           <div class="col-lg-12">
                                <div class="row">
                                    
                                        <div class="col-12 tags_tags">
                                            باركودات بديلة
                                            <input    name="serial[<?php  echo $c_data['id'] ?>][<?php  echo $c_code['id'] ?>]" type="text"  class="form-control tags serial"     data-role="tagsinput" id="validationServer0_code"   value="<?php  echo $c_code['serial'] ?>"  />
                                        </div>


                                </div>
                                </div>



                                <?php  if ($index != 0) {  ?>
                                    <div class="col-auto align-self-end removeRow_Code_<?php  echo $c_code['id'] ?>">
                                        <button type="button" class="btn remove_sub_row" onclick="remove_sub_row_database(<?php  echo $c_code['id'] ?>)"> <i class="fa  fa-times-circle"></i> </button>
                                    </div>
                                    <?php  }  ?>
                                   </div>

                                <?php  }  ?>
                            </div>

                        </div>
                        <?php  if ($key != 0) {  ?>
                        <button class="btn remove_div"  type="button" onclick="remove_row_database(<?php  echo $c_data['id'] ?>)"> <i class="fa  fa-times-circle"></i> </button>
                    <?php  }  ?>
                </div>

                <?php  }  ?>
                    <div class="blockPs AddButton">
                    </div>

                    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add')?> <i class="fa fa-plus-circle"></i> </a>


                </div>
            </div>
            <br>
            <br>





            <div class="form-row">
                <div class="col-auto">
                    <label for="validationServer02"> <?php  echo $this->langControl('date') ?>  </label>
                    <input name="date"  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"   value="<?php echo  date('Y-m-d\TH:i:s', $data['date'])  ?>"  class="form-control " id="validationServer02" >
                </div>
            </div>



            <hr>
            <br>
            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary" id="save_btn_card"  type="submit"  value="<?php  echo $this->langControl('save') ?>" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .sp_price
    {
        display: none;
    }

</style>
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

    function special_price(e) {
        var vis=$(e).is( ':checked' )? 1:0;

        if (vis === 1)
        {
            $('.sp_price').show('fast');

        }
        else
        {
            $('.sp_price').hide('fast');
        }

    }


    var name_country=[];
    function xx(x)
    {
        $(".custom-select option[value="+x+"]").each(function() {
            $(this).css('display','none');
        });
        name_country.push(x);
    }

    var upxcol;

     count = 1;

    $('.addPs').click(function() {

        count += 1;
        upxcol = 'new'+count;
        id_div = 'id_r_'+count;
        sub_add = 'sub_add_'+count;

        $('.blockPs:last').before(`<div class="blockPs">
                             <div  id="${id_div}" class="row x_down">

                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label for="validationServer01"> <?php  echo $this->langControl('name_color') ?>  </label>
                                <input   name="name_color[newx${count}]" type="text"  class="form-control " id="validationServer01"  value=""  required/>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label for="validationServer0_color"> <?php  echo $this->langControl('color') ?>  </label>
                                <input   name="color[newx${count}]" type="color"  class="form-control " id="validationServer0_color"  value=""  required/>
                            </div>


                            <div class="col-lg-3 col-md-3 col-sm-3  align-self-end">
                                   <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                                <input   name="image[newx${count}]" type="file"    id="validationServer0_image"  value=""  required/>
                            </div>


                            <div class="col-12 new_sub_row_${sub_add}">
                              <div class="col-auto align-self-end">
                                <button type="button" class="btn add_new_sub_row"  onclick="xxx(${count},'${sub_add}')">  <i class="fa fa-plus-circle"></i> </button>
                            </div>
                                <div class="row">
                                   <div class="col-lg-3 code_m">
                                        <input    name="code[newx${count}][new0]" oninput="check_code(this)"   type="text"  class="form-control " id="validationServer0_code"  placeholder="<?php  echo $this->langControl('code') ?>" value="" required />
                                    </div>
                                   <div class="col-lg-3 code_m">
                                        <input    name="point[newx${count}][new0]"     type="text"  class="form-control " id="validationServer0_point"  placeholder="<?php  echo $this->langControl('point') ?>" value=""  />
                                    </div>
                                    <div class="col-lg-3 code_m">
                                        <input    name="size[newx${count}][new0]" type="text"  class="form-control " id="validationServer0_code"  placeholder="<?php  echo $this->langControl('size') ?>" value="" required />
                                    </div>

                                        <div class="col-12">
                                           <div class="row">
                                                 <div class="col-lg-12 tags_tags ">

                                           <label for="input-tags" class="col-sm-12 col-form-label"><span> باركودات بديلة </span>    </label>

                                           <input type="text"  name="serial[newx${count}][new0]" class="form-control tags serial"     data-role="tagsinput" />
                                       </div>

                                           </div>
                                           </div>




                             </div>
                           </div>
                         <button class="btn remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </button>
                       </div>
                       </div>`);

        for (i=0;i<name_country.length;i++)
        {
            $(".custom-select.new_select_"+count+" option[value="+name_country[i]+"]").css('display','none');

        }
        tags()
    });

    function remove_div(id) {
        $(id).remove();
    }
    sub_count=0;
    function xxx(x,class_is) {
        sub_count += 1;
        $('.new_sub_row_'+class_is).append(`

               <div class="row code_m align-items-end remove_sub_row_${sub_count}">

                   <div class="col-lg-3 ">
                       <?php  echo $this->langControl('code') ?>
                    <input   name="code[${x}][new${sub_count}]" oninput="check_code(this)"   type="text"  class="form-control " id="validationServer02" placeholder="<?php  echo $this->langControl('code') ?>" value="" required />
                   </div>
                   <div class="col-lg-3 ">
                       <?php  echo $this->langControl('point') ?>
                    <input   name="point[${x}][new${sub_count}]"    type="text"  class="form-control " id="validationServer02" placeholder="<?php  echo $this->langControl('point') ?>" value=""  />
                   </div>

                   <div class="col-lg-3 ">
                       <?php  echo $this->langControl('size') ?>
                    <input   name="size[${x}][new${sub_count}]" type="text"  class="form-control " id="validationServer02" placeholder="<?php  echo $this->langControl('size') ?>" value="" required />
                   </div>


                   <div class="col-auto">
                   <button type="button" class="btn remove_sub_row" onclick="remove_sub_row(${sub_count})"> <i class="fa  fa-times-circle"></i> </button>
                    </div>


                            <div class="col-12 tags_tags">
                  
                                  <label for="input-tags" class="col-sm-12 col-form-label"><span> باركودات بديلة </span>    </label>
                                 <input type="text"  name="serial[${x}][new${sub_count}]" class="form-control tags serial"     data-role="tagsinput" />

                               </div>




                </div>
                   `)
        tags()
    }


    function remove_sub_row(id) {
        $('.remove_sub_row_'+id).remove();
    }

    function remove_row_database(id) {
        $.get( "<?php echo url.'/'.$this->folder ?>/remove_row_database/"+id, function( data ) {
            $('.removeRow_'+id).remove();
        });
    }

    function remove_sub_row_database(id) {
        $.get( "<?php echo url.'/'.$this->folder ?>/remove_sub_row_database/"+id, function( data ) {
            $('.removeRow_Code_'+id).remove();
        });
    }


</script>



<style>

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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> اغلاق </button>

                </div>
            </div>
        </div>
    </div>

<?php  } ?>





<br>
<br>
<br>
<br>




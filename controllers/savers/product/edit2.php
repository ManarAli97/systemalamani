


<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_product_savers"><?php  echo $this->langControl('product_savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $data['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit_product_savers2/<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
                    <input name="title" class="form-control"  id="validationServer01"  value="<?php  echo $data['title']  ?>" type="text">
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="col-auto">
                    <label for="validationServer02">  <?php  echo $this->langControl('bast_it') ?>  </label>
                </div>

                <div class="col-auto">
                    <input type="hidden"  name="bast_it"  value="0"    >
                    <input type="checkbox"  name="bast_it"  value="1" data-toggle="toggle" datax-stylex="iosx" data-size="small"   <?php  if ($data['bast_it'] == 1 ) echo 'checked'?>  >
                </div>
            </div>


            <br>


            <div class="form-row">
                <div class="col-auto">
                    <label for="validationServer0code">  <span>   رمز المادة </span>  <span style="color: red;font-size: 14px;" id="code"> </span> </label>
                    <input value="<?php echo  $data['code']  ?>"  name="code" type="text" class="form-control is-valid" id="validationServer0code"  >
                </div>
            </div>

            <br>


            <div class="form-row">
                <div class="col-auto">
                    <label for="validationServer0code">  <span>    نقاط المادة</span>  <span style="color: red;font-size: 14px;" id="point"> </span> </label>
                    <input value="<?php echo  $data['point']  ?>"  name="point" type="text" class="form-control is-valid" id="validationServer0code"  >
                </div>
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


            <br>

            <br>


            لون المادة في كرستال
            <div class="row">
                <div class="col">
                    <?php  foreach ($color as $key => $c_data) {  ?>
                        <div class="row x_down removeRow_<?php  echo $c_data['id'] ?>">



                            <div class="col-lg-3 col-md-3 col-sm-3 align-self-end">
                                <label for="validationServer01"> <?php  echo $this->langControl('name_color') ?>  </label>
                                <input   name="name_color[<?php echo $c_data['id'] ?>]" type="text"   class="form-control is-valid" id="validationServer01"  value="<?php echo $c_data['color'] ?>"  required/>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 align-self-end">
                                <label for="validationServer0_color"> <?php  echo $this->langControl('color') ?>  </label>
                                <input   name="color[<?php echo $c_data['id'] ?>]" type="color"  class="form-control is-valid" id="validationServer0_color"  value="<?php echo $c_data['code_color'] ?>"  required/>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3  align-self-end">
                                <label style=" width: 100%;" for="validationServer0_image"> <?php  echo $this->langControl('image') ?>  </label>
                                <input   name="image[<?php echo $c_data['id'] ?>]" type="file"     />
                            </div>



                            <div class="col-auto  align-self-end">
                                <img id="image_device_<?php echo $c_data['id'] ?>" width="70px" src="<?php  echo $this->save_file . $c_data['img'] ?>">

                                <button type="button" class="btn btn-primary btn-sm crop_image" id="btn_crop_image_<?php echo $c_data['id'] ?>"   data-ids="<?php echo $c_data['id'] ?>"  img="<?php  echo $c_data['img'] ?>" data-id="<?php  echo $c_data['id'] ?>" data-table="<?php  echo $this->color ?>"  url="<?php  echo $this->save_file . $c_data['img'] ?>" ><i class="fa fa-crop"></i>   <span>قص الصورة</span>   </button>

                            </div>


                            <?php if ( $this->checkColor($c_data['color'])) {   ?>

                                <input type="hidden" name="typeDevice[<?php echo $c_data['id'] ?>]" value="0">
                                <?php  } else { ?>
                            <div class="col-12">

                                <div class="category_div">

                                <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="brand"> اختر الماركة </label>
                                    <select class="custom-select"   id="brandx<?php  echo $c_data['id'] ?>"   onchange="brand<?php  echo $c_data["id"] ?>()"  >
                                        <?php foreach ($category as $keyx => $catg) {   ?>
                                            <option   <?php if ($keyx == 0 )  echo 'selected'?>  value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                                        <?php  } ?>

                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="nameDevice"> اختر السلسة </label>
                                    <select onchange="typeDevice<?php  echo $c_data["id"] ?>()" class="custom-select"   id="nameDevice<?php  echo $c_data['id'] ?>" >

                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="typeDevice"> اختر نوع الجهاز </label>
                                    <select   class="custom-select"  name="typeDevice[<?php echo $c_data['id'] ?>]" id="typeDevicex<?php  echo $c_data['id'] ?>" required>

                                    </select>
                                </div>
                            </div>
                         </div>

                                <script>

                                    brand<?php  echo $c_data["id"] ?>();
                                    function brand<?php  echo $c_data["id"] ?>() {

                                        $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice/" + $('#brandx<?php  echo $c_data["id"] ?> option:selected').val(), function (data) {
                                            $('#nameDevice<?php  echo $c_data["id"] ?>').html(data);

                                            if (data)
                                            {
                                                typeDevice<?php  echo $c_data["id"] ?>($('#brandx<?php  echo $c_data["id"] ?> option:selected').val())
                                            }
                                        });
                                    }

                                    function typeDevice<?php  echo $c_data["id"] ?>() {

                                        $.get("<?php echo url . '/' . $this->folder ?>/typeDevice/"+$('#nameDevice<?php  echo $c_data["id"] ?> option:selected').val(), function (data) {
                                            $('#typeDevicex<?php  echo $c_data["id"] ?>').html(data);

                                        });
                                    }




                                </script>



                        </div>

                            <?php } ?>


                            <?php  if ($key != 0) {  ?>
                                <button class="btn remove_div"  type="button" onclick="remove_row_database(<?php  echo $c_data['id'] ?>)"> <i class="fa  fa-times-circle"></i> </button>
                            <?php  }  ?>
                        </div>



                    <?php  }  ?>


                </div>
            </div>
            <br>

            <div class="row    justi fy-conte nt-md-c enter">
                <?php if(!empty($get_file)) {  ?>
                    <div class="col-auto" id="rem_img_<?php  echo $data['id']  ?>">

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

            <hr>


            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary" type="submit" name="submit" value="حفظ">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


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




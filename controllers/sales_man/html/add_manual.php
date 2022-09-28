


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('sales_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/add_manual" method="post" enctype="multipart/form-data">

            <?php   if ($sendProd) { ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
              تمت اضافة النقص بنجاح وتحويلة الى مدير المشتريات.
                <a type="button" href="<?php  echo url ?>/home" class="close"  >
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <?php   }  ?>

            <div class="row">
                <div class="col">

                    <div class="row x_down" id="expand_menu">

                            <select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)" required >
                                <option value="" disabled selected>  اختر الفئة الرئيسية  </option>
                            <?php  foreach ($categ as $cg) {   ?>
                                <option value="<?php  echo $cg ?>" > <?php  echo $this->langControl($cg) ?></option>
                            <?php  } ?>
                            </select>

                    </div>

                    <div class="row x_down">




                        <div class="col-sm-12 col-mb-6 col-lg-4">

                            <label for="title">  <?php  echo $this->langControl('region')?> </label>
                            <select name="region" class="custom-select " id="inlineFormCustomSelect" >
                                <option disabled selected  value=""> نوع المشتريات  </option>
                                <?php  foreach ($region as $r ) { ?>
                                    <option value="<?php echo $r['id'] ?>"><?php echo $r['title'] ?></option>
                                <?php  } ?>
                            </select>
                            <br>
                            <br>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer02">  اسم المادة   </label>
                            <input    name="item" type="text" class="form-control is-valid" id="validationServer02"  >
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="code">  الكود </label>
                            <input   name="code" type="text"  class="form-control is-valid" id="code"  value=""   />
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="color">  اسم اللون </label>
                            <input   name="color" type="text"  class="form-control is-valid" id="color"  value=""   />
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="price">  اخر سعر شراء </label>
                            <input   name="price" type="text"  class="form-control is-valid" id="price"  value=""   />
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="quantity"> الكمية المقترحة </label>
                            <input   name="quantity" type="number"  class="form-control is-valid" id="quantity"  value=""   />
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="note"> ملاحظة  </label>
                                <textarea rows="1" placeholder="ملاحظة"  name="note"   id="note" class="form-control" ></textarea>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="imgInp">    <span>  رفع صورة</span> <span> (jpg, jpeg,png) </span> </label>
                            <br>
                            <input   name="image" type="file"   id="imgInp"     />
                        </div>
                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <img  style="width: 200px" id="blah"     />
                        </div>

                    </div>

                </div>
            </div>

            <hr>

            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary"  value="حفظ"  type="submit" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });


    function mainCatgHtmlx(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url . '/' . $this->folder ?>/getMainCatDB/" +value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                alert('حدث خطاء في الاختيار يرجى تحديث الصفة او المحاولة لاحقا')
            }
        });
    }


    function sub_catgs(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;
        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
    }



    function sub_catgs2(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs2/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
    }



</script>



<style>

    .list_menu_categ
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }
    .list_menu_categ:focus
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }


    .x_down div
    {
        margin-bottom: 30px;
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
        padding: 22px;
        padding-bottom: 15px;
        background: #eeeff08a;
    }
</style>



<br>
<br>




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


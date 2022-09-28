


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('delegate_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/add_manual" method="post" enctype="multipart/form-data">


            <div class="row">
                <div class="col">

                    <div class="row x_down">

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer01">  القسم   </label>
                            <input   name="category[]" type="text" class="form-control is-valid" id="validationServer01"  required>
                        </div>
                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer02">  اسم المادة   </label>
                            <input    name="item[]" type="text" class="form-control is-valid" id="validationServer02"  required>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="code">  الكود </label>
                            <input   name="code[]" type="text"  class="form-control is-valid" id="code"  value=""   />
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="color">  اسم اللون </label>
                            <input   name="color[]" type="text"  class="form-control is-valid" id="color"  value=""  required/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="price">    سعر الشراء </label>
                            <input   name="price[]" type="text"  class="form-control is-valid" id="price"  value=""  required/>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="sale_quantity">  الكمية التي تم شراوها  </label>
                            <input   name="sale_quantity[]" type="text"  class="form-control is-valid" id="sale_quantity"  value=""  required/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="date_purchases">  تاريخ الشراء </label>
                            <input   name="date_purchases[]" type="date"  class="form-control is-valid" id="date_purchases"  value=""  required/>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="note_d"> ملاحظة  </label>
                                <textarea rows="1" placeholder="ملاحظة"  name="note_d[]"   id="note_d" class="form-control" ></textarea>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="image">    <span>  رفع صورة</span> <span> (jpg, jpeg,png) </span> </label>
                            <br>
                            <input   name="image[]" type="file"   id="image"     required/>
                        </div>

                    </div>

                    <div class="blockPs AddButton">
                    </div>

                    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add')?> <i class="fa fa-plus-circle"></i> </a>


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

<style>
    .sp_price
    {
        display: none;
    }

</style>
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


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer01">  القسم   </label>
                            <input    name="category[]" type="text" class="form-control is-valid" id="validationServer01" required >
                        </div>
                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer02">  اسم المادة   </label>
                            <input    name="item[]" type="text" class="form-control is-valid" id="validationServer02"  required >
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="code">  الكود </label>
                            <input   name="code[]" type="text"  class="form-control is-valid" id="code"  value=""  required/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="color">  اسم اللون </label>
                            <input   name="color[]" type="text"  class="form-control is-valid" id="color"  value=""  required/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="price">  اخر سعر شراء </label>
                            <input   name="price[]" type="text"  class="form-control is-valid" id="price"  value=""  required/>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="quantity">  الكمية  المطلوبة  </label>
                            <input   name="quantity[]" type="text"  class="form-control is-valid" id="quantity"  value=""  required/>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="note"> ملاحظة  </label>
                                <textarea rows="1" placeholder="ملاحظة"  name="note[]"   id="note" class="form-control" ></textarea>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="image">   <span>  رفع صورة</span> <span> (jpg, jpeg, png) </span> </label>
                            <br>
                            <input   name="image[]" type="file"   id="image"     required/>
                        </div>


                         <button class="btn remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </button>
                       </div>
                       </div>`);

    });

    function remove_div(id) {
        $(id).remove();
    }


</script>



<style>

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
        padding-bottom: 22px;
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


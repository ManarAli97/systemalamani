


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('sales_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add_shortfalls') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
<form  action="<?php  echo url .'/'.$this->folder ?>/add_by_category/<?php echo $id  .'/'. $model?>" method="post"  enctype="multipart/form-data">

    <?php   if ($sendProd) { ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            تمت اضافة النقص بنجاح وتحويلة الى مدير المشتريات.
            <a type="button" href="<?php  echo url ?>/home" class="close"  >
                <span aria-hidden="true">&times;</span>
            </a>
        </div>

    <?php   }  ?>
<div class="row">
    <div class="col-12">
        <label for="title">  مسار الفئات </label>
        <label     class="form-control"  ><?php  echo   $cat_link ?></label>
            <br>
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
            <input    name="item" type="text" class="form-control is-valid" id="validationServer02"  required>
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
            <input   name="price" type="text"  class="form-control is-valid" id="price"  value=""  required />
        </div>



        <div class="col-sm-12 col-mb-6 col-lg-4">
            <label for="quantity"> الكمية المطلوبة </label>
            <input   name="quantity" type="number"  class="form-control is-valid" id="quantity"  value=""  required />
        </div>


        <div class="col-sm-12 col-mb-6 col-lg-4">
            <label for="note"> ملاحظة  </label>
            <textarea rows="1" placeholder="ملاحظة"  name="note"   id="note" class="form-control" ></textarea>
        </div>


        <div class="col-sm-12 col-mb-6 col-lg-4">
            <label for="image">    <span>  رفع صورة</span> <span> (jpg, jpeg,png) </span> </label>
            <br>
            <input   name="image" type="file"   id="image"     required/>
        </div>

    </div>

</div>




    <hr>
    <div class="row justify-content-center">
        <div class="col-auto">
            <input type="submit" name="submit" class="btn btn-primary" value="اضافة للنواقص">
        </div>
    </div>

</form>

<br>
<br>
<br>
<br>
<br>

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
<br>











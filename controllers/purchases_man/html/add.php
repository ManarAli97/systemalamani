


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchases_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add_shortfalls') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
<form  action="<?php  echo url .'/'.$this->folder ?>/add/<?php echo $id  .'/'. $model?>" method="post">

    <div class="row">
        <div class="col-12">
            <label for="title">  مسار الفئات </label>
            <label     class="form-control"  ><?php  echo   $cat_link ?></label>
            <br>
        </div>


        <div class="col-12">
            <label for="title">   اسم الجهاز  </label>
            <label  class="form-control"   ><?php  echo $result['title']?></label>
            <br>
        </div>


        <div class="col-auto">

            <label for="title">  <?php  echo $this->langControl('region')?> </label>
            <select name="region" class="custom-select mr-sm-4" id="inlineFormCustomSelect" required>
                <option disabled selected  value=""> نوع المشتريات  </option>
                <?php  foreach ($region as $r ) { ?>
                    <option value="<?php echo $r['id'] ?>"><?php echo $r['title'] ?></option>
                <?php  } ?>
            </select>
            <br>
            <br>
        </div>

        <div class="col-12">
            <?php  foreach ($g_c_content as $key => $c_data) {  ?>
                <div class="row align-items-center x_down removeRow_<?php  echo $c_data['id'] ?>">





                    <div class="col-auto align-self-center">
                        <div class="form-group" style="margin: 0;padding: 0;    margin-top: 37px;">
                            <input type="checkbox"  checked   name="selected[<?php echo $c_data['id'] ?>]" value="<?php echo $c_data['id'] ?>"  onchange="this_required(this,<?php echo $c_data['id'] ?>)"  id="exampleCheck1">
                        </div>
                    </div>


                    <div class="col-lg-2 col-md-2 col-sm-2 align-self-end">
                        <label for="validationServer01"> <?php  echo $this->langControl('name_color') ?>  </label>
                        <label  class="form-control"   ><?php echo $c_data['color'] ?></label>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 align-self-end">
                        <label for="validationServer01">  الكود  </label>
                        <label  class="form-control"   ><?php echo $c_data['code'] ?></label>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 align-self-end">
                        <label for="validationServer0_color"> الكمية الموجودة </label>
                        <label  class="form-control"   ><?php echo $c_data['quantity'] ?></label>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 align-self-end">
                        <label for="validationServer0_color"> اخر سعر شراء </label>
                        <input   type="text"  name="price"  class="form-control is-valid"   id="last_price_<?php echo $c_data['id'] ?>"  value=""  />
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 align-self-end">
                        <label for="validationServer0_color">  الكمية المقترحة للطلب  </label>
                        <input   name="quantity" type="number"  class="form-control is-valid" id="quantity_<?php echo $c_data['id'] ?>"   value=""     />
                    </div>

                    <div class="col-auto  align-self-end">
                        <img width="70px" src="<?php  echo $this->save_file . $c_data['img'] ?>">
                    </div>

                    <div class="col-10">
                        <br>
                        <div class="form-group form-check">
                            <textarea  placeholder="ملاحظة"  name="note"   class="form-control" ></textarea>
                        </div>

                    </div>

                </div>

            <?php  }  ?>



        </div>
    </div>

    <hr>
    <div class="row justify-content-center">
        <div class="col-auto">
            <input type="submit" name="submit" class="btn btn-primary" value="اضافة للنواقص">
        </div>
    </div>

</form>


<script>




    function this_required(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;

        if (vis===1)
        {
            $('#last_price_'+id).attr('required','required') ;
            $('#quantity_'+id).attr('required','required') ;
        }else
        {
            $('#last_price_'+id).removeAttr('required') ;
            $('#quantity_'+id).removeAttr('required') ;
        }

    }



</script>

<br>
<br>
<br>
<br>
<br>

<style>
    @supports (zoom:2) {
        input[type="radio"],  input[type=checkbox]{
            zoom: 2;
        }
    }
    @supports not (zoom:2) {
        input[type="radio"],  input[type=checkbox]{
            transform: scale(2);
            margin: 15px;
        }
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

    label.form-control
    {
        background:ghostwhite;
    }

</style>





<br>
<br>
<br>











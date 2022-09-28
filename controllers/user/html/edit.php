<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url .'/'.$this->folder?>/group"><?php  echo $this->langControl('group_user') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php  echo $this->langControl('edit')?>  </li>
                <li class="breadcrumb-item active" aria-current="page"> <?php  echo $result['username'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="container ">
    <div class="row justify-content-md-center ">
        <div class="col-10">
            <h5>الاعضاء</h5>
<hr>
<form method="post" action="<?php echo url?>/user/edit/<?php echo $result['id'] ?>">

<div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label">اسم المستخدم </label>
    <div class="col-10">
        <input class="form-control" type="text"  value="<?php echo $result['username'] ?>" name="username" id="example-text-input">
    </div>
</div>


<div class="form-group row">
    <label for="example-password-input" class="col-2 col-form-label">كلمة المرور</label>
    <div class="col-10">
        <input class="form-control" type="password" name="password"  id="example-password-input">
    </div>
</div>

<div class="form-group row">
    <label for="inlineFormCustomSelect" class="col-2 col-form-label">الدور</label>
    <div class="col-10">
        <select name="role"  class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">

            <option value="admin" <?php  if ($result['role'] == 'admin') { echo 'selected';} ?>>admin</option>
            <option value="owner"  <?php  if ($result['role'] == 'owner') { echo 'selected';} ?>>Owner</option>
        </select>
    </div>
</div>


    <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label"> رقم الموظف </label>
        <div class="col-10">
            <input class="form-control" type="number"  value="<?php echo $result['number'] ?>" name="number" id="example-text-input">
        </div>
    </div>



    <div class="form-group row">
    <label for="inlineFormCustomSelect" class="col-2 col-form-label">
        المجموعة
    </label>
    <div class="col-10">
         <select name="idGroup" class="custom-select mb-2 mr-sm-2 mb-sm-0" >
            <?php foreach ($group as $dropGroup){  ?>
                <option value="<?php echo $dropGroup['id'] ?>" <?php echo $dropGroup['selected'] ?> ><?php echo $dropGroup['name'] ?></option>
            <?php } ?>

        </select>
    </div>
</div>


    <div class="form-group row">
    <label for="inlineFormCustomSelect" class="col-2 col-form-label">
        تحديد الطابعة :
    </label>
    <div class="col-10">
        <select name="print" id="print"   class="custom-select menu_user mb-2 mr-sm-2 mb-sm-0" >

            <option value="">افتراضي</option>

            <?php  foreach ($print_devices as $pd ) {  ?>
                <option <?php if ($result['print'] == $pd['title'])  echo  'selected' ?>  value="<?php echo $pd['title'] ?>"><?php echo $pd['title'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>


    <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label"> عدد النسخ </label>
        <div class="col-10">
            <input class="form-control" type="number"  value="<?php echo $result['number_copy'] ?>" name="number_copy" id="example-text-input">
        </div>
    </div>




    <!--    --><?php // if ($sales_man  ||  $purchases_man || $delegate_man || $preparation || $direct) {  ?>

        <br>

        <label >القسم المسوؤل علية : </label>
        <br>
        <?php  foreach ($this->category_website as $key => $catg ) {   ?>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"  onchange="delete_user_purchases_catg('<?php echo $key ?>')"   name="category[]"   <?php  if (in_array($key,$categ)) echo 'checked' ?>    value="<?php echo $key ?>" id="customcheckboxInline<?php echo $key ?>"class="custom-control-input">
                <label class="custom-control-label" for="customcheckboxInline<?php echo $key ?>">  <?php echo $catg ?>  </label>
            </div>

        <?php  }   ?>



    <?php  if ($delegate_man ) {  ?>

        <hr>
        <br>

        <label >  منطقة التسوق :  </label>
        <br>
        <?php  foreach ($region as $keyg => $reg ) {   ?>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"  onchange="delete_user_purchases_region(<?php echo    $reg['id']  ?>)"  <?php  if (in_array($reg['id'],$region_id)) echo 'checked' ?>   name="region[]"   value="<?php echo    $reg['id']  ?>" id="customcheckboxInline<?php echo $keyg ?>" class="custom-control-input">
                <label class="custom-control-label" for="customcheckboxInline<?php echo $keyg ?>">  <?php echo $reg['title'] ?>  </label>
            </div>
        <?php  }   ?>
    <?php  }   ?>
    <?php  if ($direct ) {  ?>

        <hr>
        <br>

        <label >  نوع المستخدم :  </label>
        <br>

        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio"   name="direct"  onchange="money_box_f(this)"   value="1" id="customradioInline-1" <?php if ($result['direct'] ==1) echo 'checked'?>    class="custom-control-input" required>
            <label class="custom-control-label" for="customradioInline-1">   مبيعات  </label>
        </div>

        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio"   name="direct"   onchange="money_box_f(this)"  value="2" id="customradioInline-2" <?php if ($result['direct'] ==2) echo 'checked'?> class="custom-control-input"  required>
            <label class="custom-control-label" for="customradioInline-2">   تجهيز  </label>
        </div>

        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio"   name="direct"  onchange="money_box_f(this)"   value="3" id="customradioInline-3" <?php if ($result['direct'] ==3) echo 'checked'?> class="custom-control-input" required>
            <label class="custom-control-label" for="customradioInline-3">   مبيعات ومجهز ومحاسب  </label>
        </div>

    <?php  }   ?>


    <div class="row money_box" <?php if ($result['direct'] == 3) echo 'style="display:block"'?>  >
        <div class="col-lg-4 col-md-6 col-sm-12">
            <br>
            <label for="mbox">حجم الصندوق</label>
            <div class="input-group mb-2">
                <input type="text" onkeyup="add_comma(this)" name="money_box" id="money_box" value="<?php echo number_format($result['money_box'])  ?>" class="form-control">
                <div class="input-group-prepend">
                    <div class="input-group-text">د.ع</div>
                </div>
            </div>

        </div>
    </div>
    <script>




        function add_comma(e)
        {
            valu=$(e).val();
            $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

    </script>





    <br>
    <hr>


    <label > اختر نوع عرض السعر للموظف : </label>
    <br>
    <?php  foreach ($this->price_type as $key => $price ) {   ?>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox"  <?php  if(in_array($key,explode(',',$result['price_type'])))  echo 'checked' ?>  name="price_type[]"   value="<?php echo $key ?>" id="price_type<?php echo $key ?>" class="custom-control-input">
            <label class="custom-control-label" for="price_type<?php echo $key ?>">  <?php echo $price ?>  </label>
        </div>

    <?php  }   ?>

    <br>
    <hr>

    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="hidden"   name="smart_prepared"   value="0" >
        <input type="checkbox" <?php  if ($result['smart_prepared'] == 1)  echo 'checked' ?>   name="smart_prepared"   value="1" id="price_type_smart_prepared" class="custom-control-input">
        <label class="custom-control-label" for="price_type_smart_prepared">   تفعيل التجهيز الذكي </label>
    </div>


    <hr>


    <label >   تقرير النواقص:  </label>
    <br>

    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox"   <?php  if(in_array(1,explode(',',$result['shortfalls'])))  echo 'checked' ?>   name="shortfalls[]"   value="1" id="customcheckboxInline-shortfalls-1" class="custom-control-input"  >
        <label class="custom-control-label" for="customcheckboxInline-shortfalls-1">   واجهة موظف  </label>
    </div>

    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox"    <?php  if(in_array(2,explode(',',$result['shortfalls'])))  echo 'checked' ?>  name="shortfalls[]"   value="2" id="customcheckboxInline-shortfalls-2" class="custom-control-input"  >
        <label class="custom-control-label" for="customcheckboxInline-shortfalls-2">   واجهة الادمن  </label>
    </div>


    <hr>


    <label >   تقرير  فحص اكسسوار اصلي :  </label>
    <br>

    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox"   <?php  if(in_array(1,explode(',',$result['check_accessories'])))  echo 'checked' ?>   name="check_accessories[]"   value="1" id="customcheckboxInline-check_accessories-1" class="custom-control-input"  >
        <label class="custom-control-label" for="customcheckboxInline-check_accessories-1">   واجهة موظف  </label>
    </div>

    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox"    <?php  if(in_array(2,explode(',',$result['check_accessories'])))  echo 'checked' ?>  name="check_accessories[]"   value="2" id="customcheckboxInline-check_accessories-2" class="custom-control-input"  >
        <label class="custom-control-label" for="customcheckboxInline-check_accessories-2">   واجهة الادمن  </label>
    </div>

<hr>
    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="hidden"   name="location_out_pull"   value="0">
        <input type="checkbox"  <?php  if ($result['location_out_pull']==1) echo  'checked' ?>  name="location_out_pull"   value="1" id="customcheckboxInline-location_out_pull-1" class="custom-control-input">
        <label class="custom-control-label" for="customcheckboxInline-location_out_pull-1">     سحب من المواقع (401..402..403..999)  </label>
    </div>



    <?php  echo $this->CSRFToken($_SESSION['CSRFToken'])  ?>


    <hr>

    <div class="row">
        <div class="col align-self-center text-center">
            <input  name="submit" value="حفظ" class="btn btn-success" type="submit">
        </div>
    </div>



</form>


        </div>
    </div>
</div>

<br>
<br>
<br>
<br>


<script>

    function delete_user_purchases_catg(model) {
            $.get("<?php echo url .'/'.$this->folder?>/delete_user_purchases_catg/"+model+'/<?php echo $id  ?>', function(){ })
    }


    function delete_user_purchases_region(id_region) {
            $.get("<?php echo url .'/'.$this->folder?>/delete_user_purchases_region/"+id_region+'/<?php echo $id  ?>', function(){ })
    }


    function money_box_f(e) {
        if ($(e).val() === "3")
        {
            $(".money_box").show();
            $("input[name='money_box']").attr('required','required');
        }else {
            $(".money_box").hide();
            $("input[name='money_box']").removeAttr('required');
        }

    }

</script>

<style>
    .money_box
    {
        display: none;
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

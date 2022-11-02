<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('add_account') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<div class="content">
    <form  action="<?php echo url.'/'.$this->folder ?>/edit_user_account/<?php echo $id_account ?>/<?php echo $id ?>" method="post" enctype="multipart/form-data">

        <div class="panel-heading">
            <ul class="nav nav-pills mb-3">
                <li class="nav-item" role="presentation">
                    <a href="#general_inf" class="nav-link active" id="general-inf-tab" data-toggle="tab"  data-bs-toggle="tab" data-bs-target="#general_inf" type="button" role="tab" aria-controls="general_inf" aria-selected="true">معلومات عامة</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a  href="#info_account" class="nav-link" id="info-account-tab" data-toggle="tab" data-bs-toggle="tab" data-bs-target="#info_account" type="button" role="tab" aria-controls="info_account" aria-selected="false" >معلومات الحساب</a>
                </li>

            </ul>
        </div>

        <div class="tab-content" id="myTabContent">
            <!-- tab general information -->
            <div class="tab-pane fade show active" id="general_inf" role="tabpanel" aria-labelledby="general-inf-tab">
                <div class='part'>
                    <div class="form-row row mt-4 mb-2">

                    <div class="col-lg-1 col-md-2"></div>
                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2 mb-0" for="name"> الاسم </label>
                            <input type="text" name="name" value="<?php echo $infoAccount[0]['name'] ?>"  class="form-control" id="name"  autocomplete="off" required>
                        </div>

                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2 mb-0" for="phone"> رقم الهاتف </label>
                            <input type="text" name="phone" value="<?php echo $infoAccount[0]['phone'] ?>"  class="form-control" id="phone"  autocomplete="off" minlength="10" required>
                        </div>

                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="job"> المهنة </label>
                            <input type="text" name="job" value="<?php echo $infoAccount[0]['job'] ?>" class="form-control" id="job"  autocomplete="off">
                        </div>
                        <div class="col-lg-1 col-md-2"></div>

                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>

                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2  mb-0" for="country"> الدولة </label>
                            <input type="text" name="country"  value="<?php echo $infoAccount[0]['country'] ?>" class="form-control" id="country"   autocomplete="off" >
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="city"> المحافظة </label>
                            <input type="text" name="city"  value="<?php echo $infoAccount[0]['city'] ?>" class="form-control" id="city"  autocomplete="off" >
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="address"> المنطقة</label>
                            <input type="text" name="address" value="<?php echo $infoAccount[0]['address'] ?>"  class="form-control" id="address" autocomplete="off" >
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                        <div class="col-lg-3 col-md-2 mr-4 mt-4">
                            <div class="form-group">
                                <label style=" font-size: 18px;margin-left: 22px;"> الجنس </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="gander" value="ذكر" <?php if($infoAccount[0]['gander'] == "ذكر") echo 'checked' ?> class="custom-control-input" >
                                    <label  class="custom-control-label" for="customRadioInline1">ذكر</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="gander" value="انثى" <?php if($infoAccount[0]['gander'] == "انثى") echo 'checked' ?>  class="custom-control-input" >
                                    <label  class="custom-control-label" for="customRadioInline2">انثى</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="brithday"> تاريخ الميلاد</label>
                            <input type="date" name="brithday" value="<?php echo $infoAccount[0]['brithday'] ?>"  class="form-control" id="brithday" autocomplete="off" >
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="note"> ملاحظة</label>
                            <textarea  name="note" class="form-control" id="note" cols="60" style="width:272px"><?php echo $infoAccount[0]['note'] ?> </textarea>
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                        <div class="form-group">
                                <label style=" font-size: 15px;margin-left: 5px;"> الحالة  </label>
                                <input type="hidden"  name="state"  value="0" >
                            <input type="checkbox" id="state" name="state" value="1"  data-toggle="toggle" data-style="slow" data-size="small" <?php if ($infoAccount[0]['active']  == 1)  echo 'checked' ?>   >
                        </div>
                        <div class="form-group">
                                <label style=" font-size: 15px;margin-left: 5px;margin-right: 16px;"> منع التعامل </label>
                                <input type="hidden"  name="stop"  value="0"    >
                                <input type="checkbox"  id="stop" name="stop"  value="1" <?php if ($infoAccount[0]['stop']  == 1)  echo 'checked' ?> data-toggle="toggle" datax-stylex="iosx" data-size="small"  >
                        </div>
                    </div>
                </div>
            </div>

            <!-- tab  information account -->
            <div class="tab-pane fade" id="info_account" role="tabpanel" aria-labelledby="info-account-tab">

                <div class='part'>
                    <div class="form-row row mt-4 mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                        <div class="col-lg-3 col-md-2 col-md-2 mr-4">
                            <label class="mr-sm-2" for="type_account">  نوع الحساب </label>
                            <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="type_account" id="type_account">
                                <?php foreach ($nameCategory as $key => $name) {   ?>
                                    <option  value="<?php  echo $name['id']?>"<?php  if ($name['id']==$infoAccount[1]['id_cat'])  echo 'selected' ?>><?php  echo $name['title']?></option>
                                <?php  } ?>
                            </select>
                        </div>


                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2" for="branch">  الفرع  </label>
                            <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="branch" id="branch">
                                <?php foreach ($nameBranch as $key => $name) {   ?>
                                    <option  value="<?php  echo $name['id']?>"<?php  if ($name['id']==$infoAccount[1]['id_branch'])  echo 'selected' ?>><?php  echo $name['title']?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-2  mb-4 mr-2  mr-4">
                            <label class="mr-sm-2" for="price_list"> نمط الاسعار </label>
                            <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="price_list" id="price_list">
                                <?php foreach ($priceList as $key => $value) {   ?>
                                    <option    value="<?php  echo $value['id']?>" <?php  if ($value['id']==$infoAccount[1]['id_price_list'])  echo 'selected' ?> ><?php  echo $value['title']?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2" for="mth_goal_amount"> مبلغ الهدف الشهري </label>
                            <input type="number" name="mth_goal_amount" value="<?php echo $infoAccount[1]['mth_goal_amount'] ?>" class="form-control" id="mth_goal_amount"  >
                        </div>

                        <div class="col-lg-3 col-md-2  mb-4 mr-2  mr-4">
                            <label class="mr-sm-2" for="mth_goal_currency">عملة الهدف الشهري  </label>
                            <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="mth_goal_currency" id="mth_goal_currency" >
                                <?php foreach ($currency as $key => $name) {   ?>
                                    <option    value="<?php  echo $name['id']?>" <?php  if ($name['id']==$infoAccount[1]['mth_goal_currency'])  echo 'selected' ?>><?php  echo $name['name']?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2" for="duration_of_debt"> مدة الدين </label>
                            <input type="number" name="duration_of_debt" value="<?php echo $infoAccount[1]['duration_of_debt'] ?>" class="form-control" id="duration_of_debt"  >
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                            <div class="col-lg-3 col-md-2 mr-4">
                                <label class="mr-sm-2" for="max_debt_limit"> حد الدين الاعلى</label>
                                <input type="number" name="max_debt_limit" value="<?php echo $infoAccount[1]['max_debt_limit'] ?>" class="form-control" id="max_debt_limit"  >
                            </div>


                            <div class="col-lg-3 col-md-2  mb-4 mr-2  mr-4">
                                <label class="mr-sm-2" for="currency_debt_limit">عملة  حد الدين  </label>
                                <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency_debt_limit" id="currency_debt_limit" >
                                    <?php foreach ($currency as $key => $name) {   ?>
                                        <option    value="<?php  echo $name['id']?>" <?php  if ($name['id']==$infoAccount[1]['currency_debt_limit'])  echo 'selected' ?>><?php  echo $name['name']?></option>
                                    <?php  } ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-2  mb-4 mr-2  mr-4">
                                <label class="mr-sm-2" for="price_style"> نوع الدفع  </label>
                                <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="price_style" id="price_style" >
                                    <?php foreach ($priceStyle as $key => $value) {   ?>
                                        <option    value="<?php  echo $value['id']?>" <?php  if ($value['id']==$infoAccount[1]['id_price_style'])  echo 'selected' ?> ><?php  echo $value['title']?></option>
                                    <?php  } ?>
                                </select>
                            </div>

                            <div class="col-lg-1 col-md-2"></div>
                        </div>



                    </div>
                </div>
            </div>
        <div class="row justify-content-md-center  mb-4" style="clear: both;">
            <input class="btn btn-primary" id="save" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
        </div>
    </form>
</div>


<script>

    $('#phone').focusout(function(e){
        var id_account = <?php echo $id_account ?>;
        var phone = $('#phone').val();
        var  value ={'phone':phone,'id_account':id_account};
        $.get( "<?php echo url .'/'.$this->folder ?>/checkIfExist/",{ jsonData: JSON.stringify(value)}, function(data) {
            if(data == 1){
                alert('رقم الهاتف موجود');
                $('#phone').val('');
            }
        });
    });

</script>
<style>

.content{
    width: 90%;
    margin: 0 auto;
}
.content .part {
    width: 100%;
    padding: 16px 10px;
    background-color: #fff !important;
    margin-bottom: 30px;
    margin-top: 1px;

    box-shadow: 0px 0px 10px #ccc;

}
input{
  border: 0 !important;
  outline: none !important;
  border-bottom: 1px solid #ced4da !important;
  font-size: 1rem !important;
  line-height: 1.5 !important;
}
.form-control:focus {
    background: none;
    border-color:rgba(100,100,100,1)!important;
    -webkit-box-shadow: none!important;
    -moz-box-shadow: none!important;
    box-shadow: none!important;
}

#save{
    text-align: center;
    justify-self: center;
    margin: 10px auto;
    color: #fff ;
    border-radius: 6px;
    padding: 5px 10px;
}
</style>
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
    <form  action="<?php echo url.'/'.$this->folder ?>/add_account/<?php echo $id ?>" method="post" enctype="multipart/form-data">

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
                            <input type="text" name="name"  class="form-control" id="name"  autocomplete="off" required>
                        </div>

                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2 mb-0" for="phone"> رقم الهاتف </label>
                            <input type="text" name="phone"  class="form-control" id="phone"  autocomplete="off" minlength="10" required>
                        </div>

                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="job"> المهنة </label>
                            <input type="text" name="job"  class="form-control" id="job"  autocomplete="off" required>
                        </div>
                        <div class="col-lg-1 col-md-2"></div>

                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>

                        <div class="col-lg-3 col-md-2 mr-4">
                            <label class="mr-sm-2  mb-0" for="country"> الدولة </label>
                            <input type="text" name="country"  class="form-control" id="country"  autocomplete="off" required>
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="city"> المحافظة </label>
                            <input type="text" name="city"  class="form-control" id="city"  autocomplete="off" required>
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="address"> المنطقة</label>
                            <input type="text" name="address"  class="form-control" id="address"  autocomplete="off" required>
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>

                    <div class="form-row row  mb-2">
                        <div class="col-lg-1 col-md-2"></div>
                        <div class="col-lg-3 col-md-2 mr-4 mt-4">
                            <div class="form-group">
                                <label style=" font-size: 18px;margin-left: 22px;"> الجنس </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="gander" value="ذكر" class="custom-control-input" required>
                                    <label  class="custom-control-label" for="customRadioInline1">ذكر</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="gander" value="انثى" class="custom-control-input" required>
                                    <label  class="custom-control-label" for="customRadioInline2">انثى</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="brithday"> تاريخ الميلاد</label>
                            <input type="date" name="brithday"  class="form-control" id="brithday"  autocomplete="off" required>
                        </div>
                        <div class="col-lg-3 col-md-2  mr-4">
                            <label class="mr-sm-2  mb-0" for="note"> ملاحظة</label>
                            <textarea  name="note" class="form-control" id="note" cols="60" style="width:272px"></textarea>
                        </div>
                        <div class="col-lg-1 col-md-2"></div>
                    </div>
                </div>
            </div>

            <!-- tab  information account -->
            <div class="tab-pane fade" id="info_account" role="tabpanel" aria-labelledby="info-account-tab">

                <div class='part'>
                    <div class="form-row row mb-4  mt-4">
                        <div class="col-lg-1 col-md-2 mb-4"></div>
                        <div class="col-lg-2 col-md-2 mr-4  mr-4">
                            <label class="mr-sm-2" for="select_source_request">  نوع الحساب </label>
                            <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="source_request" id="select_source_request" required>
                                <?php foreach ($nameCategory as $key => $name) {   ?>
                                    <option  value="<?php  echo $name['id']?>"<?php  if ($name['id']==$id)  echo 'selected' ?>><?php  echo $name['title']?></option>
                                <?php  } ?>
                            </select>
                        </div>


                        <div class="col-lg-2 col-md-2 mr-4  mr-4">
                            <label class="mr-sm-2" for="select_source_request">  الفرع  </label>
                            <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="source_request" id="select_source_request" required>
                                <?php foreach ($nameBranch as $key => $name) {   ?>
                                    <option  value="<?php  echo $name['id']?>"><?php  echo $name['title']?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 mb-4  mr-4">
                            <label class="mr-sm-2" for="date_request"> مبلغ الهدف الشهري </label>
                                <input type="text" name="date_request"  class="form-control" id="date_request"  >
                        </div>

                        <div class="col-lg-2 col-md-2  mb-4 mr-2  mr-4">
                            <label class="mr-sm-2" for="currency">عملة الهدف الشهري  </label>
                            <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency" id="currency"  required>
                                <option value = '' name= ''> اختر اسم</option>
                                <?php foreach ($currency as $key => $name) {   ?>
                                    <option    value="<?php  echo $name['id']?>" name='<?php  echo $name['name']?>'><?php  echo $name['name']?></option>
                                <?php  } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center  mb-4" style="clear: both;">
            <input class="btn btn-primary" id="save" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
        </div>
    </form>
</div>




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
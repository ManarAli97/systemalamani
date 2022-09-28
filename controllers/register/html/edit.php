
<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/subscribers"><?php  echo $this->langControl('registration') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  تعديل معلومات الزبون   </li>
                <li class="breadcrumb-item active" aria-current="page" >   <?php echo $result['name'] ?>  </li>

            </ol>
        </nav>

    </div>

</div>


<form action="<?php echo url .'/'.$this->folder ?>/edit/<?php  echo $id ?>" method="post">



                <div class="form-group row">
                    <label for="input-phone" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('phone') ?></span> <span style="color: red;font-size: 14px;" id="phone"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">
                        <input type="text" name="phone"  value="<?php echo $result['phone'] ?>" class="form-control" id="input-phone" placeholder="<?php echo $this->langSite('phone') ?>">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="input-name" class="col-sm-3 col-form-label"><span> الاسم واللقب </span> <span style="color: red;font-size: 14px;" id="name"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">
                        <input type="text" name="name"  value="<?php echo $result['name'] ?>" class="form-control" id="input-name" placeholder=" الاسم واللقب">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-title" class="col-sm-3 col-form-label"><span>  المهنة   </span> <span style="color: red;font-size: 14px;" id="title"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">
                        <input type="text" name="title"  value="<?php echo $result['title'] ?>" class="form-control" id="input-title" placeholder="المهنة">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="input-birthday" class="col-sm-3 col-form-label"><span> تاريخ الميلاد</span> <span style="color: red;font-size: 14px;" id="birthday"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">
                        <input type="date" name="birthday"  value="<?php echo $result['birthday'] ?>" class="form-control" id="input-birthday"  >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-birthday" class="col-sm-3 col-form-label"><span>  الجنس  </span> <span style="color: red;font-size: 14px;" id="birthday"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">


                        <div class="custom-control custom-radio custom-control-inline">
                            <input  <?php if ($result['gander'] == 'ذكر')  echo 'checked' ?>  type="radio" id="gander-1" name="gander" value="ذكر" class="custom-control-input">
                            <label class="custom-control-label" for="gander-1">ذكر</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input <?php if ($result['gander'] == 'انثى')  echo 'checked' ?>  type="radio" id="gander-2" name="gander"  value="انثى" class="custom-control-input">
                            <label class="custom-control-label" for="gander-2">انثى</label>
                        </div>



                     </div>
                </div>



                <div class="form-group row">
                    <label for="input-city" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('city') ?></span>  <span style="color: red;font-size: 14px;" id="city"></span>  <span class="star_red"> * </span>  </label>
                    <div class="col-sm-9">
                        <select name="city"  id="input-country" class="custom-select">

                            <option value=""    > اختر محافظة </option>

                            <?php  foreach ($city as $cy)  { ?>
                                <option value="<?php  echo $cy ?>"  <?php if ($result['city'] == $cy) echo 'selected'?>  > <?php  echo $cy ?></option>
                            <?php  }  ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="input-address" class="col-sm-3 col-form-label"><span><?php echo $this->langSite('address') ?></span>  <span style="color: red;font-size: 14px;" id="address"></span>  <span class="star_red"> * </span> </label>
                    <div class="col-sm-9">
                        <input type="text"  name="address" value="<?php echo $result['address'] ?>"  class="form-control" id="input-address" placeholder="<?php echo $this->langSite('address') ?>">
                    </div>
                </div>



                <hr>

                  <div class="row justify-content-center">
                      <div class="col-auto">
                          <input type="submit" class="btn btn-primary" name="submit" value="تعديل ">
                      </div>
                  </div>

            </form>




<br>
<br>


<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {

                $('#'+prop).html('&nbsp;&nbsp;'+error[prop] );
                $("*[name='"+prop+"']").addClass('error_border_red');
            if (prop==='phone')
            {
                $('#length_phone').html(error[prop]);
            }
        }


    </script>

<?php  } ?>
<style>


    .note_wholesale_price_account
    {
        border: 1px solid #c9c9c9;
        margin-top: 11px;
        padding: 8px 7px;
        background: #283581;
        color: #ffff;
        display: none;
    }


    .error_border_red
    {
        border: 1px solid red !important;
        box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
    }

    .error_pop
    {
        display: block !important;
    }


    .star_red
    {
        color: red;
    }


    #myTabContent{
        border: 1px solid #dee2e6;
        border-top: 0;
        padding: 8px;
    }

</style>

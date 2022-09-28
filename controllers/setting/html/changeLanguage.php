<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php  echo $this->langControl('setting') ?></li>
                <li class="breadcrumb-item active"><?php  echo $this->langControl('changeLanguage') ?> </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="form-group row">
    <label for="inlineFormCustomSelect_control" class="col-sm-auto col-form-label"> <?php  echo $this->langControl('select_language_control') ?>  </label>
    <div class="col-sm-3">
        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect_control">

            <?php  foreach ($langControl as $lgC) { ?>
                <option value="<?php echo $lgC['lang_control'] ?>"  <?php echo $lgC['selectLang'] ?> ><?php echo $lgC['lang_control'] ?></option>


            <?php } ?>

        </select>

    </div>
</div>


<div class="form-group row">
    <label for="inlineFormCustomSelect_site" class="col-sm-auto col-form-label"> <?php  echo $this->langControl('select_default_language_site') ?>  </label>
    <div class="col-sm-3">
        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect_site">

            <?php  foreach ($langSite as $lgS) { ?>
                <option value="<?php echo $lgS['lang_site'] ?>"  <?php echo $lgS['selectSite'] ?> ><?php echo $lgS['lang_site'] ?></option>


            <?php } ?>

        </select>

    </div>
</div>



<script>
    $('#inlineFormCustomSelect_control').change(function() {
        var lang_control = $(this).val(); //get the current value's option

        $.ajax({
            type:'post',
            url:'<?php echo url ?>/lang/changeLangControl/'+lang_control,
            success:function(data){
                console.log(data);
               window.location.href = '';


            }
        });
    });


    $('#inlineFormCustomSelect_site').change(function() {
        var lang_site = $(this).val(); //get the current value's option

        $.ajax({
            type:'post',
            url:'<?php echo url ?>/lang/changeLangSite/'+lang_site,
            success:function(data){
                console.log(data)
            }
        });
    });
</script>
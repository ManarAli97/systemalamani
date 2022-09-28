<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php  echo $this->langControl('setting') ?></li>
                <li class="breadcrumb-item active"><?php  echo $this->langControl('link_social_media') ?> </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<form  action="<?php echo url.'/'.$this->folder ?>/link_social_media" method="post">

    <div class="form-group row">
        <label for="inputfacebook" class="col-sm-2 col-form-label"><?php echo $this->langControl('facebook')?> </label>
        <div class="col-sm-4">
            <input type="text" name="facebook" value="<?php echo $this->get('facebook') ?>" class="form-control" id="input" >
        </div>

        <label for="inputinstagram" class="col-sm-2 col-form-label"><?php echo $this->langControl('instagram')?> </label>
        <div class="col-sm-4">
            <input type="text" name="instagram" value="<?php echo $this->get('instagram') ?>" class="form-control" id="inputinstagram" >
        </div>
    </div>

    <br>

    <div class="form-group row">
        <label for="inputtelegram" class="col-sm-2 col-form-label"><?php echo $this->langControl('telegram')?> </label>
        <div class="col-sm-4">
            <input type="text" name="telegram" value="<?php echo $this->get('telegram') ?>" class="form-control"  id="inputtelegram" >
        </div>

        <label for="inputwhatsapp" class="col-sm-2 col-form-label"><?php echo $this->langControl('whatsapp')?> </label>
        <div class="col-sm-4">
            <input type="text" name="whatsapp" value="<?php echo $this->get('whatsapp') ?>" class="form-control" id="inputwhatsapp" >
        </div>


    </div>
    <br>
    <div class="form-group row">
        <label for="inputlinkedin" class="col-sm-2 col-form-label"><?php echo $this->langControl('linkedin')?> </label>
        <div class="col-sm-4">
            <input type="text" name="linkedin" value="<?php echo $this->get('linkedin') ?>" class="form-control"  id="inputlinkedin" >
        </div>

        <label for="inputyoutube" class="col-sm-2 col-form-label"><?php echo $this->langControl('youtube')?> </label>
        <div class="col-sm-4">
            <input type="text" name="youtube" value="<?php echo $this->get('youtube') ?>" class="form-control" id="inputyoutube" >
        </div>


    </div>
    <br>


    <hr>
    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >
            </div>
        </div>
    </div>

</form>





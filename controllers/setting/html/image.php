<br>


<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php  echo $this->langControl('setting') ?></li>
                <li class="breadcrumb-item active"><?php  echo $this->langControl('image') ?> </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<form  action="<?php echo url.'/'.$this->folder ?>/image" method="post">



    <div class="form-group row">
        <label for="inputwidth" class="col-sm-2 col-form-label"><?php echo $this->langControl('width')?> </label>
        <div class="col-sm-4">
            <input type="number" name="width" value="<?php echo $this->get('width',1800) ?>" class="form-control" id="inputwidth" >
        </div>

        <label for="inputheight" class="col-sm-2 col-form-label"><?php echo $this->langControl('height')?> </label>
        <div class="col-sm-4">
            <input type="number" name="height" value="<?php echo $this->get('height',1600) ?>" class="form-control" id="inputheight" >
        </div>
    </div>

    <br>

    <div class="form-group row">
        <label for="inputproportional" class="col-sm-2 col-form-label"><?php echo $this->langControl('proportional')?> </label>
        <div class="col-sm-4">
            <input type="number" name="proportional" value="<?php echo $this->get('proportional',1) ?>" class="form-control"  id="inputproportional" >
        </div>

        <label for="inputquality" class="col-sm-2 col-form-label"><?php echo $this->langControl('quality')?> </label>
        <div class="col-sm-4">
            <input type="number" name="quality" value="<?php echo $this->get('quality',75) ?>" class="form-control" id="inputquality" >
        </div>


    </div>
    <br>
    <div class="form-group row">
        <label for="inputgrayscale" class="col-sm-2 col-form-label"><?php echo $this->langControl('grayscale')?> </label>
        <div class="col-sm-4">
            <input type="number" name="grayscale" value="<?php echo $this->get('grayscale',0) ?>" class="form-control"  id="inputgrayscale" >
        </div>

    </div>

    <hr>
    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn " type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >
            </div>
        </div>
    </div>

</form>





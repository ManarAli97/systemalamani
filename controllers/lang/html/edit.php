<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_lang"> <?php  echo $this->langControl('website_translation') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('Edit') ?></li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $result['key'] ?>  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>



<form method="post" action="<?php echo url?>/lang/edit/<?php echo $result['id'] ?>">

<div class="form-group row">
    <label for="example-text-input" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('key_word') ?>  </label>
    <div class="col-8">
        <input class="form-control" type="text"  value="<?php echo $result['key'] ?>" name="key" id="example-text-input" readonly>
    </div>
</div>


<div class="form-group row">
    <label for="example-password-input" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('arabic_translation') ?> </label>
    <div class="col-8">

        <input class="form-control" type="text"  value="<?php echo $result['ar'] ?>" name="ar" id="example-text-input">

    </div>
</div>

<div class="form-group row">
    <label for="inlineFormCustomSelect" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('english_translation') ?></label>
    <div class="col-8">
        <input class="form-control" type="text"  value="<?php echo $result['en'] ?>" name="en" id="example-text-input">

    </div>
</div>



    <hr>

    <div class="row">
        <div class="col align-self-center text-center">
            <input  name="submit" value="حفظ" class="btn btn-success" type="submit">
        </div>
    </div>


</form>
























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

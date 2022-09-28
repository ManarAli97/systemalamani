<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_questions"> <?php  echo $this->langControl('questions') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('add') ?></li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<br>

<form method="post" action="<?php echo url .'/'.$this->folder?>/add"   enctype="multipart/form-data">





    <div class="form-group row">
        <label for="number_q" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('number_q') ?></label>
        <div class="col-8">
            <input class="form-control" type="text"  value="<?php echo $data['number_q'] ?>" name="number_q" id="number_q">

        </div>
    </div>


    <div class="form-group row">
    <label for="example-text-questions" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('questions') ?>  </label>
    <div class="col-8">
        <input class="form-control" type="text"  value="<?php echo $data['questions'] ?>" name="questions" id="example-text-questions"  >
    </div>
    </div>


    <div class="form-group row">
        <label for="customFile" class="col-2 col-form-label"    style="text-align: center">صورة</label>
        <div class="col-8">
            <input type="file" name="image"  accept="image/*" id="customFile">

        </div>
    </div>


    <div class="form-group row">
        <label for="inlineFormCustomSelect" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('answer') ?></label>
        <div class="col-8">



            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="cc_name"><?php echo $this->langControl('answer')?></label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><span>1</span> - <?php echo $this->langControl('answer')?></div>
                        </div>
                        <input type="text" class="form-control" name="answer[]" id="answer"  required>
                    </div>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="correct"><?php echo $this->langControl('correct')?></label>
                    <div class="input-group mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio2" value="0" name="correct[]" class="custom-control-input">
                            <label class="custom-control-label"   for="customRadio2">  اجابة صحيحية </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="blockPs AddButton">

            </div>

            <br>

            <a class="btn btn-warning addPs" id="clickme"> <?php echo  $this->langControl('add_more')?> <i class="fa fa-plus-circle"></i> </a>

        </div>
    </div>





    <hr>

    <div class="row">
        <div class="col align-self-center text-center">
            <input  name="submit" value="<?php  echo $this->langControl('save') ?>" class="btn btn-success" type="submit">
        </div>
    </div>


</form>


<script>

    count = 0;

    $('.addPs').click(function() {
        count += 1;
        id_div = 'id_r_'+count;
        $('.blockPs:last').before(`<div  id="${id_div}" class="form-row align-items-center">
         <div class="col-auto">
            <label class="sr-only" for="answer"><?php echo $this->langControl('answer')?></label>
            <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><span>${count+1}</span> - <?php echo $this->langControl('answer')?></div>
                        </div>
                        <input type="text" class="form-control"  name="answer[]" id="answer"  required>
                    </div>
              </div>
        <div class="col-auto">
                    <label class="sr-only" for="correct"><?php echo $this->langControl('correct')?></label>
                    <div class="input-group mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio2${count+1}" value="${count}" name="correct[]" class="custom-control-input">
                            <label class="custom-control-label"  for="customRadio2${count+1}">  اجابة صحيحية </label>
                        </div>
                    </div>
                </div>
        <div class="col-auto">
             <div class="input-group mb-2">
                  <div class="input-group-text remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </div>
             </div>
        </div>
    </div>`);
    });



    function remove_div(id) {
        $(id).remove();
    }

</script>

<style>
    .remove_div
    {
        cursor: pointer;
        background: transparent;
        border: 0;
    }



    .remove_div i
    {

        color: red;
        font-size: 21px;
    }
    .addPs
    {
        color: #FFFFFF !important;
    }
</style>

<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("input[name='"+prop+"']").addClass('error_border_red');
        }
    </script>
    <style>
        .error_border_red
        {
            border: 1px solid red !important;
            box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
        }
    </style>
<?php  } ?>




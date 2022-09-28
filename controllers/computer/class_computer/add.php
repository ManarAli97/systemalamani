<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_class_computer"><?php  echo $this->langControl('class_computer') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/add_class_computer" method="post"  >

    <div class="form-row">
        <div class="col-6">
        <label for="validationServer01">  <?php  echo $this->langControl('title') ?> <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="title[]" class="form-control"  id="validationServer01"   type="text">
        </div>
    </div>


    <div class="blockPs AddButton">
    </div>

    <br>
    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add_class_computer')?> <i class="fa fa-plus-circle"></i> </a>
    <br>



<hr>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="حفظ">
            </div>
        </div>
    </div>

</form>



<script>
    count = 0;
    $('.addPs').click(function() {

        count += 1;

        $('.blockPs:last').before(`<div class="blockPs">
                             <div  id="rowx${count}" class="row" style="margin-top: 30px">

                            <div class="col-6">

                                <input   name="title[]" type="text"  class="form-control is-valid" id="validationServer01"  value=""  required/>
                            </div>
                             <div class="col-auto">
                                 <button class="btn remove_div" type="button"  onclick="remove_div(${count})"> <i class="fa  fa-times-circle"></i> </button>
                              </div>
                            </div>
                       </div>`);

     });

    function remove_div(id) {
        $('#rowx'+id).remove();
    }

</script>



<?php if(!empty($this->error_form ))  { ?>
<script>

    var error=<?php echo $this->error_form ?>;
    for (var prop in error) {
        $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
        $("*[name='"+prop+"']").addClass('error_border_red');
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

<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_questions"> <?php  echo $this->langControl('questions') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('edit') ?></li>
            </ol>
        </nav>
        <hr>
    </div>
</div>



<form method="post" action="<?php echo url .'/'.$this->folder?>/edit/<?php echo $result['id'] ?>" enctype="multipart/form-data">

   <div class="row align-items-center">
       <div class="col-9">


           <div class="form-group row">
               <label for="example-text-input" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('number_q') ?>  </label>
               <div class="col-10">
                   <input class="form-control" type="text"  value="<?php echo $result['number_q'] ?>" name="number_q" id="example-text-input"  >
               </div>
           </div>

           <div class="form-group row">
               <label for="inlineFormCustomSelect" class="col-2 col-form-label" style="text-align: center"><?php  echo $this->langControl('questions') ?></label>
               <div class="col-10">
                   <input class="form-control" type="text"  value="<?php echo $result['questions'] ?>" name="questions" id="example-text-input">

               </div>
           </div>


           <div class="form-group row">
               <label for="customFile" class="col-2 col-form-label"    style="text-align: center">صورة</label>
               <div class="col-10">
                   <input type="file" name="image"  accept="image/*" id="customFile">

               </div>
           </div>



           <div class="form-group row">
               <label for="inlineFormCustomSelect" class="col-2 col-form-label" style="text-align: center">  الاجوبة </label>
               <div class="col-10">

                   <?php foreach ($answer as $camp) {   ?>

                       <div class="form-row align-items-center" id="delete_from_db_<?php echo $camp['id'] ?>">

                           <div class="col-auto">
                               <label class="sr-only" for="answer"><?php echo $this->langControl('answer')?></label>
                               <div class="input-group mb-2">
                                   <div class="input-group-prepend">
                                       <div class="input-group-text">  <?php echo $this->langControl('answer')?></div>
                                   </div>
                                   <input type="text" class="form-control" name="answer[<?php echo $camp['id'] ?>]" id="answer<?php echo $camp['id'] ?>" value="<?php echo $camp['answer'] ?>"  required>
                               </div>
                           </div>
                           <div class="col-auto">
                               <label class="sr-only" for="correct"><?php echo $this->langControl('correct')?></label>
                               <div class="input-group mb-2">
                                   <div class="custom-control custom-checkbox">
                                       <input <?php echo $camp['checked'] ?>  type="checkbox" id="customRadio2<?php echo $camp['id'] ?>" value="<?php echo $camp['id'] ?>" name="correct[]" class="custom-control-input">
                                       <label class="custom-control-label"   for="customRadio2<?php echo $camp['id'] ?>">  اجابة صحيحية </label>
                                   </div>
                               </div>
                           </div>

                           <div class="col-auto">
                               <div class="input-group mb-2">
                                   <div class="input-group-text remove_div"  onclick="remove_db(<?php echo $camp['id'] ?>)"> <i class="fa  fa-times-circle"></i> </div>
                               </div>
                           </div>
                       </div>
                   <?php  } ?>
                   <div class="blockPs AddButton">

                   </div>

                   <br>

                   <a class="btn btn-warning addPs" id="clickme"> <?php echo  $this->langControl('add_more')?> <i class="fa fa-plus-circle"></i> </a>

               </div>
           </div>




       </div>
       <?php  if (!empty($result['image']))  { ?>
       <div class="col-3">
           <div class="img_q" id="image_q_<?php echo $result['id'] ?>">
               <img src="<?php echo  $this->save_file .'questions/'.$result['image'] ?>">

               <button type="button" onclick="delt_image_q(<?php echo $result['id'] ?>)" class="btn delete_image_q"> <i class="fa fa-times"></i> </button>
           </div>

       </div>
       <?php  } ?>


   </div>



    <hr>

    <div class="row">
        <div class="col align-self-center text-center">
            <input  name="submit" value="<?php  echo $this->langControl('save') ?>" class="btn btn-success" type="submit">
        </div>
    </div>


</form>


<style>

    .img_q
    {
       padding: 15px;
        position: relative;
    }
    .img_q img
    {
        width: 100%;
    }


    button.btn.delete_image_q {
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 50%;
        color: white;
        background: red;
    }

</style>


<script>

    function delt_image_q(id)
    {
        $.get( "<?php  echo url .'/'.$this->folder?>/delt_image_q/"+id, function( data ) {
            if (data)
            {
                $('#image_q_'+id).remove()
            }else
            {
                alert('حدث خطا')
            }

        });

    }








    count = 0;

    $('.addPs').click(function() {
        count += 1;
        id_div = 'id_r_'+count;
        $('.blockPs:last').before(`<div  id="${id_div}" class="form-row align-items-center">
         <div class="col-auto">
            <label class="sr-only" for="answer"><?php echo $this->langControl('answer')?></label>
            <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"> <?php echo $this->langControl('answer')?></div>
                        </div>
                        <input type="text" class="form-control"  name="answer[x${count}]" id="answer"  required>
                    </div>
              </div>
        <div class="col-auto">
                    <label class="sr-only" for="correct"><?php echo $this->langControl('correct')?></label>
                    <div class="input-group mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio2__${count+1}" value="x${count}" name="correct[]" class="custom-control-input">
                            <label class="custom-control-label"  for="customRadio2__${count+1}">  اجابة صحيحية </label>
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


    function remove_db(id) {
        if (confirm('<?php echo $this -> langControl('are_you_sure') ?>')) {
            $.post( "<?php echo url .'/'.$this->folder ?>/delete_from_db/"+id, function( data ) {
                $('#delete_from_db_'+id).remove();
            });
        }
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




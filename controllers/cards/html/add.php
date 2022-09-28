


 <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('cards') ?> </a></li>
                    <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                        <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                    <?php  } } ?>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Add_cards') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

    <div class="row">
<div class="col">

     <form action="<?php echo url.'/'.$this->folder ?>/add_cards/<?php echo $id ?>" method="post">
         <div class="form-row">
             <div class="col-md-6 mb-6 lg-6">
                 <label for="validationServer01"> <span>  اسم الفئة </span> <span style="color: red;font-size: 14px;" id="title"></span>  </label>
                 <input   name="title" value="<?php echo  $data['title']  ?>" type="text" placeholder="مثلا:فئة 5000 د.ع"  class="form-control is-valid" id="validationServer01"  >
             </div>
         </div>

         <br>
         <div class="form-row">

             <div class="col-md-6 mb-6 lg-6">
                 <label for="validationServer01"> <span>  <?php  echo $this->langControl('price') ?> </span> <span style="color: red;font-size: 14px;" id="price"></span>  </label>

                 <div class="input-group mb-2">
                     <input   name="price" value="<?php echo  $data['price']  ?>" type="text" placeholder="مثلا:5,000 - 6,500" class="form-control is-valid" id="validationServer01"   >
                     <div class="input-group-prepend">
                         <div class="input-group-text">د.ع</div>
                     </div>
                 </div>
             </div>


         </div>


         <br>
         <div class="form-row">

             <div class="col-md-6 mb-6 lg-6">
                 <label for="validationServer01"> <span>  الكمية </span> <span style="color: red;font-size: 14px;" id="quantity"></span>  </label>

                     <input   name="quantity" value="<?php echo  $data['quantity']  ?>" type="text"   class="form-control is-valid" id="validationServer01"   >

             </div>


         </div>
         <br>


         <div class="form-row">
             <div class="col-md-12 mb-12 lg-12">
                 <fieldset class="fieldsetCatg" >
                     <legend>  <?php  echo $this->langControl('categories') ?>  </legend>

                     <div class="panel panel-default">
                         <div class="panel-body">


                             <?php foreach ($data_cat as $rowCat) {    ?>
                                 <div class="custom-control custom-radio">
                                     <input <?php echo $rowCat['checked'] ?> value="<?php echo $rowCat['id'] ?>"  type="radio" id="cat_<?php echo $rowCat['id'] ?>" name="id_cat"  class="custom-control-input">
                                     <label class="custom-control-label" for="cat_<?php echo $rowCat['id'] ?>"><?php echo $rowCat['title'] ?></label>
                                 </div>
                             <?php   } ?>
                         </div>
                     </div>

                 </fieldset>
                 <div class="clearfix"></div>
             </div>
         </div>

        <br>
        <br>
          <?php  if(!empty($media)) {  ?>
             <div class="row">
                 <?php foreach ( $media as $md) { ?>
                    <?php  if ($md['file_type'] =='video') {   ?>
                     <div class="col-lg-auto">
                         <video   style="width: 350px;margin-bottom: 22px;" controls src="<?php  echo $this->save_file. $md['rand_name'] ?>" preload="metadata"  ></video>
                     </div>
                     <?php  } else{  ?>
                         <div class="col-lg-auto">
                             <img   style="width: 350px;margin-bottom: 22px;"  src="<?php  echo $this->save_file. $md['rand_name'] ?>"  >
                         </div>

                 <?php }  } ?>
             </div>
         <?php }  ?>

         <textarea name="files" id="img" hidden class="form-control"><?php echo  $data['files']?></textarea>
         <?php  if(empty($media)) {  ?>
         <label class="label_files" >  <?php  echo $this->langControl('add')  .' '. $this->langControl('images') ?>  </label>
         <div class="fileupload-wrapper">
             <div id="myUpload">
             </div>
         </div>
          <?php  }  ?>

         <br>
         <br>

         <div class="form-row">
             <div class="col-auto">
                 <label for="validationServer02"> <?php  echo $this->langControl('date') ?>  </label>
                 <input name="date"  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"   value="<?php echo  date('Y-m-d\TH:i:s', $data['date'])  ?>"  class="form-control is-valid" id="validationServer02" >
             </div>
         </div>

         <br>
         <hr>
         <div class="container">
             <div class="row justify-content-md-center ">
                 <div class="col-md-auto">

                     <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save') ?>">
                 </div>
             </div>
         </div>
     </form>
 </div>
    </div>






<script>

    $("#myUpload").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: true,
        multiUpload: true,
        fileTypes: {
            images: [],

        },
        onUploadSuccess: function(response) {
            $('#img').val(response);
            console.log(response)
        },
        onUploadReset: function () {

            $('#myUpload .fileupload-reset').remove();
            $('.label_files').remove();
            $('#myUpload .fileupload-add').remove();
        }
    });
</script>

<style>
    .note-popover .popover-content .dropdown-menu, .card-header.note-toolbar .dropdown-menu
    {

        left: unset !important;
    }
    .custom-control {
        position: relative;
        display: -ms-inline-flexbox;
        display: inline-flex;
        min-height: 1.5rem;
        padding-left: 1.5rem;
        margin-right: 1rem;
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



<br>
<br>
<br>
<br>
















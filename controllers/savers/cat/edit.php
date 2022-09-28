


<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $data['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit_category/<?php echo $id ?>" method="post"  >
            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label for="validationServer01"> اسم الماركة </label>
                    <input value="<?php echo  $data['title']  ?>"  name="title" type="text" class="form-control is-valid" id="validationServer01"  >
                </div>
            </div>


            <br>
            <div class="form-row">
                <div class="col-auto">
                    <label for="validationServer0order_cat"> رقم الترتيب </label>
                    <input value="<?php echo  $data['order_cat']  ?>"  name="order_cat" type="text" class="form-control is-valid" id="validationServer0order_cat"  >
                </div>
            </div>


            <hr>

            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary"  value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



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





<br>







<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('Edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $catg['title'] ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo  $data['title'] ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit/<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="form-row">

                <div class="col-auto my-1">
                    <label class="mr-sm-2" for="inlineFormCustomSelect"> اختر الماركة </label>
                    <select class="custom-select mr-sm-2" name="id_cat" id="inlineFormCustomSelect">
                        <?php foreach ($category as $cat) {  ?>
                            <option <?php if ($data['id_cat'] == $cat['id'] ) echo 'selected'?>  value="<?php echo $cat['id']?>"  >  <?php echo $cat['title']?> </option>

                        <?php } ?>
                    </select>
                </div>

            </div>


            <br>


            <div class="row">
                <div class="col">

                    <div class="row">


                        <div class="col-lg-3 col-md-3 col-sm-3 align-self-end">
                            <label for="validationServer01">  اسم السلسة  </label>
                            <input   name="title" type="text"   class="form-control is-valid" id="validationServer01"  value="<?php echo $data['title'] ?>"  required/>
                        </div>

                </div>


                </div>
            </div>
            <br>
            <hr>


            <div class="container">
                <div class="row justify-content-md-center ">
                    <div class="col-md-auto">
                        <input  class="btn btn-primary" type="submit" name="submit" value="حفظ">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<style>
    .title_type_d
    {
        margin-top: 8px;
    }

    .code_m
    {
        margin-top: 5px;
    }
    button.btn.add_new_sub_row {
        margin-top: 12px;
    }
    button.btn.remove_sub_row {
        padding: 0;
        background: transparent;
        color: red;
        font-size: 25px;
    }

    .remove_div
    {
        position: absolute;
        left: 13px;
        padding: 0;
        top: -14px;
        background: #f5f6f7;
        border: 0;
    }

    .remove_div i
    {
        color: red;
        font-size: 28px;
    }
    .addPs
    {
        color: #FFFFFF !important;
    }
    .x_down
    {
        position: relative;
        margin-bottom: 25px;
        border: 1px solid #eeeff0;
        border-bottom: 1px solid #d5d7d8;
        padding-bottom: 22px;
        background: #eeeff08a;
    }
</style>


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
<br>
<br>
<br>




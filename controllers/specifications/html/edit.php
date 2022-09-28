


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('list_category') ?> </a></li>
                <li class="breadcrumb-item"> <a href="<?php  echo url.'/'.$this->folder?>/list_specifications/<?php  echo $result['model']?>"><?php  echo $this->langControl($result['model']) ?></a>     </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('edit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $result['title']?> </li>
            </ol>
        </nav>

        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/edit_specifications/<?php echo $id ?>" method="post" enctype="multipart/form-data">

            <br>

            <div class="row">
                <div class="col">

                    <div class="row x_down">

                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label for="validationServer01"> عنوان الصفة   </label>
                            <input   name="title" type="text"  class="form-control is-valid" id="validationServer01"  value="<?php  echo $result['title']?>"  required/>
                        </div>
                        <div class="col-auto align-self-end">
                            <button type="button" class="btn add_new_sub_row" onclick="xxx(0,'first')">  <i class="fa fa-plus-circle"></i> </button>
                        </div>
                        <div class="col-12">
                            <div class="new_sub_row_first">

                                <?php  foreach ($specif as $key => $sp) {  ?>

                                    <div class="row code_m align-items-end " id="remove_sub_row_db<?php echo $sp['id']?>">
                                        <div class="col-lg-3 ">
                                            <input   name="item[<?php echo $sp['id']?>]" type="text"  class="form-control is-valid" id="validationServer02" placeholder="الخاصية" value="<?php echo $sp['item']?>"  required/>
                                        </div>
                                        <?php if ($key !=0) {  ?>

                                            <div class="col-auto">
                                                <button type="button" class="btn remove_sub_row" onclick="remove_sub_row_db(<?php echo $sp['id']?>)"> <i class="fa  fa-times-circle"></i> </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>


                            </div>

                        </div>

                    </div>



                </div>
            </div>


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

<script>



    var upxcol;
    count = 0;


    sub_count=0;
    function xxx(x,class_is) {
        sub_count += 1;
        $('.new_sub_row_'+class_is).append(`

                <div class="row  align-items-end code_m remove_sub_row_${sub_count}">

                   <div class="col-lg-3 ">

                    <input   name="item[new${sub_count}]" type="text"  class="form-control is-valid" id="validationServer02" placeholder="الخاصية" value=""  required/>
                   </div>



                   <div class="col-auto">
                   <button type="button" class="btn remove_sub_row" onclick="remove_sub_row(${sub_count})"> <i class="fa  fa-times-circle"></i> </button>
                    </div>

                </div>

                   `)
    }


    function remove_sub_row(id) {
        $('.remove_sub_row_'+id).remove();
    }

    function remove_sub_row_db(id) {

        $.get( "<?php  echo url . '/' . $this->folder  ?>/remove_sub_row_db/"+id, function( data ) {

            $('#remove_sub_row_db'+id).remove();

        });


    }

</script>



<style>

    .code_m
    {
        margin-top: 15px;
    }
    button.btn.add_new_sub_row {
        padding: 0;
        background: transparent;
        color: #218838;
        font-size: 25px;
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



<br>
<br>




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


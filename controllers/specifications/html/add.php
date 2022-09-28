


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('list_category') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl($model) ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/add_specifications/<?php echo $model ?>" method="post" enctype="multipart/form-data">

            <br>

            <div class="row">
                <div class="col">

                        <div class="row x_down">

                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label for="validationServer01"> عنوان الصفة   </label>
                                <input   name="title[]" type="text"  class="form-control is-valid" id="validationServer01"  value=""  required/>
                            </div>



                            <div class="col-auto align-self-end">
                                <button type="button" class="btn add_new_sub_row" onclick="xxx(0,'first')">  <i class="fa fa-plus-circle"></i> </button>
                            </div>

                            <div class="col-12">
                                <div class="new_sub_row_first">
                                   <div class="row code_m">
                                       <div class="col-lg-3 ">
                                           <label for="validationServer01"> الخاصية    </label>
                                           <input   name="item[0][]" type="text"  class="form-control is-valid" id="validationServer0_code"  placeholder="الخاصية" value="" required />
                                       </div>
                                   </div>

                                </div>

                            </div>

                        </div>

                        <div class="blockPs AddButton">
                        </div>

                    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add')?> <i class="fa fa-plus-circle"></i> </a>


                </div>
            </div>

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

<script>



    var upxcol;
    count = 0;
    $('.addPs').click(function() {

        count += 1;
        upxcol = 'new'+count;
        id_div = 'id_r_'+count;
        sub_add = 'sub_add_'+count;

        $('.blockPs:last').before(`<div class="blockPs">
                             <div  id="${id_div}" class="row x_down">

                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <label for="validationServer01"> عنوان الصفة  </label>
                                <input   name="title[]" type="text"  class="form-control is-valid" id="validationServer01"  value=""  required/>
                            </div>


                            <div class="col-auto align-self-end">
                                <button type="button" class="btn add_new_sub_row"  onclick="xxx(${count},'${sub_add}')">  <i class="fa fa-plus-circle"></i> </button>
                            </div>
                            <div class="col-12 new_sub_row_${sub_add}">
                                <div class="row ">
                                   <div class="col-lg-3 code_m">
                                       <label for="validationServer01"> الخاصية    </label>
                                        <input    name="item[${count}][]" type="text"  class="form-control is-valid" id="validationServer0_code"  placeholder="الخاصية" value="" required />
                                    </div>

                             </div>
                           </div>
                         <button class="btn remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </button>
                       </div>
                       </div>`);

        for (i=0;i<name_country.length;i++)
        {
            $(".custom-select.new_select_"+count+" option[value="+name_country[i]+"]").css('display','none');

        }
    });

    function remove_div(id) {
        $(id).remove();
    }
    sub_count=0;
    function xxx(x,class_is) {
        sub_count += 1;
        $('.new_sub_row_'+class_is).append(`

                <div class="row  align-items-end code_m remove_sub_row_${sub_count}">

                   <div class="col-lg-3 ">

                    <input   name="item[${x}][]" type="text"  class="form-control is-valid" id="validationServer02" placeholder="الخاصية" value=""  required/>
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
            }
        }
    );

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


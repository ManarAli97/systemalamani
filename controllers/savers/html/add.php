


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/add" method="post" enctype="multipart/form-data">
            <div class="form-row">

                    <div class="col-auto my-1">
                        <label class="mr-sm-2" for="inlineFormCustomSelect"> اختر الماركة </label>
                        <select class="custom-select mr-sm-2" name="id_cat" id="inlineFormCustomSelect">
                          <?php foreach ($category as $cat) {  ?>
                            <option value="<?php echo $cat['id']?>"  >  <?php echo $cat['title']?> </option>

                            <?php } ?>
                        </select>
                    </div>

            </div>


            <br>



            <div class="row">
                <div class="col">

                        <div class="row x_down">

                            <div class="col-auto">
                                <label for="validationServer01">  اسم السلسة  </label>
                                <input   name="name_device[]" type="text"  class="form-control is-valid" id="validationServer01" placeholder="مثال: Note"  value=""  required/>
                            </div>



                        </div>

                        <div class="blockPs AddButton">
                        </div>

                    <a class="btn btn-success addPs" id="clickme"> <?php echo  $this->langControl('add_series')?> <i class="fa fa-plus-circle"></i> </a>


                </div>
            </div>
            <br>
            <br>



        <hr>
            <br>
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

    var name_country=[];
    function xx(x)
    {
        $(".custom-select option[value="+x+"]").each(function() {
            $(this).css('display','none');
        });
        name_country.push(x);
    }

    var upxcol;
    count = 0;
    $('.addPs').click(function() {

        count += 1;
        upxcol = 'new'+count;
        id_div = 'id_r_'+count;


        $('.blockPs:last').before(`<div class="blockPs">
                             <div  id="${id_div}" class="row x_down">
                               <div class="col-auto">
                                <label for="validationServer01">  اسم السلسة  </label>
                                <input   name="name_device[]" type="text"  class="form-control is-valid" id="validationServer01" placeholder="مثال: A"  value=""  required/>
                            </div>


                         <button class="btn remove_div"  onclick="remove_div(${id_div})">    <i class="fa  fa-times-circle"></i> </button>
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


</script>



<style>
    .title_type_d
    {
        margin-top: 8px;
    }
    .code_m
    {
        margin-top: 15px;
    }
    button.btn.add_new_sub_row {
        margin: 19px 0 0 0;

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


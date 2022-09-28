<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url .'/'.$this->folder?>/group"><?php  echo $this->langControl('group_user') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page"> <?php  echo $data[0]['name']?>  </li>
                <li class="breadcrumb-item active" aria-current="page"><?php  echo $this->langControl('add') ?></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="row" >

    <div class="col">

        <form   method="post" action="<?php echo url .'/'.$this->folder?>/add/<?php echo $id ?>">


            <div class="row">

                <div class="col-lg-6">
                    <label   for="inlineFormInput">   اسم المستخدم : </label>
                    <input type="text" value="<?php echo $data['username'] ?>" name="username"
                           class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" >
                </div>



                <div class="col-lg-3">
                    <label  for="inlineFormInputGroup"> باسورد :</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input type="password" name="password" class="form-control" id="inlineFormInputGroup"
                               placeholder="Password">
                    </div>
                </div>


                <div class="col-lg-3">

                    <label >الدور : </label>
                    <select name="role" id="role" class="form-control menu_user">
                        <option value="owner">owner</option>
                        <option value="admin">admin</option>
                    </select>
                </div>

                <div class="col-lg-3 mt-3">
                    <label   for="inlineFormInput">   رقم الموظف : </label>
                    <input type="number" value="<?php echo $data['number'] ?>" name="number"
                           class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" >
                </div>


                <div class="col-lg-3 mt-3">

                    <label >تحديد الطابعة : </label>
                    <select name="print" id="print" class="form-control menu_user">

                        <option value="">افتراضي</option>

                        <?php  foreach ($print_devices as $pd ) {  ?>
                            <option value="<?php echo $pd['title'] ?>"><?php echo $pd['title'] ?></option>
                        <?php } ?>
                    </select>
                </div>


                <div class="col-lg-3 mt-3">
                    <label   for="inlineFormInput">  عدد النسخ : </label>
                    <input type="number" value="<?php echo $data['number_copy'] ?>" name="number_copy"
                           class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" >
                </div>

            </div>


            <!--                --><?php // if ($sales_man  ||  $purchases_man   || $delegate_man || $preparation || $direct) {  ?>


            <br>

            <label >القسم المسوؤل علية : </label>
            <br>
            <?php  foreach ($this->category_website as $key => $catg ) {   ?>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"   name="category[]"   value="<?php echo $key ?>" id="customcheckboxInline<?php echo $key ?>"class="custom-control-input">
                    <label class="custom-control-label" for="customcheckboxInline<?php echo $key ?>">  <?php echo $catg ?>  </label>
                </div>

            <?php  }   ?>



            <?php  if ($delegate_man ) {  ?>

                <hr>
                <br>

                <label >  منطقة التسوق :  </label>
                <br>
                <?php  foreach ($region as $keyg => $reg ) {   ?>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox"   name="region[]"   value="<?php echo    $reg['id']  ?>" id="customcheckboxInline<?php echo $keyg ?>" class="custom-control-input">
                        <label class="custom-control-label" for="customcheckboxInline<?php echo $keyg ?>">  <?php echo $reg['title'] ?>  </label>
                    </div>
                <?php  }   ?>
            <?php  }   ?>

            <?php  if ($direct ) {  ?>

                <hr>


                <label >  نوع المستخدم :  </label>
                <br>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio"   name="direct" onchange="money_box_f(this)"  value="1" id="customradioInline-1" class="custom-control-input" required>
                    <label class="custom-control-label" for="customradioInline-1">   مبيعات  </label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio"   name="direct"  onchange="money_box_f(this)" value="2" id="customradioInline-2" class="custom-control-input" required>
                    <label class="custom-control-label" for="customradioInline-2">   تجهيز  </label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio"   name="direct" onchange="money_box_f(this)"  value="3" id="customradioInline-3" class="custom-control-input" required>
                    <label class="custom-control-label" for="customradioInline-3">   مبيعات ومجهز ومحاسب  </label>
                </div>

            <?php  }   ?>

            <div class="row money_box">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <br>
                    <label for="mbox">حجم الصندوق</label>

                    <div class="input-group mb-2">
                        <input type="text"  onkeyup="add_comma(this)" name="money_box" class="form-control">
                        <div class="input-group-prepend">
                            <div class="input-group-text">د.ع</div>
                        </div>
                    </div>

                </div>

                <script>


                    function add_comma(e)
                    {
                        valu=$(e).val();
                        $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }

                </script>
            </div>





            <br>
            <hr>


            <label > اختر نوع عرض السعر للموظف : </label>
            <br>
            <?php  foreach ($this->price_type as $key => $price ) {   ?>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"   name="price_type[]"   value="<?php echo $key ?>" id="price_type<?php echo $key ?>" class="custom-control-input">
                    <label class="custom-control-label" for="price_type<?php echo $key ?>">  <?php echo $price ?>  </label>
                </div>

            <?php  }   ?>
            <br>
            <hr>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="hidden"   name="smart_prepared"   value="0" >
                <input type="checkbox"   name="smart_prepared"   value="1" id="price_type_smart_prepared" class="custom-control-input">
                <label class="custom-control-label" for="price_type_smart_prepared">   تفعيل التجهيز الذكي </label>
            </div>

            <hr>


            <label >   تقرير النواقص:  </label>
            <br>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"   name="shortfalls[]"   value="1" id="customcheckboxInline-shortfalls-1" class="custom-control-input"  >
                <label class="custom-control-label" for="customcheckboxInline-shortfalls-1">   واجهة موظف  </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"   name="shortfalls[]"   value="2" id="customcheckboxInline-shortfalls-2" class="custom-control-input"  >
                <label class="custom-control-label" for="customcheckboxInline-shortfalls-2">   واجهة الادمن  </label>
            </div>


            <hr>


            <label >   تقرير  فحص اكسسوار اصلي :  </label>
            <br>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"   name="check_accessories[]"   value="1" id="customcheckboxInline-check_accessories-1" class="custom-control-input"  >
                <label class="custom-control-label" for="customcheckboxInline-check_accessories-1">   واجهة موظف  </label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox"   name="check_accessories[]"   value="2" id="customcheckboxInline-check_accessories-2" class="custom-control-input"  >
                <label class="custom-control-label" for="customcheckboxInline-check_accessories-2">   واجهة الادمن  </label>
            </div>

            <hr>



            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="hidden"   name="location_out_pull"   value="0">
                <input type="checkbox"  <?php  if ($data['location_out_pull']==1) echo  'checked' ?>  name="location_out_pull"   value="1" id="customcheckboxInline-location_out_pull-1" class="custom-control-input">
                <label class="custom-control-label" for="customcheckboxInline-location_out_pull-1">     سحب من المواقع (401..402..403..999)  </label>
            </div>



            <?php  echo $this->CSRFToken($_SESSION['CSRFToken'])  ?>

            <hr>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <input name="submit" class="btn btn-primary" value="حفظ" type="submit">

                </div>
            </div>


        </form>
        <hr>
    </div>
</div>



<script>


    function money_box_f(e) {
        if ($(e).val() === "3")
        {
            $(".money_box").show();
            $("input[name='money_box']").attr('required','required');
        }else {
            $(".money_box").hide();
            $("input[name='money_box']").removeAttr('required');
        }

    }



</script>



<style>
    .money_box
    {
        display: none;
    }

    table thead tr
    {
        text-align: center;
    }

    table tbody tr td
    {
        text-align: center;
    }


    .d-table
    {
        width:100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }

    .class_delete_row
    {
        background: transparent;
        border-radius: 50%;
        padding: 0;
        width: 35px;
        height: 35px;
        font-size: 28px;
        margin: 0;
    }
    .p_nm
    {
        margin: 0;
    }
    .menu_user
    {
        padding: 0 .75rem;
    }

</style>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>



<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var role = button.data('role') ;
        var modal = $(this);

        modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
        modal.find('#save').css('display','block')

        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url ?>/user/delete/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });

    });
</script>







<?php if(!empty($this->error_form ))  { ?>
    <script>  $(document).ready(function() { $("#errorMsg").modal("show")  }); </script>

    <div class="modal fade" id="errorMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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



<script>


    function visible_edit_price(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_edit_price/"+vis+'/'+id, function(){ })
    }



</script>


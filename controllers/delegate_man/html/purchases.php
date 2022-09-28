


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('delegate_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  شراء  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">



            <div class="row">
                <div class="col">

                    <div class="row x_down">

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer01">  القسم   </label>
                            <input   name="category" type="text" value="<?php  echo $result['category'] ?>" class="form-control is-valid" id="validationServer01"  disabled>
                        </div>
                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="validationServer02">  اسم المادة   </label>
                            <input     type="text" class="form-control is-valid" value="<?php  echo $result['item'] ?>" id="validationServer02"  disabled>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="code">  الكود </label>
                            <input     type="text"  class="form-control is-valid" value="<?php  echo $result['code'] ?>" id="code"   disabled />
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="color">  اسم اللون </label>
                            <input    type="text"  class="form-control is-valid" value="<?php  echo $result['color'] ?>" id="color"    disabled/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="price">  اخر سعر شراء </label>
                            <input    type="text"  class="form-control is-valid" value="<?php  echo $result['price'] ?>" id="price"   disabled/>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="quantity">  الكمية  المطلوبة  </label>
                            <input     type="number"  class="form-control is-valid" value="<?php  echo $result['quantity'] ?>" id="quantity"     disabled/>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="note"> ملاحظة مدير المشتريات </label>
                            <textarea rows="1" placeholder="ملاحظة مدير المشتريات "    id="note"  class="form-control" disabled ><?php  echo $result['note'] ?></textarea>
                        </div>

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <img width="100" src="<?php  echo $result['img'] ?>">
                        </div>
                    </div>

                    <br>
                    <form id="purchasesForm" action="<?php echo url.'/'.$this->folder ?>/purchases_add/<?php echo $id ?>" method="post"  >

                    <div class="row x_down">

                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="price_purchases"> سعر الشراء </label>
                            <input   name="price_purchases" type="text"  class="form-control is-valid"   id="price_purchases"   required/>
                        </div>



                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="sale_quantity"> الكمية التي تم شروائها </label>
                            <input   name="sale_quantity" type="number"  class="form-control is-valid"   id="sale_quantity"   required/>
                        </div>


                        <div class="col-sm-12 col-mb-6 col-lg-4">
                            <label for="note_d"> ملاحظة المندوب </label>
                                <textarea rows="1" placeholder=" ملاحظة المندوب"  name="note_d"   id="note_d"  class="form-control" ></textarea>
                        </div>


                    </div>

                        <hr>

                        <div class="container">
                            <div class="row justify-content-md-center ">
                                <div class="col-md-auto">
                                    <input  class="btn btn-primary"  value="حفظ"  type="submit" name="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



    </div>
</div>




<script>



    $(function() {
        $("#purchasesForm").submit(function (e) {
            e.preventDefault();
            var actionurl = e.currentTarget.action;

            quantity=parseInt($('#quantity').val());
            sale_quantity=parseInt($('#sale_quantity').val());

            if ( sale_quantity > quantity )
            {
                if (confirm('كمية الشراء اكبر من الكمية المطلوبة؟'))
                {

                    $.ajax({
                        url:  actionurl,
                        type: 'post',
                        cache: false,
                        data: $("#purchasesForm").serialize(),
                        success: function (data) {
                            if(data) {
                                alert('تمت عملية الشراء بنجاح');
                                window.location="<?php echo url .'/'. $this->folder ?>"
                            }
                            else if (data)
                            {
                                alert('حدث خطاء')
                            }
                        }
                    })
                }
              return false;
            }else
            {
                $.ajax({
                    url:  actionurl,
                    type: 'post',
                    cache: false,
                    data: $("#purchasesForm").serialize()+'&submit=submit',
                    success: function (data) {
                        if(data) {
                            alert('تمت عملية الشراء بنجاح');
                            window.location="<?php echo url .'/'. $this->folder ?>"
                        }
                        else if (data)
                        {
                           alert('حدث خطاء')
                        }
                    }
                })
            }


        });
    });



</script>



<style>
    .sp_price
    {
        display: none;
    }

</style>




<style>

    .x_down div
    {
        margin-bottom: 30px;
    }
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


<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"> <?php  echo $this->langControl('check_accessories') ?>  </li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<div class="result"></div>

<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/form_add" method="post"  >

    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer01">  رقم الفاتورة <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="number_bill"   class="form-control"  id="validationServer01"   type="number"  required autocomplete="off">
        </div>
    </div>
    <br>

    <div class="form-group row">
        <label for="input-tags" class="col-sm-12 col-form-label"><span>   سيريال </span> <span style="color: red;font-size: 14px;" id="tags"></span>    </label>
        <div class="col-sm-12 tags_tags">
            <input type="text"  name="serial" class="form-control tags" id="input-tags"    data-role="tagsinput"  required />
        </div>
    </div>


<hr>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-auto">
                <input class="btn btn-primary" id="save_short"  type="submit" name="submit" value="حفظ">
            </div>
        </div>
    </div>

</form>





<script>

    $("#randomInsert").submit(function(e) {

        $('#save_short').attr('disabled','disabled');

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize()+"&submit=submit", // serializes the form's elements.
            success: function(data)
            {

                if (data === 'false')
                {
                    alert('يرجى اضافة حقل واحد على الاقل')
                    $('#save_short').removeAttr('disabled');
                }else if (data ==='true')
                {
                    $('.result').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong> تم الحفظ   </strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>`);

                    setTimeout(function () {
                         window.location=''
                    },1000)

                }else
                {
                    alert('يرجى تسجيل الدخول')
                    $('#save_short').removeAttr('disabled');
                }
            }
        });

    });


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

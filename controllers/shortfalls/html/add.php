<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"> <?php  echo $this->langControl('shortfalls') ?>  </li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<div class="result"></div>

<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/form_add" method="post"  >
	 <div class="form-row">
        <div class="col-lg-3 mb-4">
            <select name="category" class=" form-control dropdown_filter" id="category" required >
            <option value = ''> اختر القسم</option>
                <?php foreach ($this->category_website as $key => $value) {   ?>

                     <option value="<?php  echo $key?>"><?php  echo $value?></option>
                <?php  } ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer01">  اسم  المادة <span style="color: red;font-size: 14px;" id="title"> </span>  </label>
            <input name="title" class="form-control"  id="validationServer01"   type="text"  autocomplete="off">
        </div>
    </div>
    <br>

    <br>
    <div class="form-row">
        <div class="col-md-12 mb-12 lg-12">
        <label for="validationServer-code">  رمز المادة <span style="color: red;font-size: 14px;" id="code"> </span>  </label>
            <input name="code" class="form-control"  id="validationServer-code"  type="text" autocomplete="off">
        </div>
    </div>
    <br>




    <style>

        .label_files
        {
            float: right;
            padding: 7px;
            background: #eeeff0;
        }
    </style>


    <span style="color: red;font-size: 14px;" id="files"> </span>
    <br>
        <label class="label_files" >  <?php  echo $this->langControl('add') .' '. $this->langControl('images') ?>  </label>
        <textarea name="files" id="img" hidden class="form-control"></textarea>
        <div class="fileupload-wrapper">
            <div id="myUpload">
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


    $("#myUpload").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image",
        inputName: 'image',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            images: []
        },
        onUploadSuccess: function(response) {
            $('#img').val(response);
            console.log(response)
        }
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
 #category{
        padding: 0 !important;
 		height : 80px
    }
</style>
<?php  } ?>

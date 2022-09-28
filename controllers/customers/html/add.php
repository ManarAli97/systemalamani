
<br>

<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_registration"><?php  echo $this->langControl('registration') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  اضافة زبون  </li>
            </ol>
        </nav>
    </div>

</div>
<hr>




<div class="status_register"></div>
<div class="progress progressx" style="height: 2px;">
    <div  class="progress-bar progress_inter" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<form  id="add_customer" action="<?php  echo url .'/'.$this->folder ?>/form_add_customer" method="post">
    <div class="row align-items-center">
        <div class="col">
            <label> الاسم </label>
            <input type="text" name="name" class="form-control" placeholder="الاسم">
        </div>
        <div class="col-auto">
             او
        </div>
        <div class="col">
            <label> الرقم </label>
            <input type="text" name="phone" value="<?php echo $phone ?>" class="form-control" placeholder="رقم الهاتف">
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-auto">
            <input class="btn btn-primary" type="submit" name="submit" value="حفظ">
        </div>
    </div>

</form>

<style>
    .progressx{
        display: none;
    }

</style>


<script>


    $("#add_customer").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            success: function (result) {
                console.log(result)
                var response = JSON.parse(result);
                if (response.error) {

                    $('.status_register').html(`
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                 يجب كتابة الاسم او الرقم
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                    `)

                } else if (response.done) {

                    $('.status_register').html(`
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                               تمت اضافة الزبون بنجاح سوف يتم تحويلك الى السوق لتسوق لهذا الزبون
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                    `)


                    $('.progressx').css('display','block')
                    var timeleft = 100;
                    var downloadTimer = setInterval(function(){
                        if(timeleft <= 0){
                            clearInterval(downloadTimer);
                        }
                        $('.progressx').css('width',100 - timeleft +'%');
                        timeleft -= 1;
                        if (timeleft===0)
                        {
                            window.location="<?php echo url ?>"
                        }
                    }, 50);



                } else {
                    $('.status_register').html(`
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               فشل الارسال.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                        `)
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })

    });



</script>




<br>

<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.-$this->folder?>/list_registration"><?php  echo $this->langControl('registration') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  بجث  </li>
            </ol>
        </nav>
    </div>

</div>
<hr>






<form  id="search_customer" action="<?php  echo url .'/'.$this->folder ?>/ch_search_c" method="post">
    <div class="row align-items-center">
        <div class="col">
            <input  type="text" id="phonesre" name="name" maxlength="11" minlength="11" required class="form-control" placeholder="رقم الهاتف">
        </div>

        <div class="col">
            <input   class="btn btn-primary" type="submit" name="submit" value="بحث">
        </div>
    </div>

    <hr>

</form>

<div class="status_register"></div>


<script>


    $("#search_customer").submit(function(e) {

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

                console.log(response);

                if (response.error) {

                    $('.status_register').html(`
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span>الرقم غير مسجل هل تريد الاستمرار ?</span>
                          <a class="btn btn-success" href="<?php  echo url .'/'.$this->folder?>/add_customers/${response.error['error']}"> <span>نعم</span> </a>
                          <a class="btn btn-danger"  onclick="notadd()"   > <span>لا</span> </a>

                        </div>

                    `)

                } else if (response.done) {

                    $('.status_register').html(`
                       <div class="row">
                      <div class="col-auto">
                      <a class="btn btn-primary" href="<?php  echo url ?>/register/details_client/${response.done['done']}"> <span>عرض التفاصيل</span> </a>
                      </div>
                       <div class="col-auto">
                        <a class="btn btn-warning"   href="<?php  echo url .'/'.$this->folder ?>/login_customer/${response.done['done']}"> <span>  تسجيل دخول بحساب الزبون   </span> </a>
                       </div>
                    </div>

                    `)

                } else if (response.doner) {

                    $('.status_register').html(`
                       <div class="row">
                      <div class="col-auto">
                      <a class="btn btn-info" href="<?php  echo url ?>/register/view_req/${response.doner['doner']}"> <span>عرض  الطلب</span> </a>
                      </div>
                      <div class="col-auto">
                      <a class="btn btn-primary" href="<?php  echo url ?>/register/details_client/${response.doner['doner']}"> <span>عرض التفاصيل</span> </a>
                      </div>
                       <div class="col-auto">
                        <a class="btn btn-warning"   href="<?php  echo url .'/'.$this->folder ?>/login_customer/${response.doner['doner']}"> <span>  تسجيل دخول بحساب الزبون   </span> </a>
                       </div>
                    </div>

                    `)

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

function notadd() {

    $('.status_register').empty();
    $('#phonesre').val('');

}

</script>
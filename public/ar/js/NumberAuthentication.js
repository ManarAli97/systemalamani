window.onload=function () {
  render();
};
function render() {
    window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}
var str;
function phoneAuth() {

    var number=document.getElementById('number').value;

    $.get( "https://alamani.iq/register/checkphone",{phone:number}, function( data ) {


        if (data==='true')
        {


              str = number;
            var res = str.replace("+964", "");

            number='+964'+res;

            firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                //s is in lowercase
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;
                console.log(coderesult);

                $('.resultPhone').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                       تم ارسال رمز التحقق الى الرقم الذي ادخلته يرجى كتابة في حقل الرمز.  
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                        </div>
                `);

                $('.code_her_sms').show();


            }).catch(function (error) {
                alert(error.message);

            });

        }else
        {

            $('.resultPhone').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  رقم الهاتف الذي ادخلتة غير مرتبط في اي حساب  .
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div> 
                `);
        }

    });




}
function codeverify() {
    var code=document.getElementById('verificationCode').value;
     coderesult.confirm(code).then(function (result) {
        var user=result.user;
        $.post( "https://alamani.iq/register/hashalixcol",{alixcolph:str,alixcolrndid:user.uid}, function( data ) {

                $('.checkedPhone').removeClass('show active');
                $('.resetP').addClass('show active');
                $('.title_tab').text('كلمة السر الجدبدة');

        });

        }).catch(function (error) {
         alert('الرمز الذي ادخلتة انتهت صلاحيتة يرجى اعادة المحاولة');
    });
}



<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item " aria-current="page" >
                    <a href="<?php echo url .'/'. $this->folder ?>/image/<?php  echo $model ?>">   مدير الملفات  </a>

                </li>
                <li class="breadcrumb-item active" aria-current="page" > ضغط الصور  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl($model) ?>  </li>
            </ol>
        </nav>

        <hr>
    </div>
</div>
 <br>
<a class="btn btn-danger back_to" href="<?php echo url .'/'. $this->folder ?>/image/<?php  echo $model ?>">  رجوع  </a>


<div class="initialize">
    جاري التهيئة
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
   </div>
    <br>
</div>




 <button class="btn btn-primary" id="start_resize" onclick="resize_image()" style="display: none">  <span>ابدأ  ضغط حجم </span>  <span id="num_image"></span> <span>صورة</span> </button>

<br>
<br>
<div class="processing_now">
<div class="progress">
    <div class="progress-bar  bg-warning progress_line" role="progressbar" style="width: 0%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>
    <br>
    <div class="count_size"></div>
    <br>
    <div class="print_image">

    </div>

</div>
<script>

    var image='';
    var i=0;
    var count=0;
    setTimeout(function () {
        $.get( "<?php  echo url .'/'. $this->folder ?>/initialize/<?php echo  $model  ?>", function( data ) {
            if (data)
            {
                image=data;
                $('#start_resize').show();
                $('.initialize').hide();
                img= JSON.parse(image)
                count=img.length
                $('#num_image').text(count)
            }else
            {
                $('.initialize').hide();

                $('.back_to').show()
                alert('لا توجد صور ذات حجم غير مقبول')
            }
        });
    },1000);

    function resize_image()
    {
        $('#start_resize').hide();
        $('.processing_now').show();
        loopOn()
    }


    function loopOn() {

        $.get( "<?php  echo url .'/'. $this->folder ?>/zip",{photo:img[i]}, function( data ) {
            if (data)
            {
                $('.print_image').append(`<div><img style="width: 40px" src="<?php echo $this->save_file ?>${data}" >${data}</div>`).scrollTop($('.print_image')[0].scrollHeight);

                i++;
                if (i <  count)
                {

                    $('.count_size').text(i);
                    par= Math.round(((i/ count) * 100)) +"%";
                    $('.progress_line').css('width', par).text(par)
                    loopOn();
                }else
                {
                    $('.count_size').text(i);
                    par= Math.round(((i/ count) * 100)) +"%";
                    $('.progress_line').css('width', par).text(par)
                    setTimeout(function () {
                        alert('انتهت عملية الضغط')
                        $('.back_to').show()

                    },1000)
                }

            }
        });
    }

</script>


<style>

    .print_image
    {
        height: 500px;
        overflow: auto;
        border: 1px solid #efeeee;
        padding: 12px;
        background: #f7f7f7;
    }
.processing_now
{
    display: none;
}
    .back_to
    {
        display: none;
    }
</style>
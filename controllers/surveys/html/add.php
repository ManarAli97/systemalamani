
<body>

   
        <div class="row d-flex justify-content-start">
            <div class="col-md-4 c p-3">
                <a href="<?=url?>" > <img class="logo" width="300" src="<?= url ?>/controllers/surveys/image/logo.png"> </a>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row  d-flex justify-content-center">
                <div class="title question<?=$id ?> col-md-8 c">
                    <h4>
                        <?=$answer['info_next']; ?>
                    </h4>
                </div>
            </div>
            <br>
            <form action="<?php echo url.'/surveys/addFeedBack/'.$id ?>" method="post">


                <div class="row justify-content-center">
                    <div class="col-10 my-2 c">
                        <input class="form-control" type="text" name="number" placeholder="رقم الهاتف">
                    </div>
                    
                    <div class="col-10 my-2 c">
                        <textarea class="form-control" type="text" name="note" placeholder="أكتب ملاحظة"></textarea>
                    </div>
                </div>
                <br>
                <div class="row justify-content-center">
                    <div class="col-md-3 c">
                        <button type="submit" class="w200 btn btn-warning" name="submit">إرسال</button>
                    </div>
                </div>
            </form>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <a href="<?=url.'/surveys/' ?>" ><button type="button" class="btn center btn-info">تصويت جديد</button></a>
        </div>
        <script type="text/javascript">


            $('.vote-btn .img').click(function () { $('.vote-btn .img').removeClass('checkedVote'); $(this).toggleClass('checkedVote'); });


        </script>



</body>

</html>

<body>

    
        <div class="row d-flex justify-content-start">
            <div class="col-md-4 c p-3">
                <a href="<?=url?>" > <img class="logo" width="300" src="<?= url ?>/controllers/surveys/image/logo.png"> </a>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row  d-flex justify-content-center">
                <div class="title question col-md-8 c">
                    <h1>
                        <?=$answer['info_next']; ?>
                    </h1>
                </div>
            </div>
            <br>
            <br>

            <br>

            <br>
            <br>
            <br>

            <a href="<?=url.'/surveys/' ?>" ><button type="button" class="btn center btn-info">تصويت جديد</button></a>
        </div>
        
        <script type="text/javascript">

            $(document).ready(function () {
                


            });

          


        </script>



</body>

</html>
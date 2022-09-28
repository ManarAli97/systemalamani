<?php  $this->publicHeader($this->langSite($this->folder));  ?>




    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>


                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>

                        <li class="breadcrumb-item">  <?php echo $this->langSite($this->folder); ?>   </li>

                    </ol>
                </nav>


                <div class="row align-items-center">
                    <div class="col-auto">
                        الاقسام:
                    </div>
                    <div class="col-lg-6 col-md-8 col">
                        <select style="padding-top: 2px" name="id_cat" class="form-control"   onchange="location = this.value;">

                            <option value="<?php echo url .'/'. $this->folder ?>" selected > كل الاقسام </option>

                            <?php foreach ($category as $cag) {   ?>
                                <option value="<?php echo url .'/'. $this->folder ?>/index/<?php echo $cag['id'] ?>" <?php    if ($cag['id'] == $id) echo 'selected' ?> ><?php echo $cag['title'] ?> </option>
                            <?php  }  ?>
                        </select>
                    </div>
                </div>
                <hr>

                <?php  if (!empty($dataalamani_art))  { ?>


                    <?php  if ($this->setting->get('alamani_art')) { ?>
                        <div class="notexcol">

                            <?php echo $this->setting->get('alamani_art'); ?>

                        </div>
                        <br>
                 <?php }    ?>

                    <div class="row">
                    <?php foreach ($dataalamani_art as $data) {  ?>
                       <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <a href="<?php  echo  url .'/'.$this->folder ?>/details/<?php echo    $data['id']  ?>" class="card cardList">
                            <div class="image_card" style="background-image: url(<?php echo $data['image'] ?>)"></div>
                            <div class="card-body">
                                <div class="card-title title_card">  <?php echo $data['title'] ?> </div>
                            </div>
                        </a>
                      </div>
                    <?php  }  ?>
                 </div>


                <?php  }  else {  ?>

                    <br>
                    <div class="alert alert-danger" role="alert">
                         لا توجد محتويات سوف تتوفر قريبا.
                    </div>
                <?php  }  ?>
            </div>
        </div>
    </div>



    <br>
    <br>


<style>

    .image_card
    {
        height: 260px;
        width: 100%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .cardList
    {
        display: block;
        text-decoration: none !important;
    }

    #links .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 15;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #links .carousel-indicators li {
        box-sizing: content-box;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        width: 30px;
        height: 3px;
        margin-right: 3px;
        margin-left: 3px;
        text-indent: -999px;
        cursor: pointer;
        background-color: #283581;
        background-clip: padding-box;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: .5;
        transition: opacity .6s ease;

    }
    #links  .carousel-indicators .active {
        opacity: 1;
    }
    .notexcol
    {
        border: 1px solid #dddddd;
        padding: 10px 12px;
        border-radius: 5px;
    }
    .title_card
    {
        color: #283581;
        text-align: center;
        padding: 7px 2px;
        font-size: 20px;
        margin: 3px;
        height: 63px;
        overflow: hidden;
    }
    .content_card
    {
        color: #020202d4;
        padding: 8px;
    }



    .blueimp-gallery > .next, .blueimp-gallery > .prev
    {
        color: #fff !important;
    }
    .blueimp-gallery > .close
    {
        color: #fff !important;
    }



    .page.active a
    {
        background: #007bff;
        color: #FFFFFF;
    }

    li.next.disabled a:hover ,li.last.disabled a:hover ,
    li.first.disabled a:hover,li.prev.disabled a:hover{

        cursor: not-allowed;
    }


    .blueimp-gallery > .close {

        left: 15px !important;
        right: auto !important;

    }
 .blueimp-gallery > .title {

        right: 15px !important;
       opacity: 1 !important;
    }


</style>






    <script>



        $(document).ready(function() {

                document.getElementById('links').onclick = function (event) {
                    var  i = 0;
                    blueimp.Gallery(
                        document.getElementById('links').getElementsByTagName('a'),
                        {
                            container: '#blueimp-gallery',
                            carousel: true,
                        }
                    );

                }



    </script>



<?php $this->publicFooter(); ?>
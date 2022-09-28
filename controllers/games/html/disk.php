<?php  $this->publicHeader( $this->langSite($this->folder));  ?>



<div class="disk">


    <div class="image_disk_post">

        <video  autoplay  muted loop >
            <source src="<?php echo $this->static_file_site ?>/image/site/vd-disk2.mp4" type="video/mp4">
            <source src="movie.ogg" type="video/ogg">
            Your browser does not support the video tag.
        </video>
    </div>



    <?php  if ($cat) {  ?>

    <div class="title_page">
       <?php  echo $result['title'] ?>
    </div>
<div class="container">
    <div class="row  "   >

        <?php  foreach ($cate_disk as $key =>  $disk) {  ?>

             <?php  if ($key < 10 ) {  ?>
            <div class="col-lg-4 col-md-4 col-sm-4 mb-4">

            <div class="card">
                <div class="card-header title_card_disk"  >
                    <span>  <?php echo $disk['title'] ?>  </span>
                  </div>
                    <ul class="list-group list-group-flush  list_disk">
                        <?php  foreach ($disk['sub_cat'] as $sub_cat) {  ?>
                        <li class="list-group-item">
                            <a href="<?php  echo url .'/'.$this->folder ?>/list_view/<?php echo $sub_cat['id'] ?>" class="card-link"><?php  echo $sub_cat['title'] ?></a>
                        </li>
                         <?php  } ?>

                    </ul>

            </div>


        </div>
          <?php  } else {  ?>

            <div class="col-lg-6 col-md-6 col-sm-6 mb-1">

                <div class="card">
                    <div class="card-header title_card_disk"  >
                        <span>  <?php echo $disk['title'] ?>  </span>
                    </div>
                    <div class="row">
                        <?php  foreach ($disk['sub_cat'] as $sub_cat) {  ?>

                            <div class="col-6 last_card">
                                <a href="<?php  echo url .'/'.$this->folder ?>/list_view/<?php echo $sub_cat['id'] ?>" class="card-link"><?php  echo $sub_cat['title'] ?></a>

                            </div>
                        <?php  } ?>
                    </div>

                </div>


            </div>
            <?php } ?>
      <?php   } ?>


    </div>
</div>

    <?php } else {  ?>

        <div class="container">
            <div class="alert alert-danger" role="alert">
                 لاتوجد بيانات
            </div>
        </div>
    <?php } ?>



    
</div>

<style>

    .last_card
    {
       border-left:1px solid #dfdfdf;
    }
    .last_card:last-child
    {
       border-left:0 ;
    }
    .last_card a
    {
        padding: 10px 4px;
        display: block;
        color: #283581;
        font-weight: bold;
        background: #ffffff;
        padding-right: 34px;
    }

    .image_disk_post
    {
        margin-top:0px;
        margin-bottom: 5px;
        padding: 10px;
    }
    .image_disk_post video
    {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #dfdfdf;
    }

    .disk{
       min-height: 850px;
        padding-top: 5px;
        /*background-image:url(*/<?php //echo $this->static_file_site ?>/*/image/site/ps5.png) ;*/
        /*background-size: 56%;*/
        /*background-repeat: no-repeat;*/
        /*background-position: center bottom;*/
    }

    .title_card_disk
    {
        position: relative;
    }
    .title_card_disk span
    {
      font-size: 20px;
        font-weight: bold;
    }

    .list_disk li
    {
      padding: 0;
    }
    .list_disk li a {
        padding: 10px 4px;
        display: block;
        color: #283581;
        font-weight: bold;
        background: #ffffff;
        padding-right: 34px;
    }

    .title_page {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 15px;
        text-shadow: 2px 2px #ffffff;
    }


</style>

<?php $this->publicFooter(); ?>
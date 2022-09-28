<?php  $this->publicHeader($this->langSite('how_use'));  ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>

                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item">    <?phP echo $this->langSite('how_use')  ?>  </li>

                    </ol>
                </nav>


             <?php  if (!empty($result))  { ?>


                <div class="row">

                    <?php  foreach ($result as $ret) {  ?>
                    <div class="col-12 lastChildXB" >

                        <div class="section_between_video">

                          <div class="content_how_use">  <?php echo $ret['content'] ?></div>
                        <?php  if ( $ret['img'] != 0 ) { ?>
                            <video  controls style="width: 100%" preload="none" src="<?php echo $ret['video']   ?>#t=0.5"></video>
                        <?php  } ?>
                    </div>
                    </div>
                  <?php  }  ?>

                </div>

                <?php  } else { ?>


                 <div class="alert alert-warning" role="alert">
                     سوف يتم اضافة المحتوى قريبا.
                 </div>

                 <br>
                 <br>
                <?php  }  ?>


            </div>
        </div>
    </div>


    <br>
    <br>

<style>
.section_between_video
{
    border-bottom: 1px solid #e6e5e5;
    padding-bottom: 30px;
    margin-bottom: 30px;
}

    .content_how_use
    {
        margin-bottom: 15px;
    }

    .lastChildXB:last-child .section_between_video
    {
        border-bottom: 0;
    }
</style>


<?php $this->publicFooter(); ?>
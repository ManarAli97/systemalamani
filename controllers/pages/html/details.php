<?php  $this->publicHeader($result['title']);  ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>


                    <nav aria-label="breadcrumb" class="path_bread">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item">    <?phP echo $result['title'] ?>  </li>

                        </ol>
                    </nav>


                <br>

                <div class="row">

                    <div class="col-12">

                        <?phP echo $result['content'] ?>
                        <?php  if ( $result['img'] != 0 ) { ?>
                            <br>
                            <br>

                            <img style="width: 100%" src="<?php echo $file  ?>">


                        <?php  } ?>


                    </div>
                </div>




            </div>
        </div>
    </div>


<br>
<br>




<?php $this->publicFooter(); ?>
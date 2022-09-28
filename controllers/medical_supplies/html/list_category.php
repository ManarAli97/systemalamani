<?php $this->publicHeader($this->langSite('medical_supplies')); ?>


    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">
                <br>


                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">    <?phP echo $this->langSite('medical_supplies') ?>  </li>
                    </ol>
                </nav>




                <div class="row">
                    
                    <?php  foreach ($data as $dta) {  ?>
                    <div class="col-g-4 col-md-4 col-sm-6 col-6">
                        <a class="link_catg_view" href="<?php echo url .'/'. $this->folder ?>/view_medical_supplies/<?php  echo $dta['id']?>">
                        <div class="image_carg">
                             <img src="<?php  echo $dta['image']?> ">
                         </div>
                        <div class="title_catg">
                            <?php  echo $dta['title']?> 
                        </div>
                        
                        </a>
                    </div>
                      <?php  } ?>
                    
                </div>
                


            </div>
        </div>
    </div>


<br>
<br>
<br>
<?php $this->publicFooter(); ?>
<div class="menu_category d-none d-sm-none d-md-none d-lg-block">

    <div id="accordion">

		<?php  if ($this->thisCatg('mobile')){    ?>
        <div class="card row_accordion main_catg mobile_menu">

            <div class="card-header" id="heading-1">

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col-8">
                        <a  class="list_link" data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" ><img class="ion_catg" src="<?php echo $this->static_file_site ?>/image/site/icon_catg.png"></div>
                                <div class="col-8" style="padding-right: 3px" > موبايل </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                            <i class="fa fa-caret-left"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse-1" class="collapse" data-parent="#accordion" aria-labelledby="heading-1">
                    <div class="card-body">

                        <div id="accordionmobile">

                            <?php foreach ($category_site_acc as $key => $cat_s_t) { ?>
                                <div class="card row_accordion">
                                    <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-<?php if ($mobile->ck_sub_cat_public($cat_s_t['id'])) echo 8;  else echo 12 ;?>">
                                                <a  class="list_link" href="<?php  echo url ?>/mobile/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                    <div class="row align-items-center">
                                                        <div class="col-auto" style="padding-left: 3px" >   <?php echo $cat_s_t['image'] ?>   </div>
                                                        <div class="col-<?php if ($mobile->ck_sub_cat_public($cat_s_t['id'])) echo 8;else echo 10 ?>" style="padding-right: 3px" >   <?php echo $cat_s_t['title'] ?> </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php  if ($mobile->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                <div class="col-4">
                                                    <button value="0" onclick="get_sub_mobile(this,<?php  echo $cat_s_t['id'] ?>)" class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                        <i class="fa fa-caret-left"></i>
                                                    </button>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div  id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                            <div class="card-body body_menu_mobile<?php  echo  $cat_s_t['id'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php   } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php  }  ?>



		<?php  if ($this->thisCatg('accessories')){    ?>
        <div class="card row_accordion main_catg accessories_menu">

            <div class="card-header" id="heading-2">

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col-8">
                        <a  class="list_link"    data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-diamond"></i></div>
                                <div class="col-8" style="padding-right: 3px" >  اكسسوارات </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                            <i class="fa fa-caret-left"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse-2" class="collapse" data-parent="#accordion" aria-labelledby="heading-2">
                    <div class="card-body">

                        <div id="accordionmobile">

                            <?php foreach ($category_site_acc_accessories as $key => $cat_s_t) { ?>
                                <div class="card row_accordion">
                                    <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-<?php if ($accessories->ck_sub_cat_public($cat_s_t['id'])) echo 9;  else echo 12 ;?>">
                                                <a  class="list_link" href="<?php  echo url ?>/accessories/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                    <div class="row align-items-center">
                                                        <div class="col-auto" style="padding-left: 3px" >  <?php echo $cat_s_t['image'] ?>  </div>
                                                        <div class="col-<?php if ( $accessories->ck_sub_cat_public($cat_s_t['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px;" >   <?php echo $cat_s_t['title'] ?> </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php  if ($accessories->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                <div   class="col-3" style="padding-right: 1px">
                                                    <button value="0" onclick="get_sub_accessories(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                        <i class="fa fa-caret-left"></i>
                                                    </button>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                            <div class="card-body body_menu_accessories<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php   } ?>

                        </div>

                        <div class="card row_accordion  "  >

                            <div class="card-header" >

                                <div class="row justify-content-between align-items-center">
                                    <div class="col-8">
                                        <a  class="list_link" href="<?php   echo  url ?>/savers/list_view">
                                            <div class="row align-items-center">
                                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-clone"></i>  </div>
                                                <div class="col-8" style="padding-right: 3px" > <?php echo $this->langSite('savers') ?>  </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		<?php  }  ?>

		<?php  if ($this->thisCatg('games')){    ?>
        <div class="card row_accordion main_catg games_menu">

            <div class="card-header" id="heading-4">

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col-8">
                        <a  class="list_link"    data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-gamepad"></i></div>
                                <div class="col-8" style="padding-right: 3px" > <?php echo $this->langSite('games') ?> </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                            <i class="fa fa-caret-left"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse-4" class="collapse" data-parent="#accordion" aria-labelledby="heading-4">
                    <div class="card-body">

                        <div id="accordionmobile">

                            <?php foreach ($category_site_acc_games as $key => $cat_s_t) { ?>
                                <div class="card row_accordion">
                                    <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-<?php if ($games->ck_sub_cat_public($cat_s_t['id'])) echo 8;  else echo 12 ;?>">
                                                <a  class="list_link" href="<?php  echo url ?>/games/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                    <div class="row align-items-center">
                                                        <div class="col-auto" style="padding-left: 3px" >  <?php echo $cat_s_t['image'] ?>  </div>
                                                        <div class="col-<?php if ( $games->ck_sub_cat_public($cat_s_t['id'])) echo 8;else echo 10 ?>" style="padding-right: 3px" >   <?php echo $cat_s_t['title'] ?> </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php  if ($games->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                <div class="col-4">
                                                    <button value="0" onclick="get_sub_games(this,<?php  echo $cat_s_t['id'] ?>)" class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                        <i class="fa fa-caret-left"></i>
                                                    </button>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                            <div class="card-body  body_menu_games<?php  echo  $cat_s_t['id'] ?>">



                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php   } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php  }  ?>

        <?php  if ($this->thisCatg('camera')){    ?>
        <div class="card row_accordion main_catg  camera_menu">

            <div class="card-header" id="heading-5">

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col-8">
                        <a  class="list_link"    data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-video-camera"></i></div>
                                <div class="col-9" style="padding-right: 3px" > <?php echo $this->langSite('camera') ?> </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                            <i class="fa fa-caret-left"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse-5" class="collapse" data-parent="#accordion" aria-labelledby="heading-5">
                    <div class="card-body">

                        <div id="accordionmobile">

                            <?php foreach ($category_site_acc_camera as $key => $cat_s_t) { ?>
                                <div class="card row_accordion">
                                    <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-<?php if ($camera->ck_sub_cat_public($cat_s_t['id'])) echo 9;  else echo 12 ;?>">
                                                <a  class="list_link" href="<?php  echo url ?>/camera/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                    <div class="row align-items-center">
                                                        <div class="col-auto" style="padding-left: 3px" >  <?php echo $cat_s_t['image'] ?>  </div>
                                                        <div class="col-<?php if ( $camera->ck_sub_cat_public($cat_s_t['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px;" >   <?php echo $cat_s_t['title'] ?> </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php  if ($camera->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                <div class="col-3"  style="padding-right: 1px">
                                                    <button  value="0" onclick="get_sub_camera(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                        <i class="fa fa-caret-left"></i>
                                                    </button>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                            <div class="card-body  body_menu_camera<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php   } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php  }  ?>



        <?php  if ($this->thisCatg('network')){    ?>
        <div class="card row_accordion main_catg network_menu">

            <div class="card-header" id="heading-6">

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col-8">
                        <a  class="list_link"    data-toggle="collapse" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-wifi"></i></div>
                                <div class="col-8" style="padding-right: 3px" > <?php echo $this->langSite('network') ?> </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                            <i class="fa fa-caret-left"></i>
                        </button>
                    </div>
                </div>

                <div id="collapse-6" class="collapse" data-parent="#accordion" aria-labelledby="heading-6">
                    <div class="card-body">

                        <div id="accordionmobile">

                            <?php foreach ($category_site_acc_network as $key => $cat_s_t) { ?>
                                <div class="card row_accordion">
                                    <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-<?php if ($network->ck_sub_cat_public($cat_s_t['id'])) echo 9;  else echo 12 ;?>">
                                                <a  class="list_link" href="<?php  echo url ?>/network/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                    <div class="row align-items-center">
                                                        <div class="col-auto" style="padding-left: 3px" > <?php echo $cat_s_t['image'] ?>  </div>
                                                        <div class="col-<?php if ($network ->ck_sub_cat_public($cat_s_t['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px" >   <?php echo $cat_s_t['title'] ?> </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <?php  if ($network->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                <div class="col-3" style="padding-right: 1px">
                                                    <button  value="0" onclick="get_sub_network(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                        <i class="fa fa-caret-left"></i>
                                                    </button>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                            <div class="card-body  body_menu_network<?php  echo  $cat_s_t['id'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php   } ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php  }  ?>


		<?php  if ($this->thisCatg('computer')){    ?>
            <div class="card row_accordion main_catg  camera_menu">

                <div class="card-header" id="heading-8">

                    <div class="row justify-content-between align-items-center main_title_cat">
                        <div class="col-8">
                            <a  class="list_link"    data-toggle="collapse" href="#collapse-8" aria-expanded="false" aria-controls="collapse-8">
                                <div class="row align-items-center">
                                    <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-laptop"></i></div>
                                    <div class="col-9" style="padding-right: 3px" > <?php echo $this->langSite('computer') ?> </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-8" aria-expanded="false" aria-controls="collapse-8">
                                <i class="fa fa-caret-left"></i>
                            </button>
                        </div>
                    </div>

                    <div id="collapse-8" class="collapse" data-parent="#accordion" aria-labelledby="heading-8">
                        <div class="card-body">

                            <div id="accordionmobile">

								<?php foreach ($category_site_acc_computer as $key => $cat_s_t) { ?>
                                    <div class="card row_accordion">
                                        <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-<?php if ($computer->ck_sub_cat_public($cat_s_t['id'])) echo 9;  else echo 12 ;?>">
                                                    <a  class="list_link" href="<?php  echo url ?>/computer/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                        <div class="row align-items-center">
                                                            <div class="col-auto" style="padding-left: 3px" >  <?php echo $cat_s_t['image'] ?>  </div>
                                                            <div class="col-<?php if ( $computer->ck_sub_cat_public($cat_s_t['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px;" >   <?php echo $cat_s_t['title'] ?> </div>
                                                        </div>
                                                    </a>
                                                </div>

												<?php  if ($computer->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <div class="col-3"  style="padding-right: 1px">
                                                        <button  value="0" onclick="get_sub_computer(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-caret-left"></i>
                                                        </button>
                                                    </div>
												<?php  } ?>
                                            </div>
                                            <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                                <div class="card-body  body_menu_computer<?php  echo  $cat_s_t['id'] ?>">

                                                </div>
                                            </div>
                                        </div>
                                    <?php   } ?>
                                    
                                     <div class="col">
                            			<a  class="list_link"    href="<?php echo url ?>/computer_assembly"  >
                               				 <div class="row align-items-center">
                                    		    <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-cubes"></i></div>
                                   				<div class="col-9" style="padding-right: 3px" > <?php echo $this->langSite('computer_assembly') ?> </div>
                                             </div>
                                         </a>
                                  </div>
                                 </div>
                               </div>
								

                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php  }  ?>



		<?php  if ($this->thisCatg('printing_supplies')){    ?>
            <div class="card row_accordion main_catg  network_menu">

                <div class="card-header" id="heading-9">

                    <div class="row justify-content-between align-items-center main_title_cat">
                        <div class="col">
                            <a  class="list_link"    data-toggle="collapse" href="#collapse-9" aria-expanded="false" aria-controls="collapse-9">
                                <div class="row align-items-center">
                                    <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-print"></i></div>
                                    <div class="col-9" style="padding-right: 3px" > <?php echo $this->langSite('printing_supplies') ?> </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapse-9" aria-expanded="false" aria-controls="collapse-9">
                                <i class="fa fa-caret-left"></i>
                            </button>
                        </div>
                    </div>

                    <div id="collapse-9" class="collapse" data-parent="#accordion" aria-labelledby="heading-9">
                        <div class="card-body">

                            <div id="accordionmobile">

								<?php foreach ($category_site_acc_printing_supplies as $key => $cat_s_t) { ?>
                                    <div class="card row_accordion">
                                        <div class="card-header" id="headingmobile_<?php  echo  $cat_s_t['id'] ?>">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-<?php if ($printing_supplies->ck_sub_cat_public($cat_s_t['id'])) echo 9;  else echo 12 ;?>">
                                                    <a  class="list_link" href="<?php  echo url ?>/printing_supplies/list_view/<?php echo $cat_s_t['id'] ?>" >
                                                        <div class="row align-items-center">
                                                            <div class="col-auto" style="padding-left: 3px" >  <?php echo $cat_s_t['image'] ?>  </div>
                                                            <div class="col-<?php if ( $printing_supplies->ck_sub_cat_public($cat_s_t['id'])) echo 9;else echo 10 ?>" style="padding-right: 3px;padding-left: 1px;" >   <?php echo $cat_s_t['title'] ?> </div>
                                                        </div>
                                                    </a>
                                                </div>

												<?php  if ($printing_supplies->ck_sub_cat_public($cat_s_t['id'])) { ?>
                                                    <div class="col-3"  style="padding-right: 1px">
                                                        <button  value="0" onclick="get_sub_printing_supplies(this,<?php  echo $cat_s_t['id'] ?>)"  class="btn btn_open_accordion collapsed"   data-toggle="collapse" href="#collapsemobile_<?php  echo  $cat_s_t['id'] ?>" aria-expanded="false" aria-controls="collapsemobile_<?php  echo  $cat_s_t['id'] ?>">
                                                            <i class="fa fa-caret-left"></i>
                                                        </button>
                                                    </div>
												<?php  } ?>
                                            </div>
                                            <div id="collapsemobile_<?php  echo  $cat_s_t['id'] ?>" class="collapse" aria-labelledby="headingmobile_<?php  echo  $cat_s_t['id'] ?>" data-parent="#accordionmobile" >
                                                <div class="card-body  body_menu_printing_supplies<?php  echo  $cat_s_t['id'] ?>">


                                                </div>
                                            </div>
                                        </div>
                                    </div>

								<?php   } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php  }  ?>




            <div class="card row_accordion main_catg  camera_menu">
                <div class="card-header" id="heading-8">
                    <div class="row justify-content-between align-items-center main_title_cat">
                        <div class="col">
                            <a  class="list_link"    href="<?php echo url ?>/offers"  >
                                <div class="row align-items-center">
                                    <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-gift"></i></div>
                                    <div class="col-9" style="padding-right: 3px" > <?php echo $this->langSite('offers') ?> </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
<!--             <div class="card row_accordion main_catg network_menu ">
                <div class="card-header" id="heading-8">
                    <div class="row justify-content-between align-items-center main_title_cat">
                        <div class="col">
                            <a  class="list_link"    href="< ?php echo url ?>/computer_assembly"  >
                                <div class="row align-items-center">
                                    <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-cubes"></i></div>
                                    <div class="col-9" style="padding-right: 3px" > < ?php echo $this->langSite('computer_assembly') ?> </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div> -->


        <div class="card row_accordion main_catg   camera_menu ">

            <div class="card-header"  >

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col" style="padding-left: 0">
                        <a  class="list_link"   href="<?php echo url ?>/dhuquk_ahlaa" >
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-heart"></i></div>
                                <div class="col" style="padding-right: 3px" > <?php echo $this->langSite('dhuquk_ahlaa') ?> </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="card row_accordion main_catg   network_menu">

            <div class="card-header"  >

                <div class="row justify-content-between align-items-center main_title_cat">
                    <div class="col" style="padding-left: 0">
                        <a  class="list_link"   href="<?php echo url ?>/alamani_art" >
                            <div class="row align-items-center">
                                <div class="col-auto" style="padding-left: 3px" > <i class="fa fa-magic"></i></div>
                                <div class="col" style="padding-right: 3px" > <?php echo $this->langSite('alamani_art') ?> </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>


    </div>




    <script>

        function get_sub_mobile(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_mobile"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/mobile/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_mobile"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }
        function get_sub_games(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_games"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/games/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_games"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }
        function get_sub_camera(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_camera"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/camera/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_camera"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }

        function get_sub_network(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_network"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/network/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_network"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }

        function get_sub_computer(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_computer"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/computer/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_computer"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }

        function get_sub_printing_supplies(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_printing_supplies"+id ).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/printing_supplies/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_printing_supplies"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }


        function get_sub_accessories(e,id)
        {
            if ($(e).val() === '0')
            {
                $(".body_menu_accessories"+id).html(`<div class="loading_sub_menu"><img src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>`);
                $.get( "<?php  echo url ?>/accessories/listSubCategoryMenu_acc/"+id, function( data ) {
                    if (data)
                    {
                        $( ".body_menu_accessories"+id).html( data );
                        $(e).val(1)
                    }
                });
            }

        }

    </script>








    <style>

        .card-body {
            padding: 2px 0px 2px 0;
        }
        .main_catg
        {
            border-top: 1px #dbd9d9 dashed;
        }


        .main_catg:last-child {
            /*border-bottom: 1px #dbd9d9 dashed;*/
        }

        .row_accordion {

            background: transparent;
            border: 0;
            border-radius: 0;
            /*border-top: 1px #dbd9d9 dashed;*/

        }

        .row_accordion  .card-header
        {
            background: transparent;
            padding: 0 10px 1px 0;
            border: none;
            border-radius: 0;

            transition: 0.5s;
        }



        .row_accordion .btn_open_accordion
        {
            background: transparent;
            border-right: 1px solid #635f5f87;
            border-radius: 0;
            color: #635f5f;
            font-size: 19px;
            padding: 3px 16px 0 13px;
        }



        .btn.btn_open_accordion.focus, .btn.btn_open_accordion:focus {
            outline: 0;
            box-shadow: unset;
        }

        .row_accordion .btn_open_accordion i
        {
            transition:  0.5s;
            transform: rotate(-90deg);
        }

        .row_accordion .btn_open_accordion.collapsed i
        {
            transform: rotate(0deg);
        }

        img.ion_catg {
            width: 14px;
        }

        .list_link
        {

            color: black;
        }

        .list_link ,
        .list_link:hover
        {
            text-decoration: none;

        }



        .menu_category {

            padding-top: 26px;

        }

        .loading_sub_menu
        {
            text-align: center;
        }

        .loading_sub_menu img
        {
           width: 25px;
        }


    </style>




</div>



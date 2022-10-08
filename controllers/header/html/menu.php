<br>
<ul class="file-tree">


    <?php  if ($category_mobile) {  ?>
        <li class="mobile"> <a href="#"><?php  echo $this->langControl('mobile') ?></a>

            <a href="<?php echo  url ?>/mobile/add_category"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/admin_category"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/list2_mobile"  style="color: #4CAF50"  data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/barcode"  data-toggle="tooltip" data-placement="top" title="تحديث الباركودات البديلة"><i class="fa fa-barcode" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/mobile/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>



                <?php   if ($this->permit('point', 'mobile')) { ?>
                    <li class="mobile">
                        <a href="<?php echo url  ?>/mobile/point" class="mobile">  رفع ملف excel نقاط المادة </a>
                    </li>
                <?php } ?>

                <?php foreach ($category_mobile as $cat) {   ?>
                    <?php  if ($mobile->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $mobile->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="mobile"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/mobile/list_mobile/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/mobile/edit_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/mobile/add_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/mobile/admin_category/<?php   echo $cat['id']?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $mobile->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/mobile/list_mobile/<?php    echo $cat['id'] ?>" class="mobile"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/mobile/edit_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/mobile/add_category/<?php   echo $cat['id'] ?>"  class="mobile" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>

    <?php  } ?>
    <?php  if ($category_games) {  ?>
        <li class="games"> <a href="#"><?php  echo $this->langControl('games') ?></a>

            <a href="<?php echo  url ?>/games/add_category"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/games/admin_category"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/games/list2_games"  style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/games/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/games/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/games/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>


            <ul>
                <?php   if ($this->permit('point', 'games')) { ?>
                <li class="games">
                    <a href="<?php echo url  ?>/games/point" class="games">  رفع ملف excel نقاط المادة </a>
                </li>
             <?php } ?>
                <li class="games"> <a href="<?php echo url ?>/games/list_class_games"><?php  echo $this->langControl('class_games') ?>
                        <a href="<?php echo  url ?>/games/add_class_games"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_class_games')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                    </a>


                    <?php foreach ($category_games as $cat) {   ?>
                    <?php  if ($games->ck_sub_cat($cat['id'])) { ?>
                <li class="<?php echo $games->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="games"> <?php   echo $cat['title']?> </a>
                    <a href="<?php echo  url ?>/games/list_games/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                    <a href="<?php echo  url ?>/games/edit_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <a href="<?php echo  url ?>/games/add_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    <a href="<?php echo  url ?>/games/admin_category/<?php   echo $cat['id']?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                    <?php   $games->listSubCategory($cat['id'],$id) ?>
                </li>
                <?php  }else { ?>
                    <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/games/list_games/<?php    echo $cat['id'] ?>" class="games"> <?php   echo $cat['title']?></a>

                        <a href="<?php echo  url ?>/games/edit_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="<?php echo  url ?>/games/add_category/<?php   echo $cat['id'] ?>"  class="games" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </li>

                <?php }  } ?>
            </ul>
        </li>
    <?php  } ?>

    <?php  if ($category_camera) {  ?>
        <li class="camera"> <a href="#"><?php  echo $this->langControl('camera') ?></a>

            <a href="<?php echo  url ?>/camera/add_category"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/admin_category"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/list2_camera"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/camera/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>

                <?php   if ($this->permit('point', 'camera')) { ?>

                    <li class="camera">
                        <a href="<?php echo url  ?>/camera/point" class="camera">  رفع ملف excel نقاط المادة </a>
                    </li>

                <?php } ?>

                <?php foreach ($category_camera as $cat) {   ?>
                    <?php  if ($camera->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $camera->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="camera"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/camera/list_camera/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/camera/edit_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/camera/add_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/camera/admin_category/<?php   echo $cat['id']?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $camera->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/camera/list_camera/<?php    echo $cat['id'] ?>" class="camera"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/camera/edit_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/camera/add_category/<?php   echo $cat['id'] ?>"  class="camera" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>

    <?php  } ?>


    <?php  if ($category_printing_supplies) {  ?>
        <li class="printing_supplies"> <a href="#"><?php  echo $this->langControl('printing_supplies') ?></a>

            <a href="<?php echo  url ?>/printing_supplies/add_category"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/admin_category"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/list2_printing_supplies"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/printing_supplies/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>

                <?php   if ($this->permit('point', 'printing_supplies')) { ?>
                    <li class="network">
                        <a href="<?php echo url  ?>/printing_supplies/point" class="printing_supplies">  رفع ملف excel نقاط المادة </a>
                    </li>
                <?php } ?>

                <?php foreach ($category_printing_supplies as $cat) {   ?>
                    <?php  if ($printing_supplies->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $printing_supplies->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="printing_supplies"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/printing_supplies/list_printing_supplies/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/printing_supplies/edit_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/printing_supplies/add_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/printing_supplies/admin_category/<?php   echo $cat['id']?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $printing_supplies->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/printing_supplies/list_printing_supplies/<?php    echo $cat['id'] ?>" class="printing_supplies"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/printing_supplies/edit_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/printing_supplies/add_category/<?php   echo $cat['id'] ?>"  class="printing_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>

    <?php  } ?>


    <?php  if ($category_computer) {  ?>
        <li class="computer"> <a href="#"><?php  echo $this->langControl('computer') ?></a>

            <a href="<?php echo  url ?>/computer/add_category"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/admin_category"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/list2_computer"   style="color: #4CAF50"   data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/computer/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>

                <?php   if ($this->permit('point', 'computer')) { ?>
                    <li class="computer">
                        <a href="<?php echo url  ?>/computer/point" class="camera">  رفع ملف excel نقاط المادة </a>
                    </li>

                <?php } ?>
              <li class="computer">

                    <a href="<?php echo url ?>/computer/list_class_computer"><?php  echo $this->langControl('class_computer') ?>
                        <a href="<?php echo  url ?>/computer/add_class_computer"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_class_computer')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                    </a>

                </li>

                <?php foreach ($category_computer as $cat) {   ?>
                    <?php  if ($computer->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $computer->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="computer"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/computer/list_computer/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/computer/edit_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/computer/add_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/computer/admin_category/<?php   echo $cat['id']?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>

                            <?php   $computer->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/computer/list_computer/<?php    echo $cat['id'] ?>" class="computer"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/computer/edit_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/computer/add_category/<?php   echo $cat['id'] ?>"  class="computer" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>

    <?php  } ?>




    <?php  if ($category_network) {  ?>
        <li class="network"> <a href="#"><?php  echo $this->langControl('network') ?></a>

            <a href="<?php echo  url ?>/network/add_category"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/admin_category"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/list2_network"  style="color: #4CAF50"    data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/list_model_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه   "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/network/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>

                <?php   if ($this->permit('point', 'network')) { ?>
                    <li class="network">
                        <a href="<?php echo url  ?>/network/point" class="network">  رفع ملف excel نقاط المادة </a>
                    </li>
                <?php } ?>

                <?php foreach ($category_network as $cat) {   ?>
                    <?php  if ($network->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $network->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="network"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/network/list_network/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/network/edit_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/network/add_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/network/admin_category/<?php   echo $cat['id']?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $network->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/network/list_network/<?php    echo $cat['id'] ?>" class="network"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/network/edit_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/network/add_category/<?php   echo $cat['id'] ?>"  class="network" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php  } ?>
    <?php  if ($category_accessories) {  ?>
        <li class="accessories"> <a href="#"><?php  echo $this->langControl('accessories') ?></a>

            <a href="<?php echo  url ?>/accessories/add_category"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/admin_category"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/list2_accessories"  style="color: #4CAF50"    data-toggle="tooltip" data-placement="top" title="عرض محتويات كل الاقسام"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/min_max" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="تقرير الحد الادنى والحد الاعلى"><i class="fa fa-arrows-v" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/list_accessories_connect"  data-toggle="tooltip" data-placement="top" title="ربط الاقسام المتشابه في الاواسق "><i class="fa fa-link" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/accessories/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>
                <?php   if ($this->permit('point', 'accessories')) { ?>
                    <li class="accessories">
                        <a href="<?php echo url  ?>/accessories/point" class="accessories">  رفع ملف excel نقاط المادة </a>
                    </li>

                <?php } ?>



                <?php foreach ($category_accessories as $cat) {   ?>
                    <?php  if ($accessories->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $accessories->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="accessories"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/accessories/list_accessories/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/accessories/edit_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/accessories/add_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/accessories/admin_category/<?php   echo $cat['id']?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $accessories->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/accessories/list_accessories/<?php    echo $cat['id'] ?>" class="accessories"> <?php   echo $cat['title']?></a>

                            <a href="<?php echo  url ?>/accessories/edit_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/accessories/add_category/<?php   echo $cat['id'] ?>"  class="accessories" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php  }  ?>


    <?php  if ($this->permit('savers','savers')) {  ?>
        <li class="savers">  <a href="#">  <?php  echo $this->langControl('savers') ?> </a>
            <a href="<?php echo  url ?>/savers/all_cover" style="color: #4CAF50" data-toggle="tooltip" data-placement="top" title="كل الحافظات"><i class="fa fa-list" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/savers/quantity" style="color: #ff0000" data-toggle="tooltip" data-placement="top" title="export excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/savers/unknown"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/savers/unknown2"  data-toggle="tooltip" data-placement="top" title="اضافة مواد غير معرفة بدون تحديد اسم الجهاز"><i class="fa fa-folder-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/savers/type_cover"  data-toggle="tooltip" data-placement="top" title=" تحديث الاسم الاتيني "><i class="fa fa-undo" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/savers/active"  data-toggle="tooltip" data-placement="top" title="تفعيل/الغاء تفعيل المواقع و ادخال السيريال عند التجهيز "><i class="fa fa-cog" aria-hidden="true"></i></a>

            <ul>

                <?php   if ($this->permit('point', 'savers')) { ?>
                    <li class="savers">
                        <a href="<?php echo url  ?>/savers/point" class="savers">  رفع ملف excel نقاط المادة </a>
                    </li>

                <?php } ?>

                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_category"> <?php  echo $this->langControl('brands') ?> </a>
                    <a href="<?php echo url ?>/savers/add_category" class="savers" data-toggle="tooltip"
                       data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </li>

                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_savers"> <?php  echo $this->langControl('hardware_chains') ?> </a>
                    <a href="<?php echo url ?>/savers/add" class="savers" data-toggle="tooltip"
                       data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </li>

                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_type_device"> <?php  echo $this->langControl('type_device') ?> </a>
                    <a href="<?php echo url ?>/savers/add_type_device" class="savers" data-toggle="tooltip"
                       data-placement="top" title="<?php echo $this->langControl('add') ?>"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </li>

                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_cover_material">  <?php echo $this->langControl('cover_material') ?>   </a>
                </li>
                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_type_cover">  <?php echo $this->langControl('type_cover') ?>   </a>
                </li>


                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/list_feature_cover">  <?php echo $this->langControl('feature_cover') ?>   </a>
                </li>


                <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/open_savers"> عرض الحافظات </a>
                </li>

				 <li class="savers">
                    <a class="savers" href="<?php echo url?>/savers/full_report">   تقرير شامل  </a>
                </li>


            </ul>
        </li>

    <?php }  ?>



    <?php  if ($this->permit('specifications','specifications')) {  ?>
        <li class="specifications"> <a href="<?php echo url?>/specifications"> <?php  echo $this->langControl('specifications') ?> </a>
        </li>

    <?php  } ?>

    <?php  if ($this->permit('files','files')) {  ?>
        <li class="files">  <a href="#">  مدير الملفات </a>

            <ul>
                <?php  foreach ($this->category_website as $key => $catg)  { ?>
                  <?php  if ($key !='product_savers') {  ?>
                    <li class="files">
                        <a class="files" href="<?php echo url?>/files/image/<?php  echo $key ?>">  <?php  echo $catg ?> </a>

                    </li>
                <?php } ?>
                <?php } ?>
            </ul>

        </li>

    <?php  }  ?>

    <?php  if ($this->permit('excel','excel')) {  ?>
        <li class="excel">  <a href="#">  <?php  echo $this->langControl('excel') ?> </a>

            <ul>

                <?php  foreach ($this->category_website as $key => $cat)  {  ?>
                <?php  if ($key !='product_savers') {  ?>
                 <li class="excel">
                    <a class="excel" href="<?php echo url?>/excel/list_excel/<?php  echo $key ?>" > <?php  echo $this->langControl("add_excel_{$key}") ?> </a>


                    <a href="<?php echo url ?>/excel/add/<?php  echo $key ?>" class="excel" data-toggle="tooltip"
                       data-placement="top" title="<?php echo $this->langControl("add_excel_{$key}") ?>"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i></a>

                    <?php  if ($this->permit("archives_{$key}",'excel')) {  ?>
                        <a href="<?php echo url ?>/excel/archives/<?php  echo $key ?>" class="excel" data-toggle="tooltip"
                           data-placement="top" title="ارشيف"><i
                                class="fa fa-archive" aria-hidden="true" ></i></a>
                    <?php } ?>
                    <a href="<?php echo url ?>/excel/<?php  echo $key ?>_location_set" class="excel" data-toggle="tooltip"
                       data-placement="top" title="مواقع محدده"><i
                            class="fa fa-map-marker" aria-hidden="true" style="color: green"></i></a>


                    <a href="<?php echo url ?>/excel/<?php  echo $key ?>_location_set_not" class="excel" data-toggle="tooltip"
                       data-placement="top" title="مواقع غير محدده"><i
                            class="fa fa-map-marker" aria-hidden="true" style="color: red"></i></a>


                </li>
         <?php  }   ?>
         <?php  }   ?>




                <li class="excel">
                    <a class="excel" href="<?php echo url?>/excel/all_archives"> <?php  echo $this->langControl('all_archives') ?> </a>

                </li>

            </ul>


        </li>

    <?php  }  ?>


    <?php  if ($this->permit('location_model','location_model')) {  ?>
        <li class="location_model">  <a href="#">  <?php  echo $this->langControl('location_model') ?> </a>

            <ul>
                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/mobile">  <i class="fa fa-upload"></i> </a>
                </li>
                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/camera"> <?php  echo $this->langControl('camera') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/camera">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/computer"> <?php  echo $this->langControl('computer') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/computer">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/games"> <?php  echo $this->langControl('games') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/games">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/network"> <?php  echo $this->langControl('network') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/network">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/printing_supplies">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/accessories">  <i class="fa fa-upload"></i> </a>
                </li>
                <li class="location_model">
                    <a class="location_model" href="<?php echo url?>/location_model/list_location/savers"> <?php  echo $this->langControl('savers') ?> </a>
                    <a class="location_model" href="<?php echo url?>/location_model/add/savers">  <i class="fa fa-upload"></i> </a>
                </li>

            </ul>


        </li>

    <?php  }  ?>



    <?php  if ($this->permit('location_confirm','location_confirm')) {  ?>
        <li class="location_confirm">  <a href="#">  <?php  echo $this->langControl('location_confirm') ?> </a>

            <ul>
                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/mobile">  <i class="fa fa-upload"></i> </a>
                </li>
                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/camera"> <?php  echo $this->langControl('camera') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/camera">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/computer"> <?php  echo $this->langControl('computer') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/computer">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/games"> <?php  echo $this->langControl('games') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/games">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/network"> <?php  echo $this->langControl('network') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/network">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/printing_supplies">  <i class="fa fa-upload"></i> </a>
                </li>

                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view_acc_and_cover/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/accessories">  <i class="fa fa-upload"></i> </a>
                </li>
                <li class="location_confirm">
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/view_acc_and_cover/savers"> <?php  echo $this->langControl('savers') ?> </a>
                    <a class="location_confirm" href="<?php echo url?>/location_confirm/add/savers">  <i class="fa fa-upload"></i> </a>
                </li>

            </ul>


        </li>

    <?php  }  ?>


  <?php  if ($this->permit('excel_location','excel_location')) {  ?>
        <li class="excel_location">  <a href="#">  <?php  echo $this->langControl('excel_location') ?> </a>

            <ul>
                <?php  foreach ($this->category_website as $key => $model) {   ?>
                <?php  if ($key !='product_savers') {  ?>
                <li class="excel_location">
                    <a class="excel_location" href="<?php echo url?>/excel_location/<?php  echo $key ?>"> <?php  echo $this->langControl($key) ?> </a>
                    <?php  if ($key == 'savers')  { ?>
                    <a class="excel_location" href="<?php echo url?>/excel_location/add_savers/savers/<?php  echo $key ?>">  <i class="fa fa-upload"></i> </a>
                        <?php }else  if ($key == 'accessories') { ?>

                        <a class="excel_location" href="<?php echo url?>/excel_location/add_accessories/accessories/<?php  echo $key ?>">  <i class="fa fa-upload"></i> </a>

                        <?php } else {  ?>

                        <a class="excel_location" href="<?php echo url?>/excel_location/add/<?php  echo $key ?>">  <i class="fa fa-upload"></i> </a>

                    <?php } ?>

                    <a class="excel_location" href="<?php echo url?>/excel_location/location_backup/<?php  echo $key ?>"  data-toggle="tooltip" data-placement="top"  title="تفاصيل تأكيد كمية المواقع"  >  <i class="fa fa-map-marker"></i> </a>
                    <?php  if ($this->permit('zero_location','excel_location')) {  ?>
                        <a class="excel_location" href="<?php echo url?>/excel_location/zero_location/<?php  echo $key ?>"    data-toggle="tooltip" data-placement="top"  title="تصفير كمية المواقع"    >  <i class="fa fa-circle-o"></i> </a>
                    <?php } ?>
                </li>
                <?php } ?>
                <?php } ?>

            </ul>


        </li>

    <?php  }  ?>





    <?php  if ($this->permit('case_reports','case_reports')) {  ?>
        <li class="case_reports">  <a href="#">  <?php  echo $this->langControl('case_reports') ?> </a>

            <ul>
                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/mobile"> <?php  echo $this->langControl('mobile') ?> </a>
                </li>
                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/camera"> <?php  echo $this->langControl('camera') ?> </a>
                </li>

                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/computer"> <?php  echo $this->langControl('computer') ?> </a>
                </li>

                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/games"> <?php  echo $this->langControl('games') ?> </a>
                </li>

                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/network"> <?php  echo $this->langControl('network') ?> </a>
                </li>

                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/printing_supplies"> <?php  echo $this->langControl('printing_supplies') ?> </a>
                </li>

                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/accessories"> <?php  echo $this->langControl('accessories') ?> </a>
                </li>
                <li class="case_reports">
                    <a class="case_reports" href="<?php echo url?>/case_reports/index/savers"> <?php  echo $this->langControl('savers') ?> </a>
                </li>

            </ul>


        </li>

    <?php  }  ?>





    <?php  if ($this->permit('material_inventory','material_inventory')) {  ?>
        <li class="material_inventory">  <a href="#">  <?php  echo $this->langControl('material_inventory') ?> </a>

            <ul>
                <?php  foreach ($this->category_website as $key => $catg)  { ?>
                <li class="material_inventory">
                    <a class="material_inventory" href="<?php echo url?>/material_inventory/list_material/<?php  echo $key ?>"><?php  echo $catg ?></a>
                    <a class="material_inventory" href="<?php echo url?>/material_inventory/excel_compare/<?php  echo $key ?>" data-toggle="tooltip" data-placement="top" title="مقارنة بين كمية اكسيل كميات واسعار وجرد المواد"><i class="fa fa-exchange"></i></a>
                </li>
                <?php } ?>

            </ul>

        </li>

    <?php  }  ?>
    <?php  if ($this->permit('reports','reports')) {  ?>
        <li class="reports">  <a href="#">  <?php  echo $this->langControl('reports') ?> </a>
            <ul>
                <?php  if ($this->permit('shortage_report','reports')) {  ?>
                    <li class="reports">
                        <a class="reports" href="<?php echo url?>/goods_availability/shortage_report"> <?php  echo $this->langControl('shortage_report') ?> </a>
                    </li>
                <?php  }  ?>
                <?php  if ($this->permit('slack_report','reports')) {  ?>
                    <li class="reports">
                        <a class="reports" href="<?php echo url?>/goods_availability/slack_report"> <?php  echo $this->langControl('slack_report') ?> </a>
                    </li>
                <?php  }  ?>
                <?php  if ($this->permit('user_sales','reports')) {  ?>
                    <li class="reports">
                        <a class="reports" href="<?php echo url?>/total_sales_report"> <?php  echo $this->langControl('user_sales') ?> </a>
                    </li>
                <?php  }  ?>
                <?php  if ($this->permit('daily_sales','reports')) {  ?>
                    <li class="reports">
                        <a class="reports" href="<?php echo url?>/total_sales_report/daily_sales"> <?php  echo $this->langControl('daily_sales') ?> </a>
                    </li>
                <?php  }  ?>
            	<?php  if ($this->permit('report_point_sales','reports')) {  ?>
                    <li class="reports">
                        <a class="reports" href="<?php echo url?>/report/report_point_sales"> <?php  echo $this->langControl('report_point_sales') ?> </a>
                    </li>
                <?php  }  ?>
                   
            </ul>
        </li>
    <?php  }  ?>






    <?php  if ($this->permit('compare_warehouses','compare_warehouses')) {  ?>
        <li class="compare_warehouses">

            <?php if (empty($wc)) { ?>
                <a href="<?php echo url?>/compare_warehouses/add"> <?php  echo $this->langControl('compare_warehouses') ?> </a>
            <?php } else{ ?>
                <?php  foreach ($wc as $w) {  ?>
                    <a href="<?php echo url?>/compare_warehouses/index/<?php echo $w['category'] ?>/<?php echo $w['type'] ?>"> <?php  echo $this->langControl('compare_warehouses') ?> </a>
                <?php } ?>
            <?php } ?>

            <a class="compare_warehouses" href="<?php echo url?>/compare_warehouses/cover"  data-toggle="tooltip" data-placement="top"  title="خاص في الحافظات">  <i class="fa fa-folder-open-o"></i> </a>



        </li>
    <?php  } ?>


    <?php  if ($this->permit('statistics','statistics')) {  ?>
        <li class="statistics"> <a href="<?php echo url?>/statistics"> <?php  echo $this->langControl('statistics') ?> </a> </li>

    <?php  } ?>



    <?php  if ($this->permit('all_active_buy','accountant')) {  ?>
        <li class="accountant">  <a href="<?php echo url?>/accountant" > <?php  echo $this->langControl('accountant') ?>    </a>

            <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $accountant = new accountant();  echo $accountant-> all_notification_buy() ?> </span>

        </li>

        <style>
            span.bellOrder {
                margin-right: 6px;
            }
            .bellOrder .fa-bell
            {
            <?php  if ($accountant-> all_notification_buy() > 0) {  ?>
                color: red;

            <?php  }  ?>
            }

        </style>



    <?php  }  ?>



    <?php  if ($this->permit('all_active_buy','accountant')) {  ?>
        <li class="under_accounting">  <a href="<?php echo url?>/accountant/under_accounting" > <?php  echo $this->langControl('under_accounting') ?>    </a>

            <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $accountant = new accountant();  echo $accountant-> all_notification_buy() ?> </span>

        </li>

        <style>
            span.bellOrder {
                margin-right: 6px;
            }
            .bellOrder .fa-bell
            {
            <?php  if ($accountant-> all_notification_buy() > 0) {  ?>
                color: red;

            <?php  }  ?>
            }

        </style>



    <?php  }  ?>



    <?php  if ($this->permit('all_active_buy','prepared')) {  ?>
        <li class="prepared">  <a href="<?php echo url?>/prepared" > <?php  echo $this->langControl('prepared') ?>    </a>

            <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $prepared = new prepared();  echo $prepared-> all_notification_buy() ?> </span>

        </li>

        <style>
            span.bellOrder {
                margin-right: 6px;
            }
            .bellOrder .fa-bell
            {
            <?php  if ($prepared-> all_notification_buy() > 0) {  ?>
                color: red;

            <?php  }  ?>
            }

        </style>



    <?php  }  ?>

    <?php  if ($this->permit('direct','direct')) {  ?>
        <?php  if ($this->isDirect() || $this->admin($this->userid) )  { ?>
            <?php if ( $_SESSION['direct'] == 2 || $this->admin($this->userid)) { ?>
                <li class="direct">  <a href="<?php echo url?>/direct" > <?php  echo $this->langControl('direct2') ?>    </a>

                    <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $direct = new direct();  echo $direct-> all_notification_buy() ?> </span>

                </li>

                <style>
                    span.bellOrder {
                        margin-right: 6px;
                    }
                    .bellOrder .fa-bell
                    {
                    <?php  if ($direct-> all_notification_buy() > 0) {  ?>
                        color: red;

                    <?php  }  ?>
                    }

                </style>

            <?php  }  ?>
        <?php  }  ?>

    <?php  }  ?>

    <?php  if ($this->permit('direct','direct')) {  ?>
        <?php  if ($this->isDirect() || $this->admin($this->userid) )  { ?>
            <?php if ( $_SESSION['direct'] == 3 || $this->admin($this->userid)) { ?>
                <li class="direct">  <a href="<?php echo url?>/direct/direct3_account" > <?php  echo $this->langControl('direct3') ?>    </a>

                    <span class="bellOrder">   <i class="fa fa-bell "> </i> <?php $direct = new direct();  echo $direct-> all_notification_buy3() ?> </span>

                </li>

                <style>
                    span.bellOrder {
                        margin-right: 6px;
                    }
                    .bellOrder .fa-bell
                    {
                    <?php  if ($direct-> all_notification_buy3() > 0) {  ?>
                        color: red;

                    <?php  }  ?>
                    }

                </style>

            <?php  }  ?>
        <?php  }  ?>

    <?php  }  ?>



    <?php  if ($this->permit('main_log_accountant','main_log_accountant')) {  ?>
        <li class="register">  <a href="<?php echo url?>/main_log_accountant" > <?php  echo $this->langControl('main_log_accountant') ?>    </a>

        </li>

    <?php  }  ?>



    <?php  if ($this->permit('log_accountant','log_accountant')) {  ?>
        <li class="register">  <a href="<?php echo url?>/log_accountant" > <?php  echo $this->langControl('log_accountant') ?>    </a>

        </li>

    <?php  }  ?>


    <?php  if ($this->permit('bill_main_accountant','bill_main_accountant')) {  ?>
        <li class="bill_main_accountant">  <a href="<?php echo url?>/bill_main_accountant" > <?php  echo $this->langControl('bill_main_accountant') ?>    </a>

        </li>

    <?php  }  ?>

    <?php  if ($this->permit('bill_secondary_accountant','bill_secondary_accountant')) {  ?>
        <li class="bill_secondary_accountant">  <a href="<?php echo url?>/bill_secondary_accountant" > <?php  echo $this->langControl('bill_secondary_accountant') ?>    </a>
        </li>
    <?php  }  ?>



    <?php  if ($this->permit('account_bill_purchase_customer','purchase_customer')) {  ?>
        <li class="code"> <a href="<?php echo url ?>/purchase_customer"> <?php  echo $this->langControl('account_bill_purchase_customer') ?> </a> </li>
    <?php  }  ?>



    <?php  if ($this->permit('purchase_customer','purchase_customer')) {  ?>
        <li class="purchase_customer">  <a href="#" > <?php  echo $this->langControl('purchase_customer') ?>    </a>

            <ul>

                <?php  if ($this->permit('purchase','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/purchase"> شراء جهاز </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('purchase_customer','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/search_purchase_customer_bill"> بحث عن فاتورة </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_enter','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_enter">   فواتير شراء مدخلة  </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_note_enter','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_note_enter">   فواتير شراء غير مدخلة  </a>

                        <span class="all_purchase_customer_note_enter_bill">   <i class="fa fa-bell "> </i> <?php $purchase_customer = new purchase_customer();  echo $purchase_customer-> all_purchase_customer_note_enter_bill() ?> </span>

                    </li>

                    <style>
                        span.all_purchase_customer_note_enter_bill {
                            margin-right: 6px;
                        }
                        .all_purchase_customer_note_enter_bill .fa-bell
                        {
                        <?php  if ($purchase_customer-> all_purchase_customer_note_enter_bill() > 0) {  ?>
                            color: red;

                        <?php  }  ?>
                        }

                    </style>


                <?php  } ?>


                <?php  if ($this->permit('group_not_enter','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/group_not_enter">  مجاميع بإنتضار كتابة رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('group_enter','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/group_enter">  مجاميع  تم ادخال  رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>




                <?php  if ($this->permit('bills_checked','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_checked">   فواتير  شراء مدققه   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_note_checked','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_note_checked">   فواتير شراء غير مدققه   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_edit','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_edit">   فواتير  شراء تم التعديل عليها   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_cancel','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/bills_cancel">   فواتير  شراء ملغيه </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('prch_acc','purchase_customer')) {  ?>
                    <li class="purchase_customer"> <a  class="purchase_customer" href="<?php echo url?>/purchase_customer/prch_acc"> فواتير شراء المحاسبين</a> </li>
                <?php  } ?>

            </ul>

        </li>

    <?php  }  ?>




    <?php  if ($this->permit('rewind','rewind')) {  ?>
        <li class="rewind">  <a href="#" > <?php  echo $this->langControl('rewind') ?>    </a>

            <ul>

                <?php  if ($this->permit('search_rewind_bill','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/search_rewind_bill">  بحث عن فاتورة </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_enter','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_enter">   فواتير مرتجع مدخلة  </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_note_enter','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_note_enter">   فواتير مرتجع غير مدخلة  </a>

                        <span class="all_rewind_note_enter_bill">   <i class="fa fa-bell "> </i> <?php $rewind = new rewind();  echo $rewind-> all_rewind_note_enter_bill() ?> </span>

                    </li>

                    <style>
                        span.all_rewind_note_enter_bill {
                            margin-right: 6px;
                        }
                        .all_rewind_note_enter_bill .fa-bell
                        {
                        <?php  if ($rewind-> all_rewind_note_enter_bill() > 0) {  ?>
                            color: red;

                        <?php  }  ?>
                        }

                    </style>

                <?php  } ?>



                <?php  if ($this->permit('group_not_enter','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/group_not_enter">  مجاميع بإنتضار كتابة رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('group_enter','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/group_enter">  مجاميع  تم ادخال  رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>




                <?php  if ($this->permit('bills_checked','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_checked">   فواتير  مرتجع مدققه   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_note_checked','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_note_checked">   فواتير مرتجع غير مدققه   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_edit','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_edit">   فواتير  مرتجع تم التعديل عليها   </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('bills_note_enter_cancel','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_note_enter_cancel">  فواتير مرتجع ملغية غير مدخلة  </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('bills_enter_cancel','rewind')) {  ?>
                    <li class="rewind"> <a  class="rewind" href="<?php echo url?>/rewind/bills_enter_cancel">  فواتير مرتجع ملغية مدخلة  </a> </li>
                <?php  } ?>




            </ul>

        </li>

    <?php  }  ?>








    <?php  if ($this->permit('money_clipper','money_clipper')) {  ?>
        <li class="money_clipper"> <a  href="#"> <?php  echo $this->langControl('money_clipper') ?> </a>
            <ul>
                <?php  if ($this->permit('details_money_clipper','money_clipper')) {  ?>
                    <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/details_money_clipper">  تفاصيل القاصة   </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('record_add_money_clipper','money_clipper')) {  ?>
                    <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/record_add_money_clipper">     سجل الاضافة   الى القاصه  </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('withdraw','money_clipper')) {  ?>
                    <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/withdraw">     سجل السحب من القاصه  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('main_user','money_clipper')) {  ?>
                    <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/main_user">  المحاسبين الرئيسيين   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('secondary_user','money_clipper')) {  ?>
                    <li class="money_clipper"> <a  class="money_clipper" href="<?php echo url?>/money_clipper/secondary_user">  المحاسبين الثانوين  </a> </li>
                <?php  } ?>

            </ul>
        </li>
    <?php  } ?>



    <?php  if ($this->permit('group_location','group_location')) {  ?>
        <li class="code"> <a href="<?php echo url ?>/group_location/list_group_location"> <?php  echo $this->langControl('group_location') ?> </a> </li>
    <?php  }  ?>


    <?php  if ($this->permit('bills_inside_system','bills_inside_system')) {  ?>
        <li class="bills_inside_system">  <a href="#" onclick="noty_menu()" > <?php  echo $this->langControl('bills_inside_system') ?>    </a>
            <span class="delete_bill">   <i class="fa fa-star "> </i> <?php $bills_inside_system = new bills_inside_system();  echo $bills_inside_system-> all_delete_bill() ?> </span>

            <ul>

                <?php  if ($this->permit('search_bill','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/search_bill">    بحث عن فاتورة   </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('all','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system">   كل الفواتير   </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('bills_crystal_enter','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_enter">  فواتر كرستال مدخلة</a> </li>
                <?php  } ?>


                <?php  if ($this->permit('bills_crystal_not_enter','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_not_enter">  فواتر كرستال غير مدخلة   </a>



                        <span class="all_note_enter_bill">   <i class="fa fa-bell "> </i>  <span class="noty_bills_inside_system">   </span> </span>

                    </li>

                    <style>
                        span.all_note_enter_bill {
                            margin-right: 6px;
                        }
                        .all_note_enter_bill .fa-bell
                        {
                        <?php  if ($bills_inside_system-> all_note_enter_bill() > 0) {  ?>
                            color: red;
                        <?php  }  ?>
                        }

                    </style>



                <?php  } ?>


                <?php  if ($this->permit('group_not_enter','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/group_not_enter">  مجاميع بإنتضار كتابة رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('group_enter','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/group_enter">  مجاميع  تم ادخال  رقم فاتورة كرستال لها  </a> </li>
                <?php  } ?>



                <?php  if ($this->permit('bills_checked','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_checked">   فواتير مدققه  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_note_checked','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_note_checked">   فواتير غير مدققه  </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('bills_crystal_edit_bill','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_edit_bill">    فواتير تم التعديل عليها  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_deleted','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_deleted">  <?php echo $this->langControl('bills_deleted') ?> </a>


                        <span class="delete_bill">   <i class="fa fa-star "> </i> <?php $bills_inside_system = new bills_inside_system();  echo $bills_inside_system-> all_delete_bill() ?> </span>

                    </li>

                    <style>
                        span.delete_bill {
                            margin-right: 6px;
                        }
                        .delete_bill .fa-star
                        {
                        <?php  if ($bills_inside_system-> all_delete_bill() > 0) {  ?>
                            color: red;

                        <?php  }  ?>
                        }

                    </style>


                <?php  } ?>


                <?php  if ($this->permit('bills_crystal_note_enter_deleted','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_note_enter_deleted">  <?php echo $this->langControl('bills_crystal_note_enter_deleted') ?>    </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('item_deleted_from_bills','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/item_deleted_from_bills">   <?php echo $this->langControl('item_deleted_from_bills') ?>     </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_crystal_not_enter_cancel','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_not_enter_cancel">   <?php echo $this->langControl('bills_crystal_not_enter_cancel') ?>     </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('bills_crystal_enter_cancel','bills_inside_system')) {  ?>
                    <li class="bills_inside_system"> <a  class="bills_inside_system" href="<?php echo url?>/bills_inside_system/bills_crystal_enter_cancel">   <?php echo $this->langControl('bills_crystal_enter_cancel') ?>     </a> </li>
                <?php  } ?>


            </ul>

        </li>

    <?php  }  ?>





    <?php  if ($this->permit('location_report','location_report')) {  ?>
        <li class="location_report">  <a href="#" >  <?php  echo $this->langControl('location_report') ?>  </a>

            <ul>
                <?php  if ($this->permit('view_location','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/location">  عرض المواقع  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('create_transporter','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/report">  انشاء مناقلة  </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('transport_not_confirm','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/transport_not_confirm">   مناقلات غير مؤكدة    </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/view_transport_not_confirm">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>

                <?php  if ($this->permit('transport_confirm','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/transport_confirm">   مناقلات  مؤكدة    </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/view_transport_confirm">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>

                <?php  if ($this->permit('group_not_enter','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/group_not_enter"> مجاميع بإنتضار كتابة رقم فاتورة كرستال لها   </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/export_group">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>

                <?php  if ($this->permit('group_enter','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/group_enter">  مجاميع تم ادخال رقم فاتورة كرستال لها  </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/export_group_enter">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>
                <?php  if ($this->permit('transport_user','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/transport_user">  عرض المستخدمين </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/transport_user">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>
                <?php  if ($this->permit('store_transport','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/store_transport">  <?php echo $this->langControl('store_transport') ?>   </a> <a data-toggle="tooltip" data-placement="top" title="not click" class="location_report" href="<?php  echo url ?>/location_report/store_transport">   <i style="font-size: 10px" class="fa fa-arrow-right"></i>   </a> </li>

                <?php  } ?>
                <?php  if ($this->permit('code_transport_search','location_report')) {  ?>
                    <li class="location_report"> <a  class="location_report" href="<?php  echo url ?>/location_report/view_transport_search">  <?php echo $this->langControl('code_transport_search') ?>   </a>   </li>

                <?php  } ?>

            </ul>

        </li>

    <?php  }  ?>



    <?php  if ($this->permit('shortfalls','shortfalls')) {  ?>
        <li class="shortfalls">  <a href="#" >  <?php  echo $this->langControl('shortfalls') ?>  </a>

            <ul>
                <?php  if ($this->permit_shortfalls($this->userid,1)) {  ?>
                    <li class="shortfalls"> <a  class="shortfalls" href="<?php  echo url ?>/shortfalls/employee">  واجهة الموظف  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit_shortfalls($this->userid,2)) {  ?>
                    <li class="shortfalls"> <a  class="shortfalls" href="<?php  echo url ?>/shortfalls/list_shortfalls">  واجهة الادمن  </a> </li>
                <?php  } ?>


            </ul>

        </li>

    <?php  }  ?>



    <?php  if ($this->permit('check_accessories','check_accessories')) {  ?>
        <li class="check_accessories">  <a href="#" >  <?php  echo $this->langControl('check_accessories') ?>  </a>

            <ul>
                <?php  if ($this->permit_check_accessories($this->userid,1)) {  ?>
                    <li class="check_accessories"> <a  class="check_accessories" href="<?php  echo url ?>/check_accessories/employee">  واجهة الموظف  </a> </li>
                <?php  } ?>

                <?php  if ($this->permit_check_accessories($this->userid,2)) {  ?>
                    <li class="check_accessories"> <a  class="check_accessories" href="<?php  echo url ?>/check_accessories/list_check_accessories">  واجهة الادمن  </a> </li>
                <?php  } ?>


            </ul>

        </li>

    <?php  }  ?>




    <?php  if ($this->permit('serial_system','serial_system')) {  ?>
        <li class="serial_system">  <a href="#" >  <?php  echo $this->langControl('serial_system') ?>  </a>

            <ul>
                <?php  if ($this->permit('generation_serial','serial_system')) {  ?>
                    <li class="serial_system"> <a  class="serial_system" href="<?php  echo url ?>/serial_system/list_page_serial_system"> <?php  echo  $this->langControl('generation_serial')  ?> </a> </li>
                <?php  } ?>


                <?php  if ($this->permit('report_serial_entry','serial_system')) {  ?>
                    <li class="serial_system"> <a  class="serial_system" href="<?php  echo url ?>/serial_system/list_report_serial_entry"> <?php  echo  $this->langControl('report_serial_entry')  ?> </a> </li>
                <?php  } ?>

                <?php  if ($this->permit('spare_code','serial_system')) {  ?>
                    <li class="serial_system">
                        <a  class="serial_system" href="<?php  echo url ?>/serial_system/list_spare_code"> باركودات بديلة</a>
                        <!--                        <a  class="serial_system" href="--><?php // echo url ?><!--/serial_system/add_spare_code"    data-toggle="tooltip" data-placement="top" title="اضافة باركودات بديلة" ><i class="fa fa-plus"></i> </a>-->
                    </li>
                <?php  } ?>

                <?php  if ($this->permit('serial_conform','serial_system')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/list_serial_conform">مواد بأنتضار ادخال سيريال لها </a></li>
                <?php  } ?>


                <?php  if ($this->permit('serial_material_inventory','serial_system')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/serial_material_inventory">    السيريلات المعرفة  </a></li>
                <?php  } ?>


                <?php  if ($this->permit('jard','serial_system')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/list_jard">  تقرير الجرد </a></li>
                <?php  } ?>


                <?php  if ($this->permit('list_serial_deleted','serial_system')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/list_serial_deleted">  السيريلات المحذوفة </a></li>
                <?php  } ?>


                <?php  if ($this->permit('report_serial_cases','serial_system')) {  ?>
                    <li class="serial_system" ><a href="#"  class="serial_system"> <?php  echo  $this->langControl('report_serial_cases')  ?></a>
                        <ul>
                            <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/selling_mismatched_serial"> <?php  echo  $this->langControl('selling_mismatched_serial')  ?></a></li>
                            <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/serial_over_enter_quantity"> <?php  echo  $this->langControl('serial_over_enter_quantity')  ?></a></li>

                        </ul>


                    </li>
                <?php  } ?>


                <?php  if ($this->permit_user('jard_and_correction')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/list_jard_and_correction"> جرد وتصحيح </a></li>
                <?php  } ?>

                <?php  if ($this->permit('record_quantity_correction','serial_system')) {  ?>
                    <li class="serial_system"><a  class="serial_system" href="<?php  echo url ?>/serial_system/record_quantity_correction">   سجل التصحيح   </a></li>
                <?php  } ?>


            </ul>

        </li>

    <?php  }  ?>






    <?php  if ($this->permit('register','register')) {  ?>
        <li class="register"> <a  href="#"> <?php  echo $this->langControl('registration') ?>

                <a target="_blank" href="<?php echo  url ?>/customers/add_customers"  class="customers" data-toggle="tooltip" data-placement="top" title="اضافة زبون"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                <a href="<?php echo  url ?>/customers/search"  class="customers" data-toggle="tooltip" data-placement="top" title="بحث عن زبون"><i class="fa fa-search" aria-hidden="true"></i></a>

            </a>
            <ul>
                <?php  if ($this->permit('active_customer','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/active">   حظور الزبائن </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers_screen','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers_screen">  زبائن شاشة الحقيقة </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers_order_screen','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers_order_screen">  طلبات الزبائن من شاشة الحقيقة </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers"> عرض الكل </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers_qr','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers_qr">  رمز QR الخاص بالزبائن </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers1','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers1">  زبائن مقتنعين   </a> </li>
                <?php  } ?>
                <?php  if ($this->permit('subscribers2','register')) {  ?>
                    <li class="register"> <a  class="register" href="<?php echo url?>/register/subscribers2">   زبائن غير  مقتنيعين </a> </li>
                <?php  } ?>
            </ul>
        </li>
    <?php  } ?>



    <?php  if ($this->permit('staff_evaluation','staff_evaluation')) {  ?>
        <li class="code"> <a href="<?php echo url?>/staff_evaluation/list_staff_evaluation">  تقييم الموظفين من قبل الزبائن </a> </li>
    <?php  }  ?>



    <?php  if ($this->permit('note_user','note_user')) {  ?>
        <li class="code"> <a href="<?php echo url?>/note_user/list_note_user">   ملاحظة الموظفين على الزبائن</a> </li>
    <?php  }  ?>



    <?php  if ($this->permit('code','code')) {  ?>
        <li class="code"> <a href="<?php echo url?>/code"> <?php  echo $this->langControl('check_code') ?> </a> </li>
    <?php  }  ?>

    <?php  if ($this->permit('report_upload','report')) {  ?>
        <li class="report"> <a href="<?php echo url?>/report/report_upload"> <?php  echo $this->langControl('report_upload') ?> </a> </li>
    <?php  }  ?>

    <?php  if ($this->permit('report_withdrawn','report')) {  ?>
        <li class="report"> <a href="<?php echo url?>/report/report_withdrawn"> <?php  echo $this->langControl('report_withdrawn') ?> </a> </li>
    <?php  }  ?>

    <?php  if ($this->permit('add_material_report','add_material_report')) {  ?>
        <li class="report"> <a href="<?php echo url?>/add_material_report"> <?php  echo $this->langControl('add_material_report') ?> </a> </li>
    <?php  }  ?>

    <?php  if ($this->permit('view_bills','bills')) {  ?>
        <li class="bills"> <a href="<?php echo url?>/bills"> <?php  echo $this->langControl('view_bills') ?> </a> </li>
    <?php  }  ?>

    <?php  if ($this->permit('insert_bills','bills')) {  ?>
        <li class="bills"> <a href="<?php echo url?>/bills/insert_bills"> <?php  echo $this->langControl('insert_bills') ?> </a> </li>
    <?php  }  ?>



    <?php  if ($this->permit('delivery_user','delivery_user')) {  ?>
        <li class="delivery_user"> <a href="<?php echo url?>/delivery_user"> <?php  echo $this->langControl('delivery_user') ?> </a> </li>

    <?php  } ?>



    <?php  if ($this->permit('questions','questions')) {  ?>
        <li class="questions"> <a href="<?php echo url?>/questions/view_questions"> <?php  echo $this->langControl('questions') ?> </a>
            <a  class="questions" href="<?php echo url?>/questions/add" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>">  <i class="fa fa-plus-circle" aria-hidden="true"></i> </a>
        </li>
    <?php  } ?>

    <?php  if ($this->permit('competition','competition')) {  ?>
        <li class="competition">  <a href="<?php echo url?>/competition/view_competition">  اجابات الزبائن على المسابقة </a> </li>

    <?php  } ?>
    <?php  if ($categorygroups) {  ?>
        <li class="groups"> <a href="#"><?php  echo $this->langControl('groups') ?></a>
            <a href="<?php echo  url ?>/groups/add_category"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/groups/admin_category"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <ul>
                <?php foreach ($categorygroups as $cat) {   ?>
                    <?php  if ($groups->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $groups->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="groups"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/groups/edit_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/groups/add_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/groups/admin_category/<?php   echo $cat['id']?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $groups->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/groups/list_groups/<?php    echo $cat['id'] ?>" class="groups"> <?php   echo $cat['title']?></a>
                            <a href="<?php echo  url ?>/groups/edit_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/groups/add_category/<?php   echo $cat['id'] ?>"  class="groups" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php }  ?>


    <?php  if ($this->permit('list_dhuquk_ahlaa','dhuquk_ahlaa')) {  ?>
        <li class="dhuquk_ahlaa"> <a   href="<?php echo  url ?>/dhuquk_ahlaa/admin_category"  class="dhuquk_ahlaa"><?php  echo $this->langControl('dhuquk_ahlaa') ?></a>
            <a href="<?php echo url ?>/dhuquk_ahlaa/add_category" class="dhuquk_ahlaa" data-toggle="tooltip"
               data-placement="top" title="<?php echo $this->langControl('add_category') ?>"><i
                    class="fa fa-plus-circle" aria-hidden="true"></i></a>

        </li>
    <?php }  ?>

    <?php  if ($this->permit('list_alamani_art','alamani_art')) {  ?>
        <li class="alamani_art"> <a   href="<?php echo  url ?>/alamani_art/admin_category"  class="alamani_art"><?php  echo $this->langControl('alamani_art') ?></a>
            <a href="<?php echo url ?>/alamani_art/add_category" class="alamani_art" data-toggle="tooltip"
               data-placement="top" title="<?php echo $this->langControl('add_category') ?>"><i
                    class="fa fa-plus-circle" aria-hidden="true"></i></a>

        </li>
    <?php }  ?>



    <?php  if ($this->permit('list_ads','ads')) {  ?>
        <li class="ads">  <a href="<?php echo url?>/ads/list_ads"> <?php  echo $this->langControl('ads') ?> </a>

            <a href="<?php echo  url ?>/ads/add"  class="ads" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

        </li>

    <?php  }  ?>




    <?php  if ($this->permit('offers','offers')) {  ?>
        <li class="offers">  <a class="offers" href="#">  <?php  echo $this->langControl('offers') ?> </a>

            <ul>

                <?php    if ($this->permit('offer_categories','offers')) {    ?>
                <li class="offers">
                    <a class="offers" href="<?php echo url?>/offers/list_offer_categories">  <?php  echo $this->langControl('offer_categories') ?> </a>
                    <a href="<?php echo  url ?>/offers/add_offer_categories"  class="offers" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

                </li>
                <?php  } ?>

                <?php    if ($this->permit('list_offers','offers')) {    ?>
                    <li class="offers">
                        <a class="offers" href="<?php echo url?>/offers/list_offers">  <?php  echo $this->langControl('offers') ?> </a>

                        <?php    if ($this->permit('add','offers')) {    ?>
                         <a href="<?php echo  url ?>/offers/add"  class="offers" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php    if ($this->permit('offers_active','offers')) {    ?>
                <li class="offers">
                    <a class="offers" href="<?php echo url?>/offers/offers_active">  عروض مفعلة </a>
                </li>
                <?php } ?>


                <?php    if ($this->permit('pending_offers','offers')) {    ?>
                <li class="offers">
                    <a class="offers" href="<?php echo url?>/offers/pending_offers">  عروض معلقة </a>
                </li>
                <?php } ?>

                <?php    if ($this->permit('offers_deleted','offers')) {    ?>
                <li class="offers">
                    <a class="offers" href="<?php echo url?>/offers/offers_deleted">  عروض محذوفة </a>
                </li>
                <?php } ?>

                <?php    if ($this->permit('offers_report','offers')) {    ?>
                    <li class="offers">
                    <a class="offers" href="<?php echo url?>/offers/offers_report">   تقرير العروض   </a>
                </li>
                <?php } ?>
            </ul>


        </li>

    <?php  }  ?>


    <?php  if ($this->permit('computer_assembly','computer_assembly')) {  ?>
        <li class="computer_assembly">  <a class="computer_assembly" href="#">  <?php  echo $this->langControl('computer_assembly') ?> </a>

            <ul>



                <?php    if ($this->permit('list_computer_assembly','computer_assembly')) {    ?>
                    <li class="computer_assembly">
                        <a class="computer_assembly" href="<?php echo url?>/computer_assembly/list_computer_assembly">   عرض التجميعات </a>

                        <?php    if ($this->permit('add','computer_assembly')) {    ?>
                            <a href="<?php echo  url ?>/computer_assembly/add"  class="computer_assembly" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        <?php } ?>
                    </li>
                <?php } ?>

                <?php    if ($this->permit('list_computer_assembly_active','computer_assembly')) {    ?>
                    <li class="computer_assembly">
                        <a class="computer_assembly" href="<?php echo url?>/computer_assembly/list_computer_assembly_active">   تجميعات مفعلة </a>
                    </li>
                <?php } ?>
                <?php    if ($this->permit('list_computer_assembly_stopped','computer_assembly')) {    ?>
                    <li class="computer_assembly">
                        <a class="computer_assembly" href="<?php echo url?>/computer_assembly/list_computer_assembly_stopped">   تجميعات متوقفة </a>
                    </li>
                <?php } ?>
                <?php    if ($this->permit('list_computer_assembly_deleted','computer_assembly')) {    ?>
                    <li class="computer_assembly">
                        <a class="computer_assembly" href="<?php echo url?>/computer_assembly/list_computer_assembly_deleted">   تجميعات  محذوفة </a>
                    </li>
                <?php } ?>

            </ul>


        </li>

    <?php  }  ?>




    <?php  if ($this->permit('list_how_use','how_use')) {  ?>
        <li class="how_use">  <a href="<?php echo url?>/how_use/list_how_use"> <?php  echo $this->langControl('how_use') ?> </a>

            <a href="<?php echo  url ?>/how_use/add"  class="how_use" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>

        </li>

    <?php  }  ?>



    <?php  if ($category_parts) {  ?>
        <li class="parts"> <a href="#"><?php  echo $this->langControl('parts') ?></a>

            <a href="<?php echo  url ?>/parts/add_category"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/parts/admin_category"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>

            <ul>
                <?php foreach ($category_parts as $cat) {   ?>
                    <?php  if ($parts->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $parts->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="parts"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/parts/list_parts/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_content')  ?>"><i class="fa  fa-folder" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/parts/edit_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/parts/add_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/parts/admin_category/<?php   echo $cat['id']?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $parts->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/parts/list_parts/<?php    echo $cat['id'] ?>" class="parts"> <?php   echo $cat['title']?></a>
                            <a href="<?php echo  url ?>/parts/edit_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/parts/add_category/<?php   echo $cat['id'] ?>"  class="parts" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php } ?>


    <?php  if ($categorypages) {  ?>
        <li class="pages"> <a href="#"><?php  echo $this->langControl('pages') ?></a>
            <a href="<?php echo  url ?>/pages/add_category"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/pages/admin_category"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <ul>
                <?php foreach ($categorypages as $cat) {   ?>
                    <?php  if ($pages->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $pages->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="pages"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/pages/edit_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/pages/add_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/pages/admin_category/<?php   echo $cat['id']?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $pages->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>">  <?php   echo $cat['title']?>
                            <a href="<?php echo  url ?>/pages/edit_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/pages/add_category/<?php   echo $cat['id'] ?>"  class="pages" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php  } ?>



    <?php  if ($this->permit('gallery','gallery')) {  ?>
        <li class="gallery"> <a href="#"><?php  echo $this->langControl('gallery') ?></a>
            <a href="<?php echo  url ?>/gallery/add_category"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/gallery/admin_category"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <ul>
                <?php foreach ($category_gallery as $cat) {   ?>
                    <?php  if ($gallery->ck_sub_cat($cat['id'])) { ?>
                        <li class="<?php echo $gallery->sub_cat_active($cat['id'],$id) ?>  card_<?php echo $cat['id']?>"> <a href="#" class="gallery"> <?php   echo $cat['title']?> </a>
                            <a href="<?php echo  url ?>/gallery/edit_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/gallery/add_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/gallery/admin_category/<?php   echo $cat['id']?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                            <?php   $gallery->listSubCategory($cat['id'],$id) ?>
                        </li>
                    <?php  }else { ?>
                        <li class="card_<?php echo $cat['id']?>"> <a href="<?php echo url ?>/gallery/list_gallery/<?php    echo $cat['id'] ?>" class="gallery"> <?php   echo $cat['title']?></a>
                            <a href="<?php echo  url ?>/gallery/edit_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo  url ?>/gallery/add_category/<?php   echo $cat['id'] ?>"  class="gallery" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        </li>

                    <?php }  } ?>
            </ul>
        </li>
    <?php } ?>

    <?php  if ($group_user) {  ?>
        <li class="group"> <a href="#">  <?php  echo $this->langControl('group_user') ?></a>

            <a href="<?php echo  url ?>/user/add_group"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/user/group"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/user/list_all_user"  class="group" data-toggle="tooltip" data-placement="top" title="كل المستخدمين"><i class="fa fa-user" aria-hidden="true"></i></a>

            <ul>
                <?php  foreach ($group_user as $gp_user)  {  ?>
                    <li> <a href="<?php echo url  ?>/user/list_user/<?php echo $gp_user['id']  ?>" class="group"> <?php  echo $gp_user['name'] ?> </a>

                        <a href="<?php echo  url ?>/user/edit_group/<?php   echo $gp_user['id'] ?>"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="<?php echo  url ?>/permit/admin_permit/<?php   echo $gp_user['id'] ?>"  class="group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('permit')  ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>

                    </li>
                <?php  } ?>
            </ul>
        </li>

    <?php } ?>



    <?php    if ($this->permit('truth_screen_questions','truth_screen_questions')) {    ?>
        <li class="truth_screen_questions">
            <a class="truth_screen_questions" href="<?php echo url?>/truth_screen_questions/list_truth_screen_questions">  <?php  echo $this->langControl('truth_screen_questions') ?>  </a>
        </li>
    <?php } ?>



    <?php  if ($this->permit('inbox','inbox')) {  ?>

        <li class="inbox"> <a href="<?php echo url?>/inbox/view_inbox"> <?php  echo $this->langControl('view_inbox') ?> </a> </li>
    <?php  }  ?>
    <?php  if ($this->permit('language','language')) {  ?>
        <li class="languageSite">  <a href="<?php echo url?>/lang/view_lang"> <?php  echo $this->langControl('website_translation') ?> </a> </li>
    <?php } ?>

    <?php  if ($this->permit('setting','setting')) {  ?>
        <li class="setting"> <a href="#"> <?php  echo $this->langControl('setting') ?> </a>
            <ul>
                <li class="setting"> <a class="setting" href="<?php echo url?>/setting/update"> <?php  echo $this->langControl('information') ?> </a></li>
                <li class="setting"> <a class="setting" href="<?php echo url?>/setting/link_social_media"> <?php  echo $this->langControl('link_social_media') ?> </a></li>
                <li class="setting"> <a class="setting" href="<?php echo url?>/setting/image"> <?php  echo $this->langControl('images') ?> </a></li>
                <li class="setting"> <a class="setting" href="<?php echo url?>/setting/changeLanguage"> <?php  echo $this->langControl('changeLanguage') ?> </a></li>

            </ul>
        </li>

    <?php  } ?>



    <?php  if ($this->permit('log','log')) {  ?>
        <li class="log">  <a href="<?php echo url?>/log/view_log" class="log"> <?php  echo $this->langControl('log') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('movement_materials','movement_materials')) {  ?>
        <li class="movement_materials">  <a href="<?php echo url?>/movement_materials" class="movement_materials"> <?php  echo $this->langControl('movement_materials') ?> </a> </li>
    <?php  } ?>
    <?php  if ($this->permit('movement_materials_secondary','movement_materials_secondary')) {  ?>
        <li class="movement_materials_secondary">  <a href="<?php echo url?>/movement_materials_secondary" class="movement_materials_secondary"> <?php  echo $this->langControl('movement_materials_secondary') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('search_serial','search_serial')) {  ?>
        <li class="search_serial">  <a href="<?php echo url?>/search_serial" class="search_serial"> <?php  echo $this->langControl('search_serial') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('dollar_price','dollar_price')) {  ?>
        <li class="dollar_price">  <a href="<?php echo url?>/dollar_price" class="dollar_price"> <?php  echo $this->langControl('dollar_price') ?> </a> </li>
    <?php  } ?>


    <?php  if ($this->permit('range_table','range_table')) {  ?>
        <li class="dollar_price">  <a href="<?php echo url?>/range_table/list_range_table" class="range_table"> <?php  echo $this->langControl('range_table') ?> </a> </li>
    <?php  } ?>


    <?php  if ($this->permit('found','found')) {  ?>
        <li class="found">  <a href="<?php echo url?>/found/view" class="found"> <?php  echo $this->langControl('found') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('print_devices','print_devices')) {  ?>
        <li class="trace">  <a href="<?php  echo url  ?>/print_devices/list_print_devices" class="trace"> <?php  echo $this->langControl('print_devices') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('hide_location','hide_location')) {  ?>
        <li class="trace">  <a href="<?php  echo url  ?>/hide_location/list_hide_location" class="trace"> <?php  echo $this->langControl('hide_location') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('menu_link_device_acc_cover','menu_link_device_acc_cover')) {  ?>
        <li class="trace">  <a href="<?php  echo url  ?>/menu_link_device_acc_cover/list_menu_link_device_acc_cover" class="trace"> <?php  echo $this->langControl('menu_link_device_acc_cover') ?> </a> </li>
    <?php  } ?>



    <?php  if ($this->permit('model_big_q','model_big_q')) {  ?>
        <li class="trace">  <a href="<?php  echo url  ?>/model_big_q/list_model_big_q" class="trace"> <?php  echo $this->langControl('model_big_q') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('trace','trace')) {  ?>
        <li class="trace">  <a href="<?php  echo url  ?>/trace/list_trace" class="trace"> <?php  echo $this->langControl('trace') ?> </a> </li>
    <?php  } ?>


    <?php  if ($this->permit('trace_site','trace_site')) {  ?>
        <li class="trace_site">  <a href="<?php  echo url  ?>/trace_site/list_trace_site" class="trace_site"> <?php  echo $this->langControl('trace_site') ?> </a> </li>
    <?php  } ?>



    <?php  if ($this->permit('surveys','surveys')) {  ?>
        <li class="surveys">  <a href="<?php  echo url  ?>/surveys/view" class="trace_site"> <?php  echo $this->langControl('surveys') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('processing_report','processing_report')) {  ?>
        <li class="processing_report">  <a href="<?php  echo url  ?>/processing_report/list_processing_report" class="trace_site"> <?php  echo $this->langControl('processing_report') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('list_qr_mte','qr_mte')) {  ?>
        <li class="qr_mte">  <a href="<?php  echo url  ?>/qr_mte/list_qr_mte" class="list_qr_mte"> <?php  echo $this->langControl('list_qr_mte') ?> </a> </li>
    <?php  } ?>


    <?php  if ($this->permit('list_report','qr_mte')) {  ?>
        <li class="qr_mte">  <a href="<?php  echo url  ?>/qr_mte/list_report" class="list_report"> <?php  echo $this->langControl('list_report') ?> </a> </li>
    <?php  } ?>

    <?php  if ($this->permit('list_tamayaz_locations','qr_mte')) {  ?>
        <li class="tamayaz_locations">  <a href="<?php  echo url  ?>/tamayaz_locations/list_tamayaz_locations" class="list_tamayaz_locations"> <?php  echo $this->langControl('tamayaz_locations') ?> </a> </li>
    <?php  } ?>
	<?php  if ($this->permit('coupon','coupon')) {  ?>
        <li class="coupon"> <a href="#"> <?php  echo $this->langControl('coupon') ?> </a>
            <ul>
<!--                 < ?php  if ($this->permit('show_coupons','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="< ?php echo url?>/coupon/show_coupons"> < ?php  echo $this->langControl('show_coupons') ?> </a></li>
                < ?php  } ?> -->
            <?php  if ($this->permit('groups_coupons','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="<?php echo url?>/coupon/groups_coupons"> <?php  echo $this->langControl('groups_coupons') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('winners_customers','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="<?php echo url?>/coupon/winners_customers"> <?php  echo $this->langControl('winners_customers') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('list_customer_coupons','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="<?php echo url?>/coupon/list_customer_coupons"> <?php  echo $this->langControl('list_customer_coupons') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('use_coupon','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="<?php echo url?>/coupon/use_coupon"> <?php  echo $this->langControl('use_coupon') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('list_used_coupons','coupon')) {  ?>
                    <li class="coupon"> <a class="coupon" href="<?php echo url?>/coupon/list_used_coupons"> <?php  echo $this->langControl('list_used_coupons') ?> </a></li>
                <?php  } ?>
            </ul>
        </li>

    <?php  } ?>


	 <?php  if ($this->permit('purchase','purchase')) {  ?>
        <li class="purchase"> <a href="#"> <?php  echo $this->langControl('purchase') ?> </a>
            <ul>
                <?php  if ($this->permit('supplier','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/supplier"> <?php  echo $this->langControl('supplier') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('company_shipping','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/company_shipping"> <?php  echo $this->langControl('company_shipping') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('show_currency','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/show_currency"> <?php  echo $this->langControl('currencies') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('show_source_request','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/show_source_request"> <?php  echo $this->langControl('sources_request') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('external_accountants','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/external_accountants"> <?php  echo $this->langControl('external_accountants') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('add_purchase_bill','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/add_purchase_bill"> <?php  echo $this->langControl('purchase_bill') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('report_purchase','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/report_purchase"> <?php  echo $this->langControl('report_purchase') ?> </a></li>
                <?php  } ?>
                <?php  if ($this->permit('item_pur_not_upload','purchase')) {  ?>
                    <li class="purchase"> <a class="purchase" href="<?php echo url?>/purchase/item_pur_not_upload"> <?php  echo $this->langControl('item_pur_not_upload') ?> </a></li>
                <?php  } ?>
            </ul>
        </li>

    <?php  } ?>


    <?php  if ($this->permit('error_quantity','error_quantity')) {  ?>
    <li class="error_quantity">  <a href="#" >  <?php  echo $this->langControl('error_quantity') ?>  </a>

        <ul>
            <?php  if ($this->permit('error_quantity_location_confirm','error_quantity')) {  ?>
                <li class="error_quantity"> <a  class="error_quantity" href="<?php  echo url ?>/error_quantity/location_confirm"> <?php  echo  $this->langControl('error_quantity_location_confirm')  ?> </a> </li>
            <?php  } ?>
            <?php  if ($this->permit('location_tracking_quantity','error_quantity')) {  ?>
                <li class="error_quantity"> <a  class="error_quantity" href="<?php  echo url ?>/error_quantity/location_tracking_quantity"> <?php  echo  $this->langControl('location_tracking_quantity')  ?> </a> </li>
            <?php  } ?>
            <?php  if ($this->permit('location_error_quantity','error_quantity')) {  ?>
                <li class="error_quantity"> <a  class="error_quantity" href="<?php  echo url ?>/error_quantity/location_error_quantity"> <?php  echo  $this->langControl('location_error_quantity')  ?> </a> </li>
            <?php  } ?>
        </ul>
    </li>
    <?php } ?>
<!-- تعويض الزبائن -->
    <?php  if ($this->permit('customers_compensation','customers')) {  ?>
    <li class="customers_compensation">  <a href="#" >  <?php  echo $this->langControl('customers_compensation') ?>  </a>

        <ul>
            <?php  if ($this->permit('customers_compensation_index','customers')) {  ?>
                <li class="customers_compensation"> <a  class="customers_compensation" href="<?php  echo url ?>/customers/customers_compensation_index"> <?php  echo  $this->langControl('customers_compensation_index')  ?> </a> </li>
            <?php  } ?>
            <?php  if ($this->permit('sales_staff_customers_compensation','customers')) {  ?>
                <li class="customers_compensation"> <a  class="customers_compensation" href="<?php  echo url ?>/customers/sales_staff"> <?php  echo  $this->langControl('sales_staff_customers_compensation')  ?> </a> </li>
            <?php  } ?>
            <?php  if ($this->permit('show_all_customers_compensation','customers')) {  ?>
                <li class="customers_compensation"> <a  class="customers_compensation" href="<?php  echo url ?>/customers/show_all_customers_compensation"> <?php  echo  $this->langControl('show_all_customers_compensation')  ?> </a> </li>
            <?php  } ?>
         	<?php  if ($this->permit('customer_report','customers')) {  ?>
                <li class="customers_compensation"> <a  class="customers_compensation" href="<?php  echo url ?>/customers/customer_report"> <?php  echo  $this->langControl('customer_report')  ?> </a> </li>
            <?php  } ?>
        </ul>
    </li>
    <?php } ?>


</ul>

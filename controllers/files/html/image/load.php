<?php foreach ($files as $ns) {   ?>

        <div class="col-lg-4 card_<?php  echo $ns['id']?>"  >
            <div class="card_file  <?php  echo $ns['bigSize'] ?>">

                <a  class="card-img-top image_manager"    href="<?php echo $ns['url']  ?>" data-gallery="" data-unique-id="tmp_<?php echo $ns['id'] ?>"   >

                    <img id="image_device_<?php echo $ns['id'] ?>" width="70px" src="<?php  echo $this->save_file . $ns['img'] ?>">


                </a>



            <div class="card-footer">
                <div class="row justify-content-between icon_">
                    <div class="col-auto">
                        <a onclick="edit(<?php echo $ns['id'] ?>,'<?php  echo $model ?>')" data-toggle="tooltip" data-placement="top" title="تغير"   href="#" class="btn"> <i class="fa fa-refresh"></i> </a>
                    </div>
                    <div class="col-auto">
                        <button type="button"  data-toggle="tooltip" data-placement="top" title="قص الصورة"   class="btn btn-primary btn-sm crop_image" id="btn_crop_image_<?php echo $ns['id'] ?>"   data-ids="<?php echo $ns['id'] ?>"  img="<?php  echo $ns['img'] ?>" data-id="<?php  echo $ns['id'] ?>" data-table="<?php  echo $table ?>"  url="<?php  echo $this->save_file . $ns['img'] ?>" ><i class="fa fa-crop"></i>    </button>
                    </div>

                    <div class="col-auto">
                        <a data-toggle="tooltip" data-placement="top" title="تحميل"  download="<?php echo $ns['normal_name'] ?>" href="<?php echo $ns['url'] ?>" class="btn"> <i class="fa fa-download"></i> </a>
                    </div>
                    <div class="col-auto">
                      <?php   if ($model == 'savers' ) { ?>
                        <a target="_blank"  data-toggle="tooltip" data-placement="top" title="عرض"   href="<?php echo url .'/'.$model.'/details/'.$ns['id_device'] .'/'.$ns['id_item'] ?>" class="btn"> عرض </a>
                        <?php }else{  ?>
                          <a target="_blank"  data-toggle="tooltip" data-placement="top" title="عرض"   href="<?php echo url .'/'.$model.'/details/'.$ns['id_item'] ?>" class="btn"> عرض </a>

                      <?php  } ?>
                    </div>
                    <div class="col-auto size_file_<?php echo $ns['id'] ?>">
                        <?php echo $ns['size'] ?>
                    </div>


                </div>
            </div>
            </div>
        </div>


<?php  } ?>



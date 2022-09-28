<div class="row">


    <?php foreach ($data as $img) { ?>



        <div class="col-auto card_<?php echo $img['id'] ?>"  >
            <div class="card" >
                <img id="img_active_<?php  echo $img['id'] ?>" class="card-img-top imageCateg" style="opacity: <?php echo $img['opacity']?>" src="<?php echo $this->save_file .'/'. $img['rand_name'] ?>" alt="Card image cap">

                <div class="card-body">
                    <p class="card-text">
                        <span id="_img_<?php echo $img['id']?>"> <?php echo $img['normal_name']?>  </span>

                    </p>
                    <div class="dropdown-divider"></div>
                       <?php  if ($this->permit('control_category',$this->folder)) { ?>
            <div class="row setting_padding_Col">
                        <div class="col">
                          <?php   if ($this->permit('edit','gallery')) { ?>
                            <div class="btn-group dropup">
                                <button type="button" class="btn btn_delete"    data-toggle="modal" data-target="#exampleModal_edit" data-id="<?php  echo $img['id']  ?>" > <i class="fa fa-pencil-square-o" style="font-size:36px"></i></button>
                            </div>
                               <?php }  ?>
                        </div>

                        <div class="col">
                            <?php   if ($this->permit('delete','gallery')) { ?>
                            <button type="button" class="btn btn_delete"    data-toggle="modal" data-target="#exampleModal" data-whatever="<?php  echo $img['id']  ?>" data-title="<?php echo $img['normal_name']?> "> <i class="fa fa-trash-o" style="font-size:36px"></i></button>
                            <?php }  ?>
                        </div>
                        <div class="col">
                            <?php   if ($this->permit('visible','gallery')) { ?>
                            <input   <?php  echo $img['checked'] ?>  onchange="active_image(this,<?php echo $img['id']?>)" type="checkbox"   class="vis"     data-on="On" data-off="Off" id="toggle-event"  data-toggle="toggle" datax-stylex="iosx" data-onstyle="success" data-size="small">
                            <?php  } ?>
                       </div>
                    </div>
                       <?php  } ?>
                </div>
            </div>

        </div>


    <?php } ?>
</div>

<?php  foreach ($data as $list_parts) {  ?>
    <div class="border_space_parts"  >

        <div class="row  ">
            <div class="col-lg-4">
                <div class="image_list_parts">
                    <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $list_parts['id'] ?>"  >
                    <img src="<?php echo $list_parts['img'] ?>">
                    </a>
                </div>
            </div>
            <div class="col-lg-8" style="position: relative">
                <div class="title_list_parts">
                    <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $list_parts['id'] ?>"  >
                    <?php echo $list_parts['title'] ?>
                    </a>
                </div>
                <div class="info_parts_list">

                    <span>   &nbsp;  <?php echo $list_parts['view'] ?>  </span>
                    <i class="fa fa-eye"></i> <span
                        style="border-left: 1px solid #d0cccc; "></span>
                    &nbsp;
                    <span>      <?php echo $list_parts['date'] ?>   </span>
                    <i class="fa fa-clock-o"></i> &nbsp;


                </div>
            </div>
        </div>
    </div>
<?php  }  ?>
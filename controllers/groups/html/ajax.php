
<?php  foreach ($data as $list_groups) {  ?>
    <div class="border_space_groups"  >

        <div class="row  ">
            <div class="col-lg-4">
                <div class="image_list_groups">
                    <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $list_groups['id'] ?>"  >
                    <img src="<?php echo $list_groups['img'] ?>">
                    </a>
                </div>
            </div>
            <div class="col-lg-8" style="position: relative">
                <div class="title_list_groups">
                    <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $list_groups['id'] ?>"  >
                    <?php echo $list_groups['title'] ?>
                    </a>
                </div>
                <div class="info_groups_list">

                    <span>   &nbsp;  <?php echo $list_groups['view'] ?>  </span>
                    <i class="fa fa-eye"></i> <span
                        style="border-left: 1px solid #d0cccc; "></span>
                    &nbsp;
                    <span>      <?php echo $list_groups['date'] ?>   </span>
                    <i class="fa fa-clock-o"></i> &nbsp;


                </div>
            </div>
        </div>
    </div>
<?php  }  ?>
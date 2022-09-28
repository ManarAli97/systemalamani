<?php foreach ($files as $ns) {   ?>

        <div class="col-lg-3 card_<?php  echo $ns['id']?>"  >
            <div class="card_file">
            <div class="card-img-top " style="background-video: url()" ></div>

                <video  class="video_manager" controls>
                    <source src="<?php echo $ns['url'] ?>"  type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                    Your browser does not support the video tag.
                </video>


                <div class="card-body">
                <h5 class="card-title">  <?php  echo $ns['normal_name']?> </h5>
             </div>
            <div class="card-footer">
                <div class="row justify-content-between icon_">
                    <div class="col-auto">
                        <a  data-toggle="tooltip" data-placement="top" title="<?php  echo $this->langControl('change') ?>"   href="<?php  echo url .'/'.$this->folder ?>/edit_media/<?php echo $ns['id'] ?>/video" class="btn"> <i class="fa fa-refresh"></i> </a>
                    </div>

                    <div class="col-auto">
                        <a data-toggle="tooltip" data-placement="top" title="<?php  echo $this->langControl('download') ?>"  download="<?php echo $ns['normal_name'] ?>" href="<?php echo $ns['url'] ?>" class="btn"> <i class="fa fa-download"></i> </a>
                    </div>
                    <div class="col-auto">
                        <button  onclick="copy_text(this)" id="copyToClipboard<?php echo $ns['id'] ?>"  class="btn  copyToClipboard"  data-clipboard-text="<?php echo $ns['url'] ?>"  data-toggle="tooltip" data-placement="top" title="copy url"   > <i class="fa fa-copy"></i> </button>
                    </div>

                    <div class="col-auto">
                        <button class="btn" data-toggle="tooltip" data-html="true" title="
                            <table class='table table-bordered table_tooltip' >
                                <tbody>
                                <tr>
                                    <td> <?php  echo $this->langControl('size') ?> </td>
                                    <td> <?php  echo $ns['file_size']?> </td>
                                </tr>

                                <tr>
                                    <td> <?php  echo $this->langControl('category') ?> </td>
                                    <td> <?php  echo $ns['module']?> </td>
                                </tr>
                                <tr>
                                    <td> <?php  echo $this->langControl('type') ?> </td>
                                     <td> <?php  echo $ns['ext']?> </td>

                                </tr>
                                </tbody>
                            </table>

                         "> <i class="fa fa-info-circle"></i> </button>
                    </div>

                    <div class="col-auto">
                        <button class="btn"   data-toggle="modal" data-target="#exampleModal" data-whatever="<?php  echo $ns['id']  ?>" data-title="<?php echo $ns['normal_name']?> "> <i class="fa fa-trash-o"></i> </button>
                    </div>

                </div>
            </div>
            </div>
        </div>


<?php  } ?>



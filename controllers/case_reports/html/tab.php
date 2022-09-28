
<div class="row">

    <div class="col-auto">
        <a class="btn btn-secondary button_report  <?php  if ($active == 'case2') echo 'active_case'  ?>     " href="<?php  echo url .'/'.$this->folder ?>/list_case/<?php  echo $model ?>/2">  مواد غير مرفوعة في اكسل الكميات والاسعار و لها مواقع    </a>
    </div>

    <div class="col-auto">
        <a class="btn btn-secondary    <?php  if ($active == 'case3') echo 'active_case'  ?>    button_report " href="<?php  echo url .'/'.$this->folder ?>/list_case3/<?php  echo $model ?>">  الكمية الكلية اقل من الكمية الموزعة على المواقع   </a>
    </div>

    <div class="col-auto">
        <a class="btn btn-secondary    <?php  if ($active == 'case7') echo 'active_case'  ?>  button_report " href="<?php  echo url .'/'.$this->folder ?>/list_case7/<?php  echo $model ?>">     المواد    داخلة  بموقع غير مسموح الانتقال الها   </a>
    </div>
</div>

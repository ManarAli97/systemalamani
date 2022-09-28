<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>">  مدير المشتريات </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  تفاصيل المنتج المقترح  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="row">
    <div class="col">

 
            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <label for="validationServer01">  اسم المنتج   </label>
                    <input disabled value="<?php echo  $result['item']  ?>"   type="text" class="form-control" id="validationServer01"  >
                </div>
            </div>
        <hr>
        <h3>  صور من المنتج </h3>
        <br>

        
        
        <div class="row">
            <div class="col-lg-6  col-md-6  col-sm-12 ">
                <img class="list_image" src="<?php  echo $this->save_file . $result['image'] ?>">
            </div>
            <?php  if (!empty($image)) {  ?>
            <?php  foreach ($image as $img) {  ?>
                <?php  if (!empty($img)) {  ?>
            <div class="col-lg-6  col-md-6  col-sm-12 ">
                <img class="list_image" src="<?php  echo $this->save_file . $img ?>">
            </div>
            <?php  }  ?>
            <?php  }  ?>
            <?php  }  ?>
        </div>

        <hr>


        <div class="row justify-content-center">
            <div class="col-auto">
                <a class="btn btn-primary"  href="<?php echo url .'/'.$this->folder ?>/edit/<?php  echo $result['id']?>" > موافق على المنتج المقترح  </a>
            </div>
        </div>

        
    </div>
    
</div>


<style>

    .list_image
    {
        width: 100%;
        margin-bottom: 30px;
    }

</style>















<br>
<br>



















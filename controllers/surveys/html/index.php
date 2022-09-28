
<body>

  <main style="overflow-x: hidden;">
    
    <div class="row d-flex justify-content-start">
      <div class="col-md-4 c p-3">
       <a href="<?=url?>" > <img class="logo" width="300" src="<?= url ?>/controllers/surveys/image/logo.png"> </a>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="row  d-flex justify-content-center">
        <div class="title question<?=$id ?> col-md-8 c">
          <h2>
            <?php echo $this->getQuestion($id)?>
          </h2>
        </div>
      </div>
      <br>
      <form class="" method="post">
        <div class="row d-flex justify-content-center">
          <?php foreach($answers as $answer) { ?>
            
            <label class="c question<?=$id ?> vote-btn" for="answers<?=$answer['id']?>">
              <a href="
                <?php if($answer["type_next"]=="q")
                        echo url.'/surveys/index/'.$answer['info_next'].'/'.$answer['id'];
                      else if($answer["type_next"]=="info")
                        echo url.'/surveys/showInfo/'.$answer['id'];
                      else if($answer["type_next"]=="add")
                        echo url.'/surveys/showAdding/'.$answer['id'];

                ?>" >
                <span style="background-image: url('<?php echo $this->imgUrl.$answer['img']; ?>');"
                class="img"></span>
              </a>
                <p>
                  <?= $answer['answer'];?>
                </p>
                <input  required id="answers<?=$answer['id']?>" type="radio" name="vote" value="1">
              </label>
              <?php } ?>
        </div>  
    
    
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <a href="<?=url.'/surveys/' ?>" ><button type="button" class="btn center btn-info">تصويت جديد</button></a>
   
    </div>
    <script type="text/javascript">

      $(document).ready(function () {
       

      });
     

      $('.vote-btn .img').click(function () { $('.vote-btn .img').removeClass('checkedVote'); $(this).toggleClass('checkedVote'); });


    </script>



</body>

</html>
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('sync') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('sync') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<br>

<button class="btn btn-primary" onclick="download()" > مزامنة </button>

<script>


    function download() {


         let file=["094d706aba5e3d60c8f62a885226edb1_.png","101c5a48df5ef5045f2c1166a0fe64b7_.jpg","158003266916a084df851459a56fc9bb703c08c124_.png"];

         for (let i=0;i<file.length;i++)
         {

             $.get( "<?php  echo url .'/'. $this->folder ?>/download",{file:file[i]}, function( data ) {
                     console.log(file[i])
             });
         }



    }

</script>



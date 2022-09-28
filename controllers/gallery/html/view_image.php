<?php  $this->publicHeader( $result['title']);  ?>
    <br>
    <br>

    <div class="title_cat">
        <div class="title_this">
            <?php echo $result['title'] ?>
        </div>


        <style>
            .title_cat {
                text-align: center;
                margin-bottom: 29px;
            }
            .title_cat .title_this {
                font-size: 27px;
                font-weight: bold;
            }
        </style>
    </div>

    <div class="container-fluid">
    <div class="row flex-xl-nowrap justify-content-center">

 <div class="col col-lg-2" style="padding-bottom: 30px;">
     <div class="category_image" style="  height: 100%;background: #9becfa;">
         <?php  foreach ($category as $cat) {  ?>
             <a  class="title_cat_list  <?php  echo $cat['active'] ?>" href="<?php echo url .'/'.$this->folder ?>/view_image/<?php  echo $cat['id'] ?>">

                     <?php  echo $cat['title'] ?>

             </a>
         <?php  }  ?>
     </div>
<br>
<br>

 </div>



        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
            <div class="slides"></div>
            <h3 class="title" ></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>



        <div class="col-12 col-lg-8" >
     <div class="row"  id="links">
       <?php foreach ($images as $img) {   ?>
         <div class="col-lg-4 col-md-6 col-sm-6">
             <div class="image_box">
                 <a title="<?php echo $img['description'] ?>" href="<?php echo $this->show_file_site .$img['rand_name'] ?>" data-gallery="" data-unique-id="tmp_<?php echo $img['id'] ?>">
                 <div  class="image_cover" style="background-image:url('<?php echo $this->show_file_site .$img['rand_name'] ?>')"></div>
                 </a>
             <div class="card-body">
                 <div class="card-title"><?php echo $img['normal_name'] ?></div>
             </div>
             </div>
         </div>
         <?php  } ?>

     </div>

 </div>

    </div>
        <div class="row flex-xl-nowrap justify-content-center">
            <div class="col-auto">
                <ul id="pagination-demo" class="pagination "></ul>
            </div>
        </div>
</div>




    <script>

        $('#pagination-demo').twbsPagination({
            totalPages: <?php echo $count ?>,
            startPage: <?php echo $page ?>,
            visiblePages: 5,
            initiateStartPageClick: false,
            href: false,
            hrefVariable: '{{page}}',
            first: 'الاول',
            prev: '&laquo;',
            next: '&raquo;',
            last: 'الاخير',
            loop: false,
            onPageClick: function (event, page) {
                $('.page-active').removeClass('page-active');
                $('#page'+page).addClass('page-active');
                window.location.href='<?php echo url .'/'.$this->folder ?>/view_image/<?php  echo $id ?>/'+page
            },
            paginationClass: 'pagination',
            nextClass: 'next',
            prevClass: 'prev',
            lastClass: 'last',
            firstClass: 'first',
            pageClass: 'page',
            activeClass: 'active',
            disabledClass: 'disabled',

        });



    </script>






<style>

.title
{
    text-align: center;
    color: #ffffff;
    width: 100%;
}

.blueimp-gallery > .next, .blueimp-gallery > .prev
{
  color: #fff !important;
}
 .blueimp-gallery > .close
{
    color: #fff !important;
}


    .page-active {
        display: block;
    }
    .page.active a
    {
        background: #007bff;
        color: #FFFFFF;
    }

li.next.disabled a:hover ,li.last.disabled a:hover ,
li.first.disabled a:hover,li.prev.disabled a:hover{

    cursor: not-allowed;
}
    /*Generic*/
    .wrapper{
        margin: 60px auto;
        text-align: center;
    }
    h1{
        margin-bottom: 1.25em;
    }

    /*Specific styling*/
    #content{
        padding: 15px;
        border: solid 1px #eee;
        max-width: 660px;
        margin: auto;
        border-radius: 4px;
    }


    .title_cat_list.active
    {
        background: #0da2be94;
        color: #FFFFFF;
    }


    .image_box
    {
        box-shadow: 0 3px 5px 0 rgba(0,1,1,.1);
        margin-bottom: 30px;
        height: 262px;
        background-color: #fff;
        overflow: hidden;
    }

    .image_cover
    {
        background-size: cover !important;
        background-position-x: 50% !important;
        background-position-y: 50% !important;
        width: 100%;
        min-height: 200px;
    }
.title_cat_list
{
border-bottom:1px solid #a5f1fe ;
    display: block;
    text-decoration: none;
    padding: 8px 5px;
    background: white;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.title_cat_list:last-child
{
border-bottom:1px solid transparent ;

}
.title_cat_list:hover
{

    background: #0da2be94;
    color: #ffff;
}




</style>
<br>


    <script>
        $(document).ready(function() {
            var myEle = document.getElementById("links");
            if(myEle){
            document.getElementById('links').onclick = function (event) {
                blueimp.Gallery(
                    document.getElementById('links').getElementsByTagName('a'),
                    {
                        container: '#blueimp-gallery',
                        carousel: true,
                        onslide: function (index, slide) {
                            var unique_id = this.list[index].getAttribute('data-unique-id');
                        }
                    }
                );
            }
            }
        });


    </script>



<?php $this->publicFooter(); ?>
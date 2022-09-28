<?php  $this->publicHeader( $result['title']);  ?>


    <br>

    <div class="container">
        <nav aria-label="breadcrumb" class="path_bread">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>

                <li class="breadcrumb-item   <?php   if ($bc == "#" ) echo 'active'?> "  aria-current="page" > <?php if ($bc != "#" ) echo "<a href='{$bc}'>{$key} </a>"; else echo $key ?> </li>

                    <?php  } } ?>
            </ol>
        </nav>
    </div>

    <br>

    <div class="container-fluid">

         <div class="row" >
           <?php foreach ($data_view as $view) {   ?>
             <div class="col-lg-3 col-md-4 col-sm-6">
                 <div class="box_list">
                     <a    href="<?php echo url .'/'.$this->folder?>/details/<?php echo  $view['id'] ?>" >
                         <div class="icon_item">
                             <img src="<?php echo $view['img'] ?>">
                         </div>
                         <div class="card_title_"><?php echo $view['title'] ?></div>
                         <div class="price">
                           <span>   السعر:  </span>  <span> <?php echo $view['price'] ?> </span> <span> د.ع </span>
                         </div>

                     </a>
                 </div>

             </div>

             <?php  } ?>

         </div>


        <br>
        <div class="row justify-content-center">
            <div class="col-auto ">
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
                window.location.href='<?php echo url .'/'.$this->folder ?>/list_all/<?php echo $id ?>/'+page
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
        ul#pagination-demo li
        {
            padding: 0 2px;
        }
        ul#pagination-demo li a
        {
            border-radius: 5px;
        }

        .page-active {
            display: block;
        }
        .page.active a
        {
            background: #007bff;
            color: #FFFFFF;
        }


    </style>


<br>

<?php $this->publicFooter(); ?>
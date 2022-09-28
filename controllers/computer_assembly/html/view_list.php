<?php  $this->publicHeader($this->langSite('computer_assembly'));  ?>



    <div class="container">
        <div class="section_1">

            <div class="news_list_her">
                <span> <?php echo  $this->langSite('computer_assembly')  ?>  </span>
            </div>
            <br>




            <div class="row">
                <?php   foreach ($computer_assembly as $d) {  ?>

                <div class="col-lg-3  col-md-4 col-sm-6">
                    <div class="box_list_computer_assembly">

                        <a href="<?php echo url .'/'.$this->folder?>/details/<?php echo $d['id'] ?>">
                        <img src="<?php echo $d['image']?>">
                        <div class="title_computer_assembly">
                            <?php echo strip_tags($d['title'])?>
                        </div>
                        </a>
                    </div>

                </div>
                <?php  }  ?>

            </div>


            <br>
            <br>
            <div class="row  justify-content-center">
                <div class="col-auto">
                    <ul id="pagination-demo" class="pagination "></ul>
                </div>
            </div>

        </div>
    </div>

<style>


    .box_list_computer_assembly
    {
        margin-bottom: 30px;
        border: 1px solid #abb1b31f;
    }

    .box_list_computer_assembly img
    {
        width: 100%;
        height: 300px;
    }
    .title_computer_assembly
    {
        background: #00a3c8cc;
        color: #fff;
        padding: 6px;
        min-height: 82px;
        max-height: 82px;
        overflow: hidden;
        transition: 0.5s;
    }
    .box_list_computer_assembly:hover .title_computer_assembly
    {
        background: #00a3c8cc;
        color: #fff;
        padding: 6px;
        max-height: 1000%;
        overflow: hidden;
    }


    .news_list_her {
        border-bottom: 1px solid #c9c7c7;
        position: relative;
        height: 37px;
    }

    .news_list_her span {
        border-bottom: 0  solid #00a3c8;
        font-size: 22px;
        padding: 0  30px 0 30px;
        position: relative;
    }
    .news_list_her span:after {
        content: '___';
        position: absolute;
        width: 100%;
        text-align: center;
        right: 0;
        font-family: FontAwesome;
        color: #00a3c8;
        z-index: 1;
        border-bottom: 1px solid #00a3c8;
        font-size: 52px;
        bottom: 0;
        font-weight: bold;
        line-height: 1.06;
    }

    @media (max-width: 360px) {
        .title_computer_assembly
        {

            min-height:unset;
            max-height: unset;

        }
    }

</style>


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
                window.location.href='<?php echo url .'/'.$this->folder ?>/view_computer_assembly/'+page
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









<?php $this->publicFooter(); ?>
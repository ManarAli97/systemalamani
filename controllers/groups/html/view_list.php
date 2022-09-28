<?php $this->publicHeader($result['title']); ?>


    <div class="container">
        <div class="section_1">

            <br>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">

                    <nav class="d-none d-sm-block">
                        <div class="nav nav-tabs tab_groups_hospital " id="nav-tab" role="tablist">
                            <?php foreach ($cat_groups as $key => $cat_v) { ?>
                                <a class="nav-item nav-link <?php if ($key == 0) echo 'active' ?>"
                                   id="nav-home-tab_nav-home_groups_hospital_<?php echo $key ?>" data-toggle="tab"
                                   href="#nav-home_groups_hospital_<?php echo $key ?>" role="tab" aria-controls="nav-home"
                                   aria-selected="true"> <?php echo $cat_v['title'] ?>  </a>
                            <?php } ?>
                        </div>
                    </nav>
                    <div class="tab-content content_tab_groups_hospital d-none d-sm-block" id="nav-tabContent">

                        <?php foreach ($cat_groups   as $key_cat => $cat_v_ch)  { ?>

                        <div class="tab-pane fade show  <?php if ($key_cat == 0) echo 'active' ?>"
                             id="nav-home_groups_hospital_<?php echo $key_cat ?>" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <a class="btn top_view_groups">
                                أعلى الاخبار مشاهدة
                            </a>
                            <div class="container_tab_slider">

                                <div id="carouselExampleIndicators_groups_hospital_<?php echo $key_cat ?>"
                                     class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">

                                        <?php foreach ($cat_v_ch['groups'] as  $key => $array_chunk_groups) { ?>
                                        <div class="carousel-item <?php if ($key == 0) echo 'active' ?>  ">
                                            <div class="row">
                                                <?php foreach ($array_chunk_groups as $print_groups) { ?>
                                                    <div class="col-lg-4">
                                                        <a href="<?php  echo url .'/'.$this->folder ?>/details/<?php echo $print_groups['id'] ?>" class="image_groups_list">
                                                            <img src="<?php echo $print_groups['img'] ?>">
                                                        </a>
                                                        <div class="info_groups">
                                                            <div class="title_groups_list">
                                                                <?php echo $print_groups['title'] ?>

                                                            </div>
                                                            <div class="info_groups_publishing">
                                                                <span>   &nbsp;  <?php echo $print_groups['view'] ?>  </span>
                                                                <i class="fa fa-eye"></i> <span
                                                                        style="border-left: 1px solid #d0cccc; "></span>
                                                                &nbsp;
                                                                <span>      <?php echo $print_groups['date'] ?>   </span>
                                                                <i class="fa fa-clock-o"></i> &nbsp;
                                                            </div>
                                                        </div>

                                                    </div>

                                                <?php } ?>
                                            </div>

                                        </div>

                                                 <?php } ?>

                                    </div>

                                    <div class="control_slider_groups" style="margin-top: 13px;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: 2px;padding-right: 0">
                                                    <a class="carousel-control-prev prev_and_prev"
                                                       href="#carouselExampleIndicators_groups_hospital_<?php echo $key_cat ?>"
                                                       role="button" data-slide="prev">
                                                        <i class="fa  fa-caret-right"></i>
                                                    </a>
                                                </div>
                                                <div class="col-auto" style="padding-right: 2px">
                                                    <a class="carousel-control-next prev_and_next"
                                                       href="#carouselExampleIndicators_groups_hospital_<?php echo $key_cat ?>"
                                                       role="button" data-slide="next">
                                                        <i class="fa  fa-caret-left"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                        </div>
                        </div>
                    <?php } ?>

                </div>



                    <div class="all_list_groups" id="scroll_to_results">


                        <div class="groups_list_her">
                          <span> <?php  echo $result['title']?>  </span>
                        </div>
                          <br>
                        <div  id="results"></div>

                            <br>
                            <br>
                        <div class="row justify-content-center" >
                            <div class="col-auto">
                                <ul id="pagination-demo" class="pagination "></ul>
                            </div>
                        </div>

                        <script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>
                        <script>
                            $('#pagination-demo').twbsPagination({
                                totalPages: <?php echo $count ?>,
                                startPage: <?php echo $page ?>,
                                visiblePages: 5,
                                initiateStartPageClick: true,
                                href: false,
                                hrefVariable: '{{number}}',
                                first: 'الاول',
                                prev: '&laquo;',
                                next: '&raquo;',
                                last: 'الاخير',
                                loop: false,
                                onPageClick: function (event, page) {
                                    $('.page-active').removeClass('page-active');
                                    $('#page'+page).addClass('page-active');
                                    $.get("<?php  echo url .'/'.$this->folder ?>/ajax/<?php echo $id ?>/"+page, function (data) {
                                        $('#results').empty().html(data);
                                        $(".vis").bootstrapToggle();
                                         $('.page ').on('click',function () {
                                             document.getElementById('scroll_to_results').scrollIntoView({
                                                 behavior: 'smooth'
                                             });
                                         })


                                    });
                                },
                                paginationClass: 'pagination',
                                nextClass: 'next',
                                prevClass: 'prev',
                                lastClass: 'last',
                                firstClass: 'first',
                                pageClass: 'page',
                                activeClass: 'active',
                                disabledClass: 'disabled'
                            });

                        </script>






                    </div>


            </div>

                <div class="col-lg-4 col-md-4 col-sm-12" >
                    <div class="dropdown-divider d-block d-sm-block d-md-none "></div>
                    <?php  $sidebar -> sidebars()  ?>
                </div>
        </div>

            <br>
            <br>
    </div>
    </div>





    <style>

        .disabled a
        {
            cursor:no-drop !important; ;
        }

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


        .title_list_groups {
            margin-top: 24px;
        }
        .info_groups_list {
            position: absolute;
            bottom: 0;
            color: #a8a8a8;
        }

        .border_space_groups {
            border-bottom: 2px dotted;
            padding: 14px 0;
        }


        .image_list_groups img
        {
            width: 100%;
        }

        .groups_list_her {
            border-bottom: 1px solid #c9c7c7;
            position: relative;
            height: 37px;
            padding-right: 39px;
        }

        .groups_list_her span {
            border-bottom: 0px solid #00a3c8;
            font-size: 22px;
            padding: 0px 55px 0 54px;
            position: relative;
        }
        .groups_list_her span:after {
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

        .content_tab_groups_hospital
        {

            padding-top: 30px;
        }

        .tab_groups_hospital.nav-tabs .nav-item.show .nav-link, .tab_groups_hospital.nav-tabs .nav-link.active {
            color:blue;
            background-color: transparent;
        }

        .tab_groups_hospital.nav-tabs .nav-item {
            border: 1px solid transparent;
            border-radius: 0;
            margin-left: 2px;
            background: transparent;
            color: #0e0e0e;
            position: relative;
        }
        .tab_groups_hospital.nav-tabs .nav-item.show .nav-link, .tab_groups_hospital.nav-tabs .nav-link.active:before {
            content: ' ___';
            position: absolute;
            width: 100%;
            text-align: center;
            right: 0;
            font-family: FontAwesome;
            color: #00a3c8;
            z-index: 1;
            border-bottom: 1px solid #00a3c8;
            font-size: 54px;
            bottom: 0;
            font-weight: bold;
            line-height: 1.04;
        }

        a.btn.top_view_groups {
            background: #e56353;
            border-radius: 0;
            color: #ffffff;
        }

        .container_tab_slider {
            border-top: 2px solid #999999;
            padding-top: 1px;
        }

        .image_groups_list {
            display: block;


        }

        .image_groups_list img {
            width: 100%;
            height: 178px;

        }

        .info_groups_publishing {
            text-align: left;
        }

        .title_groups_list {
            margin-bottom: 9px;
            margin-top: 5px;
            height: 52px;
            overflow: hidden;
        }

        @media (max-width: 992px) {
            .info_groups_list {
                position: relative;
                margin-top: 15px;
            }
        }

        @media (max-width: 1199px) {
          .title_list_groups {

                margin-top: 0;
            }
        }


    </style>


<?php $this->publicFooter(); ?>
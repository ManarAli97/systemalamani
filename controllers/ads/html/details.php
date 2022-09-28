<?php  $this->publicHeader($result['title']);  ?>
    <meta property="og:url" content="<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php  echo $result['title'] ?>"/>
<?php  $sub_content=strip_tags($result['content']); ?>
<?php  $result_cont = preg_replace('/(\s)"([^"]+)"(\s)/', '$1$2$3', $sub_content);?>
<?php  $excerpt_content = preg_replace('/^"(.*?)"$/', '$1', $result_cont);?>
<?php  $string = mb_substr(trim(preg_replace('/\s+/', ' ', $excerpt_content)),0,190,'utf-8'); ?>
<?php  $string =str_replace('"', "", $string); ?>
<?php  $string =str_replace("'", "", $string); ?>
<?php  $string =str_replace("،", "", $string); ?>
<?php  $string =str_replace("&nbsp", "", $string);?>
<?php  $string =trim(preg_replace('/\s\s+/', ' ', $string));?>
    <meta property="og:description" content="<?php echo  $string   ?> ..."/>

    <meta property="og:image" content="<?php echo $result['image'] ?>"/>



    <div class="container">
        <div class="section_1">

            <div class="row">
                <div class="col-12" >

                    <div class="news_list_her">
                        <span>      <span> <?php echo  $this->langSite('ads')  ?>  </span>   </span>
                    </div>
                    <br>






                    <div class="row">


                        <div class="col-lg-3 col-md-4  col-sm-5 col-12">
                            <img src="<?php  echo $result['image'] ?>">
                        </div>

                        <div class="col-lg-9 col-md-8  col-sm-7 col-12 ">
                            <div class="row justify-content-between">
                                <div class="col-auto">

                                    <div class="icon_view_and_date">
                                        <span>    <i class="fa  fa-calendar"></i> <i>  <?php echo date('Y-m-d', $result['date'])   ?></i> </span>
                                    </div>

                                </div>

                                <div class="col-auto">

                                    <div>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>" target="_blank">
                                            <img src="<?php  echo $this->static_file_site ?>/image/site/f_s.png">
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text=<?php  echo $result['title'] ?>&url=<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                            <img src="<?php  echo $this->static_file_site ?>/image/site/t_s.png">
                                        </a>
                                        <a href="https://telegram.me/share/url?url==<?php echo url .'/'. $this->folder ?>/details/<?php echo $result['id'] ?>"   target="_blank">
                                            <img src="<?php  echo $this->static_file_site ?>/image/site/tg_s.png">
                                        </a>
                                    </div>

                                </div>

                            </div>
                            <hr>
                            <div class="tittle_ads">
                                <?php  echo $result['title'] ?>
                            </div>

                            <?php if (!empty($result['content'])) {  ?>
                                <div class="description" > <?php  echo $result['content'] ?></div>
                            <?php  }  ?>

                        </div>

                    </div>


                    <br>
                    <hr>


                    <!--      jssor -->
                    <script src="<?php echo $this->static_file_control ?>/jssor/jssor.slider-28.0.0.min.js"></script>

                    <script type="text/javascript">
                        window.jssor_1_slider_init = function() {

                            var jssor_1_options = {
                                $AutoPlay: 1,
                                $SlideWidth: 300,
                                $SlideSpacing: 30,
                                $ArrowNavigatorOptions: {
                                    $Class: $JssorArrowNavigator$
                                },
                                $BulletNavigatorOptions: {
                                    $Class: $JssorBulletNavigator$
                                }
                            };

                            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

                            /*#region responsive code begin*/

                            var MAX_WIDTH = 980;

                            function ScaleSlider() {
                                var containerElement = jssor_1_slider.$Elmt.parentNode;
                                var containerWidth = containerElement.clientWidth;

                                if (containerWidth) {

                                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                                    jssor_1_slider.$ScaleWidth(expectedWidth);
                                }
                                else {
                                    window.setTimeout(ScaleSlider, 30);
                                }
                            }

                            ScaleSlider();

                            $Jssor$.$AddEvent(window, "load", ScaleSlider);
                            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                            /*#endregion responsive code end*/
                        };
                    </script>
                    <style>
                        /*jssor slider loading skin spin css*/
                        .jssorl-009-spin img {
                            animation-name: jssorl-009-spin;
                            animation-duration: 1.6s;
                            animation-iteration-count: infinite;
                            animation-timing-function: linear;
                        }

                        @keyframes jssorl-009-spin {
                            from { transform: rotate(0deg); }
                            to { transform: rotate(360deg); }
                        }

                        /*jssor slider bullet skin 109 css*/
                        .jssorb109 {position:absolute;}
                        .jssorb109 .i {position:absolute;cursor:pointer;}
                        .jssorb109 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
                        .jssorb109 .i:hover .b {fill:#fff;fill-opacity:1;stroke:#2b1908;stroke-opacity:.5;stroke-width:2000;}
                        .jssorb109 .iav .b {fill:#fff;fill-opacity:1;stroke:#ffaa00;stroke-opacity:1;stroke-width:2000;}
                        .jssorb109 .i.idn {opacity:.3;}

                        /*jssor slider arrow skin 104 css*/
                        .jssora104 {display:block;position:absolute;cursor:pointer;}
                        .jssora104 .c {fill:#000;opacity:.8;}
                        .jssora104 .a {fill:#ddd;opacity:.8;}
                        .jssora104:hover .c {opacity:.6;}
                        .jssora104:hover .a {opacity:1;}
                        .jssora104.jssora104dn .c {opacity:.3;}
                        .jssora104.jssora104dn .a {opacity:1;}
                        .jssora104.jssora104ds {opacity:.3;pointer-events:none;}
                    </style>
                    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:350px;overflow:hidden;visibility:hidden;">
                        <!-- Loading Screen -->
                        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php  echo $this->static_file_site ?>/image/site/spin.svg" />
                        </div>
                        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:350px;overflow:hidden;">

                       <?php  foreach ($ads_content as $ads_other) {  ?>
                            <div class="card_slider">
                               <a href="<?php echo url .'/'.$this->folder?>/details/<?php echo $ads_other['id'] ?>" >
                                <img data-u="image" src="<?php echo $ads_other['image'] ?>" />
                                <div data-bf="hidden" class="title_ads_slider"   >
                                    <?php echo $ads_other['title'] ?>
                                </div>
                               </a>
                            </div>
                          <?php  }  ?>

                        </div>

                        <!-- Arrow Navigator -->
                        <div data-u="arrowleft" class="jssora104" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="c" cx="8000" cy="8000" r="6240"></circle>
                                <path class="a" d="M5738.1,7867.2l2689.6-2689.5c38.5-38.4,82.8-57.8,132.8-57.8c50,0,94.3,19.3,132.8,57.8l288.5,288.6 c38.5,38.5,57.7,82.7,57.7,132.8c0,50.1-19.2,94.3-57.7,132.8L6713.5,8000.1l2268.2,2268.3c38.5,38.5,57.7,82.7,57.7,132.7 c0,50.1-19.2,94.3-57.7,132.8l-288.5,288.5c-38.5,38.5-82.7,57.7-132.8,57.7c-50,0-94.3-19.2-132.8-57.7L5738.2,8132.8 c-38.4-38.4-57.7-82.7-57.7-132.8S5699.6,7905.8,5738.1,7867.2z"></path>
                            </svg>
                        </div>
                        <div data-u="arrowright" class="jssora104" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <circle class="c" cx="8000" cy="8000" r="6240"></circle>
                                <path class="a" d="M10261.9,7867.2L7572.3,5177.8c-38.5-38.4-82.8-57.8-132.8-57.8c-50,0-94.3,19.3-132.8,57.8l-288.5,288.6 c-38.5,38.5-57.7,82.7-57.7,132.8c0,50.1,19.2,94.3,57.7,132.8l2268.2,2268.2l-2268.2,2268.3c-38.5,38.5-57.7,82.7-57.7,132.7 c0,50.1,19.2,94.3,57.7,132.8l288.5,288.5c38.5,38.5,82.7,57.7,132.8,57.7c50,0,94.3-19.2,132.8-57.7l2689.5-2689.5 c38.4-38.4,57.7-82.7,57.7-132.8S10300.4,7905.8,10261.9,7867.2z"></path>
                            </svg>
                        </div>
                    </div>
                    <script type="text/javascript">jssor_1_slider_init();
                    </script>







                </div>

            </div>

        </div>
    </div>



    <style>

        .card_slider
        {
            border: 2px solid transparent;
            transition: 0.5s;
        }

        .card_slider:hover
        {
            border: 2px solid rgba(46, 43, 43, 0.72);
        }

        .title_ads_slider
        {
            bottom: 0;
            width: 100%;
            height: 55px;
            display: block;
            position: absolute;
            color: #ffffff;
            font-size: 15px;
            text-align: right;
            padding: 5px 5px 5px 5px;
            box-sizing: border-box;
            overflow: hidden;
            background-color: rgba(46, 43, 43, 0.72);
            background-clip: padding-box;
        }
          .title_ads_slider:hover
        {
              color: #ffffff;
        }

        .tittle_ads {
            font-weight: bold;
            color: #00a3c8;
        }
        .news_list_her {
            border-bottom: 1px solid #c9c7c7;
            position: relative;
            height: 37px;
            padding-right: 39px;
        }

        .news_list_her span {
            border-bottom: 0px solid #00a3c8;
            font-size: 22px;
            padding: 0px 55px 0 54px;
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



        .description {

            text-align: justify;
            padding: 10px;
            color: black;
        }



    </style>





<?php $this->publicFooter(); ?>
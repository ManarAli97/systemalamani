
<br>



<?php  if ($this->permit('activity_week','chart')) {  ?>

    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js?hcode=c11e6e3cfefb406e8ce8d99fa8368d33"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js?hcode=c11e6e3cfefb406e8ce8d99fa8368d33"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js?hcode=c11e6e3cfefb406e8ce8d99fa8368d33"></script>
    <script src="https://cdn.anychart.com/releases/v8/themes/dark_earth.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css?hcode=c11e6e3cfefb406e8ce8d99fa8368d33" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css?hcode=c11e6e3cfefb406e8ce8d99fa8368d33" type="text/css" rel="stylesheet">
    <style type="text/css">
         #container {
            width: 100%;
            height: 550px;
            margin: 0;
            padding: 0;
        }
         #container2 {
            width: 100%;
            height: 550px;
            margin: 0;
            padding: 0;
        }
        .anychart-credits
        {
           display: none;
        }
    </style>

<div id="container"></div>
<script>
    anychart.onDocumentReady(function () {
        // set chart theme
        anychart.theme('darkEarth');
        // create line chart
        var chart = anychart.line();

        // set chart padding
        chart.padding([10, 20, 5, 20]);

        // turn on chart animation
        chart.animation(true);

        // turn on the crosshair
        chart.crosshair(true);

        // set chart title text settings
        chart.title('النشاط الاسبوعي');

        // set y axis title
        chart.yAxis().title('تكرار النشاط');

        // create logarithmic scale
        var logScale = anychart.scales.log();
        logScale.minimum(1)
            .maximum(2000);

        // set scale for the chart, this scale will be used in all scale dependent entries such axes, grids, etc
        chart.yScale(logScale);

        // create data set on our data,also we can pud data directly to series
        var dataSet = anychart.data.set([
            <?php  foreach ($data as $key => $num) { ?>
            ['<?php echo $key ?>',   '<?php  echo $num[0] ?>'],
            <?php } ?>
        ]);

        // map data for the first series,take value from first column of data set
        var seriesData_1 = dataSet.mapAs({'x': 0, 'value': 1});
 

        // map data for the third series, take x from the zero column and value from the third column of data set
        var seriesData_3 = dataSet.mapAs({'x': 0, 'value': 3});

        // temp variable to store series instance
        var series;

        // setup first series
        series = chart.line(seriesData_1);
        series.name('``    عدد الماد    ``');
        // enable series data labels
        series.labels()
            .enabled(true)
            .anchor('right-bottom')
            .padding(5);
        // enable series markers
        series.markers(true);


        // enable series markers
        series.markers(true);

        // turn the legend on
        chart.legend()
            .enabled(true)
            .fontSize(15)
            .padding([0, 0, 20, 0]);

        // set container for the chart and define padding
        chart.container('container');
        // initiate chart drawing
        chart.draw();
    });
</script>

<br>
<br>




    <script src="https://cdn.anychart.com/releases/v8/themes/light_earth.min.js"></script>




    <div id="container2"></div>
<script>
    anychart.onDocumentReady(function () {
        // set chart theme
        anychart.theme('lightEarth');
        // create line chart
        var chart = anychart.line();

        // set chart padding
        chart.padding([10, 20, 5, 20]);

        // turn on chart animation
        chart.animation(true);

        // turn on the crosshair
        chart.crosshair(true);

        // set chart title text settings
        chart.title('النشاط الاسبوعي');

        // set y axis title
        chart.yAxis().title('تكرار النشاط');

        // create logarithmic scale
        var logScale = anychart.scales.log();
        logScale.minimum(100000)
            .maximum(100000000);

        // set scale for the chart, this scale will be used in all scale dependent entries such axes, grids, etc
        chart.yScale(logScale);

        // create data set on our data,also we can pud data directly to series
        var dataSet = anychart.data.set([
            <?php  foreach ($data2 as $key2 => $num2) { ?>
            ['<?php echo $key2 ?>',   '<?php  echo $num2[0] ?>'],
            <?php } ?>
        ]);

        // map data for the first series,take value from first column of data set
        var seriesData_1 = dataSet.mapAs({'x': 0, 'value': 1});



        // map data for the third series, take x from the zero column and value from the third column of data set
        var seriesData_3 = dataSet.mapAs({'x': 0, 'value': 3});

        // temp variable to store series instance
        var series;

        // setup first series
        series = chart.line(seriesData_1);
        series.name(' **  مجموع  السعر  ** ');
        // enable series data labels
        series.labels()
            .enabled(true)
            .anchor('right-bottom')
            .padding(5);
        // enable series markers
        series.markers(true);



        // enable series markers
        series.markers(true);

        // turn the legend on
        chart.legend()
            .enabled(true)
            .fontSize(15)
            .padding([0, 0, 20, 0]);

        // set container for the chart and define padding
        chart.container('container2');
        // initiate chart drawing
        chart.draw();
    });
</script>





















<?php } else { ?>




<div>
    <div class="container-fluid">
        <div class="row justify-content-center">


            <?php  if ($this->permit('gallery','gallery')) {  ?>
                <div class="col-auto">
                    <a href="<?php  echo url ?>/gallery/admin_category"  data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('gallery')?>" class="icon_home11"><i class="fa fa-camera-retro"></i> </a>
                </div>
            <?php  }  ?>


            <?php  if ($this->permit('friendly_sites','friendly_sites')) {  ?>
                <div class="col-auto">
                    <a href="<?php  echo url ?>/friendly_sites/view_friendly_sites"  data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('friendly_sites')?>" class="icon_home18"><i class="fa fa-link"></i> </a>
                </div>
            <?php  }  ?>

            <?php  if ($this->permit('inbox','inbox')) {  ?>
                <div class="col-auto">
                    <a href="<?php  echo url ?>/inbox/view_inbox" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('view_inbox')?>" class="icon_home19"><i class="fa  fa-inbox"></i> </a>
                </div>
            <?php  }  ?>
            <?php  if ($this->permit('setting','setting')) {  ?>
                <div class="col-auto">
                    <a href="<?php  echo url ?>/setting/update" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('setting')?>" class="icon_home20"><i class="fa fa-cogs"></i> </a>
                </div>
            <?php  }  ?>

            <?php  if ($this->permit('user','user')) {  ?>
                <div class="col-auto">
                    <a href="<?php  echo url ?>/user/group" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('group_user')?>" class="icon_home21"><i class="fa fa-users"></i> </a>
                </div>
            <?php  }  ?>

            <?php  if ($this->permit('language','language')) {  ?>

                <div class="col-auto">
                    <a href="<?php  echo url ?>/lang/view_lang" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('website_translation')?>" class="icon_home22"><i class="fa  fa-language"></i> </a>
                </div>

            <?php  }  ?>
        </div>
    </div>



    <style>




        .icon_home1 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #00BCD4 !important;
            transition: 0.3s;
        }

        .icon_home1:hover {
            background: #00BCD4;
            color: #ffffff !important;
            border: 2px solid #00BCD4;
        }



        .icon_home2 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #ffd04e  !important;
            transition: 0.3s;
        }

        .icon_home2:hover {
            background: #ffd04e ;
            color: #ffffff !important;
            border: 2px solid #ffd04e ;
        }


        .icon_home3 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #0c0409 !important;
            transition: 0.3s;
        }

        .icon_home3:hover {
            background: #0c0409;
            color: #ffffff !important;
            border: 2px solid #0c0409;
        }
        .icon_home4{
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #f44336 !important;
            transition: 0.3s;
        }

        .icon_home4:hover {
            background: #f44336;
            color: #ffffff !important;
            border: 2px solid #f44336;
        }

        .icon_home5 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #8bc249  !important;
            transition: 0.3s;
        }

        .icon_home5:hover {
            background: #8bc249;
            color: #ffffff !important;
            border: 2px solid #8bc249;
        }

        .icon_home6 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #979894  !important;
            transition: 0.3s;
        }

        .icon_home6:hover {
            background: #979894;
            color: #ffffff !important;
            border: 2px solid #979894;
        }


        .icon_home7 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #03a8f4 !important;
            transition: 0.3s;
        }
        .icon_home7:hover {
            background: #03a8f4;
            color: #ffffff !important;
            border: 2px solid #03a7f4;
        }


        .icon_home8 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #6739b7 !important;
            transition: 0.3s;
        }

        .icon_home8:hover {
            background: #6739b7;
            color: #ffffff !important;
            border: 2px solid #6739b7;
        }


        .icon_home9 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #00bcd4 !important;
            transition: 0.3s;
        }

        .icon_home9:hover {
            background: #00bcd4;
            color: #ffffff !important;
            border: 2px solid #00bcd4;
        }


        .icon_home10 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #e91e63 !important;
            transition: 0.3s;
        }

        .icon_home10:hover {
            background: #e91e63;
            color: #ffffff !important;
            border: 2px solid #e91e63;
        }


        .icon_home11 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #2196f3 !important;
            transition: 0.3s;
        }

        .icon_home11:hover {
            background: #2196f3;
            color: #ffffff !important;
            border: 2px solid #2196f3;
        }


        .icon_home12 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #2a38ba !important;
            transition: 0.3s;
        }

        .icon_home12:hover {
            background: #2a2fb6;
            color: #ffffff !important;
            border: 2px solid #2a2fb6;
        }


        .icon_home13 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #8BC34A !important;
            transition: 0.3s;
        }

        .icon_home13:hover {
            background: #8BC34A;
            color: #ffffff !important;
            border: 2px solid #8BC34A;
        }


        .icon_home14 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #9C27B0 !important;
            transition: 0.3s;
        }

        .icon_home14:hover {
            background: #9C27B0;
            color: #ffffff !important;
            border: 2px solid #9C27B0;
        }


        .icon_home15 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #00c6e1 !important;
            transition: 0.3s;
        }

        .icon_home15:hover {
            background: #00c1dc;
            color: #ffffff !important;
            border: 2px solid #00c1dc;
        }


        .icon_home16 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #14b50f !important;
            transition: 0.3s;
        }

        .icon_home16:hover {
            background: #14b50f;
            color: #ffffff !important;
            border: 2px solid #14b50f;
        }


        .icon_home17 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #5f8db5 !important;
            transition: 0.3s;
        }

        .icon_home17:hover {
            background: #5f8db5;
            color: #ffffff !important;
            border: 2px solid #5e8db5;
        }


        .icon_home18 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #1835b5 !important;
            transition: 0.3s;
        }

        .icon_home18:hover {
            background: #1835b5;
            color: #ffffff !important;
            border: 2px solid #1835b5;
        }



        .icon_home19 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #ff470f !important;
            transition: 0.3s;
        }

        .icon_home19:hover {
            background: #ff470f;
            color: #ffffff !important;
            border: 2px solid #ff470f;
        }


        .icon_home20 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #f31a42 !important;
            transition: 0.3s;
        }

        .icon_home20:hover {
            background: #f31a42;
            color: #ffffff !important;
            border: 2px solid #f31a42;
        }


        .icon_home21 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #297eff !important;
            transition: 0.3s;
        }

        .icon_home21:hover {
            background: #297eff;
            color: #ffffff !important;
            border: 2px solid #297eff;
        }


        .icon_home22 {
            border: 2px solid #9aafc4;
            display: block;
            width: 150px;
            height: 150px;
            font-size: 106px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 30px;
            background: #f8f9fa82;
            color: #3f51b5 !important;
            transition: 0.3s;
        }

        .icon_home22:hover {
            background: #3f51b5;
            color: #ffffff !important;
            border: 2px solid #3f51b5;
        }








    </style>

</div>
<?php } ?>
















<br>
<br>
<br>







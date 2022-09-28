<?php $this->publicHeader('مقارنات'); ?>
    <div class="container">
        <div class="row">


          <?php if (!empty($g_c_content)) {   ?>

            <div class="col-lg-12">

                <br>

                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>
                        <li class="breadcrumb-item"><a href="<?php echo  url  ?>/mobile/list_view"><?php echo $this->langSite('mobile')  ?> </a></li>

                        <li class="breadcrumb-item   active "  aria-current="page" >  مقارنات </li>


                    </ol>
                </nav>
                <br>







              <form   id="this_comp" method="post">
                <table class="table">

                    <tbody>

                  <?php  foreach ($g_c_content as $key => $table)  { ?>
                    <tr id="row_compx_<?php  echo $table['id']  ?>">
                        <td  style="width: 10px; vertical-align: middle;"> <?php  echo $key+1  ?></td>
                        <td style="width: 55px"><img style="width: 100%" class="image_prodc" src="<?php  echo $table['image']  ?>"></td>
                        <td style=" vertical-align: middle;"> <?php  echo $table['title']  ?></td>
                        <td style="width: 40px;vertical-align: middle;">

                            <div class="custom-control custom-checkbox" style="    top: -15px;right: 5px; ">
                                <input name="id_comp_item[]"  value="<?php  echo $table['id']  ?>" type="checkbox" class="custom-control-input" id="customCheck1xx<?php  echo $table['id']  ?>" checked>
                                <label class="custom-control-label" for="customCheck1xx<?php  echo $table['id']  ?>"></label>
                            </div>

                        </td>
                        <td style="width: 40px; padding:9px 0  0 0;text-align: center; vertical-align: middle;">
                             <button type="button" onclick="break_row_comp(<?php  echo $table['id']  ?>)"  class="btn remove_comp"> <i style="color: red" class="fa fa-times"></i> </button>
                        </td>
                    </tr>

                    <?php }  ?>
                    </tbody>
                </table>

                  <div class="row justify-content-center">
                      <div class="col-auto">
                          <button type="submit" name="submit" class="btn btn_search_range">  قارن </button>
                      </div>
                  </div>

                </form>


                <script>

                    $(document).ready(function () {
                        $('#this_comp').submit(function (e) {
                            e.preventDefault();

                            $('.resultComp').html(`<div style="text-align: center;width: 100%;"><img src="<?php echo $this->static_file_site ?>/image/site/loadchat.gif" ></div>`)

                            $.ajax({
                                type: "POST",
                                url: '<?php  echo url .'/'.$this->folder?>/this_comp',
                                data: $(this).serialize(),
                                success: function (data) {
                                   $('.resultComp').html(data)
                                }
                            })
                        })
                    });

                    function break_row_comp(id) {
                        $.get( "<?php  echo url .'/'.$this->folder?>/break_row_comp/"+id, function( data ) {
                            if (data)
                            {
                                $( "#row_compx_"+id ).remove();
                            }

                        });
                    }

                </script>


<br>



         <div class="row resultComp">

            </div>


            </div>

                <?php  }  else { ?>



            <div class="col-lg-3">

                <?php $this->menu->menu() ?>


            </div>

            <div class="col-lg-9">

                <br>

                <nav aria-label="breadcrumb" class="path_bread">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?php  echo url ?>"><i class="fa fa-home"></i> </a></li>

                        <li class="breadcrumb-item   active "  aria-current="page" >  مقارنات </li>


                    </ol>
                </nav>
                <br>


                <div class="alert alert-danger" role="alert" style="width: 100%;">
                        <span>   لا توجد منتجات للمقارنة بينها يرجى الضغط على هذة العلامة   </span>  <i class="fa fa-exchange"> </i>   <span> لإضافة المنتجات الى قائمة المقارنات  </span>
                    </div>

            </div>


                <?php  }  ?>



        </div>


    </div>







               <script>

                function isJson(str) {
                    try {
                        JSON.parse(str);
                    } catch (e) {
                        return false;
                    }
                    return true;
                }

            </script>


            <style>

                .bast_device
                {
                  left: 3px !important;
                   top: -5px;
                }
                .grid_comparison
                {
                    border: 2px solid #495678;
                    padding: 10px 12px;
                    height: 100%;
                    position: relative;
                    border-radius: 5px;
                }

                .required_size, .required_color {
                    color: red;
                    margin-bottom: 18px;
                }

                .price_xo_x span:nth-of-type(2) {
                    border: 1px solid #7e7;
                    padding: 0 20px;
                    border-radius: 7px;
                }

                .x_ox_number {
                    text-align: center;
                    margin: 0 5px;
                    height: 34px;
                    border-radius: 52px !important;
                }

                .sher_pro {
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                }

                .details_prod {
                    border: 1px solid #d1d0ce;
                    height: 100%;
                    padding: 5px 20px;
                    position: relative;
                }

                .size_icon {
                    border: 1px solid #d1d0ce;
                    padding: 0 7px;
                    margin: 0 3px;
                    text-align: center;
                    cursor: pointer;
                    transition: 0.5s;
                }

                .size_icon:hover, .size_icon:focus {
                    background: #707f8e;
                    color: #ffffff;
                }

                .checked {
                    background: #707f8e;
                    color: #ffffff;
                    position: relative;
                }

                .checked:before {

                    position: absolute;
                    content: '\f00c';
                    font-family: FontAwesome;
                    top: -20px;
                    color: #7e7;
                    width: 100%;
                    text-align: center;
                    right: 0;
                }

                .title_pro {
                    font-size: 28px;
                }

                .color_icon {
                    padding: 1px 17px;
                    margin: 0 5px;
                }

                .sher_pro a {
                    text-decoration: none;
                }

                .sher_pro i {
                    color: #ffffff;
                    width: 32px;
                    height: 32px;
                    font-size: 18px;
                    border-radius: 50%;
                    padding: 8px;
                    text-align: center;
                    background: #125da9;
                }


                .relImg {
                    width: 100%;
                }


                .image_or_icon {
                    text-align: center;
                    width: 250px;
                    height: 250px;
                    border: 1px solid #0ea2be;
                    border-radius: 50%;
                    overflow: hidden;
                    animation: pulse 3s infinite;
                    padding-top: 28px;
                }


                .image_or_icon img {

                    height: 186px;
                }

                .that_rel {
                    background: #125da9;
                    margin: 18px 0;
                    padding: 5px 14px;
                    border-radius: 5px;
                    color: #ffffff;
                    font-size: 22px;
                }

                button.minus {
                    border-radius: 50% !important;
                    width: 33px;
                    height: 33px;
                    padding: 0;
                    background: #536a98;
                    color: #ffffff;
                }

                button.plus {
                    border-radius: 50% !important;
                    width: 33px;
                    height: 33px;
                    padding: 0;
                    background: #536a98;
                    color: #ffffff;
                }


            </style>







    <style>
        .image_mobile_show {
            text-align: center;
        }

        .image_mobile_show img.image_user {
            height: 350px;
            max-width: 100%;
        }

        .notePrice {
            padding: 5px;
            background: #e5e7f3;
        }

        .price {

            font-size: 18px;
            font-weight: bold;
        }

        .t_d_m {
            margin-top: 30px;
            font-size: 18px;
            font-weight: bold;
        }

        #price_device, #price_unit,.price_style_comp {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }


        .infoDevice {
            border: 2px solid rgba(139, 134, 134, 0.45);
        }
        button.btn.remove_comp {
            margin-bottom: 0;
            padding: 4px 4px;
            background: transparent;
        }

    .detailsDevice tbody tr td:nth-of-type(1)
    {
        width: 150px !important;
        display: inline-table;
    }

    .detailsDevice p img,
    .detailsDevice p video
    {
     display: none !important;
    }




    </style>


    <br>
    <br>
    <br>
    <br>





<?php $this->publicFooter(); ?>
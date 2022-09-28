<?php  $this->publicHeader($this->langSite('details'));  ?>

<br>


<div class="container">
    <div class="row">
        <div class="col-12">

            <span><?php echo $result['name'] ?>  </span>

           <hr>
        </div>

        <div class="col-12">

            <?php  if (!empty($request)) { ?>
                <div class="row justify-content-between">
                    <div class="col-auto">
                       الطلبات الحالية
                    </div>

                </div>
            <table class="requ_on table table-striped">
                    <thead>
                        <tr>
                            <th class="d-none d-sm-block" scope="col">صورة</th>
                            <th  scope="col">اسم المنتج</th>
                            <th class="d-none d-sm-block" scope="col">القياس</th>
                            <th class="d-none d-sm-block" scope="col">اللون</th>
                            <th class="d-none d-sm-block" scope="col">العدد</th>
                            <th scope="col">السعر</th>
                            <th scope="col">تاريخ</th>
                            <th class=" d-block_custom" scope="col">تفاصيل</th>

                        </tr>
                    </thead>
                    <tbody>

                    <?php   $price1=0;$price2=0;  foreach ($request as $rows)  {  ?>
                        <tr>
                            <td class="d-none d-sm-block"><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                            <td ><?php  echo $rows['title'] ?></td>
                            <td class="d-none d-sm-block" ><?php  echo $rows['size'] ?></td>
                            <td class="d-none d-sm-block" style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                            <td class="d-none d-sm-block" ><?php  echo $rows['number'] ?></td>
                            <td><?php  echo $rows['price']   ?>   </td>
                            <td><?php  echo date('Y-m-d H:i:s a',$rows['date_req']) ?></td>
                            <td class="d-block_custom" ><a  class="btn btn-warning" onclick="getDetails(<?php  echo $rows['id'] ?>)"  >تفاصيل</a> </td>
                        </tr>


                        <?php

                        $price=explode('-',$rows['price']);

                        if (count($price) == 2)
                        {

                            $f1=(int)trim(str_replace(',','',$price[0] ));
                            $f2=(int)trim(str_replace(',','',$price[1] ));
                            $price1=$price1+ ($f1 * $rows['number'] );
                            $price2=$price2+($f2 * $rows['number'] );
                        }else{
                            $price1=$price1+ ((int)$rows['price'] * $rows['number'] );
                            $price2=$price2+((int)$rows['price'] * $rows['number'] );
                        }

                        ?>



                    <?php  }  ?>

                    <tr style="  background: #283581;color: #fff;font-weight: bold;">
                    <td colspan="5">المجموع</td>
                    <td >  <span> <?php  echo number_format($price1)?>  </span> - <span> <?php  echo number_format($price2)  ?> </span>  د.ع </td>
                        <td></td>
                    </tr>


                    </tbody>
                </table>


                  <?php  } else  {    ?>
                <div class="alert alert-warning" role="alert">
                    لا يوجد طلب جديد
                </div>
              <?php   }  ?>
        </div>


        <?php  if (!empty($request_old)) {  ?>
                <div class="col-12">
        <br>
        <br>

                <div  >
                  الطلبات المجهزة
                </div>


            <table class="requ_on table table-striped">
                <thead>


                <tr>
                    <th class="d-none d-sm-block" scope="col">صورة</th>
                    <th scope="col">اسم المنتج</th>
                    <th class="d-none d-sm-block" scope="col">القياس</th>
                    <th class="d-none d-sm-block" scope="col">اللون</th>
                    <th class="d-none d-sm-block" scope="col">العدد</th>
                    <th scope="col">السعر</th>
                    <th scope="col">تاريخ</th>
                    <th class=" d-block_custom" scope="col">تفاصيل</th>
                </tr>

                </thead>
                <tbody>


                <?php   foreach ($request_old as $rows)  {  ?>
                <tr>
                    <td class="d-none d-sm-block"><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $rows['img'] ?>"></td>
                    <td><?php  echo $rows['title'] ?></td>
                    <td class="d-none d-sm-block"><?php  echo $rows['size'] ?></td>
                    <td class="d-none d-sm-block" style="text-align: center"><span class="color_item_table" style="background: <?php  echo $rows['color'] ?>">  </span></td>
                    <td class="d-none d-sm-block"><?php  echo $rows['number'] ?></td>
                    <td><?php  echo $rows['price']   ?></td>
                    <td><?php  echo date('Y-m-d',$rows['date']) ?></td>
                    <td class="d-block_custom" ><a  class="btn btn-warning" onclick="getDetails(<?php  echo $rows['id'] ?>)"  >تفاصيل</a> </td>
                </tr>
                   <?php  }  ?>

                </tbody>
            </table>


        </div>
<?php  } ?>
    </div>
 

</div>


    <div class="modal  " id="exampleModal_d_item_" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"> تفاصيل </h6>
                </div>
                <div class="modal-body result_data_d_item_">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">خروج</button>

                </div>
            </div>
        </div>
    </div>


<script>
    function getDetails(id) {

        $.get( "<?php echo url ?>/register/getDetails/"+id, function( data ) {

               $( ".result_data_d_item_" ).html( data );
               $('#exampleModal_d_item_').modal('show');


        });

    }

</script>



<style>


    .xMsg
    {
        text-align: left;
    }


    .msg_order
    {
        color: #1e7e34 !important;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }

.image_prod
{
    width: 50px;
    height: 50px;
}
    table.requ_on.table.table-striped thead tr th{
        border: 1px solid #000000;
    }

  table.requ_on.table.table-striped tbody tr td{
        border: 1px solid #000000;
    }

    .color_item_table
    {
        width: 27px;
        height: 27px;
        display: block;
    }
        .d-block_custom {
             display: none;
        }

        @media (max-width: 576px)
        {
            .d-block_custom {
                display: table-cell !important;
            }
            .xMsg
            {
                text-align: right;
                padding: 8px 15px;
            }

        }
        @media (min-width: 576px)
        {
            .d-sm-block {
                display: table-cell !important;
            }


        }


</style>

    <br>
    <br>
    <br>
    <br>

<?php $this->publicFooter(); ?>
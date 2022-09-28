<br>
<div class="container-fluid" style="padding: 0">

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('movement_materials') ?> </a></li>
					<?php  echo $path_category ?>
                </ol>
            </nav>


            <hr>
        </div>
    </div>


<div class="row">
    <div class="col">
    <form action="<?php echo url.'/'.$this->folder?>" method="get">


        <div class="container-fluid" id="expand_menu">
            <div class="row">

                <select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)"  >
                    <option value=""   selected> كل الاقسام  </option>
					<?php  foreach ($this->category_website as $key => $cg) {   ?>
                        <option <?php  if ($key==$model) echo 'selected'?>  value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
					<?php  } ?>
                </select>

            </div>

        </div>


        <div class="row">
            <div class="col-auto">
                الباركود
                <input autocomplete="off" style="width: 150px" type="number" name="code" class="form-control" value="<?php  echo $code ?>"  >
            </div>

            <div class="col-auto">
                من تاريخ
                <input type="datetime-local" name="date" class="form-control" value="<?php  echo $date ?>"   >
            </div>
            <div class="col-auto">
                الى تاريخ
                <input type="datetime-local" name="todate" class="form-control" value="<?php  echo $todate ?>"   >
            </div>

        </div>
         <br>
        <div class="row">
            <div class="col">


                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="type[]"   <?php  if (in_array('account',$type)) echo 'checked' ?>    value="account" id="customcheckboxInline-0" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-0">  تمت المحاسبة (قيد التجهيز) </label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="type[]"   <?php  if (in_array('sale',$type)) echo 'checked' ?>    value="sale" id="customcheckboxInline-1" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-1">  مبيع </label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="type[]"   <?php  if (in_array('purchase',$type)) echo 'checked' ?>    value="purchase" id="customcheckboxInline-3" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-3">  شراء </label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="type[]"   <?php  if (in_array('review',$type)) echo 'checked' ?>    value="review" id="customcheckboxInline-2" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-2">  مرتجع </label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="type[]"   <?php  if (in_array('withdrawn',$type)) echo 'checked' ?>    value="withdrawn" id="customcheckboxInline-4" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-4">  سحب </label>
                </div>



                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="price_type[]"   <?php  if (in_array(1,$price_type)) echo 'checked' ?>    value="1" id="customcheckboxInline-5" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-5">  جملة </label>
                </div>




                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="price_type[]"   <?php  if (in_array(2,$price_type)) echo 'checked' ?>    value="2" id="customcheckboxInline-6" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-6">   جملة الجملة </label>
                </div>




                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox"    name="price_type[]"   <?php  if (in_array(3,$price_type)) echo 'checked' ?>    value="3" id="customcheckboxInline-7" class="custom-control-input"  >
                    <label class="custom-control-label" for="customcheckboxInline-7">   تكلفة </label>
                </div>




            </div>

        </div>

        <hr>
        <div class="">
            <input type="submit" value="بحث" class="btn btn-warning"  >
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>


    </form>
    </div>
</div>



<hr>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>


    <div class="row">
        <div class="col">


    <table id="example" class="table table-striped display d-table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">صورة</th>
            <th scope="col">القسم</th>
            <th scope="col">المادة</th>
            <th scope="col">اسم الزبون</th>
            <th scope="col">   رقم الهاتف </th>
            <th scope="col">رقم الفاتورة</th>
            <th scope="col">رقم فاتورة كرستال</th>
            <th scope="col">الكود</th>
            <th scope="col">الكمية</th>
         	<th scope="col">نوع الجهاز</th>
            <th scope="col">اللون</th>
            <th scope="col">سيريال</th>
            <th scope="col">السعر</th>
            <th scope="col"> المحاسب </th>
            <th scope="col"> المجهز </th>
            <th scope="col">   نوع الفاتورة  </th>
            <th scope="col">    ننصح به  </th>
            <th scope="col">      الموقع  </th>
            <th scope="col">    المستودع  </th>
            <th scope="col">    البائع  </th>
            <th scope="col">    العروض  </th>
            <th scope="col">     نوع السعر  </th>
            <th scope="col">تاريخ </th>
            <th scope="col">  وقت  </th>
            <?php  if ( $date_acc_and_req==1) {  ?>
            <th scope="col">  تاريخ الطلب  </th>
            <th scope="col">  تاريخ المحاسبة  </th>
            <th scope="col">  تاريخ التجهيز  </th>
            <?php } ?>
            <th scope="col">  حالة الفاتورة  </th>
            <th scope="col">  نقاط المادة </th>
            <th scope="col">   ملاحظة المجهز</th>
            <th scope="col">   ملاحظة البائع</th>

        </tr>
        </thead>
        <tbody>
		<?php foreach ($data as $key => $d)  {  ?>

            <tr>
                <th scope="row"> <?php echo $key + 1 ?>  </th>
                <td><img width="40" src="<?php  echo $this->save_file.$d['image'] ?>"></td>
                <td><?php  echo $this->langSite($d['table']) ?></td>
                <td><?php  echo $d['title'] ?></td>
                <td  style="color: red"><?php  echo $this->customerInfo($d['id_member_r']) ?></td>
                <td  style="color: red"><?php  echo $this->customerInfo($d['id_member_r'],'phone') ?></td>
                <td style="color: red"> <?php  echo  $d['number_bill']  ?></td>
                <td style="color: red"> <?php  echo  $d['crystal_bill']  ?></td>
                <td><?php  echo $d['code'] ?></td>
                <td><?php  echo $d['number'] ?></td>
             	<td><?php if($d['table'] == 'product_savers' || $d['table'] == 'savers'){ echo $d['name_device']; }else {echo '';}?></td>
                <td><?php  echo $d['name_color'] ?></td>
                <td><?php  echo $d['enter_serial'] ?></td>
                <td>
                   <?php  if ($d['edit_price'] == 1 ) {  ?>
                         <span style="color: red;font-weight: bold"  data-toggle="tooltip" data-placement="top" title="تم تغير السعر"  > <?php  echo $d['price'] ?> </span>
                    <?php } else {  ?>
                       <?php  echo $d['price'] ?>
                    <?php  }  ?>
                </td>
                <td><?php  echo $d['account'] ?></td>

                <td>
                    <?php

                    if ($d['id_prepared'])
                    {
                        echo  $this->UserInfo($d['id_prepared']);

                    }else
                    {
                        echo $this->UserInfo($d['user_direct']);
                    }

                    ?>
                </td>

                <td><?php  echo $d['type_bill'] ?></td>
                <td><?php  echo $d['bast_it'] ?></td>
                <td><?php  echo $d['location'] ?></td>
                <td><?php  echo $d['store_location'] ?></td>
                <td><?php  echo $d['user_sale'] ?></td>
                <td>
                    <?php  if($d['offers']) { ?>
                        <?php  echo $this->details_offer($d['id_offer'],'title')?>
                    <?php  } ?>
                </td>
                <td>
                    <?php  if(in_array($d['price_type'],array(1,2,3))) { ?>
                        <?php  echo $this->price_type[$d['price_type']] ?>
                    <?php  }else{  ?>
                        سعر مفرد
                    <?php  }  ?>
                </td>
                <td><?php  echo date('Y-m-d' , $d['date'] ) ?></td>


                <td><?php  echo date('h:i:s A' , $d['date'] ) ?></td>
                 <?php  if ( $date_acc_and_req==1) {  ?>
                     <td><?php  echo date('Y-m-d h:i:s A' , $d['date_req'] ) ?></td>
                     <td><?php  echo date('Y-m-d h:i:s A' , $d['date_accountant'] ) ?></td>
                     <td>
                     <?php if ($d['date_prepared'])  { ?>
                        <?php  echo date('Y-m-d h:i:s A' , $d['date_prepared'] ) ?>
                       <?php } ?>
                       </td>
                    <?php } ?>

                <td>
                 <?php   if ($d['crystal_bill'] !='x' && $d['group_bill']!='x') { ?>
                     <?php  if (!empty($d['group_bill']) && empty($d['crystal_bill']))  {  ?>
                         <span> مجموعة بنتظار كتابة رقم فاتورة كرستال - رقم المجموعة  </span> <span> <?php  echo $d['group_bill'] ?> </span>
                     <?php } else if ($d['group_bill'] && $d['crystal_bill']){  ?>

                     <span> تم ادخال رقم فاتورة كرستال ورقم مجموعة  - رقم المجموعة   </span> <span> <?php  echo $d['group_bill'] ?> </span>

                     <?php } else if (empty($d['group_bill']) && !empty($d['crystal_bill']))  {?>

                         تم ادخال رقم فاتورة كرستال للفاتورة وهذة الفاتورة بدون مجموعة

                     <?php } else if (empty($d['group_bill']) && empty($d['crystal_bill'])) {  ?>

                         بنتظار تصدير مجموعة فواتير كرستال او كتابة رقم فاتورة كرستال مباشرتأ بدون مجموعة

                     <?php  } ?>
                  <?php } ?>

                 </td>

                <td><?php  echo $d['point'] ?></td>
                <td><?php  echo $d['note_prepared'] ?></td>
                <td><?php  echo $d['note'] ?></td>

            </tr>
		<?php  }  ?>

        </tbody>

    </table>
</div>
</div>

</div>


<script>



    function mainCatgHtmlx(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;

        if (value) {

            if (value !== 'savers') {
                $.get("<?php echo url . '/' . $this->folder ?>/getMainCatDB/" + value, function (data) {
                    if (data) {
                        $('#' + id_html).nextAll('select').remove();
                        $('#' + id_html + ':last').after(data);
                    } else {
                        alert('حدث خطاء في الاختيار يرجى تحديث الصفة او المحاولة لاحقا')
                    }
                });
                pathCatg();

            }
        }else
        {
            $("select[name='category']").remove();
        }
    }


    function sub_catgs(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;
        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function sub_catgs2(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs2/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function pathCatg() {
        var d = $('#expand_menu select option:selected').map(function () {
            return $(this).text();
        });

        p=d[0];
        for (i = 1; i < d.length; i++)
        {
            p+=" / "+d[i];
        }
        $('#path_catg').val(p)
    }

</script>




<style>
    .list_menu_categ
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }
    .list_menu_categ:focus
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }


    .x_down div
    {
        margin-bottom: 30px;
    }
    table thead tr
    {
        text-align: center;
    }

    table tbody tr td
    {
        text-align: center;
    }


    .d-table
    {

        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }


</style>





<br>
<br>
<br>
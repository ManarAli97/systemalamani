<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('purchase_bill') ?> </li>
            </ol>
        </nav>
    </div>

</div>


<div class="content">
    <form  action="<?php echo url.'/'.$this->folder ?>/add_purchase_bill/" method="post" enctype="multipart/form-data">
        <div id="addReminder"   class="btn addReminder">
            <i class="fa fa-bell iconReminder" ></i>
            <input type="date" name="date_reminder"  class="form-control" id="date_reminder" style="display:none" >
        </div>
        <div class='part_1'>

            <div class="form-row row mb-4">
                <div class="col-lg-3 col-md-2 mr-4">
                    <label class="mr-sm-2" for="select_name_supplier">اسم المورد</label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="name_supplier" id="select_name_supplier" required>
                        <option value = ''> اختر اسم</option>
                        <?php foreach ($nameSupplier as $key => $name) {   ?>
                                <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
                            <?php  } ?>
                        </select>
                </div>

                <div class="col-lg-2 col-md-2 mr-4">
                    <label class="mr-sm-2" for="select_source_request"> مصدر الطلب</label>
                    <select class=" form-control dropdown_filter selectpicker" data-live-search="true" name="source_request" id="select_source_request" required>
                        <option value = ''> اختر مصدر الطلب</option>
                        <?php foreach ($sourceRequest as $key => $name) {   ?>
                                <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
                            <?php  } ?>
                        </select>
                </div>

                <div class="col-lg-3 col-md-2 mr-4">
                    <label class="mr-sm-2" for="select_company_shipping">اسم شركة الشحن</label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true"  name="company_shipping" id="select_company_shipping" required>
                        <option value = ''> اختر اسم شركة الشحن</option>
                        <?php foreach ($companyShipping as $key => $name) {   ?>
                            <option    value="<?php  echo $name['id']?>"><?php  echo $name['name']?></option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-2 mr-4">
                    <label class="mr-sm-2" for="select_type_shipping">نوع  الشحن</label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="type_shipping" id="select_type_shipping"  required>
                        <option value = ''> اختر  نوع الشحن</option>
                        <?php foreach ($typeShipping as $key => $name) {   ?>
                            <option    value="<?php  echo $name['id']?>"><?php  echo $name['type']?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class='part_2'>
            <div class="form-row row mb-4">
                <div class="col-lg-3 col-md-2 mb-4">
                    <label class="mr-sm-2" for="date_request">تاريخ الطلب </label>
                    <input type="date" name="date_request"  class="form-control" id="date_request"  required>
                    <p id='user_date_req' class="user"></p>
                </div>

                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_ex_eq"> المدة المتوقعة لتجهيز </label>
                    <input type="number" name="date_ex_eq"  class="form-control" id="date_ex_eq" min='0'>
                    <p id='user_date_ex_eq' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_eq">   تاريخ التجهيز</label>
                    <input type="date" name="date_eq"  class="form-control" id="date_eq" >
                    <p id='user_date_eq' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_send">   تاريخ الارسال</label>
                    <input type="date" name="date_send"  class="form-control" id="date_send" >
                    <p id='user_date_send' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-1  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_ex_shipping"> المدة المتوقعة لشحن </label>
                    <input type="number" name="date_ex_shipping"  class="form-control" id="date_ex_shipping" min='0' >
                    <p id='user_date_ex_shipping' class="user"></p>
                </div>

            </div>
            <div class="form-row row mb-4">
                <div class="col-lg-3 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_shipping"> تاريخ  الشحن   </label>
                    <input type="date" name="date_shipping"  class="form-control" id="date_shipping">
                    <p id='user_date_shipping' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_ex_arrival"> المدة المتوقعة للوصول </label>
                    <input type="number" name="date_ex_arrival"  class="form-control" id="date_ex_arrival" min='0' >
                    <p id='user_date_ex_arrival' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="date_arrival"> تاريخ وصول البضاعة   </label>
                    <input type="date" name="date_arrival" class="form-control" id="date_arrival">
                    <p id='user_date_arrival' class="user"></p>
                </div>
                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="currency">عملة الشراء  </label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency" id="currency"  required>
                        <option value = '' name= ''> اختر اسم</option>
                        <?php foreach ($currency as $key => $name) {   ?>
                            <option    value="<?php  echo $name['id']?>" name='<?php  echo $name['name']?>'><?php  echo $name['name']?></option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-2 mb-4">
                    <label class="mr-sm-2" for="price_exchange_order"> سعر التصريف  بالدولار   </label>
                    <input type="text" name="price_exchange_order" class="form-control" id="price_exchange_order">
                </div>
            </div>

            <div class="form-row row mb-4">
                <div class="col-lg-3 col-md-2 mb-4 mr-4">
                    <label class="mr-sm-2" for="date_arrival_warehouse">تاريخ وصول البضاعة لمخازن الشركة</label>
                    <input type="date" name="date_arrival_warehouse"  class="form-control" id="date_arrival_warehouse">
                    <p id='user_date_arrival_warehouse' class="user"></p>
                </div>

                <div class="col-lg-2 col-md-2 mb-4">
                    <label class="mr-sm-3" for="user_add_arrival_warehouse"> اسم مستلم البضاعة في مخازن الشركة </label>
                    <input type="text" name="user_add_arrival_warehouse" class="form-control" id="user_add_arrival_warehouse" autocomplete="off" list='list_user'><datalist id="list_user"> </datalist>
                </div>

                <div class="col-lg-2 col-md-2 mb-4 mr-4">
                    <label class="mr-sm-2" for="depart">اختر قسم الفاتورة</label>
                    <select name="depart" class=" dropdown_filter selectpicker" data-live-search="true"  id="depart" required >
                        <?php foreach ($this->category_website as $key => $value) {   ?>
                            <option name="<?php echo $this->langControl($value)?>" value="<?=$key?>"><?= $value?></option>
                        <?php  } ?>
                    </select>
                </div>


                <!--  note_order -->
                <div class="col-lg-4 col-md-2 mb-4 mr-4">
                    <label class="mr-sm-2" for="note_order">ملاحظة الفاتورة</label>
                    <textarea name="note_order" class="form-control" id="note_order" cols="150"></textarea>
                </div>
            </div>
        </div>

        <table id="example"  class="table table-striped  d-table table-bordered row-border order-column"  width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th> اسم المادة</th>
                    <th>القسم</th>
                    <th> رمز المادة</th>
                    <th> الكمية </th>
                    <th>سعر الشراء</th>
                    <th> الكلفة الاجمالية</th>
                    <th>صورة المادة</th>
                    <th> سعر البيع $</th>
                    <th> سعر البيع جملة $</th>
                    <th> سعر البيع جملة الجملة $</th>
                    <th>ملاحظة</th>
                    <th> تعديل بطاقة المادة </th>
                </tr>
            </thead>
            <tbody>
                <tr id='1'>
                    <td> <button type="button" class="btn add_new_sub_row">  <i class="fa fa-plus"></i> </button></td>
                    <td><input  type="text" name="title[1]" class="form-control-lg"  id="title_1" list='list1_1' autocomplete="off" style="width:330px;height:40px; font-size:14px"><datalist id="list1_1"> </datalist>
                        <p  name="size[1]" id="size_1" style="margin-top:10px;"></p> <input   name="size_val[1]" type="hidden"  class=""    id= 'size_val_1'/>
                        <p  name="type[1]" id="type_1" style="margin-top:10px;"></p> <input   name="type_val[1]" type="hidden"  class=""    id= 'type_val_1' />
                        <p  name="rate[1]"  id="rate_1" style="margin-top:10px;"></p> <input   name="rate_val[1]" type="hidden"  class=""    id= 'rate_val_1' />
                    </td>
                    <td>
                        <p id = 'category_val_1'>موبايل</p> <input type='hidden' name="category[1]" id="category_1" value="mobile" />
                    </td>
                    <td> <input type="text"  name="code[1]" class="form-control" id="code_1" autocomplete="off" style="width:120px"></td>
                    <td> <input type="text" name="quantity[1]" class="form-control" id="quantity_1" autocomplete="off" style="width:120px"></td>
                    <td> <input type="text" name="price_purchase[1]"  class="form-control" id="price_purchase_1" autocomplete="off" style="width:170px"></td>
                    <td name="price_total[1]" id="price_total_1" ></td>
                    <td><img src="" name="img[1]"  alt="لا توجد صورة" srcset="" id='img_1' width='150px' height='150px' ><input   name="image[1]" type="hidden"  id='image_1'/></td>
                    <td> <input type="text" name="sale_price[1]" class="form-control" id="sale_price_1" autocomplete="off" style="width:170px"></td>
                    <td> <input type="text" name="wholesale_price_sale[1]" class="form-control" id="wholesale_price_sale_1"  autocomplete="off" style="width:170px"></td>
                    <td> <input type="text" name="wholesale_price2_sale[1]" class="form-control" id="wholesale_price2_sale_1" autocomplete="off" style="width:170px"></td>
                    <td> <textarea  name="note[1]" class="form-control" id="note_1" cols="60" style="width:220px"></textarea></td>
                    <td>  <div id='edit_1' style='text-align: center;font-size: 25px;' ><a href="" id='edit_item_1' target="_blank"> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a></div> </td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>
        <br>
        <br>


        <div class='part_3'>

            <div class="form-row row mt-4 mb-4">

                <div class="col-lg-1 col-md-2">

                </div>
                <div class="col-lg-3 col-md-2" style ="margin-top:35px">
                    <p  class='text_total'>  المجموع الكلي : <span class ='price'   id ='totalprice'  name='totalprice'> 0 </span></p>
                    <input type="hidden" name="total-price"  value="0" id="total-price" >
                </div>

            	<div class="col-lg-3 col-md-2" style ="margin-top:35px">
                    <p  class='text_total'>  المجموع الكلي + التكلفة الاضافية : <span class ='price' id ='priceandcost' name='priceandcost' >0</span></p>
                    <input type="hidden"  name="total_price_cost"  value="0" id="total_price_cost" >
                </div>
            
                <div class="col-lg-3 col-md-2" style ="margin-top:35px">
                    <p  class='text_total'>    المجموع الكلي المدفوع : <span class ='price' id ='totalpricedollars' name='totalpricedollars' >0</span></p>
                    <input type="hidden"  name="total_price_dollars"  value="0" id="total_price_dollars" >
                </div>

            </div>
            <h6>اضافة تكلفة</h6>
            <div class="cost">
                <div class="form-row row mt-4 mb-4 mt-4 ">
                    <div  class="col-lg-1 col-md-2">
                        <button type="button" class="btn add-class"  onclick="create_cost()" id="btn-cost-1" style="margin-top:35px;margin-right:13px">  <i class="fa fa-plus"></i></button>
                    </div>


                    <div class="col-lg-2 col-md-2">
                        <label class="mr-sm-2" for="cost_1">تكلفة اضافية  </label>
                        <input type="text" name="cost[1]" class="coost form-control" id="cost_1" autocomplete="off">
                    </div>


                    <div class="col-lg-2 col-md-2  mb-4 mr-2">
                        <label class="mr-sm-2" for="currency_1">عملة </label>
                        <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency_cost[1]" id="currency_1">
                            <option value = '' name= ''> اختر اسم</option>
                            <?php foreach ($currency as $key => $name) {   ?>
                                <option    value="<?php  echo $name['id']?>" name='<?php  echo $name['name']?>'><?php  echo $name['name']?></option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2  ml-4">
                        <label class="mr-sm-2" for="price_exchange_cost_1"> سعر التصريف  بالدولار   </label>
                        <input type="text" name="price_exchange_cost[1]" value="1" class="form-control" id="price_exchange_cost_1" autocomplete="off" >
                    </div>

                    <div class="col-lg-2 col-md-2  ml-4">
                        <label class="mr-sm-2" for="note_cost_1"> ملاحظة  </label>
                        <textarea  name="note_cost[1]" class="form-control" id="note_cost_1" cols="60" style="width:240px"></textarea>
                    </div>
                </div>
            </div>
            <br><br> <br><br>
            <h6>اضافة دفعة</h6>
            <div class="payment">
                <div class="form-row row mt-4 mb-4 mt-4 create_payment">
                    <div  class="col-lg-1 col-md-2">
                        <button type="button" class="btn add-class"  onclick="create_payment()" id="btn-payment-<?php echo $i ?>" style="margin-top:35px;margin-right:13px">  <i class="fa fa-plus"></i></button>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <label class="mr-sm-2 " for="name_pay_1">اسم الحساب الذي تم الدفع منه</label>
                        <select class="name_pay form-control dropdown_filter selectpicker" data-live-search="true" name="name_pay[1]" id="name_pay_1" >
                            <option value = ''> اختر اسم</option>
                            <?php foreach ($accountSupplier as $key => $name) {?>
                                <option name="<?php  echo $name['type'] ?>"  value="<?php echo $name['id'] ?>">
                                <?php  if($name['type'] == 'supplier'){
                                    echo $name['name']. ' ' .'(مورد)';
                                }else{
                                    echo $name['name'];
                                }?>

                            </option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="">
                        <label for="subtotal_1" class='mr-sm-2' id='text_total' name='subtotal'>  المبلغ المدفوع:</label>
                        <input type="input" name="subtotal[1]"  class="form-control subtotal_1" id="subtotal_1"  autocomplete="off">
                        <p id='sub_total_1'></p>
                    </div>

                    <div class="col-lg-2 col-md-2  ml-4">
                        <label class="mr-sm-2" for="price_exchange_1"> سعر التصريف  بالدولار   </label>
                        <input type="text" name="price_exchange[1]" value="1" class="form-control" id="price_exchange_1" autocomplete="off">
                    </div>

                    <div class="col-lg-2 col-md-2  ml-4">
                        <label class="mr-sm-2" for="note_payment_1"> ملاحظة      </label>
                        <textarea  name="note_payment[1]" class="form-control" id="note_payment_1" cols="60" style="width:240px"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center  mb-4" style="clear: both;">
            <input class="btn btn-primary" id="save_bill" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
        </div>
    </form>
</div>


<script>
    $('.iconReminder').click(function() {
        $('#addReminder').toggleClass("addWth");
        $('.iconReminder').toggle();
        $('#date_reminder').toggle();

    });
    $(document).ready(function() {

        $('#depart').on('change',function() {
            var nameGategory = $("#depart").val();
            var nameGatAribic = $("#depart").find('option:selected').attr("name");
            console.log(table.row(':last').index());
           if(table.row(':last').index() == 0){
            if($('#title_1').val() == '' || $('#code_1').val() == '' ){
                $('#category_val_1').text(nameGatAribic);
                $('#category_1').val(nameGategory);
            }

           }
        });

        $('#example').DataTable( {
            //scrollY: "300px",
            // scrollX: true,
            // scrollCollapse: true,
            // scrollX: true,
            // responsive: true,
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);

            },
            'columnDefs': [{
                "targets": [0],
                "orderable": false
            }],
            "order": [[ 0, 'desc'] ],
            // aLengthMenu: [ 50,100, 200, 300,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                footer: true,
                    exportOptions: {
                        columns: [1,3,2,4,5,10,11,12],
                        format: {
                            body: function ( inner, rowidx, colidx, node ) {
                                if($(node).find('option:selected').val()){
                                    return $(node).find('option:selected').text();
                                 }
                                if ($(node).children("input").length > 0) {
                                return $(node).children("input").first().val();
                                } else {
                                return inner;
                                }
                            }
                        }
                    }
                },
            ],

            bFilter: true, bInfo: true,

            } );
            $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );

        });

        var table = $('#example').DataTable();
        // اضافة صف جديد
        $(".add_new_sub_row").click(function () {

            var nameGategory = $("#depart").val();
            var nameGatAribic = $("#depart").find('option:selected').attr("name");
            let countLine = table.row(':last').index() + 1;
            // var nameGategory = $("#category_"+countLine).val();
            countLine++;
            newRow = `<tr id='${countLine}' class="remove_sub_row_${countLine}"><td>  <button type="button" class="btn remove_sub_row" onclick="remove_sub_row(${countLine})"> <i class="fa  fa-minus"></i> </button></td>
            <td><input type="text" name="title[${countLine}]" class="form-control"   id="title_${countLine}" list='list1_${countLine}' autocomplete="off"><datalist id="list1_${countLine}"></datalist>
                <p  name ="size[${countLine}]" id="size_${countLine}" style="margin-top:10px;"></p><input   name="size_val[${countLine}]" type="hidden"   id="size_val_${countLine}">
                <p name ="type[${countLine}]" id="type_${countLine}" style="margin-top:10px;"></p> <input   name="type_val[${countLine}]" type="hidden"    id="type_val_${countLine}">
                <p  name ="rate[${countLine}]" id="rate_${countLine}" style="margin-top:10px;"></p><input   name="rate_val[${countLine}]" type="hidden"   id="rate_val_${countLine}">
            </td>
                <td><p id = 'category_val_${countLine}'>${nameGatAribic}</p> <input type='hidden' name="category[${countLine}]" id="category_${countLine}" value="${nameGategory}"/></td>
                <td> <input type="text" name ="code[${countLine}]"  class="form-control" id="code_${countLine}" autocomplete="off" style="font-size:14px"></td>
                <td> <input type="text" name ="quantity[${countLine}]"  class="form-control" id="quantity_${countLine}" autocomplete="off"></td>
                <td> <input type="text" name="price_purchase[${countLine}]"  class="form-control" id="price_purchase_${countLine}" autocomplete="off"></td>>
                <td name="price_total[${countLine}]" id="price_total_${countLine}" ></td>
                <td><img src=""  name ="img[${countLine}]" alt="لاتوجد صورة" srcset="" id='img_${countLine}' width='150px' height='150px' ><input   name="image[${countLine}]" type="hidden"   id="image_${countLine}" /></td>
                <td> <input type="text" name ="sale_price[${countLine}]"  class="form-control" id="sale_price_${countLine}"autocomplete="off" ></td>
                <td> <input type="text" name ="wholesale_price_sale[${countLine}]" class="form-control" id="wholesale_price_sale_${countLine}" autocomplete="off"></td>
                <td> <input type="text" name ="wholesale_price2_sale[${countLine}]" class="form-control" id="wholesale_price2_sale_${countLine}" autocomplete="off"></td>
                <td> <textarea name ="note[${countLine}]" class="form-control" id="note_${countLine}" ></textarea></td>
                <td>  <div id='edit_${countLine}' style='text-align: center;font-size: 25px;' ><a href="" id='edit_item_${countLine}' target="_blank"> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a></div> </td>
                </tr>`;
            table.row.add($(newRow)).draw();
            $("#category_"+countLine).val(nameGategory).change();
            $('.remove_sub_row_'+countLine).find('tr').attr('id',countLine);
            $('.dropdown_filter').selectpicker();
        });

        // اذا تاريخ المتوقع للتجهيز 0 لا يسمح له بادخال باقي التواريخ
        $( "#date_ex_eq" ).on('input',function() {
            var numberOfDay= $('#date_ex_eq').val();
            if(numberOfDay == 0)
            {
                $("#date_eq").attr("disabled", true);
                $("#date_send").attr("disabled", true);
                $("#date_ex_shipping").attr("disabled", true);
                $("#date_shipping").attr("disabled", true);
                $("#date_ex_arrival").attr("disabled", true);
                $("#date_arrival").attr("disabled", true);
            }else{
                $("#date_eq").attr("disabled", false);
                $("#date_send").attr("disabled", false);
                $("#date_ex_shipping").attr("disabled", false);
                $("#date_shipping").attr("disabled", false);
                $("#date_ex_arrival").attr("disabled", false);
                $("#date_arrival").attr("disabled", false);
            }
        });

        // المستخدم الذي اختار تاريخ الطلب
        $('#date_request').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_req').text(name);
        });

        // المستخدم الذي اختار تاريخ المتوقع للتجهيز
        $('#date_ex_eq').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_ex_eq').text(name);
        });

        // المستخدم الذي اختار تاريخ  التجهيز
        $('#date_eq').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_eq').text(name);
        });

        // المستخدم الذي اختار تاريخ الارسال
        $('#date_send').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_send').text(name);
        });

        // المستخدم الذي  ادخل المدة المتوقعه للشحن
        $('#date_ex_shipping').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_ex_shipping').text(name);
        });

        // المستخدم الذي اختار تاريخ الشحن
        $('#date_shipping').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_shipping').text(name);
        });

        //المستخدم الذي ادخل المدة المتوقعه للوصول
        $('#date_ex_arrival').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_ex_arrival').text(name);
        });
        // المستخدم الذي اختار تاريخ الوصول
        $('#date_arrival').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_arrival').text(name);
        });

        // المستخدم الذي اختار تاريخ وصول البضاعة لمخازن الشركة
        $('#date_arrival_warehouse').on('input',function() {
            var name = "<?php echo $this->UserInfo($this->userid) ?>";
            $('#user_date_arrival_warehouse').text(name);
        });

        // المستخدم الذي اختار تاريخ تسليم البضاعة لمخازن الشركة
        $('#user_add_arrival_warehouse').on('input',function() {
            var date = $('#date_arrival_warehouse').val();
            if(date != ''){
                var  nameAccount = $('#user_add_arrival_warehouse').val();
                var data={'name':nameAccount};
                // console.log(data);
                $.get( "<?php echo url .'/'.$this->folder ?>/selectUser/",{ jsonData: JSON.stringify(data)}, function(nameUser) {
                    var user = JSON.parse(nameUser);
                    allUser = '';
                    for(var i=0;i<user.length;i++){
                        allUser += '<option value="'+user[i].name+'"  />';
                    }
                    $('#list_user').html(allUser);
                });
            }
            else{
                alert('يجب ادخال تاريخ تسليم البضاعة لمخازن الشركة اولا');
                $('#user_add_arrival_warehouse').val('');
                $('#date_arrival_warehouse').focus();
            }
        });

        // من يدخل تاريخ الوصول للبضاعة لمخازن الشركة لازم يدخل اسم الشخص الي استلام البضاعة
        $('#date_arrival_warehouse').on('input',function() {
            if($('#date_arrival_warehouse').val() != ''){
                $('#user_add_arrival_warehouse').prop('required',true);
            }
        });

        var table = $('#example').DataTable();
        $('#example').on( 'click', 'tr', function () {
            var id = table.row(this).id();
            var code= $('#code_'+id).val();
            var title = $('#title_'+id).val();
            var category = $('#category_'+id).val();
            var model = category;

            if(model == 'savers'){
                model = 'product_savers';
            }
            // اذا الكود موجود ميضيفه
            if(code != ''){
                for(var i=0;i<table.rows().count();i++){
                    if(code == $('#code_'+i).val() && i != id){
                        alert('الكود موجود مسبقا');
                        $('#code_'+id).val('');
                        $('#title_'+id).val('');
                        $('#img_'+id).attr('src','');
                        $('#image_'+id).val('');
                        $('#size_'+id).html('');
                        $('#size_val_'+id).val('');
                        $('#type_'+id).html('');
                        $('#type_val_'+id).val('');
                        $('#rate_'+id).html('');
                        $('#rate_val_'+id).val('');
                        $('#sale_price_'+id).val('');
                        $('#wholesale_price_sale_'+id).val('');
                        $('#wholesale_price2_sale_'+id).val('');
                        title = '';
                        code = '';
                     	break;
                    }
                }
            }

            var  dataCode={'category':category,'code':code ,'title':title};
            if(code!='' && title ==''){
                $.get( "<?php echo url .'/'.$this->folder ?>/processing_show_items/",{ jsonData: JSON.stringify(dataCode)}, function(data) {
                    if(data != 1){
                        console.log(data);
                        var value = JSON.parse(data);
                        $('#title_'+id).val(value[0].title);
                        $('#img_'+id).attr('src','<?php echo $this->save_file?>'+value[0].img);
                        $('#image_'+id).val(value[0].img);
                        $('#size_'+id).html( "الحجم : "+ value[0].size);
                        $('#size_val_'+id).val(value[0].size);
                        $('#type_'+id).html("التصنيف : "+ value[0].type);
                        $('#type_val_'+id).val(value[0].type);
                        $('#rate_'+id).html( "نسبة : "+ value[0].rate);
                        $('#rate_val_'+id).val(value[0].rate);
                        $('#sale_price_'+id).val(value[0].price_dollars);
                        $('#wholesale_price_sale_'+id).val(value[0].wholesale_price);
                        $('#wholesale_price2_sale_'+id).val(value[0].wholesale_price2);

                        var  urlEdit = '<?php echo url.'/' ?>'+category+'/edit_'+model+'/'+value[0].id;
                        $('#edit_item_'+id).attr("href", urlEdit);
                    }else{
                        alert(' الباركود غير موجود اضف بطاقة مادة اولا');
                        $('#code_'+id).val('');
                        $('#title_'+id).val('');
                        $('#img_'+id).attr('src','');
                        $('#image_'+id).val('');
                        $('#size_'+id).html('');
                        $('#size_val_'+id).val('');
                        $('#type_'+id).html('');
                        $('#type_val_'+id).val('');
                        $('#rate_'+id).html('');
                        $('#rate_val_'+id).val('');
                        $('#sale_price_'+id).val('');
                        $('#wholesale_price_sale_'+id).val('');
                        $('#wholesale_price2_sale_'+id).val('');
                    }
                });
            }

            // end of keyup
            $('#title_'+id ).on('input',function() {
                category = $('#category_'+id).val();
                title = $('#title_'+id).val();
                code = $('#code_'+id).val();
                var dataTitle={'category':category,'title':title};
                $.get( "<?php echo url .'/'.$this->folder ?>/selectName/",{ jsonData: JSON.stringify(dataTitle)}, function(titleItem) {
                    // console.log(titleItem);
                    var dat = JSON.parse(titleItem);

                    allTitle = '';
                    for(var i=1;i<dat.length;i++){
                        // console.log(dat[i].code);
                        allTitle += '<option value="'+dat[i].title+'" id="'+dat[i].code+'" />';
                    }
                    $('#list1_'+id).html(allTitle);

                });

            });
            // end select item by name

            $('#title_'+id).keyup(function() {

                title = $('#title_'+id).val();
                code =  title.substring(title.lastIndexOf(':') + 1, title.lastIndexOf(')'));
                var  dataName={'category':category,'code':code,'title':title};

                $.get("<?php echo url .'/'.$this->folder ?>/processing_show_items/",{ jsonData: JSON.stringify(dataName)}, function(data) {
                    if(data.length != 0){
                        var value = JSON.parse(data);
                        $('#code_'+id).val(value[0].code);
                        $('#img_'+id).attr('src','<?php echo $this->save_file?>'+value[0].img);
                        $('#image_'+id).val(value[0].img);
                        $('#size_'+id).html( "الحجم : "+ value[0].size);
                        $('#size_val_'+id).val(value[0].size);
                        $('#type_'+id).html("التصنيف :" + value[0].type);
                        $('#type_val_'+id).val(value[0].type);
                        $('#rate_'+id).html("نسبة :"+ value[0].rate);
                        $('#rate_val_'+id).val(value[0].rate);
                        $('#sale_price_'+id).val(value[0].price_dollars);
                        $('#wholesale_price_sale_'+id).val(value[0].wholesale_price);
                        $('#wholesale_price2_sale_'+id).val(value[0].wholesale_price2);
                        var  urlEdit = '<?php echo url.'/' ?>'+category+'/edit_'+model+'/'+value[0].id;
                        $('#edit_item_'+id).attr("href", urlEdit);
                      }
                });

            });


            //
            $('#price_purchase_'+id).keyup(function() {
                var len_table = $('#example tr').length;
                var sum = 0;
                var sale_price = 0;
                var total_price_dollars = 0;

                var price_exchange = $('#price_exchange_order').val();
                var currency  = $('#currency').find('option:selected').attr("name");
                if($('#price_exchange_order').val() == ''){
                   $('#price_exchange_order').focus();
                    $('#price_purchase_'+id).val('');
                }


                for(var i=1; i<= len_table;i++){
                    $('#price_total_'+i).text($('#price_purchase_'+i).val() * $('#quantity_'+i).val() + ' ' + currency);
                    $('#price_total_'+i).val($('#price_purchase_'+i).val() * $('#quantity_'+i).val());
                    sale_price = $('#price_total_'+i).val();
                    if(sale_price != undefined){
                        sum += parseFloat(sale_price);
                    }
                    $('#totalprice').text(sum + ' ' + currency);
                    $('#total-price').val(sum);
                }
                if(currency != 'دولار'){
                    total_price_dollars =parseFloat(sum / price_exchange).toFixed(2);
                    // var total_price_dollars =  parseFloat($('#total-price').val() / price_exchange).toFixed(2);  // total price in dollars
                    // $('#total_price_dollars').val(total_price_dollars);
                    // $('#totalpricedollars').text(total_price_dollars);
                    $('#price_purchase').text(total_price_dollars);
                }else{
                    // $('#total_price_dollars').val($('#total-price').val());
                    // $('#totalpricedollars').text($('#total-price').val());
                    $('#price_purchase').text($('#total-price').val()+ ' ' + currency);
                }
            });

            $('#quantity_'+id).keyup(function() {
                var len_table = $('#example tr').length;
                var sum = 0;
                var sale_price = 0;
                var total_price_dollars = 0;


                var price_exchange = $('#price_exchange_order').val();
                var currency  = $('#currency').find('option:selected').attr("name");
                if($('#price_exchange_order').val() == ''){
                   $('#price_exchange_order').focus();
                    $('#quantity_'+id).val('');
                }

                for(var i=1; i<= len_table;i++){
                    $('#price_total_'+i).text($('#price_purchase_'+i).val() * $('#quantity_'+i).val() + ' ' + currency);
                    $('#price_total_'+i).val($('#price_purchase_'+i).val() * $('#quantity_'+i).val());

                    sale_price = $('#price_total_'+i).val();
                    if(sale_price != undefined){
                        sum += parseFloat(sale_price);
                    }
                    $('#totalprice').text(sum + ' ' + currency);
                    $('#total-price').val(sum);
                }
                if(currency != 'دولار'){
                    total_price_dollars =parseFloat(sum / price_exchange).toFixed(2);
                    // var total_price_dollars =  parseFloat($('#total-price').val() / price_exchange).toFixed(2);  // total price in dollars
                    // $('#total_price_dollars').val(total_price_dollars);
                    // $('#totalpricedollars').text(total_price_dollars);
                    $('#price_purchase').text(total_price_dollars);
                }else{
                    // $('#total_price_dollars').val($('#total-price').val());
                    // $('#totalpricedollars').text($('#total-price').val());
                    $('#price_purchase').text(totalpricedollars);
                }
            });
        });








        $('#currency').on('change',function() {
            var currency  = $('#currency').find('option:selected').attr("name");
            console.log(currency);
            if(currency == 'دولار'){
                $("#price_exchange_order").val('1');
                $("#price_exchange_order").attr("readonly", true);
                $("#price_exchange_1").attr("readonly", true);
            }
            else{
                $("#price_exchange_order").attr("readonly", false);
                $("#price_exchange_1").attr("readonly", false);
            }
        });

        // هنا حتى ميكتب بالحقل قبل مايختار عملة
        $('#price_exchange_order').on('change',function() {
            var currency  = $('#currency').val();
            if(currency == ''){
                alert('اختر عملة الشراء');
                $('#price_exchange_order').val('');
            }

           var price_exchange = $('#price_exchange_order').val();
           var totalprice = $('#total-price').val();
           var totalpricedollars = parseFloat(totalprice / price_exchange);
        //    $('#total_price_dollars').val(totalpricedollars);
        //    $('#totalpricedollars').text(totalpricedollars);
           $('#price_purchase').text(totalpricedollars);
        });





        setInterval(function() {
            var total = 0;
            // مجموع السعر في نفس عملة الشراء
            var totalInCurrency = 0;
            $('#totalpricedollars').text(0);
            $('#total_price_dollars').val(0);
            for(var i=1; i<= countClass;i++){
               var subtotal = $('.subtotal_'+i).val();
               console.log("subtotal" + subtotal);
               if(subtotal == undefined){
                subtotal = 0;
               }
               totalInCurrency += parseFloat(subtotal);
               console.log("totalInCurrency" + totalInCurrency);
               var  price_exchange = $('#price_exchange_'+i).val();
               // السعر حسب عملة الشراء
               var price_total = $('#total-price').val();
               if(subtotal != ' '){
                    if(totalInCurrency < price_total || totalInCurrency == price_total){
                        total +=  parseFloat(subtotal / price_exchange);
                        $('#totalpricedollars').text(total);
                        $('#total_price_dollars').val(total);
                    }

                    if(totalInCurrency > price_total){
                        var min = totalInCurrency - price_total;
                        subtotal = subtotal - min;
                        total +=  parseFloat(subtotal / price_exchange);
                        $('#totalpricedollars').text(total);
                        $('#total_price_dollars').val(total);
                        return false;
                    }

                }
            }


            //

            var cost = 0;
        	var priceAndCost = 0;
            $('#priceandcost').text(0);
            $('#total_price_cost').val(0);
         
        	if($('#total-price').val() != 0){
            var totalPrice =  $('#total-price').val() / $('#price_exchange_order').val();
            for(var i=1; i<= countCost;i++){
                if($('#cost_'+i).val() != '' && $('#price_exchange_cost_'+i).val() != ''){
                    cost += $('#cost_'+i).val() / $('#price_exchange_cost_'+i).val();
                }
            }
            priceAndCost = totalPrice + cost;
            priceAndCost = parseFloat(priceAndCost * $('#price_exchange_order').val()).toFixed(2);
        
            $('#priceandcost').text(priceAndCost);   //total_price_cost
            $('#total_price_cost').val(priceAndCost);
            }
        }, 1000);


    });





    // حذف الصف بعد الضغط على الزر
    function remove_sub_row(id){
        $('.remove_sub_row_'+id).remove();
        $('#example').DataTable().row('.remove_sub_row_'+id).remove().draw(true);
    }


    var countCost = 1;
    function create_cost(){
        countCost += 1;
        $('.cost').append(`<div class="form-row row mt-4 mb-4 mt-4 remove_cost_${countCost} " id='${countCost}'>
                <div  class="col-lg-1 col-md-2">
                    <button type="button" class="btn remove-class"  onclick="remove_cost(${countCost})" id="btn-cost-${countCost}" style="margin-top:35px;margin-right:13px">  <i class="fa fa-minus"></i></button>
                </div>


                <div class="col-lg-2 col-md-2">
                    <label class="mr-sm-2 " for="cost_${countCost}">تكلفة اضافية  </label>
                    <input type="text" name="cost[${countCost}]" class="coost form-control" id="cost_${countCost}" autocomplete="off">
                </div>

                <div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="currency_${countCost}">عملة الشراء  </label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="currency_cost[${countCost}]" id="currency_${countCost}"  >
                        <option value = '' name= ''> اختر اسم</option>
                        <?php foreach ($currency as $key => $name) {   ?>
                            <option    value="<?php  echo $name['id']?>" name='<?php  echo $name['name']?>'><?php  echo $name['name']?></option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-2  ml-4">
                    <label class="mr-sm-2" for="price_exchange_cost_${countCost}"> سعر التصريف  بالدولار   </label>
                    <input type="text" name="price_exchange_cost[${countCost}]" value="1" class="form-control" id="price_exchange_cost_${countCost}" autocomplete="off" >
                </div>

                <div class="col-lg-2 col-md-2  ml-4">
                    <label class="mr-sm-2" for="note_cost_${countCost}"> ملاحظة  </label>
                    <textarea  name="note_cost[${countCost}]" class="form-control" id="note_cost_${countCost}" cols="60" style="width:240px"></textarea>
                </div>
            </div>`
        );

        // $('#cost_'${countCost}).addClass('coost');
    }

    function remove_cost(id) {
        $('.remove_cost_'+id).remove();
    }

    // add function create_payment
    var countClass = 1;
    function create_payment(){
        countClass += 1;
        $('.payment').append(`
            <div class="part form-row row mb-4 remove_class_${countClass} " id='${countClass}'">
                <div class="col-lg-1 col-md-2" >
                    <button type="button" class="btn btn-sm remove-class"  onclick="remove_class(${countClass})" id="btn-payment-${countClass}" style="margin-top:35px;margin-right:13px">  <i class="fa fa-minus"></i></button>
                </div>

                <div class="col-lg-2 col-md-2">
                    <label class="mr-sm-2 " for="name_pay_${countClass}">اسم الحساب الذي تم الدفع منه</label>
                    <select class="name_pay form-control dropdown_filter" data-live-search="true" name="name_pay[${countClass}]" id="name_pay_${countClass}">
                        <option value = ""> اختر اسم</option>
                        <?php foreach ($accountSupplier as $key => $name) {?>
                            <option name="<?php  echo $name['type'] ?>"  value="<?php echo $name['id'] ?>">
                                <?php  if($name['type'] == 'supplier'){
                                    echo $name['name']. ' ' .'(مورد)';
                                }else{
                                    echo $name['name'];
                                } ?>

                            </option>
                        <?php  } ?>
                    </select>
                </div>

                <div>
                    <label for="subtotal_${countClass}" class='mr-sm-2' id='text_total' name='subtotal'>  المبلغ المدفوع:</label>
                    <input type="input" name="subtotal[${countClass}]"  class="form-control subtotal_${countClass}" id="subtotal_${countClass}"  autocomplete="off">
                    <p id='sub_total_${countClass}'></p>
                </div>

                <div class="col-lg-2 col-md-2 ml-4">
                    <label class="mr-sm-2" for="price_exchange_${countClass}"> سعر التصريف  بالدولار </label>
                    <input type="text" name="price_exchange[${countClass}]" value="1" class="form-control" id="price_exchange_${countClass}" autocomplete="off">
                </div>

                <div class="col-lg-2 col-md-2  ml-4">
                        <label class="mr-sm-2" for="note_payment_${countClass}"> ملاحظة      </label>
                        <textarea  name="note_payment[${countClass}]" class="form-control" id="note_payment_${countClass}" cols="60" style="width:240px"></textarea>
                    </div>
            </div>`
        );

        $('#name_pay_'+countClass).selectpicker();
        var currency  = $('#currency').find('option:selected').attr("name");
        console.log(currency);
        if(currency == 'دولار'){
            $("#price_exchange_"+countClass).attr("readonly", true);
        }
        else{
            $("#price_exchange_"+countClass).attr("readonly", false);
        }

    }

    function remove_class(id) {
        $('.remove_class_'+id).remove();
    }







</script>

<style>

    body{
        background-color: #f8f9fa !important;
    }
    .breadcrumb{
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background-color: rgba(121,169,197,.92) !important;
        -webkit-box-shadow: 0px -4px 3px #ccc;
        -moz-box-shadow: 0px -4px 3px #ccc;
        box-shadow: 0px -4px 10px #ccc;
    }
    .breadcrumb li {
        color: #fff !important;
    }
    .content{
        width: 100%;
        margin-right: 0 auto;
    }
    .addReminder{
        overflow: hidden;
        transition: 0.5s;
        color: #ffb600;
        background: #fff;
        position: fixed;
        top: 122px;
        left: 26px;
        padding: 0;
        font-size: 22px;
        width: 37px;
        height: 37px;
        border-radius: 50%;
        z-index: 10;
        -webkit-box-shadow: 0px 0px 10px #696969;
        -moz-box-shadow:0px 0px 10px #696969;
        box-shadow: 0px 0px 10px #696969;
    }

    .addWth{
        width: 304px;
        height: 40px;
        border-radius: 0;
    }
    @media (max-width: 360px) {
        .addWth{
            overflow: auto;
            font-size: 10px;
            width: 260px;
            border-radius:0;
        }
    }
    .content .part_1 , .content .part_2, .content .part_3{
        width: 100%;
        padding: 16px 10px;
        background-color: #fff !important;
        margin-bottom: 30px;
        box-shadow: 0px 0px 10px #ccc;
    }

    .content .part_4{
        width: 30%;
        float: left;
        padding: 16px 10px;
        border : 1px solid #007bff;
        background-color: #fff !important;
        margin-bottom: 30px;
        margin-left: 10px;
        box-shadow: 0px 0px 10px #ccc;
    }
    .user{
        color: #007bff;
    }
    .d-table{
        width:100%;
        margin-top:30px !important;
        border: 1px solid #c4c2c2;
        border-radius: 5px;

    }
    table thead tr{
        text-align: center;
        white-space: nowrap;
        background-color: rgba(121,169,197,0.92) !important;
        color: #fff;
        font-size:14px;
    }
    table tbody tr td{
        /* text-align: center; */
        /* white-space: nowrap; */
        height : 50px !important;
        font-size:14px;
    }
    table tbody  tr:nth-child(odd) {
        background-color: #f8f9fa !important;
    }
    table tbody  tr:nth-child(even) {
        background-color: #f3f8fa;
    }
    input, .custom-select
    {
        border-radius: 6px;
    }
    .add_new_sub_row{
        color: green;
    }
    .remove_sub_row{
       color: red;
    }
    .content .part_1 .edit{
        text-align: center !important;
        position: relative;
        margin: 0 auto !important;
    }
    .content .part_3 .text_total{
        font-size: 16px;
        font-weight: bold;
        /* padding-top: 10px;
        white-space: nowrap; */
        color: red;

    }
    .content .part_3 .text_total .price{
        color: #000;
        font-size: 16px;
    }
    .remove-class{
        color : red;
    }

    .add-class{
        color : green;
    }
    #save_bill{
        text-align: center;
        justify-self: center;
        margin: 10px auto;
        color: #fff;
        border-radius: 6px;
        padding: 5px 10px;
    }
    /* input{
        border-radius: 6px;
        padding: 5px;
        font-size: 12px !important;
    } */

</style>

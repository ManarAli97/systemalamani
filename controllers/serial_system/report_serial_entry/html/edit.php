
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_report_serial_entry"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > تعديل </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الصفحة</span>  <?php echo $id ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<?php if ($this->permit('repet_serial',$this->folder)) {  ?>
    <div class="row">

        <div class="col-auto">
            <input <?php  if ( $this->setting->get('repet') == 2) echo 'checked' ?>   class='toggle-demo' onchange='switch_hide(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle'   data-onstyle='success' data-size='small'>  تكرار السيريال

        </div>
    </div>
<?php } ?>

<script>

    function switch_hide(e) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/serial_system/repet/"+vis, function(data){

        })
    }


</script>


    <div class="row">
        <div class="col">

            <form id="save_serial" action="<?php echo url.'/'.$this->folder ?>/from_edit/<?php  echo $id ?>" method="post" enctype="multipart/form-data">

                <br>

                <div class="row  align-items-center ">
                    <div class="col-1 mb-4">
                        <label> رقم الفاتورة  </label>
                        <input type="text"    autofocus name="bill" id="bill" class="form-control" required>
                    </div>
                    <div class="col-auto mb-4">
                        <label> الموقع  </label>
                        <input type="text"     name="location" id="location" class="form-control"  >
                    </div>
                    <div class="col-auto mb-4">
                        <label> رمز المادة  </label>
                        <input type="text"   oninput="$('#code').val(this.value);info_code()"    id="code_search" class="form-control" required>
                        <input  type="hidden"   name="code" id="code"   >
                        <input  type="hidden"   name="spare_code" id="spare_code"   >

                    </div>
                    <div class="col-auto mb-4">
                        <label> سيريال  </label>
                        <input type="text"   autocomplete="off" onkeyup="setTimeStamp(this)"  autofocus name="serial" id="serial" class="form-control" required>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit" name="submite">حفظ</button>
                        <a href="<?php echo  url.'/'.$this->folder ?>/list_report_serial_entry"  class="btn btn-warning">رجوع</a>
                    </div>
                </div>

                <hr>
                <div class="over_q" style="display: none">
                    <div class="alert alert-danger" role="alert">
                        السيريلات المدخلة اكبر من الكمية الموجودة
                    </div>
                </div>
                <div class="result"></div>

            </form>
        </div>
    </div>
<div class="modal fade bd-example-modal-lg" id="exampleModalSmartSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> بحث عن المادة </h5>

            </div>
            <div class="modal-body">



                <form action="#" method="post" id="smart_search" >
                    <div class="row align-items-end mt-3 mb-3">


                        <div class="col-12 mb-3">
                            <label>الباركود البديل</label>
                            <input type="text" class="form-control spare_code" readonly>
                        </div>
                        <div class="col-6 mb-3">
                            <label> اختر القسم  </label>

                            <select    id="fullsearch" class="custom-select mr-sm-2"  onchange="resetSelect()"   required >

                                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                                    <option  value="<?php  echo  $key ?>"    value="<?php echo $key ?>"><?php  echo $c ?></option>
                                <?php }  ?>

                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label>بحث</label>
                            <input   id="id_item"  name="id_item" type="hidden"   ">
                            <input  onkeyup="smartSearch(this)"   class="form-control empty_search_text"   type="text" required placeholder="اسم المادة - رمز المادة - باركود بديل ">
                            <div class="search_data"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label>اللون</label>

                            <select id="color"     onchange="get_details_code(this)"  style="padding-bottom: 0" class="form-control"  required ></select>
                        </div>
                        <div class="col-6 mb-3">
                            <label  data-placement="top" title="في حال قسم الاكسسوارات والحافظات يظهر الباركود لانها لا تحتوي على ذاكرة" >الذاكرة</label>

                            <select id="code_details"   class="form-control"     data-toggle="tooltip" data-placement="top"  required title="في حال قسم الاكسسوارات والحافظات يظهر الباركود لانها لا تحتوي على ذاكرة"   ></select>
                        </div>

                        <div class="col-12 text-left">
                            <hr>
                            <button type="submit"  class="btn btn-warning">موافق</button>
                            <button type="button" class="btn btn-danger" onclick="resetSelect()" data-dismiss="modal">خروج</button>

                        </div>

                    </div>
                </form>



            </div>

        </div>
    </div>
</div>


<script>


    function resetSelect() {
        $('.empty_search_text').val('');
        $('.code').val('');
        $('#color').empty();
        $('#code_details').empty();
        $('.over_q').hide();
        $('#serial').removeClass('border_red');
    }




    var date_now=0;
    var con=0;
    var flagProcessing=0;
    function setTimeStamp(e) {

        if ($(e).val()) {
            if (con == 0) {
                var dt = new Date();
                date_now = dt.getSeconds();
                console.log(date_now);
                con = 1;
            }
        }

    }




    function delete_serial(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url .'/'.$this->folder ?>/delete_serial/"+id, function (data ) {

                if (data==='true')
                {
                    table.draw()
                }else
                {
                    alert('لا يمكن حذف السيريال تم بيعة')
                }

            })
        } return false;


    }




    function info_code()
    {


        var  val=$("#code").val()

        if (val)
        {

            $.get("<?php  echo url .'/'.$this->folder ?>/info_code", {
                code:  val,
            }, function (data ) {

                $('.result').html(data)
            })
        }else
        {

            $("#spare_code").val('')
        }
        $('#serial').removeClass('border_red');
        $('.over_q').hide();
    }


    $("#save_serial").submit(function(e) {


        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var actionUrl = form.attr('action');

        $.get("<?php  echo url .'/'.$this->folder ?>/insert_data", {
            date_now: date_now,
        }, function (data_type) {
            date_now=0;
            con=0;

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize()+"&submit=submit&type_enter="+data_type, // serializes the form's elements.
                success: function(data)
                {
                    console.log(data)
                    if (data==='true')
                    {
                        info_code()
                        $("#spare_code").val('')
                        $('#serial').val('')
                        $('#code').val('')
                        $('#code_search').val('').select()
                        table.draw()
                    }
                    else if (data==='no_duplication')
                    {
                        alert('السيريال مدخل سابقا لا يمكن تكرارة لمادة اخرى')
                        $('#serial').select()
                    }else if (data==='locationNotFound')
                    {
                        alert('الموقع ليس ضمن مواقع القسم')
                    }
                    else if (data==='over')
                    {
                        $('#serial').select()
                        $('#serial').addClass('border_red');
                        $('.over_q').show();
                    }
                    else {
                        alert('رمز المادة غير موجود')

                        $('.spare_code').val( $('#code_search').val());

                        resetSelect()
                        $('#exampleModalSmartSearch').modal('show')

                    }

                }
            });

        });


    });



    $("#smart_search").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('#exampleModalSmartSearch').modal('hide')
        $('#code').val($('#code_details').val());
        $('#spare_code').val($('.spare_code').val());

        info_code()
    });


    function smartSearch(e) {

        var val = $(e).val();

        if (val) {

            var cat =  $('#fullsearch').val();

            if (cat) {

                $.get("<?php  echo url . '/' . $this->folder ?>/smartsearch", {
                    val: val,cat:cat,
                }, function (data) {
                    if (data) {
                        $(".search_data").html(data).show();
                    } else {
                        $(".search_data").empty().hide();
                    }
                    codeDetails(cat,val);
                });
            }else
            {
                alert('اختر القسم')
            }
        }else
        {
            $("#id_item").val('');
            $(".search_data" ).empty().hide();
        }

    }

    function codeDetails(model,code) {


        $.get("<?php  echo url . '/' . $this->folder ?>/codeDetails/"+model+"/"+code, function (data) {
            if (data) {
                $(".search_data" ).empty().hide();
                var resp=JSON.parse(data)

                $('#color').html(`<option value="${resp.code}">${resp.color}</option>`);
                $('#code_details').html(`<option value="${resp.code}">${resp.size}</option>`);

            }

        });

    }


    function getDetails_device(e) {

        $("#id_item").val($(e).val());
        $( ".search_data" ).empty().hide();
        $( ".empty_search_text" ).val($(e).text());

        var cat =  $('#fullsearch').val();

        $.get("<?php  echo url . '/' . $this->folder ?>/get_color", {
            id_item: $("#id_item").val(),cat:cat,
        }, function (data) {
            if (data) {
                $('#color').html(data);
            }
        });

    }


    function get_details_code(e) {


        var cat =  $('#fullsearch').val();
        $.get("<?php  echo url . '/' . $this->folder ?>/get_code_details", {
            id_color: $(e).val(),cat:cat,
        }, function (data) {
            if (data) {

                $('#code_details').html(data);
            }

        });

    }







    var table;
    $(document).ready(function() {


        table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_details_page/<?php  echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 6, 'desc'] ],
            aLengthMenu: [ -1,10,25, 50, 100,],
            orderCellsTop: true,
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
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
<br>



<table  id="example" class="table table-striped display d-table"  >
    <thead>
    <tr>
        <th> رقم الفاتورة </th>
        <th>  رمز المادة  </th>
        <th>   سيريال </th>
        <th>    الموقع </th>
        <th>    نوع الادخال </th>
        <th> المستخدم </th>
        <th>تاريخ والوقت </th>
        <th>   حذف   </th>

    </tr>
    </thead>

</table>



<style>
    .border_red{
        background: red;
        border: 1px solid red;
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
        width:100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }
    .class_delete_row
    {
        background: transparent;
        border-radius: 50%;
        padding: 0;
        width: 35px;
        height: 35px;
        font-size: 28px;
        margin: 0;
    }

</style>





<style>

        .code_m
        {
            margin-top: 15px;
        }
        button.btn.add_new_sub_row {
            padding: 0;
            background: transparent;
            color: #218838;
            font-size: 25px;
        }
        button.btn.remove_sub_row {
            padding: 0;
            background: transparent;
            color: red;
            font-size: 25px;
        }

        .remove_div
        {


            padding: 0;

            background: #f5f6f7;
            border: 0;
        }

        .remove_div i
        {
            color: red;
            font-size: 28px;
        }
        .addPs
        {
            color: #FFFFFF !important;
        }
        .x_down
        {
            position: relative;
            margin-bottom: 25px;
            border: 1px solid #eeeff0;
            border-bottom: 1px solid #d5d7d8;
            padding-bottom: 22px;
            background: #eeeff08a;
        }
 
 
    .search_name,.search_phone,.search_qr,.search_data
    {
        position: absolute;
        width: 100%;
        top: 70px;
        padding-left: 46px;
        z-index: 100000;
    }

    .not_found_faq {
        background: #fff;
        border: 1px solid #d1bb96;
        padding: 7px 5px;
        z-index: 10000;
    }

    .content_search {
        border: 1px solid #d1bb96;
    }
    button.btn.row_search {
        display: block;
        background: white;
        width: 100%;
        border-radius: 0;
        border-bottom: 1px solid #d1bb96;
        text-align: right;
    }

    button.btn.row_search:hover {
        background: #14a0ad;
        color: #ffffff;
    }


    button.btn.row_search:last-child {

        border-bottom: 0;
    }



</style>




<br>
    <br>



    <br>
    <br>
    <br>
    <br>


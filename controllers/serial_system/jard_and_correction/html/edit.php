
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_jard_and_correction"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_jard_and_correction"><?php  echo $this->langControl('jard_and_correction') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  تعديل </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الجرد</span>  <?php echo $id ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>




    <div class="row">
        <div class="col">

            <form id="save_serial" action="<?php echo url.'/'.$this->folder ?>/from_edit_jard_and_correction/<?php  echo $id ?>" method="post" enctype="multipart/form-data">

                <br>

                    <div class="row  align-items-end">

                            <div class="col-auto ">
                                <label> الموقع  </label>
                                <input type="text"   autocomplete="off"   autofocus name="location" id="location" class="form-control" required>
                            </div>

                        <div class="col-auto  ">
                            <label> سيريال  </label>
                            <input type="text"   autocomplete="off" onkeyup="setTimeStamp(this)" oninput="info_serial()" autofocus name="serial" id="serial" class="form-control" required>
                        </div>


                        <div class="col-auto  ">
                            <div class="duplication_code"></div>
                        </div>


                        <div class="col-auto">
                        <button class="btn btn-primary" type="submit" name="submite">حفظ</button>
                        <a href="<?php echo  url.'/'.$this->folder ?>/list_jard_and_correction"  class="btn btn-warning    ">رجوع</a>

                    </div>
                </div>

                <hr>

                <div class="result"></div>

            </form>
        </div>
    </div>

    <script>

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

        var serialEnter='';

        function info_serial(serial=null)
        {

            if (serial)
            {
                serialEnter=serial;
            }else
            {
                serialEnter=$("#serial").val();
            }

            $.get("<?php  echo url .'/'.$this->folder ?>/info_serial", {
                serial: serialEnter ,
            }, function (data ) {

                $('.result').html(data)

               })
            duplication_code(serialEnter)

        }

        function duplication_code(serial) {


            $.get("<?php  echo url .'/'.$this->folder ?>/duplication_code", {
                serial:  serial,
            }, function (data ) {

                if (data)
                {
                    $('.duplication_code').html(data)
                }else
                {
                    $('.duplication_code').empty();
                }


            })


        }

        function get_serial_jard_and_correction_details(code,model,page) {

            $.get("<?php  echo url.'/'.$this->folder?>/get_serial_jard_and_correction_details/"+code+'/'+model+'/'+page, function(data){
                if (data)
                {
                    $('#data_collapse_'+code+model).html(data)
                }
            })
        }

        function get_all_location_jard_and_correction_details(code,model) {

            $.get("<?php  echo url.'/'.$this->folder?>/list_location/"+code+'/'+model, function(data){
                if (data)
                {
                    $('#location_data_collapse_'+code+model).html(data)
                }
            })
        }

        $("#save_serial").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');

                    $.get("<?php  echo url .'/'.$this->folder ?>/insert_data/1", {
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

                                    $('#serial').val('').select()
                                    info_serial(serialEnter);
                                    table.draw()

                                 }else if(data==='enterSerial') {
                                    alert('تم جرد السيريال سابقا')
                                 }

                                else  if (data==='locationNotFound')
                                {

                                    alert('الموقع ليس ضمن مواقع القسم')

                                }

                                else  if (data==='equal_quantity')
                                {

                                    alert('الكمية متساوية بين السيريلات المدخلة وكمية المواقع')

                                }

                                else  if (data==='no_quantity_out')
                                {

                                    alert('لا توجد كمية غير موزعة على المواقع')

                                }

                                else  if (data==='er_location')
                                {

                                    alert('الموقع غير موجود ضمن مواقع القسم')

                                }
                                else  if (data==='over_time')
                                {

                                    alert('لا يمكن تعديل الصفحة بعد 24 ساعة يرجى فتح صفحة جديدة')

                                }

                                else {
                                   alert('السريال غير مدخل للنظام')
                                }

                            }
                        });

                    });


        });


        var table;
        $(document).ready(function() {


              table= $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'.$this->folder ?>/processing_details_pagejard_and_correction/<?php  echo $id ?>",
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },

                "order": [[ 3, 'asc'] ],
                aLengthMenu: [ 10,25, 50, 100,-1],
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
        <th> رقم  الجرد </th>
        <th>  رمز المادة  </th>

        <th> الكمية المضروبة   </th>
        <th>    كمية المواقع  </th>
        <th>   الكمية الكلية </th>
        <th>    نوع الادخال </th>
        <th> المستخدم </th>
        <th>تاريخ والوقت </th>




    </tr>
    </thead>

</table>



<style>

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



    .table_location
    {
        background: #ffffFF;
        width: max-content;
    }
    .table_location tr td
    {
        padding: 0;
        background: #ffffFF;
        border: 1px solid #d4d1d1;
    }


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



</style>



    <br>
    <br>



    <br>
    <br>
    <br>
    <br>


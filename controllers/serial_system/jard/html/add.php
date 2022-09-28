
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_jard"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  صفحة جديدة </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الصفحة</span>  <?php echo $id ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



<?php if ($this->permit('required_location_jard',$this->folder)) {  ?>
    <div class="row">

        <div class="col-auto">
            <input <?php  if ( $this->setting->get('required_location_jard') == 1) echo 'checked' ?>   class='toggle-demo' onchange='switch_hide(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle'   data-onstyle='success' data-size='small'>   تفعيل / الغاء تفعيل الموقع

        </div>
    </div>
    <hr>
<?php } ?>

<script>

    function switch_hide(e) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/' .$this->folder?>/required_location_jard/"+vis, function(data){
            window.location=''
        })
    }


</script>

    <div class="row">
        <div class="col">

            <form id="save_serial" action="<?php echo url.'/'.$this->folder ?>/from_add_jard/<?php  echo $id ?>" method="post" enctype="multipart/form-data">

                <br>

                <div class="row  align-items-end">
                  <?php  if ( $this->setting->get('required_location_jard') == 1) { ?>
                    <div class="col-auto ">
                        <label> الموقع  </label>
                        <input type="text"   autocomplete="off"   autofocus name="location" id="location" class="form-control" required>
                    </div>
                 <?php  } ?>
                    <div class="col-auto  ">
                        <label> سيريال  </label>
                        <input type="text"   autocomplete="off" onkeyup="setTimeStamp(this)" oninput="info_serial(this)" autofocus name="serial" id="serial" class="form-control" required>
                    </div>
                    <div class="col-auto  ">
                        <div class="duplication_code"></div>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit" name="submite">حفظ</button>
                        <a href="<?php echo  url.'/'.$this->folder ?>/list_jard"  class="btn btn-warning">رجوع</a>
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

        function info_serial(e)
        {

            $.get("<?php  echo url .'/'.$this->folder ?>/info_serial", {
                serial:  $(e).val(),
            }, function (data ) {

                if (data)
                {
                    $('.result').html(data)
                    listCode()
                }



               });

            duplication_code($(e).val());

          }


          function listCode() {
              $('.listCode').remove()


              $.get("<?php  echo url .'/'.$this->folder ?>/code_not_jrad", {
                  id_catg:  $('#getid_catg').val(),  model:  $('#getModel').val(),  id_page: <?php echo $id ?>,
              }, function (data ) {
                  if (data)
                  {
                      $('.dataTables_empty').hide();
                      $('table#example tbody').after(data);
                  }

              });
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

        function get_all_location_jard_details(code,model) {

            $.get("<?php  echo url.'/'.$this->folder?>/get_all_location_jard_details/"+code+'/'+model, function(data){
                if (data)
                {
                    $('#location_data_collapse_'+code+model).html(data)
                }
            })
        }
        function get_serial_jard_details(code,model,page) {

            $.get("<?php  echo url.'/'.$this->folder?>/get_serial_jard_details/"+code+'/'+model+'/'+page, function(data){
                if (data)
                {
                    $('#data_collapse_'+code+model).html(data)
                }
            })
        }
        function get_serial(code,model) {

            $.get("<?php  echo url.'/'.$this->folder?>/get_serialWithOutDelete/"+code+'/'+model, function(data){
                if (data)
                {
                    $('#data_collapse_Serial'+code+model).html(data)
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
                                if (data==='true')
                                {

                                    $('#serial').val('').select()

                                    table.draw()
                                    listCode()
                                }else if(data==='locationNotFound') {
                                   alert('الموقع ليس ضمن مواقع القسم')

                                }else if(data==='enterSerial') {
                                   alert('تم جرد السيريال سابقا')
                                }else {
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
                "ajax": "<?php echo url .'/'.$this->folder ?>/processing_details_pagejard/<?php  echo $id ?>",
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },

                  "order": [[ 10, 'desc'] ],
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
        <th> القسم  </th>
        <th> الفئة  </th>
        <th>اسم المادة</th>
        <th>  رمز المادة  </th>
        <th> كمية الواقع (السيريلات المجرودة)  </th>
        <th>    الكمية الحالية  </th>
        <th>   السيريلات المدخلة </th>
        <th>    نوع الادخال </th>
        <th> المستخدم </th>
        <th>تاريخ والوقت </th>




    </tr>
    </thead>

</table>



<style>
    .list_serial {
        border-bottom: 1px solid #dfdfdf;
        position: relative;
    }
    .list_serial:last-child {
        border-bottom: 0;
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
    </style>



    <br>
    <br>



    <br>
    <br>
    <br>
    <br>


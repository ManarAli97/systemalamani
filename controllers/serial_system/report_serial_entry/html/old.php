
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  ادخال الفواتير </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
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

            <form id="save_serial" action="<?php echo url.'/'.$this->folder ?>/from_add" method="post" enctype="multipart/form-data">

                <br>

                <div class="row align-items-end">
                    <div class="col-auto mb-4">
                        <label>رقم الفاتوره</label>
                        <input type="text" name="bill" class="form-control" required>
                        <input type="hidden"  id="time_taken_id" name="time_taken" value="1"     >
                    </div>
                    <div class="col-auto mb-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input checked type="radio" value="1" id="new_page" name="new_page" class="custom-control-input">
                            <label class="custom-control-label" for="new_page">صفحة جديدة</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input  disabled value="2" type="radio" id="current_page" name="new_page" class="custom-control-input">
                            <label class="custom-control-label" for="current_page">صفحة الحالية</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">

                                <th scope="col">رمز المادة</th>
                                <th scope="col">     <button   class="btn btn-success addPs" id="clickme">  <span>سيريال</span> <i class="fa fa-plus-circle"></i> </button>  </th>
                                <th scope="col">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="blockPs">

                                <td> <input   name="code" type="text"  class="form-control cccc" id="validationServer01"  value=""  required/></td>
                                <td>
                                    <input   name="serial[]"   onkeyup="setTimeStamp(this)"    onblur="time_taken_fn()"   type="text"  class="form-control ssss" id="validationServer01"  value=""  required/>
                                    <input   name="type_enter[]"         type="hidden"  class="form-control " id="type_enter_0"      />
                                </td>

                                <td>  </td>
                            </tr>

                            </tbody>
                        </table>


                    </div>
                </div>

                <hr>
                <div class="container">
                    <div class="row justify-content-md-center ">
                        <div class="col-12">
                            <div class="result_enter"></div>
                        </div>
                        <div class="col-md-auto">
                            <input class="btn btn-primary "  id="save_serial" onclick="rr()" type="submit" name="submit" value="<?php echo $this->langControl('save')?>" >

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
     var myTimer;
        function time_taken_fn() {
            var t = 1 ;
            if ($('#time_taken_id').val() === '1')
            {
                myTimer = setInterval(function () {
                    $('#time_taken_id').val(t++)
                },1000)
            }else
            {
                clearInterval(myTimer);
                $('#time_taken_id').val('1')

            }

        }


        var date_now=0;
        var con=0;
        var flagProcessing=0;
        function setTimeStamp(e) {

            flagProcessing=0;
            if (con == 0) {
                var dt = new Date();
                date_now = dt.getSeconds();
                console.log(date_now);
                con = 1;
            }
        }


        var upxcol;
        count = 0;
        $('.addPs').click(function() {
            if ($('.ssss:last').val()  &&  $('.cccc:last').val() ) {

                count += 1;
                upxcol = 'new' + count;
                id_div = 'id_r_' + count;
                sub_add = 'sub_add_' + count;

                setTimeout(function () {
                    if (flagProcessing==0) {
                        $.get("<?php  echo url .'/'.$this->folder ?>/insert_data", {
                            date_now: date_now,
                        }, function (data) {
                             var te=count-1;
                            $('#type_enter_'+te).val(data)
                            console.log(data)
                            flagProcessing=0 ;
                        });
                    }else
                    {
                        flagProcessing=0 ;
                    }

                    date_now=0;
                    con=0;
                },3);




                $('.blockPs:last').after(`
                  <tr class="blockPs all_row"   id="${id_div}" >
                        <td style="border-bottom:1px solid #fff"> </td>
                            <td>
                               <input   name="serial[]" type="text"  onkeyup="setTimeStamp(this)"   class="form-control ssss" id="validationServer01"  value=""  required/>
                               <input   name="type_enter[]"         type="hidden"  class="form-control " id="type_enter_${count}"      />
                           </td>

                        <td>  <button  type="button"  class="btn remove_div"  onclick="remove_div(${id_div})"> <i class="fa  fa-times-circle"></i> </button> </td>
                    </tr>
               `);

            }
        });

        function remove_div(id) {
            $(id).remove();
        }




        function rr()
        {


            var sum = 0;
            $('.ssss').each(function(){
                sum ++;
            });

            if (sum > 1)
            {
                $('.ssss:last').removeAttr('required');
            }

        }

        $("#save_serial").submit(function(e) {

            $('#save_serial').attr('disabled','disabled');

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize()+"&submit=submit", // serializes the form's elements.
                success: function(data)
                {

                    if (data==='true')
                    {

                        clearInterval(myTimer);
                        $('#time_taken_id').val('1')

                        $('#current_page').removeAttr('disabled');
                        $('.all_row').remove();
                        $('.ssss').val('');
                        $('.cccc').val('').select();
                        $('.result_enter').html(`
                        <div class="alert alert-success" role="alert">
                          تم الحفظ
                        </div>
                        `);
                        setTimeout(function () {
                            $('.result_enter').empty();
                        },1000)
                    }else if(data === 'not_code_found') {
                        alert('رمز المادة غير مرفوع للنظام')
                    }

                    else{
                        $('#save_serial').removeAttr('disabled');
                        alert('حدثت مشكلة اعد المحاولة')

                    }

                }
            });

        });




    </script>



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


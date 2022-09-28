 <br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">


                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('check_code') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



<small>ملاحظة// يمكن البحث اما برمز المادة او السيريال</small>
 <br>
 <br>
<form id="myform" action="<?php  echo url ?>/report/report_withdrawn_ajax" method="post">
    <div class="form-row   align-items-end">


        <div class="col-auto">
            <label>   القسم</label>
            <select name="cat" class="custom-select mr-sm-2" id="cat_site"  onchange="settingCat()" required>
                <option   selected    >  اختر القسم  </option>
                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                    <option value="<?php echo $key ?>"><?php  echo $c ?></option>
                <?php }  ?>
            </select>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-5">
            <label>رمز المادة</label>
            <input type="text" name="code"   oninput="info_code(this)" onkeyup="info_code(this)"   autocomplete="off" class="form-control" id="code" placeholder="الكود" required>
        </div>

        <div class="col-lg-3 ">
            <label> <span>السيريال </span>   <span id="not_found_serial" style="color: red"></span></label>
            <input type="text" name="serial"  autocomplete="off" oninput="info_serial(this)" onkeyup="info_serial(this)" id="serial"  class="form-control"  placeholder="سيريال"  >
        </div>


        <div class="col-auto">
            <div class="add_color"></div>
        </div>


        <div class="col-auto">
            <button onclick="codeData()"  style="    margin: 0 !important;" type="button" class="btn btn-primary mb-2">بحث</button>
        </div>
    </div>

    <hr>
        <div class="report_withdrawn">

            <div class="row align-items-end">

                <div class="col-auto location_menu">
                </div>
                <div class="col-lg-2  mt-2">
                    <input type="number" name="quantity" min="0" id="quantity"  class="form-control"  autocomplete="off" placeholder="الكمية"        required>
                </div>


                <div class="col-lg-3  mt-2">
                    <textarea type="text" rows="1"  name="note"   class="form-control"  placeholder="ملاحظة"  ></textarea>
                </div>


                <div class="col-auto   mt-2">
                    <input  name="submit"  style="margin: 0 !important;" value="سحب" type="submit" class="btn btn-warning mb-2">
                </div>
                <div class="col-auto mt-2">
                    <a href="<?php   echo url .'/'.$this->folder ?>/excel"  style="margin: 0 !important;color: #FFFFFF"   class="btn btn-primary">  سحب بستخدام اكسيل </a>
                </div>

            </div>
        </div>



<hr>

    <div class="msg_withdrow"></div>
<div class="data_get"></div>

</form>


<script>

    function info_code(e) {

        var val = $(e).val();
        check_serial_required(val)
    }


    function info_serial(e)
    {

        var val= $(e).val();

        $.get("<?php  echo url .'/'.$this->folder ?>/info_serial", {
            serial: val,
        }, function (data ) {
            if (data)
            {
                var response= JSON.parse(data)

                check_serial_required(response.code)
               $('#code').val(response.code)
               $('#not_found_serial').empty();
               $('#cat_site option[value="'+response.model+'"]').attr('selected',true);
           }else
           {
                $('#quantity').val('').removeAttr('readonly');

               $('#cat_site option').removeAttr('selected',true);
               $('#code').val('')
               if ($('#serial').val())
               {
                   $('#not_found_serial').text('السيريال غير موجود في النظام')
               }else
               {
                   $('#not_found_serial').empty();
               }

           }

       })
   }



   function check_serial_required(code) {


       $.get("<?php  echo url .'/'.$this->folder ?>/check_serial_required_withdraw", {
           code: code,
       }, function (data ) {
           if (data === 'true') {

               $('#quantity').val(1).attr('readonly','readonly')
               $('#serial').attr('required','required')

           }else
           {
               $('#quantity').val('').removeAttr('readonly');
               $('#serial').removeAttr('required')
           }
       })


   }



   function settingCat() {
       cat=$('#cat_site option:selected').val();
       //code=$('#code').val();
       // if (code) {
       //
       //     //if (cat === 'accessories') {
       //     //    $.get("<?php ////echo url . '/' . $this->folder ?>/////color_list/" + code + '/' + cat, function (data) {
       //      //
       //      //        $('.add_color').html(data);
       //      //    });
       //      //
       //      //} else {
       //      //    $('.add_color').empty();
       //      //}
       //  }else
       //  {
       //      $('#cat_site').prop('selectedIndex', 0);
       //      alert('يرجى كتابة كود المادة قبل اختيار القسم')
       //  }
        $('.location_menu').empty();
    }


    function codeData()
    {

        $(".msg_withdrow").empty();
         code=$("#code").val();
         cat=$('#cat_site option:selected').val();

         if (code) {

          if (cat === 'xxxxx')
           {
               color = $('#color_name_acc option:selected').val();
               if (color)
               {
                   $.ajax({
                       url: "<?php  echo url . '/' . $this->folder?>/get",
                       type: 'post',
                       data: {code: code, cat: cat, color: color},
                       success: function (data) {
                           locationCode(code,cat,color);
                           $('.data_get').html(data);

                       }
                   });
               }else
               {
                   alert('اختيار لون المادة')
               }

           }
             else {
               $('.add_color').empty();
               $.ajax({
                   url: "<?php  echo url . '/' . $this->folder?>/get",
                   type: 'post',
                   data: {code: code, cat: cat},
                   success: function (data) {

                       locationCode(code,cat);
                       $('.data_get').html(data);

                   }
               });
           }
       }else
       {
           alert('المادة غير موجودة')
       }
    }



    function locationCode(code,cat,color=null)
    {

        $.get("<?php echo url . '/' . $this->folder ?>/location_list", {code: code, cat: cat, color: color}, function (data) {

            if (data)
            {
                $('.location_menu').html(data);

            }else
            {
                $('.location_menu').empty();

            }
        });

    }



    $(function() {

        $("#myform").submit(function(e) {

            id_device=$('#id_device').val();
            if (id_device)
            {

                quantity=$('#quantity').val();
                can_get=$('#can_get').text();
                found_quantity=$('#found_quantity').text();
                name_color=$('#name_color').text();

                if (Number(quantity) <= Number(can_get) &&  (quantity) > 0) {


                    if (confirm('هل  انت متأكد من سحب الكمية : ' +quantity ))
                    {

                    e.preventDefault();
                    var actionurl = e.currentTarget.action;

                    $.ajax({
                        url: actionurl,
                        type: 'post',
                        data: $("#myform").serialize()+'&name_color='+name_color,
                        success: function (data) {

                            if (data === 'true')
                            {

                             $('#can_get').text(Number(can_get) - Number(quantity) );
                             $('#found_quantity').text(Number(found_quantity) - Number(quantity) );
                             $('.msg_withdrow').html(`
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                              تمت عملية السحب بنجاح
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                             `);
                            }else if (data==='-q')
                            {
                                alert(' الكمية غير كافية  ');
                            }else if (data==='-q2')
                            {
                                alert(' الكمية غير كافية  في الموقع المحدد ');
                            }else if (data==='notLocation')
                            {
                                alert(' الموقع غير موجود  ');
                            }else if (data==='selectLocation')
                            {
                                alert(' لم يتم تحديد موقع  ');
                            }else if (data==='not_number')
                            {
                                alert('الكمية يجب ان تكون رقم');
                            }
                        }
                    });

                  }return false


                }
                else
                {
                    alert(' الكمية غير كافية   ');
                    return false;
                }
            }else
            {
                alert("عملية البحث قبل عملية السحب");
                return false;
            }


        });

    });


</script>



 <style>

     .table_style1
     {
         border-radius: 5px;
     }

     .table_style1 thead
     {
         background: #009688;

     }
     .table_style1 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table1 {
         background: #009688;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }

     .table_style2
     {
         border-radius: 5px;
     }

     .table_style2 thead
     {
         background: #2196f3a1;

     }
     .table_style2 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table2 {
         background: #2196f3a1;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }
     .table_style3
     {
         border-radius: 5px;
     }

     .table_style3 thead
     {
         background: #607d8bad;

     }
     .table_style3 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table3 {
         background: #607d8bad;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }

 </style>




 <br>
<br>
<br>
<br>
<br>

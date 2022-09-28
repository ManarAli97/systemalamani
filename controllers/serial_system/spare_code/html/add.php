
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  الباركودات البديلة   </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl($model) ?>  </li>
             </ol>
        </nav>


        <hr>
    </div>
</div>


    <div class="row">
        <div class="col">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link    <?php  if (!$tab) echo 'active' ?>  " id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                        ادخال باركودات بديلة بستخدام رمز المادة
                    </button>
                    <button class="nav-link  <?php  if ($tab) echo 'active' ?> " id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                        بستخدام البحث
                    </button>
                 </div>
            </nav>
            <br>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade <?php  if (!$tab) echo 'show active' ?> " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form id="bycode" method="post" action="<?php  echo url .'/'.$this->folder ?>/code/<?php echo $model ?>">

                        <div class="row">
                            <div class="col-auto">
                                <input placeholder="رمز المادة" type="text" id="code" name="code" class="form-control" required autofocus autocomplete="off">
                            </div>
                            <div class="col-auto">
                                <input  placeholder="الباركود البديل"  type="text" id="spare_code" name="spare_code" class="form-control" required  autocomplete="off">
                            </div>
                            <div class="col-auto">
                                <button type="submit" id="spare_code" name="submit" class="btn btn-primary" >  <i class="fa fa-save"></i> <span>حفظ</span></button>  <i  id="add_spare_code"   style="display:none;color: #0a7817" class="fa fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="result_enter">
                            <div class="list_code_print"></div>
                        </div>

                    </form>
                </div>
                <div class="tab-pane fade   <?php  if ($tab) echo 'show active' ?> " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                    <form id="bysearch" method="post" action="<?php  echo url .'/'.$this->folder ?>/bysearch" >

                    <div class="row align-items-end">
                        <div class="col-auto">
                            <label> اختر القسم  </label>
                            <input type="hidden" name="model" value="<?php  echo $model ?>">
                            <select    id="fullsearch" class="custom-select mr-sm-2"     onchange="location=this.value"  required>

                                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                                    <option  value="<?php  echo url .'/'.$this->folder ?>/add_spare_code?model=<?php  echo $key ?>&tab=2"  <?php if ($model ==$key )  echo 'selected' ?>  value="<?php echo $key ?>"><?php  echo $c ?></option>
                                <?php }  ?>

                            </select>
                        </div>
                        <div class="col-auto ">
                            <label>بحث</label>
                            <input   id="id_item"  name="id_item" type="hidden"   ">
                            <input  onkeyup="smartSearch(this)"   class="form-control empty_search_text" type="text" required placeholder="اسم المادة - رمز المادة - باركود بديل ">
                            <div class="search_data"></div>
                        </div>
                        <div class="col-auto ">
                            <label>اللون</label>

                            <select id="color"     onchange="get_details_code(this)"  style="padding-bottom: 0" class="form-control" required ></select>
                        </div>
                        <div class="col-auto ">
                            <label  data-placement="top" title="في حال قسم الاكسسوارات والحافظات يظهر الباركود لانها لا تحتوي على ذاكرة" >الذاكرة</label>

                            <select id="code_details"  name="code" class="form-control" required   data-toggle="tooltip" data-placement="top" title="في حال قسم الاكسسوارات والحافظات يظهر الباركود لانها لا تحتوي على ذاكرة"   ></select>
                        </div>
                        <div class="col-auto ">
                            <label>الباركود البديل</label>

                            <input id="spare_code2" name="spare_code" class="form-control" required >
                        </div>

                        <div class="col-auto ">
                            <button type="submit"   class="btn btn-primary"   ><i class="fa fa-save"></i>  حفظ  </button>  <i  id="add_spare_code2"   style="display:none;color: #0a7817" class="fa fa-check-circle"></i>
                        </div>



                    </div>
                </form>

                    <div class="result_enter">
                        <div class="list_code_print2"></div>
                    </div>

                </div>
             </div>
        </div>
    </div>

    <script>

        function resetForm()
        {
            $( ".empty_search_text" ).val('');
            $("#id_item").val('');
            $('#color').empty();
            $('#code_details').empty();
        }

        $("#bycode").submit(function(e) {

            $('#add_spare_code').hide()
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
                        $('.list_code_print').after(`<div class="list_spare_code"><span>${$('#spare_code').val()}<span></div>`);
                        $('#spare_code').val('').select()
                        $('#add_spare_code').show()
                    }else {
                        alert('رمز المادة غير موجود')
                        $('#add_spare_code').hide()
                    }

                }
            });

        });


        $("#bysearch").submit(function(e) {

            $('#add_spare_code2').hide()
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
                        $('.list_code_print2').after(`<div class="list_spare_code"><span>${$('#spare_code2').val()}<span></div>`);
                        $('#spare_code2').val('').select();
                        $('#add_spare_code2').show()
                    }else {
                        alert('رمز المادة غير موجود')
                        $('#add_spare_code2').hide()
                    }

                }
            });

        });




    function smartSearch(e) {

        var val = $(e).val();
        if (val) {

            var cat = "<?php  echo $model ?>";
            if (cat) {

                $.get("<?php  echo url . '/' . $this->folder ?>/smartsearch", {
                    val: val,cat:cat,
                }, function (data) {
                    if (data) {
                        $(".search_data").html(data).show();
                    } else {
                        $(".search_data").empty().hide();
                    }

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

    function getDetails_device(e) {

         $("#id_item").val($(e).val());
         $( ".search_data" ).empty().hide();
         $( ".empty_search_text" ).val($(e).text());

        var cat ="<?php  echo $model ?>";

        $.get("<?php  echo url . '/' . $this->folder ?>/get_color", {
            id_item: $("#id_item").val(),cat:cat,
        }, function (data) {
            if (data) {
                $('#color').html(data);
            }

        });

    }


    function get_details_code(e) {


         var cat = "<?php  echo $model ?>";
        $.get("<?php  echo url . '/' . $this->folder ?>/get_code_details", {
            id_color: $(e).val(),cat:cat,
        }, function (data) {
            if (data) {

                $('#code_details').html(data);
            }

        });

    }

</script>


<style >


    .sub_table
    {
        margin-bottom: 15px;
    }
    .sub_table:last-child
    {
        margin-bottom: 0;
    }


    .sub_table td
    {
        background: #ffffff;
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



    .fieldset
    {
        border: 1px solid #d6d6d6;
        padding: 21px 18px;
        background: #ecedee;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .fieldset legend
    {
        border: 1px solid #d6d6d6;
        width: auto;
        padding: 5px 15px;
        border-radius: 5px;
        background: #f8f9fa;
        font-size: 18px;
    }

</style>

<style>

    .table_prich_x
    {
        background: #ffffFF;
        margin-top: 5px;
    }

    .table_prich_x tr td
    {
        padding: 2px;
        background: #ffffFF;
    }
    .list_location {
        position: absolute;
        z-index: 1000;
        width: 100%;
        border: 1px solid #cec8c8;
        box-shadow: 5px 4px 6px 0px #0000003b;
        display: none;
        height: 300px;
        overflow: auto;
        background: #FFFFFF;
    }
    .redBorder
    {
        background: red;
        color: #ffffFF;
    }
</style>

  <style>

    .list_spare_code
    {
        padding: 15px;
    }
    .list_spare_code span
    {
        background: #ffeb3b;
        padding: 5px;
        border-radius: 5px;
    }

        .result_enter
        {
          height: 500px;
            overflow: auto;
        }

    </style>



    <br>
    <br>



    <br>
    <br>
    <br>
    <br>


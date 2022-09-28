


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl($this->folder) ?> </a></li>

			</ol>
		</nav>


		<hr>
	</div>
</div>



<form id="idForm" action="<?php  echo url .'/'.$this->folder ?>/add_data" method="post">


    <div class="form-row align-items-center">


        <div class="col-auto">

            <select name="cat" class="custom-select mr-sm-2" id="cat_site"  required>
                <option   selected    >  اختر القسم  </option>
                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                    <option value="<?php echo $key ?>"><?php  echo $c ?></option>
                <?php }  ?>
            </select>
        </div>
        <div class="col-auto">
            الكود
        </div>

        <div class="col-lg-3 col-md-4 col-sm-5">
            <input type="text" name="code"   class="form-control" id="code" placeholder="الكود" required>
        </div>



        <div class="col-auto">
            <button onclick="codeData()"  style="    margin: 0 !important;" type="button" class="btn btn-primary mb-2">بحث</button>
        </div>
    </div>




    <script>


        function codeData()
        {

            code=$("#code").val();
            cat=$('#cat_site option:selected').val();

            if (code) {

                if (cat === 'xxxxx')
                {
                    color = $('#color_name_acc option:selected').val();
                    if (color)
                    {
                        $.ajax({
                            url: "<?php  echo url ?>/code/get",
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
                        url: "<?php  echo url ?>/code/get",
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
                alert('اضف كود المنتج')
            }
        }



        function locationCode(code,cat,color=null)
        {

            $.get("<?php  echo url .'/'. $this->folder ?>/location_list", {code: code, cat: cat, color: color}, function (data) {

                if (data)
                {

                    $('.location_menu').html(data);

                }else
                {

                    $('.location_menu').html(`
                      <select class="custom-select mr-sm-2" name="location" id="location_s"  ><option selected disabled value="" >لا يوجد مواقع لهذة المادة </option></select>
                    `);

                }
            });

        }

        </script>


        <hr>


    <div class="row  ">

        <div class="col-auto show_location">
            <label>الموقع</label>
            <div class="location_menu">
                <select class="custom-select mr-sm-2" name="location" id="location_s" required><option selected disabled value="" >لا يوجد مواقع</option></select>
            </div>
        </div>


        <div class="col-auto">
            <label>الكمية</label>
            <input style="width: 100px" type="number" class="xdata form-control" name="quantity" required autocomplete="off">
        </div>



        <div class="col-auto">
            <label>ملاحظة</label>
            <textarea   class="xdata form-control" name="note" rows="1"  autocomplete="off"></textarea>
        </div>

		<div class="col-auto align-self-end">
			<button  class="btn btn-primary "  type="submit" > اضافة </button>
		</div>

	</div>

</form>

<hr>
<div class="data_get"></div>


<script>
    $("#idForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                console.log(data)

                if (data==='1')
                {
                    $('.xdata').val('')
                    alert('تم الاضافة')
                }else if (data==='not_found_code') {
                    alert('الباركود غير موجود')
                }else if (data==='not_found_location') {
                    alert(' الموقع غير موجود  ')
                }else {
                    alert('حدث خطأ اعد المحاولة')
                }
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




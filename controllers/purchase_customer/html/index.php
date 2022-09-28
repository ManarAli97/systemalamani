<div class="row align-items-center ">

	<div class="col">
		<br>
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchase_customer') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >   انشاء فاتورة شراء  </li>

			</ol>
		</nav>

	</div>
</div>


<br>

<form  id="idForm" action="<?php echo url .'/'.$this->folder ?>/save_data" method="post">


	<fieldset class="fieldset">

		<legend class="legend">معلومات الزبون</legend>

		<div class="row">

			<div class="col-lg-3 form-group">
				<label>رقم الهاتف</label>
				<input minlength="11" maxlength="11" onblur="search_phone(this)" autocomplete="off" id="phone" name="phone" class="form-control" type="number" required>

			</div>

				<div class="col-lg-3 form-group">
					<label>الاسم</label>
					<input   autocomplete="off" id="name" name="name" class="form-control" type="text" required >

				</div>

				<div class="col-lg-3 form-group">
					<label>QR</label>
					<input  name="qr" onblur="search_qr(this)" id="qr" autocomplete="off" class="form-control" type="text"  >
				</div>
		</div>


	</fieldset>

	<script>

		function search_phone(e)
		{
		    if ($(e).val())
			{
                $.get( "<?php echo url .'/'.$this->folder ?>/search_phone",{phone:$(e).val()}, function( data ) {

                    if (data)
                    {
                        response=JSON.parse(data)

                        $('#name').val(response.name);
                        $('#phone').val(response.phone);
                        $('#qr').val(response.qr);

                    }

                });
			}else
			{
                $('#name').val('');
                $('#phone').val('');
                $('#qr').val('');

			}
        }



		function search_qr(e)
		{
		    if ($(e).val())
			{
                $.get( "<?php echo url .'/'.$this->folder ?>/search_ar",{qr:$(e).val()}, function( data ) {
                    if (data)
                    {
                        response=JSON.parse(data)

                        $('#name').val(response.name);
                        $('#phone').val(response.phone);


                        $( ".search_name" ).empty().hide();
                        $( ".search_phone" ).empty().hide();
                    } else
					{
					    alert('لا يوجد زبون بهذا ال QR')

                        $( ".search_name" ).empty().hide();
                        $( ".search_phone" ).empty().hide();
					}
                });
			}else
			{
                $('#name').val('');
                $('#phone').val('');
                $('#qr').val('');

                $( ".search_name" ).empty().hide();
                $( ".search_phone" ).empty().hide();
			}
        }



        function add_comma(e)
        {
            valu=$(e).val();
            $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
	</script>






	<fieldset class="fieldset">

		<legend class="legend">  بحث عن مادة </legend>

		<div class="row align-items-end">

                <div class="col-auto form-group">
                    <label> اختر القسم  </label>
                    <select  name="cat" id="fullsearch" class="custom-select mr-sm-2"     required>
                        <option value=""  selected    >  اختر القسم  </option>
                        <?php  foreach ($this->category_website as $key  => $c ) { ?>
                            <option value="<?php echo $key ?>"><?php  echo $c ?></option>
                        <?php }  ?>

                    </select>
                </div>
                <div class="col-lg-4 form-group">
                    <label>بحث</label>
                    <input  onkeyup="smartSearch(this)" class="form-control empty_search_text" type="text"  placeholder="اسم المادة - رمز المادة - باركود بديل ">
                    <div class="search_data"></div>
                </div>

				<div class="col-auto  form-group">
					<button type="button" onclick="goAdd_mobile()"  class="btn btn-primary"   >  اضافة مادة جديدة </button>
 				</div>

		</div>

	</fieldset>

	<br>

	<div class="result_data_mobile">
		<table class="table table-striped">

			<thead>
			<tr>
				<th>الصورة</th>
				<th>اسم المادة</th>
				<th> اللون  </th>
				<th> الكود  </th>
				<th> الكمية المتوفرة  </th>
				<th> السعر  الحالي (د.ع)  </th>
				<th>  السعر الحالي ($) </th>
				<th>الكمية</th>
				<th>سيريال</th>
				<th>  سعر الشراء (د.ع)   </th>
				<th>ملاحظة</th>
				<th>  سعر البيع  ($)   </th>
				<th>  الموقع   </th>
				<th>  المستودع   </th>
				<th> حذف  </th>
			</tr>
			</thead>
			<tbody class="load_data"></tbody>



		</table>

<hr>

		<div class="text-center">

			<button disabled id="save_data" class="btn btn-primary" type="submit"> شراء </button>

		</div>

	</div>

</form>

	<script>

        function smartSearch(e) {

            var val = $(e).val();
            if (val) {

                var cat = $('#fullsearch').val();
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
                $( ".search_data" ).empty().hide();
            }

        }

        function getDetails_mobile(e) {

            var cat = $('#fullsearch').val();
            $.get( "<?php echo url .'/'.$this->folder ?>/getdata",{id:$(e).val(),model:cat}, function( data ) {
                if (data)
                {

                    $( ".load_data" ).prepend(data);
                    $( ".search_data" ).empty().hide();
                    check_data()
                }
            });

            $( ".search_data" ).empty().hide();
            $( ".empty_search_text" ).val('');


        }


        function set_checkbox(e,id_color,id_mobile) {
			$('.stopallcode_'+id_mobile).attr('disabled','disabled').prop('checked', false);
			$(".active_code_"+id_color).removeAttr('disabled');

		}


		function number_serial(e,code) {

            if ($(e).val())
			{
			    if ($(e).val() > 0)
                {
                    $(".sale_quantity_"+code).empty()

                }

                var html='';

            for (var i=1;i<=$(e).val();i++)
			{

                $.get("<?php  echo url .'/'.$this->folder ?>/check_serial_required_purchase", {
                    code: code,
                }, function (data ) {
                    if (data === 'true') {
                        html=`<input autocomplete="off"  class="form-control"  name="serial_${code}[]"  placeholder="سيريال"    required     >`
                        $(".sale_quantity_"+code).append(html)
                    }else
                    {
                        html=`<input autocomplete="off"  class="form-control"  name="serial_${code}[]"  placeholder="سيريال"          >`
                        $(".sale_quantity_"+code).append(html)
                    }
                })

			  }


            }else
			{
                $(".sale_quantity_"+code).html(`<input  name="serial_${code}[]" value="" class="form-control" placeholder="سيريال" readonly>`)
			}
        }









        function check_data() {

            if ($(".load_data tr").hasClass('found_row')) {
                $('#save_data').removeAttr('disabled');
            }else
			{
                $('#save_data').attr('disabled','disabled');

            }

        }
        $("#idForm").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');
            $('#save_data').hide();
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize()+"&submit=submit", // serializes the form's elements.
                success: function(data)
                {
                   if (data==='true')
				   {
                       localStorage.removeItem('name');
                       localStorage.removeItem('phone');
                       localStorage.removeItem('qr');

				       alert(' يرجى توجه الزبون للمحاسبة لاستلام المبلغ')
					   window.location=''
				   }else {
                       alert('حدثت مشكلة يرجى الاعادة مرة ثانية')
                       $('#save_data').show();
				   }
                }
            });


        });



        toggleOn();
        function toggleOn() {
            $('.menuControl').css('display','none');
            $('#controlMenu').bootstrapToggle('on')
        }



        (function(){
            $('#name').val(localStorage.getItem('name'));
            $('#phone').val(localStorage.getItem('phone'));
            $('#qr').val(localStorage.getItem('qr'));
        })();


        function goAdd_mobile() {

            var cat = $('#fullsearch').val();
            if (cat) {
                localStorage.setItem('name', $('#name').val());
                localStorage.setItem('phone', $('#phone').val());
                localStorage.setItem('qr', $('#qr').val());

                window.location = "<?php echo url   ?>/"+cat+"/add_"+cat+"/0/1"
            }else
            {
                alert('اختر قسم')
            }
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
<script>

    $(".location_get").focusout(function(){
        setTimeout(function () {
            $('.list_location').hide()

        },500)
    });

    function get_location_model(mode,code) {
        $('#'+mode+'_'+code).removeClass('redBorder');

        var value=$('#'+mode+'_'+code).val();

        if (value)
        {
            $.get( "<?php  echo url .'/'. $this->folder ?>/search_location",{model:mode,code:code,location:value}, function( data ) {
                if (data)
                {
                    $('.'+mode+'_'+code).html(data).show()
                }else
                {
                    $('.'+mode+'_'+code).hide().empty()
                }
            });

        }else {
            $('.'+mode+'_'+code).hide().empty()

        }


    }

    function check_location_model(mode,code) {
        setTimeout(function () {
            var value_ch=$('#'+mode+'_'+code).val();
            if (value_ch)
            {
                $.get( "<?php  echo url .'/'. $this->folder ?>/check_location_model",{model:mode,code:code,location:value_ch}, function( data ) {
                    if (data ==='false')
                    {


                        $('#'+mode+'_'+code).val('').addClass('redBorder');
                        alert('الموقع المدخل ليس من ضمن مواقع القسم')
                    }
                });

            }else {
                $('#'+mode+'_'+code).val('')
            }

        },500)
    }

    function print_location(e) {
        var mode=$(e).data('model')
        var code=$(e).data('code')
        $('#'+mode+'_'+code).val($(e).text())
        $('.list_location').hide().empty()
    }


</script>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

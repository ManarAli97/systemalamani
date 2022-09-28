<br>
<div class="row">
	<div class="col">

		<nav aria-label="breadcrumb" >

			<ol class="breadcrumb"  >
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/details_money_clipper"><?php  echo $this->langControl('money_clipper') ?> </a></li>
			</ol>

		</nav>

	</div>
	<div class="col-auto">
		<div class="sumAllMoney">
			<span>   مجموع القاصة : </span> <span>  <?php  echo number_format($this->allMoney_clipper($this->id_money_clipper)) ?> </span> <span> د.ع</span>
		</div>
	</div>


</div>



 <div id="resultwd">

 </div>



<form id="withdraw_ajax" action="<?php echo url.'/'.$this->folder?>/withdraw_ajax" method="post">

	<div class="row ">
		<div class="col-auto">
			 المبلغ الكلي في القاصه
			<input type="text"  disabled value="<?php echo number_format($this->allMoney_clipper($this->id_money_clipper))  ?> د.ع "   class="form-control"    required>
		</div>
      <div class="col-auto">
			سحب مبلغ من القاصه
			<input type="text" name="money" id="moneyWithdraw" onkeyup="add_comma(this)"  class="form-control"    required>
		</div>

      <div class="col-auto">
		 ملاحظه
          <textarea type="text" name="note" id="moneyWithdraw"   class="form-control"     ></textarea>
		</div>

		<div class="col-auto align-self-end">
			<button type="submit" class="btn btn-warning" >سحب</button>
		</div>
	</div>

</form>

<br>


<script>


    function add_comma(e)
    {
        valu=$(e).val();
        $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }

</script>



<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_withdraw",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            }
        } );
    } );
</script>


<hr>
<div class="row">
	<div class="col">

		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>
				<th>  المبلغ المسحوب  </th>
				<th> تاريخ السحب </th>
				<th>  الادمن </th>
				<th>  ملاحظه </th>



			</tr>
			</thead>

		</table>

	</div>
</div>






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

</style>

<br>
<br>
<br>
<br>









<script>


    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function () {
        $('#withdraw_ajax').on('submit', function (e) {

            if (confirm( ' هل انت متأكد من سحب مبلغ قدرة: ' +  $("#moneyWithdraw").val()   + " د.ع من القاصه " ))
			{
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: this.action,
                    data:  $('#withdraw_ajax').serialize(),
                    success: function (date) {
                        console.log(date)
                        if (date==="1")
                        {
                             $("#resultwd").html(`
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
									 تم السحب بنجاح
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;</span>
									 </button>
									 </div>
                             
                             `);

                             setTimeout(function () {

                                 window.location=''
                             },3000)
								 
								 
                        }else if (date === '0'){

                            $("#resultwd").html(`
                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
									حدثت مشكلة اعد  المحاولة لاحقا
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;</span>
									 </button>
									 </div>

                             `);


                        }else if (date ==='notMoney')
						{

                            $("#resultwd").html(`
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
									 المبلغ المسحوب اكبر من المبلغ المتوفر في القاصه
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;</span>
									 </button>
									 </div>

                             `);

						}else 
						{

                            $("#resultwd").html(`
                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
									حدثت مشكلة اعد  المحاولة لاحقا
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;</span>
									 </button>
									 </div>

                             `);

                        }
                    }
                });
			}return false


        });

    });

</script>

<div class="print_bill_casher">
    <div class="title_company">

        <img src="<?php echo $this->static_file_site ?>/image/site/bill_title3.png">
    </div>
    <div style="text-align: left;margin-bottom: 5px;font-size: 18px" > <span>السوق الالكتروني</span>  <span> www.alamani.iq  </span> </div>

    <div class="row   align-items-center">
        <div class="col-auto">
            <div class="customer_name">
                <span>  حضرة السيد   :</span> <span id="username_account"><?php  echo $this->userInfo($id)?></span>
            </div>
        </div>
        <div class="col-auto">
            <div class="customer_name">
                <span>المحترم</span>
            </div>
        </div>
    </div>
    <br>


    <div class="row justify-content-between">


        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
            <span>التاريخ:</span> <span> <?php echo date('d-m-Y',time())  ?> </span>
            <span>الوقت:</span> <span>  <?php echo date('H:i',time())  ?></span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
            <span>   سند سحب   </span>
        </div>

    </div>

    <br>
    <table class="table tableBill table-bordered  "   >

        <tbody>

        <tr>
            <td  >  المبلغ  </td>
            <td>   التاريخ  </td>
            <td>   الوقت  </td>
            <td>   الموضف  </td>


        </tr>
        <tr>
            <td id="amount_push" ></td>
            <td>   <?php echo date('d-m-Y',time())  ?>  </td>
            <td>    <?php echo date('H:i',time())  ?>  </td>
            <td>   <?php echo $_SESSION['usernamelogin'] ?>  </td>


        </tr>

        </tbody>
    </table>

</div>





<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/details_money_clipper"><?php  echo $this->langControl('money_clipper') ?> </a></li>
                <li class="breadcrumb-item"> سجل الدفع والسحب  للمحاسبين الثانوين  </li>

            </ol>

        </nav>

    </div>
    <div class="col-auto">
        <div class="sumAllMoney">
            <span>   مجموع القاصة : </span> <span>  <?php  echo number_format($this->allMoney_clipper($this->id_money_clipper)) ?> </span> <span> د.ع</span>
        </div>
    </div>


</div>









    <div class="row align-items-end">
        <div class="col-auto">
            <label for="exampleFormControlSelect1"> اختر المحاسب  </label>
            <select style="padding-top: 0" class="form-control" id="exampleFormControlSelect1"  onchange="location = this.value;">
                <option value="">  اختر المحاسب</option>
				<?php foreach ($user as $us) { ?>
                    <option value="<?php echo url.'/'.$this->folder?>/secondary_user/<?php echo $us['id'] ?>"   <?php  if (  $us['id']  == $id)echo 'selected'?>  >   <?php echo $us['username'] ?>  </option>
				<?php  }  ?>
            </select>
        </div>
		<?php  if ($id)  {  ?>
        <div class="col-auto">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="<?php echo url .'/'.$this->folder ?>/secondary_user/<?php  echo $id ?>/0"  class="btn btn-secondary" > <?php if ($flag==0) { ?> <i class="fa fa-check-circle"></i> <?php } ?> <span>سجل الاضافة</span> </a>
                <a href="<?php echo url .'/'.$this->folder ?>/secondary_user/<?php  echo $id ?>/1"  class="btn btn-secondary"> <?php if ($flag==1) { ?> <i class="fa fa-check-circle"></i> <?php } ?>  <span>سجل السحب</span> </a>
            </div>
        </div>
        <?php  } ?>

    </div>





<?php  if ($id)  {  ?>

    <hr>

<?php if ($flag==0) { ?>

 <div class="result1"></div>
<form id="add_money_to_secondary_user" action="<?php echo url.'/'.$this->folder?>/add_money_to_secondary_user/<?php echo $id ?>" method="post">

    <div class="row align-items-end">
        <div class="col-auto">
            المبلغ الذي معة
            <input type="text" disabled value="<?php  echo $sum ?> د.ع "     class="form-control"   >
        </div>
        <div class="col-auto">
            اضافة مبلغ الى  المحاسب  المحدد
            <input type="text" name="add_money"  onkeyup="add_comma(this)"  class="form-control"    required>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >اضافة</button>
        </div>
    </div>

</form>
<?php } ?>

<?php if ($flag==1) { ?>
    <div class="result2"></div>
<form id="withdraw_amount_money_to_secondary_user"  action="<?php echo url.'/'.$this->folder?>/withdraw_amount_money_to_secondary_user/<?php echo $id ?>" method="post">

    <div class="row align-items-end">
        <div class="col-auto">
            المبلغ الذي معة
            <input type="text" disabled value="<?php  echo $sum ?> د.ع "     class="form-control"   >
        </div>

        <div class="col-auto">
             سحب مبلغ من المحاسب   المحدد
            <input type="text" name="withdraw_amount"  onkeyup="add_comma(this)"  class="form-control"    required>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >سحب</button>
        </div>
    </div>

</form>
    <?php  } ?>



    <script>


        function add_comma(e)
        {
            valu=$(e).val();
            m = valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            $(e).val(m);
            $('#amount_push').html(m)

        }




        $("#add_money_to_secondary_user").submit(function(e) {

            if (confirm('هل انت متأكد من اضافة مبلغ؟'))
            {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {

                    if (data==='1')
                    {
                        $('.result1').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                         تمت الاضافة.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `)
                        setTimeout(function () {

                            window.location=''
                        },3000)

                    }else if(data==='noMoney')
                    {
                        $('.result1').html(`

                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                             لا يوجد مبلغ كافي في القاصة
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `)
                    }else
                    {
                        $('.result1').html(`
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            حدثت مشكلة اعد المحاولة
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `)
                    }
                }
            });

          }return false

        });





        $("#withdraw_amount_money_to_secondary_user").submit(function(e) {

            if (confirm('هل انت متأكد من سحب مبلغ؟'))
            {

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
                        $('.result2').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                         تم سحب المبلغ من المحاسب المحدد.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `);
                        print_bill_casher()
                        setTimeout(function () {

                            window.location=''
                        },3000)

                    }else if(data==='noMoney')
                    {
                        $('.result2').html(`

                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            المبلغ المسحوب اكبر من المبلغ المتوفر لدى المحاسب المحدد
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `)
                    }else
                    {
                        $('.result2').html(`
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            حدثت مشكلة اعد المحاولة
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        `)
                    }
                }
            });

          }return false

        });




        function print_bill_casher() {

            $('.print_bill_sale'). removeClass('sale');
            $('.print_bill_casher'). addClass('casher');
            $('.bodyControl').scrollTop(0);
            window.print();

        }



    </script>







<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_add_money_to_secondary_user/<?php  echo $id?>/<?php  echo $flag?>",
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
				<?php if ($flag==0) { ?>
                <th> المبلغ المضاف للمحاسب  </th>
                <?php  }  ?>
				<?php if ($flag==1) { ?>
                <th> المبلغ المسحوب من المحاسبين  </th>
                <?php  }  ?>
                <th>  التاريخ </th>
                <th>  الادمن </th>
            </tr>
            </thead>
        </table>

    </div>
</div>


<?php  }  ?>



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

<style>


    .title_company
    {
        margin-bottom: 15px !important;
    }
    .title_company img
    {
        width: 100%;
    }

    .print_bill_casher
    {
        padding: 8px;
        display: none;
        position: absolute;
        width: 100%;
    }


    .customer_name
    {
        font-size: 18px;
        font-weight: bold;
    }

    .tableBill.table-bordered tr td {
        border: 2px solid black !important;
        padding: 2px 5px;
        vertical-align: inherit;
    }

    .tableBill_casher.table-bordered tr td {
        border: 2px solid black !important;

    }

    @media print {

        @page {
            size: A5; /* DIN A4 standard, Europe */
            margin: 0;
        }

        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

        }

        .hide_print {
            display: none;
        }

        .fixed-top, .down_fixed, .notShowInPrint, .menuControl {
            height: 0;
            display: none;
        }


        .footer_bill {
            margin-top: 30px;
        }


        .print_bill_casher.casher {
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_bill_casher.casher * {
            position: relative;
            visibility: visible;
        }


        .footer {
            display: none;
        }

    }


</style>

<br>
<br>
<br>
<br>




<div class="row">
    <div class="col-sm-12">
        <div class="print_bill_sale">


                <div class="row   align-items-center">
                    <div class="col-auto">
                        <div class="customer_name">
                            <span>  حضرة السيد   :</span> <span id="username_account"></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="customer_name">
                            <span>المحترم</span>
                        </div>
                    </div>
                </div>
<br>
                <div class="row align-items-center">
                    <div class="col-lg-7 col-sm-7 col-7">
                        <div class="date_and_type_pay customer_name">


                            <div class="row justify-content-between">


                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <span>التاريخ:</span> <span> <?php echo date('d-m-Y',time())  ?> </span>
                                    <span>الوقت:</span> <span>  <?php echo date('H:i',time())  ?></span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <span>   سند سحب  </span>
                                </div>

                            </div>
                        </div>
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

    </div>
</div>














<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('log_accountant') ?> </a></li>
                <li class="breadcrumb-item">  عرض المحاسبين  </li>
            </ol>
        </nav>

    </div>

</div>


<?php if ($this->admin($this->userid)) {  ?>
    <div class="row">
        <div class="col-auto">
            <label for="exampleFormControlSelect1"> اختر المحاسب  </label>
            <select style="padding-top: 0" class="form-control" id="exampleFormControlSelect1"  onchange="location = this.value;">
                <option value="">  اختر المحاسب</option>
				<?php foreach ($user as $us) { ?>
                 <option value="<?php echo url.'/'.$this->folder?>/index/<?php echo $us['id'] ?>"   <?php  if (  $us['id']  == $id)echo 'selected'?>  >   <?php echo $us['username'] ?>  </option>
                <?php  }  ?>
            </select>
        </div>
    </div>
<hr>

<?php }  ?>
<form action="<?php echo url.'/'.$this->folder?>/index/<?php echo $id ?>" method="get">



    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
           الى تاريخ
            <input type="date" name="toDate" class="form-control" value="<?php  echo $tDate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>



<!---->
<!---->
<!--<table class="color_table table table-bordered table-striped text-center">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th scope="col" class="alert-primary">المبلغ الكلي المستحصل من موضفي البيع المباشر  حسب التاريخ  (محاسبين ثانوين) </th>-->
<!--        <th scope="col" class="alert-info"> المبلغ الكلي حسب التاريخ (محاسب رئسي)</th>-->
<!--        <th scope="col" class="alert-success">مجموع المبالغ المسترجعة للزبائن  حسب التاريخ </th>-->
<!--        <th scope="col" class="alert-danger">مجموع المبالغ المتواجدة  حسب التاريخ (المبلغ الكلي حسب التاريخ  + المستحصل من المحاسبين الثانوين ) </th>-->
<!--        <th scope="col" class="alert-warning">  المبلغ الكلي (- المسترجع الى الزبائن)</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--    <tr>-->
<!--        <th class="alert-primary"> <span>--><?php //echo  number_format($my) ?><!--</span> <span> د.ع </span> </th>-->
<!--        <th class="alert-info"> <span>--><?php //echo  number_format($acc) ?><!--</span>  <span> د.ع </span> </th>-->
<!--        <th class="alert-success"> <span>--><?php //echo  number_format($rewind) ?><!--</span> <span> د.ع </span> </th>-->
<!--        <th class="alert-danger"> <span>--><?php //echo number_format($allMoney) ?><!--</span> <span> د.ع </span> </th>-->
<!--        <th class="alert-warning"> <span>--><?php //echo $allMoney_from_star  ?><!--</span> <span> د.ع </span> </th>-->
<!---->
<!--    </tr>-->
<!---->
<!--    </tbody>-->
<!--</table>-->
<!---->

<style>

    .table.color_table thead th {
        border-bottom: 1px solid #000;

    }
    .color_table.table-bordered td, .color_table.table-bordered th {
        border: 1px solid #323233;

    }

</style>


<script>
    $(document).ready(function() {

        var selected = [];
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php echo $recordFDate .'/'.$recordTDate ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[9]);
            },

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
            ,
            "columnDefs": [
                { className: "title_cell", "targets": [ 0 ] },
            ],

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


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col"> اسم المحاسب </th>
        <th scope="col">    المبلغ  من الزبائن  </th>
        <th scope="col">    المبلغ المدفوع الى المحاسبين  </th>
        <th scope="col">    المبلغ المدفوع من القاصة  </th>
        <th scope="col">    المبلغ المدفوع الى القاصة  </th>
        <th scope="col">   المجموع </th>
        <th scope="col">    عرض الفواتير  </th>
        <th scope="col">    سحب  </th>
        <th scope="col">    سجل السحب  </th>
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

</style>

<br>
<br>
<br>
<br>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                      سحب المبلغ من المحاسب
                    </span>

                <span id="xdiscount"></span>

            </div>
            <div class="modal-body">
                <form id="edit_region" action="" method="post">

                        <span> المبلغ المتوفر(المبلغ من الزبئن فقط - المبلغ المدفوع الى المحاسبين الرئيسين فقط) : </span> <strong class="money"></strong> د.ع
                      <hr>

                    <input name="discount" onkeyup="add_comma(this)" class="form-control" type="text"  id="discount" placeholder="المبلغ المسحوب" required >
                      <br>
                    <a id="gotowithdrow" ><small>م//يمكن سحب المبغ المدفوع من القاصه من خانه القاصة</small></a>
                    <br>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="submit" value="<?php  echo $this -> langControl('save')?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>


    function add_comma(e)
    {
        valu=$(e).val();
        $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#amount_push').text(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }




    var money=0;
    $('#exampleModal_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var id_user = button.data('id_user');
        $('#gotowithdrow').attr('href','<?php echo url ?>/money_clipper/secondary_user/'+id_user+'/1')   ;

        var modal = $(this);
        $.ajax({
            url: "<?php  echo url . '/' . $this->folder?>/getUser/"+id+"/"+id_user,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    money=response.money;
                    modal.find('.money').text(numberWithCommas(response.money));
                    modal.find('#xdiscount').text(response.username);
                    $('#username_account').text(response.username);
                    modal.find('#edit_region').attr("action","<?php  echo url .'/'.$this->folder?>/disaccount/"+id+"/"+id_user);
                }
            }
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function () {
        $('#edit_region').on('submit', function (e) {
            e.preventDefault();

            print_bill_sale_sale()

            /*
            var noCommas=$('#discount').val();
            var m = noCommas.replace(/,/g, '');
            var filter_money = money.replace(/,/g, '');
            if (Number(m) <= Number(filter_money))
            {
                if (confirm( " هل انت متأكد من سحب مبلغ "+$('#discount').val()))
                {

                    $.ajax({
                        type: 'post',
                        url: this.action,
                        data: $('#edit_region').serialize(),
                        success: function (data) {

                           console.log(data)
                            if (data === "0") {
                                alert('لاتوجد مبالغ لسحبها من المحاسب')
                            } else {
                                alert("تم السحب بنجاح.")
                                window.location.reload()
                            }

                        }
                    });
                }return false
        }else
        {
            alert('المبلغ المسحوب اكبر من المبلغ المتوفر')
        }
*/

        });

    });



    function print_bill_sale_sale() {
    $('.print_bill_casher'). removeClass('casher');
    $('.print_bill_sale'). addClass('sale');

    window.print();
    }

</script>


<style>
.not_prepared td{
    background-color: gainsboro !important;
}

.progs_d_x
{
    display: none;
}
.progs_r_x
{
    display: none;
}

.image_prod
{
    width: 50px;
    height: 50px;
}


.color_item_table
{
    width: 27px;
    height: 27px;
    display: block;
}
.error{
    color: red;
}

.set_text_table
{
    text-align:center;
}


.note_prepared
{
    font-size:26px ;
    color: red !important;
}
.done_prepared
{
    font-size:26px ;
    color: green !important;
}
.note_prepared:before
{

    color: red !important;
}
.done_prepared:before
{

    color: green !important;
}

.notMyModel
{
    opacity: 0.3;
}


.image_prod
{

    height: 50px;
}




.color_item_table
{
    width: 27px;
    height: 27px;
    display: inline-block;
}
.error{
    color: red;
}

.set_text_table
{
    text-align:center;
}
.btn_tajhez
{
    width: 100%;
    background: #17a2b8;
    margin: 0;
    color: #fff;
}



#addLocation
{
    display: none;
}


#addLocationSerial
{
    display: none;
}



.user_sale
{
    margin: 5px 0;
}

.title_company
{
    margin-bottom: 5px !important;
}
.title_company img
{
    width: 100%;
}

.customer_mohtram.customer_name {
    margin-bottom: 15px;
}


.print_bill_sale
{
    margin-top: 92px !important;
    padding: 8px;
    display: none;

}


.print_bill_casher
{
    padding: 8px;
    display: none;

}




.customer_name
{
    font-size: 18px;
    font-weight: bold;
}

.image_prod
{
    height: 50px;
}

.tableBill.table-bordered tr td {
    border: 4px solid black !important;
    padding: 2px 5px;
    vertical-align: inherit;

}

.tableBill_casher.table-bordered tr td {
    border: 5px solid black !important;

}

table.requ_on td  {
    vertical-align: middle;
}

@media print {

    @page {
        size: A5; /* DIN A4 standard, Europe */
        margin:0;
    }

    * {
        -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
        color-adjust: exact !important; /*Firefox*/
    }

        body * {
            visibility: hidden;

}
.hide_print
    {
        display: none;
    }
.fixed-top,.down_fixed,.notShowInPrint,.menuControl
    {
        height: 0;
        display: none;
    }


.result
    {
        height: auto !important;
        overflow: unset !important;
    }

.bodyControl
    {
        overflow: unset;
    }

.footer_bill
    {
        margin-top:30px ;
    }

.print_bill_sale.sale {
        width: 100% !important;
        height: auto !important;
        position: relative;
        visibility: visible;
        display: block;
    }

.print_bill_sale.sale * {
        position: relative;
    visibility: visible;
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


.footer
    {
        display:  none;
    }

}




</style>



<style>

.user_sale
{
    margin: 5px 0;
}

.title_company
{
    margin-bottom: 15px !important;
}
.title_company img
{
    width: 100%;
}

.customer_mohtram.customer_name {
    margin-bottom: 15px;
}


.print_bill_sale
{
    margin-top: 92px !important;
    padding: 8px;
    display: none;

}


.print_bill_casher
{
    padding: 8px;
    display: none;

}




.customer_name
{
    font-size: 18px;
    font-weight: bold;
}

.image_prod
{
    height: 50px;
}

.tableBill.table-bordered tr td {
    border: 2px solid black !important;
    padding: 2px 5px;
    vertical-align: inherit;
}

.tableBill_casher.table-bordered tr td {
    border: 2px solid black !important;

}

table.requ_on td  {
    vertical-align: middle;
}

@media print {

    @page {
        size: A5; /* DIN A4 standard, Europe */
        margin:0;
    }

    * {
        -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
        color-adjust: exact !important; /*Firefox*/
    }

        body * {
            visibility: hidden;

}
.hide_print
    {
        display: none;
    }
.fixed-top,.down_fixed,.notShowInPrint,.menuControl
    {
        height: 0;
        display: none;
    }


.result
    {
        height: auto !important;
        overflow: unset !important;
    }

.bodyControl
    {
        overflow: unset;
    }

.footer_bill
    {
        margin-top:30px ;
    }

.print_bill_sale.sale {
        width: 100% !important;
        height: auto !important;
        position: relative;
        visibility: visible;
        display: block;
    }

.print_bill_sale.sale * {
        position: relative;
    visibility: visible;
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


.footer
    {
        display:  none;
    }

}




</style>

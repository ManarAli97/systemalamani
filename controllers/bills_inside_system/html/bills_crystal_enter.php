

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>
                <li class="breadcrumb-item">  فواتير كرستال مدخلة  </li>
            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {


        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if (i===0 || i===1   || i===6  ) {
                $(this).html('<input class="form-control" type="text" placeholder="بحث" />');

                $('input', this).on('keyup change', function () {
                    console.log(this.value)
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }else
            {
                $(this).html('');

            }

        } );
     var table=   $('#example').DataTable( {
            "processing": true,
          <?php if (isset($_GET['date'])&&isset($_GET['todate'])) {  ?>
         "serverSide": true,

         "ajax": "<?php echo url .'/'.$this->folder ?>/processing_bills_crystal_enter/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
         <?php  } ?>
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[15]);
            },
            "order": [[ 5, 'asc'] ],
            orderCellsTop: true,
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
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: false

        } );
    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/bills_crystal_enter" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/bills_crystal_enter" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">   اسم الزبون  </th>
        <th scope="col">     رقم الهاتف  </th>
        <th scope="col">    تاريخ تسليم الفاتورة </th>
        <th scope="col">   مبلغ الفاتورة  </th>
        <th scope="col">     مصدر الفاتورة    </th>
        <th scope="col">   رقم الفاتورة  </th>
        <th scope="col">    رقم فاتورة كرستال   </th>
        <th scope="col">    تعديل رقم فاتورة كرستال   </th>
        <th scope="col">   مدخل الفاتورة  </th>

    </tr>
    </thead>
</table>


<script>





    function saveBill(number_bill,id) {

        if($('#numberBill_'+number_bill+''+id).val())
        {
            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill",{cart_shop:'cart_shop',number_bill:number_bill,id:id,crystal_bill:$('#numberBill_'+number_bill+''+id).val()}, function( data ) {
                if (data ==='1')
                {
                    alert(    'تم اضافة فاتورة كرستال = ' +number_bill);
                    table.draw();
                }else if (data === '2' ){
                    alert('فاتورة مدخلة')
                }

            });


        }else {

            alert('حقل فاتورة كرستال فارغ !')
        }

    }


</script>


<style>


    .withBill
    {
        width: 85px;
    }
    .addBill
    {
        color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
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


    table tr td a {
        color: red;
        font-size: 20px;
        font-weight: bold;
        border: 1px solid #eaeaea;
        display: block;
        width: auto;
    }

</style>

<br>
<br>
<br>
<br>
















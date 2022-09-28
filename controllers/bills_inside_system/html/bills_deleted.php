

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>
                <li class="breadcrumb-item">  <?php  echo $this->langControl('bills_deleted') ?> </li>
            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {

        // $('#example thead tr').clone(true).appendTo( '#example thead' );
        // $('#example thead tr:eq(1) th').each( function (i) {
        //     var title = $(this).text();
        //     if (i===0 || i===1 || i===2 || i===4 || i===5  ) {
        //         $(this).html('<input class="form-control" type="text" placeholder="بحث" />');
        //
        //         $('input', this).on('keyup change', function () {
        //             console.log(this.value)
        //             if (table.column(i).search() !== this.value) {
        //                 table
        //                     .column(i)
        //                     .search(this.value)
        //                     .draw();
        //             }
        //         });
        //     }else
        //     {
        //         $(this).html('');
        //
        //     }
        //
        // } );
        var table=  $('#example').DataTable( {
            "processing": true,
           
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_deleted/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",

            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[8]);
            },
            "order": [[ 5, 'asc'] ], orderCellsTop: true,
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
            bFilter: true, bInfo: true

        } );
    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/bills_deleted" method="get">

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
            <a href="<?php echo url.'/'.$this->folder?>/bills_note_checked" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">   اسم الزبون  </th>
        <th scope="col">     رقم الهاتف  </th>
        <th scope="col">    تاريخ حذف الفاتورة </th>
        <th scope="col">   مبلغ الفاتورة  </th>
        <th scope="col">   رقم الفاتورة  </th>
        <th scope="col">    رقم فاتورة كرستال   </th>
        <th scope="col">    تم    </th>
        <th scope="col">     المجهز     </th>
        <th scope="col">     المحاسب     </th>



    </tr>
    </thead>
</table>


<script>


    function crystal_delete(id,number_bill) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_delete/"+id+"/"+number_bill, function( data ) {
                if (data ==='1')
                {
                    $("#div_checked_"+id).html(`<i style="color: red" class="fa fa-check-circle"></i>`);
                }else {
                    alert('فشل التحقيق')
                }

            });
        }return false


    }


    function saveBill(number_bill) {

        if($('#numberBill_'+number_bill).val())
        {

            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill",{number_bill:number_bill,crystal_bill:$('#numberBill_'+number_bill).val()}, function( data ) {
                if (data ==='1')
                {
                    alert('تم اضافة فاتورة كرستال');
                    $("#row_"+number_bill+" td").eq(6).text($('#numberBill_'+number_bill).val());
                    $('#btn_in_bill_'+number_bill).addClass('addBill')
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











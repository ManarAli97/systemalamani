

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>
                <li class="breadcrumb-item">  فواتير غير مدققه </li>
            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {
        // $('#example thead tr').clone(true).appendTo( '#example thead' );
        // $('#example thead tr:eq(1) th').each( function (i) {
        //     var title = $(this).text();
        //     if (i===1 || i===2 || i===3 || i===5 || i===6 || i===7  ) {
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
        var table=   $('#example').DataTable( {
            "processing": true,
            <?php if (isset($_GET['date'])&&isset($_GET['todate'])) { ?>
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_bills_note_checked/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            <?php  }  ?>
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[16]);
            },
            "order": [[ 5, 'asc'] ],
            orderCellsTop: true,
            'columnDefs': [{
                "targets": [0],
                "orderable": false
            }],
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



<form action="<?php echo url.'/'.$this->folder?>/bills_note_checked" method="get">

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

<form id="checked_all" method="post">
<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th>  <input type='checkbox'   class="checkall" >  </th>

        <th scope="col">   اسم الزبون  </th>
        <th scope="col">     رقم الهاتف  </th>
        <th scope="col">    تاريخ تسليم الفاتورة </th>
        <th scope="col">   مبلغ الفاتورة  </th>
        <th scope="col">     مصدر الفاتورة    </th>
        <th scope="col">   رقم الفاتورة  </th>
        <th scope="col">    رقم فاتورة كرستال   </th>
        <th scope="col">  تم التدقيق  </th>


    </tr>
    </thead>
</table>

    <hr>
    <div class="text-center">
        <button class="btn btn-primary" type="submit"> تم التدقيق </button>

    </div>

</form>

<script>
    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });

    function checked_bill(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php  echo url .'/'.$this->folder ?>/checked_bill/"+id, function( data ) {
                if (data ==='1')
                {
                    $("#div_checked_"+id).html(`<i style="color: green" class="fa fa-check-circle"></i>`);
                }else {
                    alert('فشل التحقيق')
                }

            });
        }return false


    }






    $(function() {
        $("#checked_all").submit(function (e) {
            if (confirm("هل انت متاكد؟")) {
                e.preventDefault();
                var actionurl = e.currentTarget.action;
                $.ajax({
                    url: "<?php  echo url . '/' . $this->folder ?>/checked_all",
                    type: 'post',
                    cache: false,
                    data: $("#checked_all").serialize(),
                    success: function (data) {
                     console.log(data)
                        if (data)
                        {
                            alert('تم');
                            window.location=''
                        }else
                        {
                            alert('يرجى التحديد!')
                        }
                    }
                })
            }else
            {
                return false;
            }


        });
    });





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











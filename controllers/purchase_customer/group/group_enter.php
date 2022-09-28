

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/bills_enter"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item">   مجاميع تم ادخال رقم فاتورة كرستال لها  </li>
            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {



        var table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_group_enter/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[0]);
            },
            "order": [[ 0, 'asc'] ],
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
            bFilter: true, bInfo: true
            ,
            "columnDefs": [
                { className: "cry_bill", "targets": [ 5 ] },

            ]
        } );
    } );





</script>

<form action="<?php echo url.'/'.$this->folder?>/group_enter" method="get">

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
            <a href="<?php echo url.'/'.$this->folder?>/group_enter" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">   رقم المجموعة  </th>
        <th scope="col">  اسم المجموعة  </th>
        <th scope="col">    منشئ المجموعة </th>
        <th scope="col">  مدخل رقم فاتورة كرستال    </th>
        <th scope="col">  تاريخ انشاء المجموعة   </th>
        <th scope="col">     رقم فاتورة كرستال   </th>
        <th scope="col">     تعديل فاتورة كرستال   </th>
        <th scope="col">     تصدير مواد الفواتير  </th>



    </tr>
    </thead>
</table>


<script>



    function saveBill(number_group) {

        if($('#numberBill_'+number_group).val())
        {

            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill_group",{number_group:number_group,crystal_bill:$('#numberBill_'+number_group).val()}, function( data ) {

                if (data)
                {
                    alert(    'تم  تعديل فاتورة كرستال = ' +$('#numberBill_'+number_group).val());

                    $("#row_"+number_group+' .cry_bill').text($('#numberBill_'+number_group).val())

                }else

                {
                    alert('فشل تعديل رقم فاتورة كرستال')
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











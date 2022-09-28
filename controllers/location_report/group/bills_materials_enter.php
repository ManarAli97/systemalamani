

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/report"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/group_enter">  مجاميع تم ادخال رقم فاتورة كرستال لها </a></li>
                <li class="breadcrumb-item"> <span> رقم المجموعة </span> <?php  echo  $result['number'] ?> </li>

            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {

        var table= $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_bill_materials_crystal_enter/<?php echo $number ?>/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[1]);
            },
            "order": [[4, 'asc'] ],
            orderCellsTop: true,
            aLengthMenu: [ -1,10,25, 50, 100],
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


<div class="row justify-content-between">
    <div class="col-auto mb-2">

        <div class='row   align-items-end'>
            <div class='col-auto'  >
                <label>ادخال رقم فاتورة كرستال</label>
                <input placeholder="ادخال رقم فاتورة كرستال" id='numberBill_<?php  echo $number?>'  value="<?php  echo $result['crystal_bill'] ?>" autocomplete="off" type='text' class='form-control' name='crystal_bill' required>
            </div>
            <div class='col-auto'  >
                <button type='submit' id='btn_in_bill_<?php  echo $number?>' onclick=saveBill('<?php  echo $number?>')  name='submit' class='btn btn-warning'>حفظ</button>
            </div>
        </div>
    </div>

    <div class="col-auto">

        <form action="<?php echo url.'/'.$this->folder?>/export_group_enter?g=<?php  echo $number?>" method="get">

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
                    <a href="<?php echo url.'/'.$this->folder?>/export_group_enter?g=<?php  echo $number?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
                </div>
            </div>

        </form>


    </div>


</div>

<hr>




<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">  رمز المادة   </th>
        <th scope="col">    الكمية     </th>
        <th scope="col"> اسم المادة </th>
        <th scope="col"> اسم المستودع الذي سحب منه </th>
        <th scope="col"> اسم المستودع الذي ادخلت الكمية به </th>
        <th scope="col">  رقم المناقلة ،اسم الموظف الساحب،اسم الموظف الذي ادخل الكمية،الملاحظة </th>

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
                    alert(    'تم اضافة فاتورة كرستال = ' +$('#numberBill_'+number_group).val());

                    window.location=""

                }else

                {
                    alert('رقم فاتورة كرستال مدخل مسبقا')
                }

            });

        }else {

            alert('حقل فاتورة كرستال فارغ !')
        }

    }

    setTimeout(function () {
        $('.buttons-excel').hide();
    },100)
    <?php  if ($this->permit('export_excel','location_report')) {  ?>
     setTimeout(function () {
         $('.buttons-excel').show();
        $('.buttons-excel').click(function(){
            $.get( "<?php  echo url .'/'. $this->folder  ?>/done_export",{id:<?php  echo $result['id']?>,number:<?php  echo $result['number']?>}, function( data ) {

            });
        });
    },500)
    <?php  } ?>
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











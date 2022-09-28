




<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_network_archives/<?php   echo $from_date_stm .'/'.$to_date_stm .'/'.$number_bill ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[10]);
            },
            "order": [[ 3, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"

            },
			<?php  if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
			<?php  }  ?>
            bFilter: true, bInfo: true
        } );
    } );
</script>



<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_excel"><?php  echo $this->langControl('excel') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('excel_network_archives') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<form action="<?php echo url.'/'.$this->folder?>/archives_network" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            رقم الفاتورة
            <input autocomplete="off"  type="number" name="number_bill" class="form-control" value="<?php  echo $number_bill ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/archives_network" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>



<hr>
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th><?php  echo $this->langControl('code') ?></th>
                <th> رقم الفاتورة  </th>
                <th> الكمية  </th>
                <th>  سعر بالدولار  </th>
                <th>  نوع الرفع </th>
                <th>  تاريخ  </th>
                <th>     المستخدم </th>
            </tr>
            </thead>

        </table>

    </div>
</div>




<br>
<br>

<table class="table table-bordered">
    <thead>
    <tr>

        <th scope="col">الباركودات</th>
        <th scope="col">الكمية</th>
        <th scope="col">مجموع المبالغ بالدولار </th>
        <th scope="col">مجموع المبالغ  بالدينار </th>
    </tr>
    </thead>
    <tbody>
    <tr>

        <td> <?php echo $sumCode ?></td>
        <td> <?php echo $sumqu ?> </td>
        <td> <?php echo $amount ?> </td>
        <td> <?php echo $amountD ?> </td>
    </tr>


    </tbody>
</table>

<br>
<br>


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





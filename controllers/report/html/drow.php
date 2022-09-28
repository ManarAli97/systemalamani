


<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('report_withdrawn') ?>  </li>

            </ol>
        </nav>
        <hr>
    </div>
</div>


<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php  echo $from_date_stm ?>/<?php echo $to_date_stm ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 8, 'desc'] ],
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
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/report_withdrawn" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="datetime-local" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="datetime-local" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/report_withdrawn" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<hr>

<table  class="table table-striped display d-table" id="example">
    <thead>
    <tr>

        <th scope="col">اسم المادة   </th>
        <th scope="col"> القسم  </th>
        <th scope="col">   الكود  </th>
        <th scope="col">   السيريال  </th>
        <th scope="col">  الكمية المسحوبة  </th>
        <th scope="col">  الكمية في اكسيل السحب </th>
        <th scope="col"> الموقع </th>
        <th scope="col">   اسم الموظف الساحب  </th>
        <th scope="col">   تاريخ ووقت السحب </th>
        <th scope="col">    ملاحظة </th>


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


</style>

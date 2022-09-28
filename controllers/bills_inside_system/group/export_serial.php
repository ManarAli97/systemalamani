
<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('bills_inside_system') ?> </a></li>

                <li class="breadcrumb-item">  <?php  echo $result['name'] ?> </li>
                <li class="breadcrumb-item">   تصدير سيريلات الفواتير   </li>
            </ol>
        </nav>

    </div>

</div>
<style>
    .breadcrumb-item
    {
        word-break: break-all;
    }
</style>



<script>
    $(document).ready(function() {



        var table= $('#example').DataTable( {

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



<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">   رمز المادة </th>
        <th scope="col">    السيريل </th>

    </tr>
    </thead>

    <tbody>

    <?php  foreach ($serial as $x)   { ?>
    <?php  foreach ($x as $key => $a)   { ?>
        <tr>
            <td> <?php echo $a ?> </td>
            <td> <?php echo $key ?> </td>

        </tr>

    <?php  }  ?>
    <?php  }  ?>
    </tbody>

</table>



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











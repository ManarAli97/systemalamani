

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"> مدير المشتريات  </a></li>
                <li class="breadcrumb-item active" aria-current="page" >عرض موظفين المشتريات (المندوبين)</li>

            </ol>
        </nav>

    </div>

</div>


<script>

    $(document).ready(function() {


        $('#loadTable').DataTable( {
            "processing": true,
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 3, 'asc'] ],
            aLengthMenu: [ 10,25,100, 200,-1],
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


            }
        } );
    } );

</script>

<br>


<table class="table table-striped display d-table  set_text_table" id="loadTable">
    <thead>
    <tr>

        <th scope="col">الاسم </th>
        <th scope="col">  مجموع النقاط  </th>
        <th scope="col">   نقاط اخر عملية شراء </th>
         <th scope="col">  اضافة نقاط </th>
        <th scope="col">  عرض المشتريات </th>

    </tr>
    </thead>
    <tbody id="livesearch">
    <?php  foreach ($delegate as $result )  { ?>
        <tr>
            <td><?php echo $result['username'] ?>  </td>
            <td> <?php echo $result['sum'] ?> </td>
            <td> <?php echo $result['points'] ?>  </td>
            <td> <a href="<?php echo url .'/'.$this->folder   ?>/add_point/<?php echo $result['id'] ?>">  اضافة نقاط   </a>   </td>
            <td> <a href="<?php echo url .'/'.$this->folder   ?>/view_purchases/<?php echo $result['id'] ?>"> عرض المشتريات </a>   </td>
        </tr>
    <?php  }  ?>
    </tbody>
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

<br>
<br>
<br>
<br>


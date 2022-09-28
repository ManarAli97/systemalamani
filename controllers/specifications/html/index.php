

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('list_category') ?> </a></li>
            </ol>
        </nav>

    </div>

</div>


<script>

    $(document).ready(function() {


        $('#example_table').DataTable( {
            "processing": true,
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 0, 'asc'] ],
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


<table class="table table-striped display d-table  set_text_table" id="example_table">
    <thead>
    <tr>

        <th scope="col"># </th>
        <th scope="col">  الاقسام  </th>
        <th scope="col">   عرض المواصفات </th>


    </tr>
    </thead>
    <tbody id="livesearch">

    <?php $c=0; foreach ($this->category_website as $key => $cat )  { ?>

        <tr>
            <td> <?php  echo $c=$c+1 ?> </td>
            <td>  <?php  echo $cat ?> </td>

            <td> <a href="<?php echo url .'/'.$this->folder   ?>/list_specifications/<?php  echo $key ?>">  عرض المواصفات </a>   </td>
        </tr>
          <?php  } ?>

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


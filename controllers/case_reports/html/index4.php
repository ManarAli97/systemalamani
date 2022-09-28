


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo   $this->langControl( $model)  ?></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>




<script>
    $(document).ready(function() {

        var selected = [];

        var t=$('#example').DataTable( {

            "order": [[ 2, 'desc'] ],
            aLengthMenu: [ 10, 25, 50,100, 200, 300,-1],
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

<?php  echo $this->tab($model) ?>

<hr>
<div class="row">
    <div class="col">


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>



                <th> صورة </th>
                <th> المادة </th>
                <th>  الباركود </th>
                <th> الكمية    </th>
                <th> المواقع    </th>

            </tr>
            </thead>

            <tbody>
            <?php foreach ($data as $dt) {  ?>
                <tr>
                    <td><img width="100" src="<?php  echo $dt['image']?>"></td>
                    <td><?php  echo $dt['title']?></td>
                    <td><?php  echo $dt['code']?></td>
                    <td><?php  echo $dt['quantity']?></td>
                    <td><?php  echo $dt['location']?></td>
                </tr>
            <?php } ?>
            </tbody>


        </table>

    </div>
</div>








<style>

    .button_report
    {
        margin-bottom: 15px;
    }
    .active_case
    {
        background: #4caf50;
        border: 1px solid #4caf50;
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
</style>

<br>
<br>
<br>





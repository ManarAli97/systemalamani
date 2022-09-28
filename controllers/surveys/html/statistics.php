<link rel="stylesheet" href="<?= url ?>/controllers/surveys/css/tableStyle.css">

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view"><?php  echo $this->langControl('statistics') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >استبيان الاجهزة المستعملة</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<hr>

<div class="row">
    <div class="col">  
        <table  id="statisticsTable" class="table table-striped display d-table"  >
            <thead>
                <tr>
                    <th> السؤال </th>
                    <th> الجواب</th>
                    <th> العدد </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        var selected = [];
        $('#statisticsTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/statisticsServerSide",
            info:false,

            aLengthMenu: [ 50,100, 200, 300,-1],

            oLanguage: 
            {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            },  

            dom: 'Bfrtip',
                
            buttons: 
            [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true,    
        } );        
    });
</script>

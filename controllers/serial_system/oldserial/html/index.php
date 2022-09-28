
<script src="<?php echo $this->static_file_control ?>/datatable/js/dataTables.rowsGroup.js"></script>

<script>
    $(document).ready(function() {


        var table= $('#example').DataTable( {
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 0, 'asc'] ],
            aLengthMenu: [   50, 100,-1],
            orderCellsTop: true,
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true,
            'rowsGroup': [0,1]

        } );
    } );
</script>



<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_oldserial"><?php  echo $this->langControl('serial_system') ?> </a></li>
                 <li class="breadcrumb-item active" aria-current="page" >  مواد تأخر بيعها  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
<form action="<?php  echo url.'/'.$this->folder?>/list_oldserial" method="get">
<div class="row">
    <div class="col-auto">
        <input   placeholder="عدد اخر احدث السيريلات المباعة"  autocomplete="off" type="number" value="<?php  echo $number ?>" class="form-control" name="number" required>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">بحث</button>
        <a  type="button" href="<?php  echo url.'/'.$this->folder?>/list_oldserial" class="btn btn-warning"><i class="fa fa-refresh"></i> </a>
    </div>
</div>
</form>
<hr>
<table id="example"  class="table table-bordered   "  >
    <thead>
    <tr>
        <th> تسلسل  </th>
        <th> تاريخ تعريف السيريلات  </th>
        <th>    القسم </th>
        <th>    رمز المادة </th>
        <th> سيريلات تأخر بيعها </th>
        <th>  تاريخ احدث السيريلات المباعة </th>



    </tr>
    </thead>

    <tbody>


    <?php   foreach ($data as $index => $outDate) {  ?>

        <?php  foreach ($outDate[$outDate['normal_date']] as $key=> $serial ) {  ?>
             <tr>

                 <?php  if (0 ==0) {  ?>
                     <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>" rowsp an="<?php  echo count($outDate[$outDate['normal_date']] )?>" ><?php  echo $index+1 ?></td>
                     <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>" row span="<?php  echo count($outDate[$outDate['normal_date']] )?>" ><?php  echo $outDate['normal_date'] ?></td>
                 <?php } ?>


             <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>" ><?php  echo $this->langControl( $serial['model']) ?></td>
             <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>"><?php  echo $serial['code']?></td>
             <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>"><?php  echo $serial['serial']?></td>
             <td  class="<?php  if ($index % 2 == 0) echo 'event_row';else echo 'old_row';?>" style="border-right:1px solid #dee2e6 "><?php  echo $serial['dateLastPrepared']?></td>
            </tr>
        <?php } ?>

    <?php } ?>
    </tbody>

</table>



<style>

    .event_row
    {
        background: #f2f2f2;

    }
     .old_row
    {
        background: #ffffff;

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



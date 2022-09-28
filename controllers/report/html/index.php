<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('report_upload') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<form action="<?php echo url .'/'.$this->folder?>/report_upload" method="get">
<div class="row align-items-center x_report" >
    <div class="col-auto" >
        <select  name="cat" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <?php  foreach ($category as  $key => $catg )  { ?>
            <option value="<?php echo $key ?>"  <?php if ($key == $cat )  echo 'selected'?> >   <?php echo $this->langControl($catg) ?>  </option>
            <?php  } ?>
        </select>
    </div>
    <div class="col-auto">
      تاريخ الرفع
    </div>
    <div class="col-auto">
        <input  name="fromdate" type="date" value="<?php  echo $fromtime?>" class="form-control">
    </div>
    <div class="col-auto">
     التاريخ الحالي
    </div>
    <div class="col-auto">
        <input  name="todate" type="date" value="<?php  echo $totime?>" class="form-control">
    </div>
    <div class="col-auto">
        <input type="submit" name="submit" value="بحث" class="btn btn-success">
    </div>
    <div class="col-auto">
        <button type="button" onclick="all_data()"  class="btn btn-warning"><i class="fa fa-list"></i>  <span>عرض كل  </span> </button>
    </div>
    <div class="col-auto">
        <a type="button"  href="<?php  echo url .'/'.$this->folder ?>/report_upload" class="btn btn-primary"><i class="fa fa-refresh"></i>   </a>
    </div>
</div>
</form>
    <style>
        .x_report .col-auto
        {
            margin: 15px 0;
        }
    </style>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "processing": true,
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();
            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[12]);
            },
            "order": [[ 3, 'asc'] ],
            aLengthMenu: [ 10,25,75,100,200,-1],
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
            // <?php  //if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            // <?php  //}  ?>
            bFilter: true, bInfo: true
        } );
    } );
    function  all_data() {
        cat=$('#inlineFormCustomSelect').val();
        window.location="<?php  echo url .'/'.$this->folder ?>/report_upload/all/"+cat;
    }
</script>
<hr>
<?php  if ($all) {  ?>
    <div class="alert alert-success" role="alert">
  <strong>  <span>   <?php   echo  $this->langControl($cat) ?> </span> </strong> <i class="fa fa-caret-left"></i> <span> عرض كل منتجات القسم  التي تم طلبها والتي لم يتم طلبها  </span>
    </div>
<?php  }  ?>
<table class="table table-striped display d-table"  id="example" >
    <thead>
    <tr>
        <th scope="col">   الباركود </th>
        <th scope="col">  اسم المادة  </th>
        <th scope="col"> اللون </th>
        <th scope="col"> الذاكرة  </th>
        <th scope="col">   الكمية الحالية المتبقية </th>
        <th scope="col"> الكمية المحجوزة  </th>
        <th scope="col">    كمية تم تجهيزها بعد تاريخ الرفع </th>
        <th scope="col"> الكمية المباعة </th>
        <th scope="col">  صورة </th>
    </tr>
    </thead>
    <tbody>
    <?php  foreach ($report as $info )  { ?>
        <tr >
            <td><?php echo $info['code'] ?>  </td>
            <td><?php echo $info['name'] ?>  </td>
            <td><?php echo $info['name_color'] ?>  </td>
            <td><?php echo $info['size'] ?>  </td>
            <td>  <?php  if (!empty($info['quantity'])) echo $info['quantity']; else echo 0 ;?> </td>
            <td>   <?php  if (!empty($info['order'])) echo $info['order']; else echo 0 ;?>  </td>
            <td>   <?php  if (!empty($info['done'])) echo $info['done']; else echo 0 ;?>  </td>
            <td><?php  if (!empty($info['delivered'])) echo $info['delivered']; else echo 0 ;?>  </td>
            <td> <img style="width: 30px" src="<?php echo $info['img'] ?>">   </td>
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


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php  echo $this->langControl('winners_customers') ?></li>

            </ol>
        </nav>
        <hr>
    </div>
</div>
<form>

  <div class="form-group row">
  <div class="col-lg-3 col-md-3">
      مجاميع الكوبونات
        <select class="custom-select dropdown_filter" name="select_group" id="select_group">
            <option  value="0">اختر مجموعة</option>
			<?php foreach ($category as $key => $group) {   ?>
                <option    value="<?php  echo $group['id']?>"><?php  echo $group['name_group']?></option>
			<?php  } ?>

        </select>

    </div>
    <!-- <button type="button" id="search_group" class="btn btn-primary">بحث</button> -->
    </div>
</form>
<hr>
<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> التسلسل </th>
                <th> اسم </th>
                <th> رقم الهاتف</th>
                <th> المجموعة </th>
                <th> حالة الزبون </th>
                <th> اسم المستخدم</th>
                <th> تأريخ الاضافة </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    // $(document).ready(function () {
    //     $("#select_group").val('1').change();
    // });
     $( "#select_group" ).on('change',function() {

        var id_group = $('#select_group').val();
        if(id_group != 0){

        var table = $('#example').DataTable();
         table.destroy();
            $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing_winners_customers/"+id_group,
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();

                },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id','row_'+ aData[7]);

                },
                'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }],
                "order": [[ 0, 'desc'] ],
                aLengthMenu: [ 50,100, 200, 300,-1],
                oLanguage: {
                    sLoadingRecords: "تحميل ...",
                    sProcessing: " معالجة ...",
                    sLengthMenu: "عرض _MENU_ ",
                    sSearch: " أبحث  ",
                    oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                    sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                    sSearchPlaceholder: "البحث"


                },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
                dom: 'Bfrtip',
                buttons: [
                    'excel'  ,
                    'pageLength'
                ],
                <?php  }  ?>
                bFilter: true, bInfo: true,
            } );

        }
});


</script>

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

    #search_group{
        border-radius: 10px;
        margin-top: 24px;
        height:38px;
        width:3%;
        color: #ffff;
    }
</style>


<br>
<br>
<br>





<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_quantity/<?php echo $id ?>?from_price=<?php echo $from_price ?>&to_price=<?php echo $to_price ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
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



<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl($this->folder) ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > export excel  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>
<form action="<?php  echo url.'/'.$this->folder?>/quantity" method="get">
<div class="row">
    <div class="col-auto">

        <div class="form-group select_drop"  style="width: 100%" >
            <select name="id"  class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                <option value="all"  >    عرض الكل</option>

                <?php foreach ($data_cat as $list_cat)  {     ?>
                    <option value="<?php   echo $list_cat['id'] ?>"  <?php   if ($list_cat['id'] == $id ) echo 'selected' ?>   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>

            </select>
        </div>

    </div>
    <div class="col-auto">
        <input style="width: 210px" type="number" value="<?php echo $from_price ?>" name="from_price" class="form-control" placeholder="من سعر">
    </div>
    <div class="col-auto">
        <input style="width: 210px"  type="number"  value="<?php echo $to_price ?>" name="to_price" class="form-control" placeholder="الى سعر">
    </div>

    <div class="col-auto">
        <button type="submit"    class="btn btn-warning" >بحث</button>
    </div>

</div>
</form>
<hr>
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> اسم القسم  </th>
                <th> اسم الفئة </th>
                <th> اسم المادة </th>
                <th> لون المادة </th>
                <th> الرمز </th>
                <th> التأريخ </th>
                <th> الباركودات البديلة </th>
                <th> الكمية </th>
                <th> السعر </th>
                <th> الصورة </th>
                <th> تعديل </th>
                <th> ربط مع الواصق والحافظات </th>
                <th>  الجهار مربط مع </th>
                <th>  تحديد مواصفات </th>
                <th> مواصفات مختصره   </th>
                <th>  كلمات داله  </th>
                <th>   ننصح به  </th>


            </tr>
            </thead>

        </table>

    </div>
</div>


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






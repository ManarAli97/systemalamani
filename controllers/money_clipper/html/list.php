<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/details_money_clipper"><?php  echo $this->langControl('money_clipper') ?> </a></li>
            </ol>

        </nav>

    </div>
    <div class="col-auto">
        <div class="sumAllMoney">
            <span>   مجموع القاصة : </span> <span>  <?php  echo number_format($this->allMoney_clipper($this->id_money_clipper)) ?> </span> <span> د.ع</span>
        </div>
    </div>


</div>



<?php  if ($add==1) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         تمت اضافة مبلغ الى القاصة
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php  } ?>

<?php  if ($add==2) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        لم تتم الاضافة
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php  } ?>

<form action="<?php echo url.'/'.$this->folder?>/details_money_clipper" method="post">

    <div class="row">
        <div class="col-auto">
            اضافة مبلغ الى القاصة
            <input type="text" name="money"  onkeyup="add_comma(this)"  class="form-control"    required>
        </div>
        <div class="col-auto">
            ملاحظه
            <textarea type="text" name="note"    class="form-control"    ></textarea>
        </div>

        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-warning" >اضافة</button>
        </div>
    </div>

</form>

<br>


<script>


    function add_comma(e)
    {
        valu=$(e).val();
        $(e).val(valu.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }

</script>



<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
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
        } );
    } );
</script>


<hr>
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> مبلغ القاصة اليومي  </th>
                <th>  المبلغ المدفوع للمحاسبين الرئيسين  </th>
                <th>  المبلغ المسحوب من المحاسبين الرئيسي  </th>
                <th>  المبلغ المدفوع الى المحاسبين الثانوين    </th>
                <th>  المبلغ المسحوب  من  المحاسبين الثانوين    </th>

                <th>   مجموع المبالغ المضافة الى  المحاسبين    </th>
                <th>   مجموع المبالغ المسحوبة من المحاسبين    </th>
                <th>  باقي القاصة   </th>
                <th>    مجموع المبلغ  المسحوب من القاصه   </th>
                <th>   مجموع القاصة نهاية اليوم  </th>

                <th>  التاريخ </th>


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

<br>
<br>
<br>
<br>




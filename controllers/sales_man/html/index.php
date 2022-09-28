


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('sales_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add_shortfalls') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<form id="convert_to_employ_purchases" action="<?php  echo url .'/'.$this->folder ?>/convert_to_employ_purchases" method="post">
<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder ?>/add_manual" role="button" type="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> اضافة نواقص  </span> </a>
        <a  href="<?php echo url .'/'.$this->folder ?>/excel" role="button"  type="button"   class="btn btn-warning btn-sm"> <i class="fa fa-file-excel-o"  aria-hidden="true"></i>  <span>  رفع ملف اكسل النواقص  </span> </a>
        <button class="btn btn-info btn-sm"  type="submit"> <i class="fa fa-share"  aria-hidden="true"></i>  <span> تحويل النقوصات المحددة الى موظف المشتريات</span>     </button>
    </div>
</div>



<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[12]);
            },

            'columnDefs': [{
                "targets": [0],
                "orderable": false
            }],

            aLengthMenu: [ 50,100, 200, 300,-1],
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


            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            <?php  }  ?>
            bFilter: true, bInfo: true
        } );
    } );
</script>


<hr>

<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>  <input type='checkbox'   class="checkall" checked >  </th>
                <th>القسم</th>
                <th>اسم المادة</th>
                <th>كود</th>
                <th>اللون</th>
                <th>  اخر سعر شراء  </th>
                <th>الكمية المطلوبة</th>
                <th>ملاحظة</th>
                <th>التاريخ</th>
                <th>صورة</th>
                <th>حذف</th>
                <th>الموظف</th>
            </tr>
            </thead>

        </table>

    </div>
</div>


<div class="row justify-content-center">
    <div class="col-auto ">
        <button class="btn btn-info"   type="submit">  تحويل النقوصات المحددة الى موظف المشتريات </button>
    </div>
</div>
</form>
<script>

    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });


    $(function() {
        $("#convert_to_employ_purchases").submit(function (e) {
            e.preventDefault();
            var actionurl = e.currentTarget.action;
            $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#convert_to_employ_purchases").serialize(),
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.done) {
                        for (var prop in response.done) {
                            $('#row_'+response.done[prop]).remove();
                        }
                        alert('تم التحويل')
                    }
                    else if (response.empty)
                    {
                        alert('يرجى تحديد او اضافة نواقص الى القائمة')
                    }
                }
            })

        });
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

</style>





<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>







<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('هل انت متاكد من حذف العنصر ؟ ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_item/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>




<br>
<br>
<br>





<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('processing_report') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl('view_content') ?>  </li>
            </ol>
        </nav>

    </div>

</div>


<script>
    $(document).ready(function() {

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if (i===0 || i===1   || i===4  ) {
                $(this).html('<input class="form-control" type="text" placeholder="بحث" />');

                $('input', this).on('keyup change', function () {
                    console.log(this.value)
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }else
            {
                $(this).html('');

            }

        } );

     var table=  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_processing_report/<?php  echo $from_date_stm ?>/<?php echo $to_date_stm ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[3]);
            },
         "order": [[ 3, 'desc'] ],
         orderCellsTop: true,
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            }
            ,
         dom: 'Bfrtip',
            buttons: [
            'excel'  ,
            'pageLength'
        ],
            bFilter: true, bInfo: true
        } );
    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/list_processing_report" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="datetime-local" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="datetime-local" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/list_processing_report" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<hr>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
        <tr>
            <th scope="col">   رمز المادة  </th>
            <th scope="col">  رقم الفاتورة   </th>
            <th scope="col">    الملاحظة  </th>
            <th scope="col">    الموظف  </th>
            <th scope="col">    التاريخ والوقت  </th>
        </tr>
    </thead>
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_processing_report/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>


<script>


    function visible_processing_report(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_processing_report/"+vis+'/'+id, function(){ })
    }



</script>





<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                      <?php  echo  $this->langControl('edit') ?>
                    </span>
            </div>
            <div class="modal-body">
                <form id="edit_processing_report" action="" method="post">
                    <div class="form-group">
                        <label for="title">  <?php  echo  $this->langControl('title') ?></label>
                        <input type="text" name="title" class="title form-control title_image" id="title"  value="">
                    </div>
                    <input name="id" class="id" type="number" hidden >
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="submit" value="<?php  echo $this -> langControl('save')?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $('#exampleModal_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        $.ajax({
            url: "<?php  echo url . '/' . $this->folder?>/get_processing_report/"+id,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    modal.find('.id').val(id);
                    modal.find('.title').val(response.title);
                    modal.find('#edit_processing_report').attr("action","<?php  echo url .'/'.$this->folder?>/edit_processing_report/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_processing_report').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_processing_report').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function () {
                    $('#row_'+$('input[name="id"]').val() + ' td.title_cell').text(($('input[name="title"]').val()));
                    $('#exampleModal_edit').modal('hide')
                }
            });

        });

    });

</script>




<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_competition"> <?php  echo $this->langControl('competition') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


 <script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php  echo  $id ?>",
            info:true,

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
            },
            "order": [[ 5, 'desc'] ],
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
                sSearchPlaceholder: " البحث "

            } ,
            <?php  if ($this->permit('export_excel',$this->folder)) { ?>
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



<div class="container-fluid">
    <div class="row">
        <div class="col">
            <select class="custom-select custom-select-sm" onchange="location = this.value;">
                <?php foreach ($data_q as $list_cat)  {     ?>
                    <option value="<?php echo url .'/'.$this->folder ?>/view_competition/<?php   echo $list_cat['id'] ?>"   <?php   echo $list_cat['select'] ?> > <?php   echo $list_cat['questions'] ?> </option>
                <?php  }  ?>
            </select>
        </div>

        <div class="col-auto">

            <a  href="<?php echo url .'/'.$this->folder ?>/lot/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-spinner" aria-hidden="true"></i>  <span>   قرعة الالكترونية  </span> </a>


        </div>
    </div>
    <br>



    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>

                    <th><?php echo $this->langControl('name') ?> </th>
                    <th><?php echo $this->langControl('phone') ?> </th>
                    <th>  الاجابة  </th>
                    <th>  نتيجة الاجابة  </th>
                    <th>  نوع الاختيار  </th>
                    <th><?php echo $this->langControl('date') ?> </th>
                    <th style="text-align: center"><?php  echo $this->langControl('delete') ?></th>

                </tr>
                </thead>

            </table>

        </div>
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
    .p_nm
    {
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
        var role = button.data('role') ;
        var modal = $(this);
        if (role ==='admin')
        {
            modal.find('.modal-title').text('لا يمكن حذف المسوؤل !! ' );
            modal.find('#save').css('display','none')
        }else
        {
            modal.find('.modal-title').text('هل انت متاكد من حذف العنصر ؟ ' );
            modal.find('#save').css('display','block')

        }
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
            var  id= $('#save').val();
            $.get( "<?php echo url .'/'.$this->folder ?>/delete/"+id, function( data ) {
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide')
            });

    });
</script>


<script>





</script>




<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("input[name='"+prop+"']").addClass('error_border_red');
        }
    </script>
    <style>
        .error_border_red
        {
            border: 1px solid red !important;
            box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
        }
    </style>
<?php  } ?>

<br>
<br>
<br>


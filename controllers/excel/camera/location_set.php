




<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_camera_location_set",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[10]);
            },
            "order": [[ 1, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
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



    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_excel"><?php  echo $this->langControl('excel') ?> </a></li>
                    <li class="breadcrumb-item active"> <?php  echo $this->langControl('camera') ?>  </li>

                    <li class="breadcrumb-item active" aria-current="page" > مواد  لها مواقع   </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">


    <div class="col-lg-9">

        <a  href="<?php echo url .'/'.$this->folder ?>/add_camera" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>


    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th><?php  echo $this->langControl('code') ?></th>
                    <th> الكمية  </th>
                    <th>  سعر بالدولار  </th>
                    <th> سعر بالدينار  </th>
                    <th> رينج السعر الاقل  </th>
                    <th>  رينج السعر الاعلى  </th>
                    <th>  رقم الفاتورة    </th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th><?php  echo $this->langControl('delete') ?></th>
                    <th> المواقع </th>
                </tr>
                </thead>

            </table>

        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  توزيع المواقع </h5>

            </div>
            <div class="modal-body resultLocation">

            </div>

        </div>
    </div>
</div>
<script>

    function getLocation(model,code,q,color='') {
        $.get( "<?php  echo url  .'/'. $this->folder ?>/set_location/"+model+"/"+code+"/"+q,{color:color}, function( data ) {

            $('#exampleModalLocation').modal('show')

            $( ".resultLocation" ).html( data );
        });
    }

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_excel/"+id, function( e ) {
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }else
            {
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide')
            }

        });
    });
 </script>


<script>


    function visible_news(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_excel/"+vis+'/'+id, function(e){
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
        })
    }



</script>

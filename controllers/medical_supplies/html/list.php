

<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/medical_supplies/processing/<?php echo $id  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
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


            }
        } );
    } );
</script>



    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('medical_supplies') ?> </a></li>
                    <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                        <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                    <?php  } } ?>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">
    <div class="col-lg-3">
            <select class="custom-select custom-select-sm" onchange="location = this.value;">
                <?php foreach ($data_cat as $list_cat)  {     ?>
                <option value="<?php echo url ?>/medical_supplies/list_medical_supplies/<?php   echo $list_cat['id'] ?>"  <?php   echo $list_cat['selected'] ?>   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>
            </select>
    </div>

    <div class="col-lg-9">

        <a  href="<?php echo url ?>/medical_supplies/add_medical_supplies/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
        <a  href="<?php  echo url  ?>/medical_supplies/admin_category"  role="button"   class="btn btn-warning btn-sm"> <i class="fa fa-list" aria-hidden="true"></i> <span><?php  echo $this->langControl('show_category') ?> </span></a>
        <a  href="<?php  echo url  ?>/medical_supplies/add_category"  role="button"   class="btn btn-info btn-sm">  <i class="fa fa-folder-open-o" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_category') ?>   </span></a>


    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>   الفئة  </th>
                     <th>  السعر </th>
                     <th>  الكمية </th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th><?php  echo $this->langControl("publishing") ?> </th>
                    <th><?php  echo $this->langControl("edit") ?> </th>
                    <th><?php echo $this->langControl('delete') ?></th>

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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php echo $this->langControl('delete') ?> </button>
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
        modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url ?>/medical_supplies/delete_medical_supplies/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
 </script>


<script>


    function visible_medical_supplies(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/medical_supplies/visible_medical_supplies/"+vis+'/'+id, function(){ })
    }



</script>

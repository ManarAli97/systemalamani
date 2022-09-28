

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('list_category') ?> </a></li>
                <li class="breadcrumb-item"> <?php  echo $this->langControl($model) ?>  </li>
            </ol>
        </nav>

    </div>

</div>


    <div class="row">
        <div class="col-lg-9">
            <a  href="<?php echo url .'/'.$this->folder   ?>/add_specifications/<?php  echo $model ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
        </div>
    </div>


<script>

    $(document).ready(function() {


        $('#example_table').DataTable( {
            "processing": true,
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 0, 'asc'] ],
            aLengthMenu: [ 10,25,100, 200,-1],
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


<table class="table table-striped display d-table  set_text_table" id="example_table">
    <thead>
    <tr>

        <th scope="col"># </th>
        <th scope="col"> المواصفات </th>
        <th scope="col">    الحلة </th>
        <th scope="col">    تعديل  </th>
        <th scope="col">    حذف  </th>

    </tr>
    </thead>
    <tbody id="livesearch">

    <?php $c=0; foreach ($specif as $key => $cat )  { ?>

        <tr id="row_<?php echo $cat['id'] ?>">
            <td> <?php  echo  $key+1 ?> </td>
            <td>  <?php  echo $cat['title'] ?> </td>
               <td>
               <?php   if ($this->permit('visible',$this->folder)) { ?>
                <div style='text-align: center'>
                    <input  <?php echo  $this->ch($cat['id'])   ?>    class='toggle-demo' onchange='visible_specifications(this,<?php echo $cat['id'] ?>)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                </div>
                   <?php  } else { ?>
                   <?php echo  $this->langControl('forbidden'); ?>

                   <?php  } ?>

                </td>

            <td>
                <?php   if ($this->permit('edit_specifications',$this->folder)) { ?>
                <a href="<?php echo url .'/'.$this->folder   ?>/edit_specifications/<?php echo $cat['id'] ?>">  تعديل  </a>
                <?php  } ?>
            </td>
            <td>
                <?php   if ($this->permit('delete',$this->folder)) { ?>
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='<?php echo $cat['id'] ?>' data-title='<?php  echo $cat['title'] ?>'   >
                        <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                    </button>
                </div>
                <?php  } else { ?>
                    <?php echo  $this->langControl('forbidden'); ?>

                <?php  } ?>
            </td>
        </tr>
    <?php  } ?>

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_specifications/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>


<script>


    function visible_specifications(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_specifications/"+vis+'/'+id, function(){ })
    }



</script>
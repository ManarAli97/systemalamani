<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_lang"> <?php  echo $this->langControl('website_translation') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
    <div class="row">


        <div class="col">


            <form class="form-inline" method="post" action="<?php echo url ?>/lang/view_lang">

                <div class="form-group mx-sm-2">
                    <p class="form-control-static p_nm"><?php  echo $this->langControl('key_word') ?>  </p>

                    <label class="sr-only" for="inlineFormInput"><?php  echo $this->langControl('key_word') ?>  </label>
                    <input type="text" value="<?php echo $data['key'] ?>" name="key"
                           class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput"  placeholder="<?php  echo $this->langControl('key_word') ?> " >
                </div>

                <div class="form-group mx-sm-2">
                    <p class="form-control-static p_nm"> <?php  echo $this->langControl('arabic_translation') ?> </p>
                    <label class="sr-only" for="inlineFormInputGroup"><?php  echo $this->langControl('arabic_translation') ?> </label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input  value="<?php echo $data['ar'] ?>" type="text" name="ar" class="form-control" id="inlineFormInputGroup"
                               placeholder="<?php  echo $this->langControl('arabic_translation') ?> ">
                    </div>
                </div>
                <br>
                <br>
                <br>


                <div class="form-group mx-sm-2">
                    <p class="form-control-static p_nm"><?php  echo $this->langControl('english_translation') ?> </p>
                    <label class="sr-only" for="inlineFormInputGroup"><?php  echo $this->langControl('english_translation') ?> </label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input type="text" name="en"  value="<?php echo $data['en'] ?>" class="form-control" id="inlineFormInputGroup"
                               placeholder="<?php  echo $this->langControl('english_translation') ?> ">
                    </div>
                </div>
                <input name="submit" class="btn btn-primary" value="حفظ" type="submit">


            </form>
            <hr>
        </div>
    </div>



 <script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/lang/processing",
            info:false,

            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },
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



<div class="container-fluid">
    <br>

    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th><?php  echo $this->langControl('key_word') ?></th>
                    <th><?php echo $this->langControl('ar') ?> </th>
                    <th><?php echo $this->langControl('en') ?> </th>
                    <th style="text-align:center "><?php echo $this->langControl('edit') ?> </th>
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
        var role = button.data('role') ;
        var modal = $(this);
        if (role ==='admin')
        {
            modal.find('.modal-title').text('<?php echo $this->langControl("the_administrator_can_not_delete"); ?> !! ' );
            modal.find('#save').css('display','none')
        }else
        {
            modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
            modal.find('#save').css('display','block')

        }
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
            var  id= $('#save').val();
            $.get( "<?php echo url ?>/lang/delete/"+id, function( data ) {
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide')
            });

    });
</script>


<script>


    function visible_news(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/dashbord/visible_news/"+vis+'/'+id, function(){ })
    }



</script>




<?php if(!empty($this->error_form ))  { ?>
    <script>  $(document).ready(function() { $("#errorMsg").modal("show")  }); </script>

    <div class="modal fade" id="errorMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php  echo $this->langControl('error');?></h5>

                </div>
                <div class="modal-body">
                    <?php $i=1; foreach($this->error_form as $key => $error)  { ?>

                        <p> <span> <?php  echo $i;  ?> . </span> <?php  echo   $error ?> </p>

                        <?php  $i++; } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> اغلاق </button>

                </div>
            </div>
        </div>
    </div>

<?php  } ?>

<br>
<br>
<br>


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/group"><?php  echo $this->langControl('group_user') ?> </a></li>

            </ol>
        </nav>


        <hr>
    </div>
</div>
<div class="row  ">


    <?php foreach ($data as $cat) { ?>



        <div class="col-auto" id="card_<?php echo $cat['id'] ?>">
            <div class="card" >
                <a  href="<?php echo url ?>/user/list_user/<?php echo $cat['id'] ?>">
                    <img class="card-img-top  image_group" src="<?php echo $cat['image'] ?>" alt="Card image cap">
                </a>
                <div class="card-body">
                    <p class="card-text">
                        <span> <?php echo $cat['name']?>  </span>

                    </p>
                    <div class="dropdown-divider"></div>
                    <?php  if ($this->permit('control_category',$this->folder)) { ?>
                    <div class="row justify-content-end">
                        <div class="col-4">


                            <div class="btn-group dropup">
                                <button   class="btn  btn_edit"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fa fa-cog" style="font-size:36px;color: green"></i></button>

                                <div class="dropdown-menu" >
                                    <a class="dropdown-item" href="<?php echo url ?>/user/edit_group/<?php echo $cat['id'] ?>">تعديل المجموعة</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo url ?>/user/list_user/<?php echo $cat['id'] ?>">عرض المستخدمين</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo url ?>/permit/admin_permit/<?php echo $cat['id'] ?>">تصاريح المجموعة  </a>
                                </div>
                            </div>

                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn_delete"    data-toggle="modal" data-target="#exampleModal" data-whatever="<?php  echo $cat['id']  ?>" data-title="<?php echo $cat['name']?> "> <i class="fa fa-trash-o" style="font-size:36px"></i></button>
                        </div>
                        <div class="col-4">
                            <input  <?php  echo $cat['checked'] ?>  onchange="vis_cat(this,<?php echo $cat['id']?>)" type="checkbox"   class="vis"     data-on="On" data-off="Off" id="toggle-event"  data-toggle="toggle" datax-stylex="iosx" data-onstyle="success" data-size="small">
                        </div>
                    </div>
                    <?php  } ?>
                </div>
            </div>

        </div>


    <?php } ?>

</div>



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
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->langControl('close') ?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php echo $this->langControl('delete') ?> </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('<?php  echo $this->langControl("are_you_sure") ?> ? ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.post( "<?php echo url ?>/user/deleteGroup/"+id, function( data ) {
            $('#card_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });


    function vis_cat(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/user/visible_group/"+vis+'/'+id, function(){ })
    }



</script>

<style>
    .image_group
    {
        width: 255px;
        height: 255px;
    }
</style>

<!--<div class="container">-->
<!--    <div class="row justify-content-md-center ">-->
<!--        <div class="col-md-auto">-->
<!--            <a role="button" href="--><?php //echo url ?><!--/dashbord/add_category" class="btn btn-primary">اضافة قسم </a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

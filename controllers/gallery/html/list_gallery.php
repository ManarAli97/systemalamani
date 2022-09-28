

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl('gallery') ?> </a></li>
                <?php if ($breadcumbs){ foreach ($breadcumbs as $key => $bc) {   ?>
                    <li class="breadcrumb-item"><a href="<?php  echo $bc ?>"><?php echo $key ?></a></li>
                <?php  } } ?>
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('view_gallery') ?>  </li>
            </ol>
        </nav>

    </div>
</div>



<div class="row">
    <div class="col-lg-3">
            <select class="custom-select custom-select-sm" onchange="location = this.value;">
                <?php foreach ($data_cat as $list_cat)  {     ?>
                <option value="<?php echo url ?>/gallery/list_gallery/<?php   echo $list_cat['id'] ?>"  <?php   echo $list_cat['selected'] ?>   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>
            </select>
    </div>

    <div class="col-auto mr-auto">

        <a  href="<?php echo url ?>/gallery/add_gallery/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> <?php  echo $this->langControl('add_images') ?>   </span> </a>
        <a  href="<?php  echo url  ?>/gallery/admin_category"  role="button"   class="btn btn-warning btn-sm"> <i class="fa fa-list" aria-hidden="true"></i> <span>  <?php  echo $this->langControl('show_category') ?> </span></a>
        <a  href="<?php  echo url  ?>/gallery/add_category"  role="button"   class="btn btn-info btn-sm">  <i class="fa fa-folder-open-o" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_category') ?>   </span></a>


    </div>
    <div class="col-auto">
        <input type="checkbox"  onchange="active_all_image(this)"    <?php echo $public ?> data-toggle="toggle" data-on="<?php  echo $this->langControl('hidden_all'); ?>" data-off="<?php  echo $this->langControl('posted_all'); ?> " data-onstyle="success" data-offstyle="danger" datax-stylex="iosx" data-size="small">

    </div>


</div>
<hr>

    <div  id="results"></div>
<script src="<?php echo $this->static_file_control ?>/js/pagenation/twbsPagination.js"></script>

<div class="row justify-content-center" >
    <div class="col-auto">
        <ul id="pagination-demo" class="pagination "></ul>
    </div>
</div>


<script>

    $('#pagination-demo').twbsPagination({
        totalPages: <?php echo $count ?>,
        startPage: <?php echo $page ?>,
        visiblePages: 5,
        initiateStartPageClick: true,
        href: false,
        hrefVariable: '{{number}}',
        first: 'الاول',
        prev: '&laquo;',
        next: '&raquo;',
        last: 'الاخير',
        loop: false,
        onPageClick: function (event, page) {
            $('.page-active').removeClass('page-active');
            $('#page'+page).addClass('page-active');

            $.get("<?php  echo url .'/'.$this->folder ?>/ajax/<?php echo $id ?>/"+page, function (data) {
                 $('#results').empty().html(data);
                // window.location.replace(");
                // window.history.pushState({page: "another"}, "another page", "<?php // echo url . '/' . $this->folder ?>///list_gallery/<?php //echo $id ?>///"+page);
                $(".vis").bootstrapToggle();
            });

        },
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled'

    });



</script>





<style>


    .container {
        margin-top: 20px;
    }
    .page {
        /*display: none;*/
    }
    .page-active {
        display: block;
    }
    .page.active a
    {
        background: #007bff;
        color: #FFFFFF;
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
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php  echo $this -> langControl('delete')?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php  echo $this -> langControl('close')?> </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                      <?php  echo  $this->langControl('edit') ?>
                    </span>
                    <img id="image_edit" style="float: left;width:62px;border: 1px solid;padding: 0;"   class="col-auto">
            </div>
            <div class="modal-body">
                <form id="edit_image" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputTitle">  <?php  echo  $this->langControl('title_image') ?></label>
                        <input type="text" name="title" class="form-control title_image" id="exampleInputTitle"  value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputurl">   رابط  </label>
                        <input type="text" name="url" class="form-control url" id="exampleInputurl"  value="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputDescription">  <?php  echo  $this->langControl('description') ?></label>
                        <textarea name="description"  class="form-control description_image" id="exampleInputDescription"></textarea>
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
            url: "<?php  echo url . '/' . $this->folder?>/getImageById/"+id,
            cache: false,
            success: function(data){
                if (data)
                {
                   var  response = JSON.parse(data);
                    modal.find('.id').val(id);
                    modal.find('.title_image').val(response.normal_name);
                    modal.find('.url').val(response.url);
                    modal.find('.description_image').val(response.description);
                    modal.find('#image_edit').attr("src","<?php echo $this->save_file .'/' ?>"+response.rand_name);
                    modal.find('#edit_image').attr("action","<?php  echo url .'/'.$this->folder?>/edit_image/"+id);
                }
            }
        });
    });


    $(function () {
        $('#edit_image').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_image').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function () {
                     $('#_img_'+$('input[name="id"]').val()).text(($('input[name="title"]').val()));
                    $('#exampleModal_edit').modal('hide')
                }
            });

        });

    });

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
        $.post( "<?php echo url ?>/gallery/delete_image/"+id, function( data ) {
            $('.card_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });


    function active_image(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        if(vis===1)
        {
            $('#img_active_'+id).css('opacity', '1');
        }else{
            $('#img_active_'+id).css('opacity', '0.2');
        }
        $.get("<?php echo url ?>/gallery/active_image/"+vis+'/'+id, function(){ })
    }


    function active_all_image(e) {
        var vis=$(e).is( ':checked' )? 1:0;

        if(vis===1)
        {
            $('.vis').bootstrapToggle('on');
        }else
        {
            $('.vis').bootstrapToggle('off');
        }
        $.get("<?php echo url ?>/gallery/active_all_image/"+vis, function(){ })
    }



</script>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
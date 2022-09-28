

<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_stopped/<?php  echo $model ?>/<?php  echo $id ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[9]);
            },
            "order": [3, 'desc'],
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
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_computer_assembly"><?php  echo $this->langControl('computer_assembly') ?> </a></li>
                    <?php  echo $category ?>
                     <li class="breadcrumb-item active" aria-current="page" > تجميعات  متوقفة </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>







<form action="<?php  echo  url .'/'.$this->folder ?>/list_computer_assembly_stopped" method="get">
    <div class="container-fluid" id="expand_menu">
        <div class="row">

            <select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)" required>
                <option value="" disabled selected>  اختر الفئة الرئيسية  </option>
                <?php  foreach ($this->category_website as $key => $cg) {   ?>
                    <option value="<?php  echo $key ?>"     > <?php  echo $cg ?></option>
                <?php  } ?>
                <option <?php if ($model=='double_computer_assembly')  echo 'selected' ?>  value="double_computer_assembly"  >عروض متنوعه</option>
            </select>

            <div class="col-auto">

                <button class="btn btn-info" type="submit" >   <span>بحث </span> <i class="fa fa-search"></i> </button>
                <a onclick="window.location='<?php  echo url .'/'. $this->folder ?>/list_computer_assembly'" class="btn btn-warning" >  <i class="fa fa-refresh"></i> </a>
            </div>

        </div>

    </div>

</form>

<script>



    function mainCatgHtmlx(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;

        if (value !== 'savers' && value !== 'double_computer_assembly'  )
        {
            $.get("<?php echo url . '/' . $this->folder ?>/getMainCatDB/" +value, function (data) {
                if (data)
                {
                    $('#'+id_html).nextAll('select').remove();
                    $('#'+id_html+':last').after(data);
                }
                else
                {
                    alert('حدث خطاء في الاختيار يرجى تحديث الصفة او المحاولة لاحقا')
                }
            });
            pathCatg();

        }else
        {
            $('#'+id_html).nextAll('select').remove();
        }

    }


    function sub_catgs(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;
        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function sub_catgs2(selectObject) {
        var value = selectObject.value;
        var id_html = selectObject.id;

        $.get("<?php echo url . '/' . $this->folder ?>/sub_catgs2/" + value, function (data) {
            if (data)
            {
                $('#'+id_html).nextAll('select').remove();
                $('#'+id_html+':last').after(data);
            }
            else
            {
                $('#'+id_html).nextAll('select').remove();
            }
        });
        pathCatg();
    }



    function pathCatg() {
        var d = $('#expand_menu select option:selected').map(function () {
            return $(this).text();
        });

        p=d[0];
        for (i = 1; i < d.length; i++)
        {
            p+=" / "+d[i];
        }
        $('#path_catg').val(p)
    }

</script>



<style>

    .list_menu_categ
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }
    .list_menu_categ:focus
    {
        border-radius: 0;
        outline: none;
        box-shadow: unset;
    }


    .x_down div
    {
        margin-bottom: 30px;
    }
    .code_m
    {
        margin-top: 15px;
    }
    button.btn.add_new_sub_row {
        padding: 0;
        background: transparent;
        color: #218838;
        font-size: 25px;
    }
    button.btn.remove_sub_row {
        padding: 0;
        background: transparent;
        color: red;
        font-size: 25px;
    }

    .remove_div
    {
        position: absolute;
        left: 13px;
        padding: 0;
        top: -14px;
        background: #f5f6f7;
        border: 0;
    }

    .remove_div i
    {
        color: red;
        font-size: 28px;
    }
    .addPs
    {
        color: #FFFFFF !important;
    }
    .x_down
    {
        position: relative;
        margin-bottom: 25px;
        border: 1px solid #eeeff0;
        border-bottom: 1px solid #d5d7d8;
        padding: 22px;
        padding-bottom: 15px;
        background: #eeeff08a;
    }
</style>






<hr>
<div class="row">


    <div class="col-lg-9">

        <a  href="<?php echo url .'/'.$this->folder ?>/add" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> اضافة تجميعة  </span> </a>


    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th><?php  echo $this->langControl('title') ?></th>
                    <th>    سعر التجميعة   (دولار) </th>
                    <th>     سعر التجميعة  (دينار) </th>


                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>    الملاحظة  </th>
                    <th>الحالة</th>

                    <th><?php  echo $this->langControl('edit') ?></th>
                     <th><?php  echo $this->langControl('delete') ?></th>
                    <th>   كتابة ملاحظة </th>

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
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>







<script>


    function saveNote(id) {
        var note=$('#add_note_'+id).val();

        $.get( "<?php  echo url .'/'.$this->folder ?>/save_note",{id:id,note:note}, function( data ) {
            if (data === '1'){
                $("#note_"+id).html(note);

            }

        });



    }

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_computer_assembly/"+id, function( e ) {
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
        $.get("<?php echo url .'/'.$this->folder ?>/visible_computer_assembly/"+vis+'/'+id, function(e){

            if (vis === 1 )
            {

                $("#add_note_"+id).attr('readonly', 'readonly');
            }else
            {
                $("#add_note_"+id).removeAttr('readonly');
            }

            if (e === '01')
            {
                $("#add_note_"+id).removeAttr('readonly');
                alert('لا يمكن تفعيل التجميعة . نفذت كمية بعض المواد مع بدائلها ');
                $('#toggle-computer_assembly'+id).prop('checked', false).change()

            }
        })
    }




</script>

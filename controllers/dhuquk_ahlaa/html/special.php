

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_dhuquk_ahlaa"><?php  echo $this->langControl('dhuquk_ahlaa') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('special') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder ?>/add" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>
    </div>
</div>

<hr>

<script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>



<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            rowReorder: true,
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            order: [0, 'asc'],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            }

        } );


    } );


</script>


<table id="example"  style="width:100%"   class="table table-striped display d-table"  >
    <thead>
    <tr>


        <th  data-toggle="tooltip" data-placement="top" title="تحريك سحب وافلات" style="background: #007aff2b;">  <i class="fa fa-sort"></i> </th>
        <th>عنوان</th>
        <th> تاريخ النشر </th>
        <th> من تاريخ </th>
        <th> الى تاريخ </th>
        <th>الحالة</th>
        <th><?php  echo $this->langControl('special') ?></th>
        <th>تعديل</th>
        <th>حذف</th>
        <th style="display: none">المعرف</th>


    </tr>
    </thead>
    <tbody>

        <?php   foreach ($special as $key => $start) {  ?>
        <tr id="row_<?php echo $start['id']  ?>" role="row" >
        <td class="sort_key" style="cursor:move;background: #007aff2b;"><?php echo $key+1  ?></td>
        <td><?php echo $start['title']  ?></td>
        <td class="sorting_1"><?php echo date('Y-m-d',$start['date']);   ?></td>
        <td class="sorting_1"><?php echo date('Y-m-d',$start['fromDate']);   ?></td>
        <td class="sorting_1"><?php echo date('Y-m-d',$start['toDate']);   ?></td>
        <td>
            <?php   if ($this->permit('visible','special_offers')) { ?>
            <div style='text-align: center'>
                <input <?php echo $this->ch($start['id']) ?> class='toggle-demo' onchange='visible_news(this,"<?php echo $start['id']  ?>")' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
            </div>
            <?php  } ?>
        </td>
        <td>
          <?php   if ($this->permit('special','special_offers')) { ?>
            <div style='text-align: center'>
                <input <?php  echo $this->ch_special($start['id']) ?> class='toggle-demo' onchange='visible_special(this,"<?php echo $start['id']  ?>")' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
            </div>

            <?php  } ?>
        </td>

        <td>
            <?php  if ($this->permit('edit','special_offers')) { ?>
            <div style='text-align: center;font-size: 23px;'>
                <a href="<?php echo  url."/".$this->folder ?>/edit/<?php  echo $start['id']  ?>"> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
            </div>
            <?php  } ?>
        </td>
        <td>
           <?php  if ($this->permit('delete_dhuquk_ahlaa','special_offers')) { ?>
            <div style='text-align: center'>
                <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='<?php  echo $start['id']   ?>' data-title='<?php  echo $start['title']  ?>'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                </button>
            </div>
           <?php  } ?>
        </td>
    <td  style="display: none" class="id_key"> <?php echo $start['id']  ?></td>

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


<div id="snackbar">تم الحفظ</div>
<div class="fixed-bottom"> <div class="center_button text-center">

        <button class="btn btn-warning" onclick="save_sort()" data-toggle="tooltip" data-placement="right" title="حفظ الترتيب"> <i class="fa fa-save"></i>  </button>
        <a class="btn btn-danger" href="<?php  echo url .'/'.$this->folder?>/list_special_offers" data-toggle="tooltip" data-placement="left" title="رجوع الى القاعدة"><i class="fa fa-reply"></i> </a>

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_dhuquk_ahlaa/"+id, function( e ) {
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

    function visible_news(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_dhuquk_ahlaa/"+vis+'/'+id, function(e){
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
        })
    }


    function visible_special(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_special/"+vis+'/'+id, function(e){
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }
        })
    }


    function save_sort() {
        var myTableArray_sort_key = [];
        $("table#example tbody tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td.sort_key');
            if (tableData.length > 0) {
                tableData.each(function() { arrayOfThisRow.push($(this).text()); });
                myTableArray_sort_key.push(arrayOfThisRow);
            }
        });


        var myTableArray_id_key = [];
        $("table#example tbody tr").each(function() {
            var arrayOfThisRow = [];
            var tableData = $(this).find('td.id_key');
            if (tableData.length > 0) {
                tableData.each(function() { arrayOfThisRow.push($(this).text()); });
                myTableArray_id_key.push(arrayOfThisRow);
            }
        });



        $.ajax({
            type: "POST",
            url: "<?php  echo url .'/'.$this->folder ?>/save_sort",
            data: { myTableArray_sort_key: myTableArray_sort_key,myTableArray_id_key:myTableArray_id_key },
             success: function(data) {
                if (data)
                {
                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                }

            }
        });


    }

</script>


<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.bootstrap4.min.css">

<br>
<br>
<br>
<br>






<script>
    $(document).ready(function() {



       var t = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php echo $cat ?>/<?php echo  $type ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[10]);
            },
            "order": [[ 0, 'asc'] ],
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
            <?php  if ($this->permit('export_excel',$this->folder)) { ?>dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            <?php  }  ?>bFilter: true, bInfo: true
        } );


       t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();



    } );
</script>



    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/add"><?php  echo $this->langControl('compare_warehouses') ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row">


    <div class="col-lg-9">

        <a  href="<?php echo url .'/'.$this->folder ?>/add" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>  <span>    رفع ملف اكسيل لمقارنة المستودعات </span> </a>

    </div>
</div>
<br>
<div class="row">
    <div class="col-auto" >

        <select  name="cat" class="custom-select mr-sm-2"  id="category_system" required>
			<?php  foreach ($this->category_website as  $key => $catg )  { ?>
                <option   <?php if ($key==$cat) echo 'selected'?> value="<?php echo $key ?>"   >   <?php echo $this->langControl($catg) ?>  </option>
			<?php  } ?>
        </select>

    </div>
    <div class="col-auto">
        نوع المقارنة
    </div>


    <div class="col-auto">
        <div class="custom-control custom-radio custom-control-inline">
            <input    type="radio" id="customRadioInline1" value="1"  <?php if ($type==1) echo 'checked'?>  name="type" class="custom-control-input" required>
            <label class="custom-control-label" for="customRadioInline1">  الباركود  </label>
        </div>
        <div class="custom-control custom-radio  custom-control-inline">
            <input   type="radio" id="customRadioInline2"  value="2" <?php if ($type==2) echo 'checked'?>   name="type" class="custom-control-input" required>
            <label class="custom-control-label" for="customRadioInline2">  الباركود + الون  </label>
        </div>
    </div>
    <div class="col-auto">
        <button onclick="search_c_w()" class="btn btn-primary">بحث</button>
    </div>

<script>
    function search_c_w() {
       var cat= $('#category_system option:selected').val();
        var type= $('input[name="type"]:checked').val();
        var href="<?php   echo url .'/'.$this->folder ?>/index/"+cat+"/"+type;
         window.location=href;
    }

</script>
</div>
<br>
<h6><span>تاريخ اخر رفع :</span> <span><?php echo $last_upload  ?> </span> </h6>
<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>#</th>
                    <th>الصوره</th>
                    <th><?php  echo $this->langControl('code') ?></th>
                    <th> الاسم  </th>
                    <th>  اللون    </th>
                    <th>  الكمية الحالية    </th>
                    <th>  الكمية   المحجوزة  </th>
                    <th>  الكمية المباعة    </th>
                    <th>  ملاحظة    </th>
                    <th>  ننصح به    </th>

                    <?php  foreach ( $number as $c) {  ?>
                    <th>   الكمية من مستودع <?php echo $c ?> </th>
                    <?php   }  ?>
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
        $.get( "<?php  echo url  .'/'. $this->folder ?>/set_location/"+model+"/"+code+"/"+q+"/"+color, function( data ) {

            $('#exampleModalLocation').modal('show')

            $( ".resultLocation" ).html( data );
        });
    }
    function saveNote(id) {
       var note=$('#add_note_'+id).val();

            $.get( "<?php  echo url .'/'.$this->folder ?>/save_note",{id:id,note:note}, function( data ) {


                    $("#note_"+id).html(note);

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

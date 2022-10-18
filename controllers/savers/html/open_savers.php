

<script>
    var  table;
    $(document).ready(function() {

        var selected = [];

        table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/savers/processing_open_savers/<?php echo $id ?>/<?php echo $type ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();
            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[12]);
            },
            "order": [[ 0, 'desc'] ],
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
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
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
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" >  عرض الحافظات  </li>

                </ol>
            </nav>


            <hr>
        </div>
    </div>







<div class="row align-items-end">

    <div class="col-lg-3 col-md-3">
        الماركة
        <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brand()"   required>
            <option>   اختر الماركة </option>
			<?php foreach ($category as $key => $catg) {   ?>
                <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
			<?php  } ?>

        </select>
    </div>
    <div class="col-lg-2 col-md-2">
        السلسلة
        <select onchange="typeDevice_public()" class="custom-select dropdown_filter" name="nameDevice_public"   id="nameDevice_public" required>
            <option>   اختر السلسلة </option>
        </select>
    </div>


    <div class="col-lg-3 col-md-3">
        الجهاز
        <select    class="custom-select dropdown_filter"   id="typeDevice_public" required>

            <option>   اختر الجهاز  </option>
        </select>
    </div>

    <div class="col-lg-2 col-md-2">
        النوع
        <select id="type_cover"   class="custom-select dropdown_filter"     required>

            <option <?php  if ($type=='all') echo 'selected' ?>  value="all" >الكل</option>
            <option  <?php  if ($type=='ml') echo 'selected' ?>  value="ml" >   رجالي  </option>
            <option <?php  if ($type=='fm') echo 'selected' ?>  value="fm" >   نسائي  </option>

        </select>
    </div>


    <div class="col-lg-2 col-md-2">
        <button  class="btn  btn_search_filter" onclick="colorDevice_public()"    >  عرض الحافظات </button>
    </div>

</div>
<script>

    $(document).ready(function(){

        $("#brand option").each(function(){
            if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                $(this).attr("selected","selected");
                brand();
            }
        });
    });


    function brand() {


        $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
            $('#nameDevice_public').html(data);

            if (data)
            {

                $("#nameDevice_public option").each(function(){
                    if($(this).val()===localStorage.getItem("cats2admin")){ // EDITED THIS LINE
                        $(this).attr("selected","selected");
                    }
                });

                typeDevice_public($('#brand option:selected').val())


            }
        });

        localStorage.setItem("cats1admin",  $('#brand option:selected').val() );


    }

    function typeDevice_public() {

        $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
            $('#typeDevice_public').html(data);



            cats3="<?php  echo $id ?>";
            $("#typeDevice_public option").each(function(){
                if($(this).val()===cats3){ // EDITED THIS LINE
                    $(this).attr("selected","selected");
                }
            });

        });

        localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

    }

    function colorDevice_public() {

        if ($('#brand option:selected').val())
        {
          var  type=$('#type_cover option:selected').val();
            window.location="<?php echo url . '/' . $this->folder ?>/open_savers/"+$('#typeDevice_public option:selected').val()+"/"+type

        }else {
            alert('يجب اختيار الماركة')
        }


    }


</script>








<div class="row">

    <div class="col-lg-9">
        <a  href="<?php echo url ?>/savers/add_product_savers/<?php echo $id ?>" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span><?php  echo $this->langControl('add_content') ?>  </span> </a>

    </div>
</div>

<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>عنوان او اسم الحافظة</th>
                    <th>الرمز</th>
                    <th>الكمية</th>
                    <th>الاسم الاتيني</th>
                    <th> اسم المجموعة</th>
                    <th>نوع الجهاز</th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>صورة</th>
                    <th>الحالة</th>

                    <th>تعديل</th>
                  <th>تكرار</th>
                    <th>حذف</th>

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



    function copy_row(id) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get("<?php  echo url.'/'.$this->folder?>/copy_row/"+id, function(data){
                if (data)
                {
                    alert('تم التكرار')
                    table.draw()

                }
            })
        }

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
        $.get( "<?php echo url ?>/savers/delete_savers_product_savers/"+id, function( data ) {
            console.log(data);
            if(data == 1){
                $('#row_'+id).remove();
                $('#exampleModal').modal('hide');
            }else{
                alert('لا يمكن حذف الباركود لانه يحتوي على كمية');
            }
        });
    });
 </script>


<script>


    function visible_savers(e,id) {

        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/savers/visible_savers_product_savers/"+vis+'/'+id, function(data){
            console.log(data)
        })
    }



</script>

    <style>
    .dropdown_filter
    {
        border: 2px solid #495678;
        border-radius: 0;
        margin-bottom: 15px;
    }

    .btn_search_filter
    {
        border: 2px solid #495678;
        border-radius: 0;
        width: 100%;
        margin-bottom: 15px;
        background: #495678;
        color: #ffff;
    }

</style>

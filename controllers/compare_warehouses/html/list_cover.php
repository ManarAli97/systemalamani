




<script>
    $(document).ready(function() {



       var t = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_cover/<?php echo $brand ?>/<?php echo $series ?>/<?php echo $id_device ?>/<?php echo $cov ?>/<?php echo $typ ?>/<?php echo $feat ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[13]);
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

                    <li class="breadcrumb-item active" aria-current="page" >  الحافظات </li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row justify-content-between">


    <div class="col-auto">

        <a  href="<?php echo url .'/'.$this->folder ?>/add_cover" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>  <span>    رفع ملف اكسيل  حافظات لمقارنة المستودعات </span> </a>

    </div>

    <div class="col-auto">
        <input <?php  if ($this->setting->get('type_cover',1) == 1 )  echo  'checked' ?>  class='toggle-demo' onchange='column_type_cover(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
          نوع المادة     /
            نوع الحافظة   /
             الميزة
    </div>
    <script>
        function column_type_cover(e) {
            var vis=$(e).is( ':checked' )? 1:0;
            $.get("<?php echo url .'/'.$this->folder ?>/column_type_cover/"+vis, function(data){

                if (data)
                {
                    window.location=''
                }
            })
        }
        </script>

    <div class="col-auto">

        <?php 	if ($this->permit('delete_all', $this->folder)) { ?>
            <div class="text-left">
                <button class="btn btn-danger" onclick="delete_all('savers')"> <i class="fa fa-trash"></i> <span>حذف الكل</span></button>
            </div>

        <?php }  ?>
    </div>
</div>
<br>
<script>

    function delete_all(model) {

        if (confirm('هل انت متأكد؟'))
        {
            $.get( "<?php echo url .'/'.$this->folder ?>/delete_all/"+model, function( data ) {
                if (data)
                {
                    window.location=''
                }else {
                    alert('فشل الحذف')
                }
            });
        }



    }


</script>


<div class="row align-items-center">

    <div class="col-lg-3 col-md-3 mb-3">
        الماركة
        <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brand()"   required>
            <option value="0">   اختر الماركة </option>
            <?php foreach ($category as $key => $catg) {   ?>
                <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
            <?php  } ?>

        </select>
    </div>
    <div class="col-lg-2 col-md-2 mb-3">
        السلسلة
        <select onchange="typeDevice_public()" class="custom-select dropdown_filter" name="nameDevice_public"   id="nameDevice_public" required>
            <option value="0">   اختر السلسلة </option>
        </select>
    </div>


    <div class="col-lg-3 col-md-3 mb-3">
        الجهاز
        <select    class="custom-select dropdown_filter"   id="typeDevice_public" required>

            <option value="0">   اختر الجهاز  </option>
        </select>
    </div>


    <link href="<?php echo $this->static_file_control ?>/js/select2/select2.min.css" rel="stylesheet"/>
    <script src="<?php echo $this->static_file_control ?>/js/select2/select2.min.js"></script>



    <div class="col-lg-2 col-md-2 mb-3">
        نوع المادة
        <select   id="cover_material" class="form-control   js-example-tags">
            <option value="0" selected >اختر</option>
            <?php  foreach ($cover_material as $covm)  { ?>
                <option  <?php  if (  $covm['number']  == $cov)  echo 'selected' ?>  class="text-right"  value="<?php  echo $covm['number']  ?>"><?php  echo $covm['number'].'-'.$covm['cover_material'] ?></option>
            <?php } ?>
        </select>
    </div>


    <div class="col-lg-2 col-md-2 mb-3">
        نوع الحافظة
        <select  id="type_cover" class="form-control js-example-tags">
            <option value="0" selected >اختر</option>
            <?php  foreach ($type_cover as $tpc)  { ?>
                <option  <?php  if (  $tpc['number']  == $typ)  echo 'selected' ?>  class="text-right"  value="<?php  echo $tpc['number']  ?>"><?php  echo $tpc['number'].'-'.$tpc['type_cover'] ?></option>
            <?php } ?>
        </select>
    </div>


    <div class="col-lg-2 col-md-2 mb-3">
      الميزة
        <select   id="feature_cover" class="form-control js-example-tags">
            <option value="0" selected >اختر</option>
            <?php  foreach ($feature_cover as $feac)  { ?>
                <option  <?php  if (  $feac['number']  == $feat)  echo 'selected' ?>  class="text-right"  value="<?php  echo $feac['number']  ?>"><?php  echo $feac['number'].'-'.$feac['feature_cover'] ?></option>
            <?php } ?>
        </select>
    </div>


    <div class="col-lg-2 col-md-2">
        <button  class="btn btn-primary btn_search_filter" onclick="colorDevice_public()"    >   بحث   </button>
    </div>

</div>


<style>

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 35px;
    }

    .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
        padding-right: 8px;
        padding-left: 20px;
        padding-top: 4px;
    }
</style>

<script>

    $(".js-example-tags").select2({
        tags: true
    });

    $(document).ready(function(){

        $("#brand option").each(function(){
            if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                $(this).attr("selected","selected");
                brand();
            }
        });
    });


    function brand() {


        $.get("<?php echo url .'/'.$this->folder ?>/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
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

        $.get("<?php echo url .'/'.$this->folder ?>/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
            $('#typeDevice_public').html(data);

            cats3="<?php  echo $id_device ?>";
            $("#typeDevice_public option").each(function(){
                if($(this).val()===cats3){ // EDITED THIS LINE
                    $(this).attr("selected","selected");
                }
            });

        });

        localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

    }

    function colorDevice_public() {

        var brand=$('#brand option:selected').val();
        if (brand)
        {
            var series=$('#nameDevice_public option:selected').val();
            var id_device=$('#typeDevice_public option:selected').val();

            var  cover_material=$('#cover_material option:selected').val();
            var  type_cover=$('#type_cover option:selected').val();
            var  feature_cover=$('#feature_cover option:selected').val();
            window.location="<?php echo url . '/' . $this->folder ?>/cover/"+brand+"/"+series+"/"+id_device+"/"+cover_material+"/"+type_cover+"/"+feature_cover

        }else {
            alert('يجب اختيار الماركة')
        }


    }


</script>







<br>
<h6><span>تاريخ اخر رفع :</span> <span><?php echo $last_upload  ?> </span> </h6>
<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>#</th>

                    <th><?php  echo $this->langControl('code') ?></th>
                    <th> الاسم  </th>
                    <th>الصوره</th>
                    <th>  ملاحظة    </th>
                    <th>   <span> الاسم الاتيني</span>  <span>(<?php  echo $total ?>)</span> </th>
                   <?php         if ($this->setting->get('type_cover',1) == 1) { ?>
                    <th>  نوع المادة   </th>
                    <th>   نوع الحافظة  </th>
                    <th>   الميزة  </th>
                  <?php } ?>
                    <th>  التصنيف   </th>
                    <th>  تاريخ رفع الحافظة   </th>
                    <th>  الكمية الحالية    </th>
                    <th>  الكمية   المحجوزة  </th>
                    <th>  الكمية المباعة    </th>


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
    function saveNote(e,code) {
       var note=$(e).val();

            $.get( "<?php  echo url .'/'.$this->folder ?>/save_note",{code:code,note:note}, function( data ) {

                    $(".note_"+code).html(note);

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


    function cover_material(e,code) {
       var value=$(e).val();
        $.get( "<?php echo url .'/'.$this->folder ?>/update_cover_material/"+value+'/'+code, function( data ) {

            if (data)
            {

            }
        });
    }
    function type_cover(e,code) {
       var value=$(e).val();
        $.get( "<?php echo url .'/'.$this->folder ?>/update_type_cover/"+value+'/'+code, function( data ) {

            if (data)
            {

            }
        });
    }

    function feature_cover(e,code) {

        var val = [];
        $('.feature_cover_'+code+':checked').each(function(i){
            val[i] = $(this).val();
        });

        $.get( "<?php echo url .'/'.$this->folder ?>/update_feature_cover/"+code,{feature:val.join(",")}, function( data ) {
            if (data) {

            }
        });
    }


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

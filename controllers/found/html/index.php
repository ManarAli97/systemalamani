
<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" /> 

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view"><?php  echo $this->langControl('found') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > عرض  المحتوى    </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
<?php if((isset ($_SESSION['filterOption'][0]) || isset ($_SESSION['filterOption'][3])) && $id!=0 ){ ?>
<div class="row">
    <div class="col">
        <form action="<?php echo url.'/'.$this->folder ?>/view/<?php echo $id ?>" method="post" enctype="multipart/form-data">
            
            <!-- هنا نختار الموديل  -->
            <div class="row align-item-center">
                <div class="col-auto">
                    <label for="model"> الموديل </label>
                    <div class="form-group select_drop"  style="width: 100%" >
                        <select name="model"  id="model" class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                            
                        <?php foreach ($this->category_website as $key => $value ){ ?>
                    <option value="<?=$key ?>"><?= $value ?></option>
                    
                    <?php } ?>
                    <option value="card"> الخطوط والكارتات </option>
                    <option value="maintenance">الصيانة</option>
                        </select>
                    </div>
                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                        width: 392px !important; }
                </style>
            
           
            
                <div class="col-auto">
                    <label for="id_cat">الفئة</label>
                    <div class="form-group select_drop" id='div_cat' style="width: 100%" >
                        <select   name="id_cat"  id="id_cat"  >
                            </select>
                    </div>
                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                    width: 392px !important;}
                </style>
            <div class="col-auto align-self-center">
            <input class="btn btn-primary"  value="<?php  echo $this->langControl('save') ;?>"  type="submit" name="submit"/>
            </div>
        </div>  
        </form>     
    </div> 
</div>
<?php } else  { ?>
    <div class="row">
        <div class="col-auto">
            <label for="model"> الموديل </label>
            <div class="form-group select_drop"  style="width: 100%" >
                <select name="model" id="modelSearch" class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                   <?php foreach ($this->category_website as $key => $value ){ ?>
                    <option value="<?=$key ?>"><?= $value ?></option>
                    
                    <?php } ?>
                    <option value="card"> الخطوط والكارتات </option>
                    <option value="maintenance">الصيانة</option>
                </select>
            </div>
        </div>
        <style>
            .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 392px !important; }
        </style>
    
                <div class="col-auto">
                    <label for="id_cat">الفئة</label>
                    <div class="form-group select_drop" id='div_cat' style="width: 100%" >
                        <select   name="id_cat"  id="id_catSearch"  >
                            </select>
                    </div>
                </div>
                <style>
                    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
                    width: 392px !important;}
                </style>
            </div>  
<?php } ?>
<div class="row">
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="adminCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterOption'][0])) echo 'checked'; ?> value="option1">
            <label class="form-check-label"  for="adminCheck">الادمن </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="supplierCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterOption'][1])) echo 'checked'; ?> value="option2">
            <label class="form-check-label" for="supplierCheck">المجهز</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="callCenterCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterOption'][2])) echo 'checked'; ?> value="option3" >
            <label class="form-check-label" for="callCenterCheck">الكول سنتر</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="allCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterOption'][3])) echo 'checked'; ?> value="option4">
            <label class="form-check-label"  for="allCheck">الكل </label>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        
        <table  id="example" class="table table-striped display d-table"  >
            
            <thead>
            <tr>
                <th> الاسم </th>
                <th>رقم الهاتف في حساب الزبون </th>
                <th> رقم الهاتف </th>
                <th> محتوى </th>
                <th>التاريخ</th>
                <th>تفاصيل</th>
                <th>النوع</th>
                <th>الفئة</th>
                <th>ملاحظة</th>
                <th>المادة</th>
                <th>تم الاتصال</th>
                <th>ملاحظة</th>
                <th>حذف</th>
            </tr>
            </thead>
            

        </table>

    </div>
</div>




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
     $(document).ready(function(){
       
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('هل انت متاكد من حذف العنصر ؟ ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });
    
            var selected = [];
            
            var table = $('#example').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?=$id?>",
                info:false,
                "fnDrawCallback": function() {
                    jQuery('.toggle-demo').bootstrapToggle();
    
                },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id','row_'+ aData[7]);
                },
    
                'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }],
                "order": [[ 4, 'desc'] ],
                aLengthMenu: [ 50,100, 200, 300,-1],
                oLanguage: {
                    sLoadingRecords: "تحميل ...",
                    sProcessing: " معالجة ...",
                    sLengthMenu: "عرض _MENU_ ",
                    sSearch: " أبحث  ",
                    oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                    sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                    sSearchPlaceholder: "البحث"
    
    
                },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
                dom: 'Bfrtip',
                buttons: [
                    'excel'  ,
                    'pageLength'
                ],
                <?php  }  ?>
                bFilter: true, bInfo: true,
                
            } );
            $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

           /**@abstract
            * اعادة نحميل الجدول عند اختيار احد انواع المستخدمين
            * 
            */
            $('#adminCheck,#supplierCheck,#callCenterCheck,#allCheck').change( function() {
                    table.draw();
                });
            /**@abstract
             * هاي الدالة ترسل نوع المودل المختار حتى يتم الفلتره على الي مختاري
             */
            $('#modelSearch').on('change', function(e) {
                    $.get("<?php echo url ?>/found/setModelSession/"+e.target.value , function(){ }) ;
    
                    table.draw();
            });
            /**@abstract
             * هاي الدالة ترسل نوع الفئة المختار حتى يتم الفلتره على الي مختاري
             */
            $('#id_catSearch').on('change', function(e) {
                $.get("<?php echo url ?>/found/setId_catSession/"+e.target.value , function(){ }) ;
               
                table.draw();
            });
            
            
           
            /**@abstract
             * هذا الكود حتى نحدد المودل المختار للون الاحمر وخليته بهيج ايفنت الن ما رهمت بغير طريقة
             */
            $(document).on('mouseover', function() {
                
                $('#model_<?=$id?> a').css({"color":"red"});
              
               
               
            });
            
            /**@abstract
            * ملء الفئات عند اختيار نوع المودل 
            */
            $('#model').on('change', function() {
            var value = $(this).val();
            $.post("<?php echo url.'/'.$this->folder.'/getCatgry/'?>"+value,
            function(data, status){
                var jsonData = JSON.parse(data);
                $("#id_cat").empty();
                $.each(jsonData, function(index, value){
                    $("#id_cat").append(new Option(value['title'], value['id']));
                    });
                $("#id_cat").select2();
                       
                });
            });
            /**@abstract
            * ملء الفئات عند اختيار نوع المودل 
            */
            $('#modelSearch').on('change', function() {
               var value = $(this).val();
               $.post("<?php echo url.'/'.$this->folder.'/getCatgry/'?>"+value,
               function(data, status){
                       var jsonData = JSON.parse(data);
                       $("#id_catSearch").empty();
                       $("#id_catSearch").append(new Option("الكل", 0));
                       $.each(jsonData, function(index, value){
                           
                            $("#id_catSearch").append(new Option(value['title'], value['id']));
                           });
                            $("#id_catSearch").select2();
                          
               });
            });
    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_item/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
   
    
});




            
    
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
    
    /**@abstract
     * هاي الدالة تتفعل عن اختيار تم الاتصال 
     * اجاكس
     */
     function updateCalled(e,id) 
    {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/found/updateCalled/"+vis+'/'+id, function(){ })
    }

    /**@abstract
     * هنا نجيك  شنو الفلاتر الي اختار هن المستخدم 
     * 
     */
     function checkOption() {
        var adminCheck=$('#adminCheck').is( ':checked' )? 1:0;
       
        var supplierCheck=$('#supplierCheck').is( ':checked' )? 1:0;
        
        var callCenterCheck=$('#callCenterCheck').is( ':checked' )? 1:0;
        var allCheck=$('#allCheck').is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/found/checkOption/"+adminCheck+'/'+supplierCheck+'/'+callCenterCheck+'/'+allCheck, function(){ })
       
    }

    /**@abstract
     *  تضيف قيمة لحقل المادة في جدول اطلب ما  لم تجده
     */
     function addItem(item,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addId_Item/",
        data: 'value1='+item+'&value2='+id,

        success: function(data){

    }
  });
        
      
    }
    /**@abstract
     *  تضيف قيمة لحقل الملاحظات في جدول اطلب ما  لم تجده
     */
    function addNote(note,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addNote/",
        data: 'value1='+note+'&value2='+id,

        success: function(data){}

        });
         
    }
    /**@abstract
     *  تضيف قيمة لحقل ملاحظات الكول سنتر في جدول اطلب ما  لم تجده
     */
    function addNoteCalled(note,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addNoteCalled/",
        data: 'value1='+note+'&value2='+id,

        success: function(data){}

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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_item/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });

    



</script>










<br>
<br>
<br>



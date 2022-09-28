<link rel="stylesheet" href="<?= url ?>/controllers/surveys/css/tableStyle.css">

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view"><?php  echo $this->langControl('statistics') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >استبيان الاجهزة المستعملة</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<hr>
<div class="row">
    <div class="col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="adminCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterFeedback'][0])) echo 'checked'; ?> value="option1">
            <label class="form-check-label"  for="adminCheck">الادمن </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name='type' type="radio" id="callCenterCheck" onclick="checkOption()" <?php if(isset($_SESSION['filterFeedback'][1])) echo 'checked'; ?> value="option3" >
            <label class="form-check-label" for="callCenterCheck">الكول سنتر</label>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">  
        <table  id="feedbackTable" class="table table-striped display d-table"  >
            <thead>
                <tr>
                    <th> الرقم </th>
                    <th> الملاحظة</th>
                    <th> ملاحظة الادمن</th>
                    <th> تفعيل الاتصال</th>
                    <th> تم الاتصال</th>
                    <th> ملاحظة الكول سنتر</th>
                    
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        var selected = [];
        var table = $('#feedbackTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/feedbackServerSide/<?=$idAnswer?>",
            info:false,

            aLengthMenu: [ 50,100, 200, 300,-1],

            oLanguage: 
            {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            },  

            dom: 'Bfrtip',
                
            buttons: 
            [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true,    
        } );  
         /**@abstract
    * اعادة نحميل الجدول عند اختيار احد انواع المستخدمين
    * 
    */
        $('#adminCheck,#callCenterCheck').change( function() {
            table.draw();
        });      
    });
    /**@abstract
     * هنا نجيك  شنو الفلاتر الي اختار هن المستخدم 
     * 
     */
    function checkOption() {
        var adminCheck=$('#adminCheck').is( ':checked' )? 1:0;
        var callCenterCheck=$('#callCenterCheck').is( ':checked' )? 1:0;
        $.get("<?php echo url."/".$this->folder ?>/checkOption/"+adminCheck+'/'+callCenterCheck, function(){ })
       
    }
     /**@abstract
     * تحديث حالة تحويل للكولسنتر
     * اجاكس
     */
    function updateEnableCall(e,id) 
    {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url."/".$this->folder ?>/updateEnableCall/"+vis+'/'+id, function(){ })
    }
     /**@abstract
     * تحديث حالة  تم الاتصال
     * اجاكس
     */
    function updateCalled(e,id) 
    {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url."/".$this->folder ?>/updateCalled/"+vis+'/'+id, function(){ })
    }
    /**@abstract
     *  تضيف قيمة لحقل ملاحظات الادمن في جدول ملاحظات الزبائن  
     */
    function addAdminNote(note,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addAdminNote/",
        data: 'value1='+note+'&value2='+id,

        success: function(data){}

        });
         
    }
    /**@abstract
     *  تضيف قيمة لحقل ملاحظات الكولسنتر في جدول اطلب ملاحظات الزبائن   
     */
    function addCalledNote(note,id)
    {
        $.ajax({
        type: "POST",
        url:  "<?php echo url .'/'.$this->folder ?>/addCalledNote/",
        data: 'value1='+note+'&value2='+id,

        success: function(data){}

        });
         
    }
   
</script>

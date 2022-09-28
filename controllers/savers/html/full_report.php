<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" > تقرير شامل </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="search">
    <div class="form-row row mb-4">
        <div class="col-lg-3 col-md-2 mb-4 mr-4">
            الماركة
            <select class="custom-select dropdown_filter" name="category" id="category"   onchange="category()"   required>
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

                <option value="">   اختر الجهاز  </option>
            </select>
            <p id="select" class="required"></p>
        </div>
     

    </div>

	 <div class="form-row row mb-4">
        <div class="col-lg-2 col-md-2 mb-3">
            نوع المادة
            <select   id="cover_material" class="form-control   js-example-tags" style="padding:5px">
                <option value="0" selected >اختر</option>
                <?php  foreach ($cover_material as $covm)  { ?>
                    <option  class="text-right"  value="<?php  echo $covm['number']  ?>"><?php  echo $covm['cover_material'] ?></option>
                <?php } ?>
            </select>
        </div>


        <div class="col-lg-2 col-md-2 mb-3">
            نوع الحافظة
            <select  id="type_cover" class="form-control js-example-tags" style="padding:5px">
                <option value="0"    selected  >اختر</option>
                <?php  foreach ($type_cover as $tpc)  { ?>
                    <option  class="text-right"  value="<?php  echo $tpc['number']  ?>" ><?php  echo $tpc['type_cover'] ?></option>
                <?php } ?>
            </select>
        </div>


        <div class="col-lg-2 col-md-2 mb-3">
            الميزة
            <select   id="feature_cover" class="form-control js-example-tags" style="padding:5px">
                <option value="0" selected >اختر</option>
                <?php  foreach ($feature_cover as $feac)  { ?>
                    <option    class="text-right"  value="<?php  echo $feac['number']  ?>"><?php  echo $feac['feature_cover'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-row row mb-4">
        <div class="col-lg-2 col-md-1 mr-2">
            من
            <input type="datetime-local" name="date_start"  class="form-control" id="date_start" required>
            <p id="start" class="required"></p>
        </div>
        <div class="col-lg-2 col-md-1  mr-2">
            الى
            <input type="datetime-local" name="date_end"  class="form-control" id="date_end" required>
            <p id="end" class="required"></p>
        </div>
        <div class="col-lg-3 col-md-1  mr-2">
            <button type="button" class="btn  btn-primary" id="search"> <?php  echo $this->langControl('search') ?></button>
        </div>
    </div>



    <hr>
    <div class="form-row row mb-4">
        <div id='male'> كمية الحافظات الرجالية :  <span id="num-male">0</span></div>
        <div class=" ml-4 mr-2"></div>
        <div id="female"> كمية الحافظات النسائية  :  <span id="num-female">0</span></div>
        <div class=" ml-4 mr-2"></div>
        <div id='type-male'> عدد انواع الرجالية :  <span id="type-num-male">0</span></div>
        <div class=" ml-4 mr-2"></div>
        <div id="type-female"> عدد انواع النسائية  :  <span id="type-num-female">0</span></div>
        <div class=" ml-4 mr-2"></div>
        <div id="type-all"> عدد انواع المشترك  :  <span id="type-num-all">0</span></div>
        <div class=" ml-4 mr-2"></div>
        <div id='type-bysearch'>  عدد الانواع  حسب البحث : <span id="type-by-search">0</span></div>
        <div class=" ml-4 mr-4"></div>

    </div>



</div>

<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped  d-table table-bordered row-border order-column">
            <thead>
            <tr>
                <th> رمز المادة  </th>
                <th> صورة  </th>
                <th> اسم المادة</th>
                <th> اسم اللاتيني </th>
                <th> تاريخ رفع الحافظة </th>
                <th> الكمية الخارجة <span id="total-sale" class="number">(0)</span></th>
                <th> الكمية الداخلة <span id="total-inside" class="number">(0)</span></th>
                <th> الكمية الحالية <span id="total" class="number">(0)</span> </th>
                <th>  الكمية القادمة <span id="total-next" class="number">(0)</span></th>
                <th> حالة الطلب </th>
                <th>  الوقت المقدر للاستلام </th>
                <th> نسبة الجمالية </th>
                <th>التصنيف</th>
                <th>نسبة الجمالية الى العدد 70% فمافوق</th>
                <th>نسبة الجمالية الى العدد 60% الى اقل 70%</th>
                <th> نسبة الجمالية الى العدد اقل من 60% </th>
                <th> نوع المادة </th>
                <th> نوع الحافظة  </th>
                <th> الميزة </th>
                <th>الكمية الخارجة حسب التصنيف الكلي</th>
                <th>الكمية الداخلة حسب التصنيف الكلي</th>
                <th>الكمية الحالية حسب التصنيف الكلي</th>
                <th>الكمية القادمة حسب التصنيف الكلي</th>
                <th> الكمية الحالية في مواقع العرض في المبيع </th>
                <th> تاريخ اخر مبيع من  الكمية الحالية في مواقع العرض </th>
                <th>الكمية الحالية في مواقع الخزن في المبيع</th>
                <th> تاريخ اخر مبيع من الحالية في مواقع الخزن </th>
                <th> تاريخ اخر مناقلة الى الحالية في مواقع العرض </th>
                <th> تاريخ اخر مناقلة الى الحالية في مواقع الخزن </th>
                <th>تاريخ اخر عرض</th>
                <th>تاريخ اخر جرد للمادة</th>
                <th>اسم الموظف الذي جرد</th>
                <th>الركود المفاجىء</th>
                <th>تاريخ اخر ركود مفاجئ</th>
                <th> تاريخ اخر اعلان  </th>
                <th>تسلسل اهمية توفر التصنيف للجهاز</th>
                <th> نوع المادة </th>
                <th>تفاصيل اوقات  توقع وصولها</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    function category(){
        var name_device = $('#category option:selected').val();
        $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public/" +name_device, function (data) {
            $('#nameDevice_public').html(data);
            typeDevice_public();
        });

    }

    function typeDevice_public() {
        var type_device = $('#nameDevice_public option:selected').val();
        $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public/"+type_device, function (data) {
            $('#typeDevice_public').html(data);

        });

    }

    $(document).ready(function(){
        $('#search').on('click', function(e) {
            // var  state =" ";

            if(!$('#typeDevice_public').val()) {
                $("#select").text("* الحقل مطلوب");
            }else{
                $("#select").text(" ");
            }

            if(!$('#date_start').val()) {
                $("#start").text("* الحقل مطلوب");
            }else{
                $("#start").text(" ");
            }

            if(!$('#date_end').val()) {
                $("#end").text("* الحقل مطلوب");
            }else{
                $("#end").text("  ");
            }

            $('#typeDevice_public').on('change',function(){
                $("#select").text(" ");
            });


            if($('#typeDevice_public').val()  && $('#date_start').val() && $('#date_end').val()){
                $("#select").text(" ");
                $("#start").text(" ");
                $("#end").text("  ");
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();
                var model = $("#typeDevice_public").val();
                var code = $("#code").val();
            	var cover_material = $("#cover_material").val();
                var type_cover = $("#type_cover").val();
                var feature_cover = $("#feature_cover").val();
                if(code == ''){
                    code = '0';
                }

              

                var table = $('#example').DataTable();
                table.destroy();
                $('#example').DataTable( {
                    // scrollCollapse: true,
                    // scrollX: "100%",
                    // responsive: true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo url .'/'. $this->folder ?>/processing_full_report/"+model+"/"+date_start+"/"+date_end+"/"+cover_material+"/"+type_cover+"/"+feature_cover,
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
                    buttons:  [
                        {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,19,20,21,22,23,24,25,26,27,28,29,30,31]
                            }
                        },
                        'pageLength'
                    ],
                    <?php  }  ?>
                    bFilter: true, bInfo: true,

                });
                $('a.toggle-vis').on( 'click', function (e) {
                    e.preventDefault();

                    // Get the column API object
                    var column = table.column( $(this).attr('data-column') );

                    // Toggle the visibility
                    column.visible( ! column.visible() );

                });
                // end datatable

                setTimeout( function(){
                
                	 

                    // العدد الكلي الخارج
                    $.get( "<?php echo url .'/'. $this->folder ?>/totalSaleByCat/"+model+"/"+date_start+"/"+date_end+"/"+cover_material+"/"+type_cover+"/"+feature_cover, function(dataSale) {
                        if (dataSale)
                        {
                            $('#total-sale').text("("+dataSale+")");
                        }else{
                            $('#total-sale').text("("+0+")");
                        }
                    });

                    // العدد الكلي الداخل
                    $.get( "<?php echo url .'/'. $this->folder ?>/totalInsideByCat/"+model+"/"+date_start+"/"+date_end+"/"+cover_material+"/"+type_cover+"/"+feature_cover, function(dataInside) {
                        if (dataInside)
                        {
                            $('#total-inside').text("("+dataInside+")");
                        }
                    });

                    // العدد الكلي الحالي
                    $.get( "<?php echo url .'/'. $this->folder ?>/totalCurrentByCat/"+model+"/"+cover_material+"/"+type_cover+"/"+feature_cover, function(dataCurrent) {
                        if (dataCurrent)
                        {
                            $('#total').text("("+dataCurrent+")");
                        }else{
                            $('#total').text("("+0+")");
                        }
                    });

                    // العدد الكلي القادم
                    $.get( "<?php echo url .'/'. $this->folder ?>/totalNextByCat/"+model+"/"+cover_material+"/"+type_cover+"/"+feature_cover, function(dataNext) {
                        if (dataNext)
                        { 
                            $('#total-next').text("("+dataNext+")");
                        }else{
                          $('#total-next').text("("+0+")");
                        }
                    });


                   var male = 1;
                    $.get( "<?php echo url .'/'. $this->folder ?>/numberCover/"+model+"/"+male, function( data ) {
                        // if (data){
                            $('#num-male').text(data);
                        // }
                    });

                   var female = 2;
                    $.get( "<?php echo url .'/'. $this->folder ?>/numberCover/"+model+"/"+female, function( data ) {
                        if (data){
                            $('#num-female').text(data);
                        }
                    });
                
                
                	var  typeMl = 1;
                    $.get( "<?php echo url .'/'. $this->folder ?>/numberTypeCover/"+model+"/"+typeMl, function( data ) {
                        if (data){
                            console.log(data);
                            $('#type-num-male').text(data);
                        }
                    });

                    var typefe = 2;
                    $.get( "<?php echo url .'/'. $this->folder ?>/numberTypeCover/"+model+"/"+typefe, function( data ) {
                        if (data){
                            console.log(data);
                            $('#type-num-female').text(data);
                        }
                    });
                    var typeall = 3;
                    $.get( "<?php echo url .'/'. $this->folder ?>/numberTypeCover/"+model+"/"+typeall, function( data ) {
                        if (data){
                            $('#type-num-all').text(data);
                        }
                    });
                

					//  	عدد الانواع حسب نتائج البحث
                	 $.get( "<?php echo url .'/'. $this->folder ?>/numberTypeCoverBySearch/"+model+"/"+cover_material+"/"+type_cover+"/"+feature_cover, function(result) {
                        if (result)
                        {
                            $('#type-by-search').text("("+result+")");
                        }
                    });

                
                },2000);

            }

        });
    });




    function cover_material(e,code) {

       var value=$(e).val();
        $.get( "<?php echo url .'/compare_warehouses' ?>/update_cover_material/"+value+'/'+code, function( data ) {

            if (data)
            {


            }
        });
    }
    function type_cover(e,code) {

       var value=$(e).val();
        $.get( "<?php echo url .'/compare_warehouses' ?>/update_type_cover/"+value+'/'+code, function( data ) {

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

        $.get( "<?php echo url .'/compare_warehouses' ?>/update_feature_cover/"+code,{feature:val.join(",")}, function( data ) {
            if (data) {

            }
        });
    }


	 function edit_cover_material(id){
        $('#edit-cover-material-'+id).css('display','none');
        $('.edit-cover-material-'+id).css('display','block');
    }

    function edit_type_cover(id){
        $('#edit-type-cover-'+id).css('display','none');
        $('.edit-type-cover-'+id).css('display','block');
    }

    function edit_feature_cover(id){
        $('#edit-feature-cover-'+id).css('display','none');
        $('.edit-feature-cover-'+id).css('display','block');
    }

	 function update_rate(rate,id){
        
        $.get( "<?php echo url .'/'. $this->folder ?>/updateRate/"+id+"/"+rate, function(result) {
            if (result){
                // console.log('result');
            }
        });
    }

</script>









<style>
    .breadcrumb{
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background-color: rgba(121,169,197,.92) !important;
        -webkit-box-shadow: 0px -4px 3px #ccc;
        -moz-box-shadow: 0px -4px 3px #ccc;
        box-shadow: 0px -4px 10px #ccc;
    }
    .breadcrumb li {
        color: #fff !important;
    }


    .d-table
    {
        width:100%;
        margin-top:30px !important;
        border: 1px solid #c4c2c2;
        border-radius: 5px;

    }
    table thead tr
    {
        position: sticky !important;
        top: 0px;
        z-index: 99;
        background-color: white;
        box-shadow: 0px 5px 5px 0px rgba(82, 63, 105, 0.08);
        white-space: nowrap;
        /* background-color: rgba(121,169,197,0.92) !important; */
        color: #000;
        font-size:14px;

    }
    table tbody tr td
    {
     text-align: center;

        height : 50px !important;
        font-size:14px;
    }
    table tbody  tr:nth-child(odd) {
        background-color: #f8f9fa !important;
    }
    table tbody  tr:nth-child(even) {
        background-color: #f3f8fa;
    }
    .number{
        text-align:center;
    }
    #search{
        margin-top: 25px
    }

	.required{
        color: red;
    }

</style>
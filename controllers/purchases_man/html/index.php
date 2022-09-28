

<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchases_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > عرض النواقص </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="row">
    <div class="col-lg-9">
        <a  href="<?php echo url .'/'.$this->folder ?>/add_manual" role="button"    class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i>  <span> اضافة نواقص  </span> </a>
        <a  href="<?php echo url .'/'.$this->folder ?>/excel" role="button"  type="button"   class="btn btn-warning btn-sm"> <i class="fa fa-file-excel-o"  aria-hidden="true"></i>  <span>  رفع ملف اكسل النواقص  </span> </a>
     </div>
</div>

<hr>

<form action="<?php  echo  url .'/'.$this->folder ?>/index" method="post">
    <div class="container-fluid" id="expand_menu">
        <div class="row">
            <select name="model"  id="her_add_menu" class="custom-select  col-md-3 mb-3 list_menu_categ" onchange="mainCatgHtmlx(this)" required>
                <option value="" disabled selected>  اختر الفئة الرئيسية  </option>
                <?php  foreach ($categ as $cg) {   ?>
                    <option value="<?php  echo $cg ?>" > <?php  echo $this->langControl($cg) ?></option>
                <?php  } ?>
            </select>

            <br>
            <div class="col-12">
                <label for="validationServer02">  مسار الفئات  </label>
                <input  disabled   type="text" class="form-control " id="path_catg" value="<?php  echo $category ?>"    >

            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-info" type="submit" >   <span>بحث </span> <i class="fa fa-search"></i> </button>
            </div>
        </div>
    </div>

</form>


    <?php  foreach ($categ as $catx ) { ?>

        <?php  if ($catx == $model) {  ?>
            <form id="convert_to_delegate_man<?php  echo $catx ?>"   method="post">

                <br>
                <br>
                <h2> <?php echo $this->langControl($catx)  ?> </h2>

                <script>
                    $(document).ready(function() {

                        var selected = [];

                        $('#example<?php  echo $catx ?>').DataTable( {
                            scrollY:        "500px",
                            scrollX:        true,
                            scrollCollapse: true,
                            serverSide:     true,
                            fixedColumns:false,
                            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php  echo $catx ?>/<?php echo $id ?>",
                            info:false,
                            "fnDrawCallback": function() {
                                jQuery('.toggle-demo').bootstrapToggle();

                            },
                            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                                $(nRow).attr('id','row_'+ aData[16]);
                            },

                            'columnDefs': [{
                                "targets": [0],
                                "orderable": false
                            }],

                            aLengthMenu: [ 50,100, 200, 300,-1],
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


                            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'  ,
                                'pageLength'
                            ],
                            <?php  }  ?>
                            bFilter: true, bInfo: true
                        } );

                    } );
                </script>


                <hr>

                <div class="row">
                    <div class="col">
                        <div class="dataTables_wrapper">


                            <table  id="example<?php  echo $catx ?>" class="table table-striped display d-table  stripe row-border order-column"  >
                                <thead>
                                <tr>
                                    <th>  <input type='checkbox'   class="checkall<?php  echo $catx ?>" checked >  </th>
                                    <th >القسم</th>
                                    <th>اسم المادة</th>
                                    <th> نوع المشتريات  </th>
                                    <th>كود</th>
                                    <th>اللون</th>
                                    <th> اخر سعر شراء  </th>
                                    <th>الكمية المطلوبة</th>
                                    <th> كمية تم شرائها  </th>
                                    <th>  باقي الكمية </th>
                                    <th>ملاحظة</th>
                                    <th>التاريخ</th>
                                    <th>صورة</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                    <th>الموظف</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>



                <div class="row justify-content-center">
                    <div class="col-auto ">
                        <button  type="submit" class="btn btn-info" >  تحويل النقوصات المحددة الى  المندوب </button>
                    </div>
                </div>

                <script>

                    $(function(){
                        $('.checkall<?php  echo $catx ?>').on('click', function() {
                            $('.childcheckbox<?php  echo $catx ?>').prop('checked', this.checked)
                        });
                    });



                    $(function() {
                        $("#convert_to_delegate_man<?php  echo $catx ?>").submit(function (e) {

                            if (confirm('هل انت متأكد؟')) {

                                e.preventDefault();
                                var actionurl = e.currentTarget.action;
                                $.ajax({
                                    url: "<?php  echo url . '/' . $this->folder ?>/convert_to_employ_delegate_man",
                                    type: 'post',
                                    cache: false,
                                    data: $("#convert_to_delegate_man<?php  echo $catx ?>").serialize(),
                                    success: function (data) {
                                        console.log(data)
                                        var response = JSON.parse(data);
                                        if (response.done) {

                                            for (var prop in response.done) {
                                                $('#row_' + response.done[prop]).remove();
                                            }
                                            alert('تم التحويل الى مندوب الشركة المحدد');
                                        } else if (response.stop_convert) {
                                            alert('يرجى التحقق من بعض المنتجات فيها نقص في المعلومات')
                                        } else if (response.empty) {
                                            alert('يرجى تحديد او اضافة نواقص الى القائمة')
                                        }
                                    }
                                })

                            }else
                            {
                                return false;
                            }
                        });
                    });


                </script>

                <hr>
            </form>


            <?php  break; } else {  ?>

            <form id="convert_to_delegate_man<?php  echo $catx ?>"   method="post">

                <br>
                <br>
                <h2> <?php echo $this->langControl($catx)  ?> </h2>

                <script>
                    $(document).ready(function() {

                        var selected = [];

                        $('#example<?php  echo $catx ?>').DataTable( {
                            scrollY:        "500px",
                            scrollX:        true,
                            scrollCollapse: true,
                            serverSide:     true,
                            fixedColumns:false,
                            "ajax": "<?php echo url .'/'. $this->folder ?>/processing/<?php  echo $catx ?>/<?php echo $id ?>",
                            info:false,
                            "fnDrawCallback": function() {
                                jQuery('.toggle-demo').bootstrapToggle();

                            },
                            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                                $(nRow).attr('id','row_'+ aData[16]);
                            },

                            'columnDefs': [{
                                "targets": [0],
                                "orderable": false
                            }],

                            aLengthMenu: [ 50,100, 200, 300,-1],
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


                            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'  ,
                                'pageLength'
                            ],
                            <?php  }  ?>
                            bFilter: true, bInfo: true
                        } );

                    } );
                </script>


                <hr>

                <div class="row">
                    <div class="col">
                        <div class="dataTables_wrapper">


                            <table  id="example<?php  echo $catx ?>" class="table table-striped display d-table  stripe row-border order-column"  >
                                <thead>
                                <tr>
                                    <th>  <input type='checkbox'   class="checkall<?php  echo $catx ?>" checked >  </th>
                                    <th >القسم</th>
                                    <th>اسم المادة</th>
                                    <th> نوع المشتريات  </th>
                                    <th>كود</th>
                                    <th>اللون</th>
                                    <th> اخر سعر شراء  </th>
                                    <th>الكمية المطلوبة</th>
                                    <th> كمية تم شرائها  </th>
                                    <th>  باقي الكمية </th>
                                    <th>ملاحظة</th>
                                    <th>التاريخ</th>
                                    <th>صورة</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                    <th>الموظف</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>



                <div class="row justify-content-center">
                    <div class="col-auto ">
                        <button  type="submit" class="btn btn-info" >  تحويل النقوصات المحددة الى  المندوب </button>
                    </div>
                </div>

                <script>

                    $(function(){
                        $('.checkall<?php  echo $catx ?>').on('click', function() {
                            $('.childcheckbox<?php  echo $catx ?>').prop('checked', this.checked)
                        });
                    });



                    $(function() {
                        $("#convert_to_delegate_man<?php  echo $catx ?>").submit(function (e) {

                            if (confirm('هل انت متأكد؟')) {

                                e.preventDefault();
                                var actionurl = e.currentTarget.action;
                                $.ajax({
                                    url: "<?php  echo url . '/' . $this->folder ?>/convert_to_employ_delegate_man",
                                    type: 'post',
                                    cache: false,
                                    data: $("#convert_to_delegate_man<?php  echo $catx ?>").serialize(),
                                    success: function (data) {
                                        console.log(data)
                                        var response = JSON.parse(data);
                                        if (response.done) {

                                            for (var prop in response.done) {
                                                $('#row_' + response.done[prop]).remove();
                                            }
                                            alert('تم التحويل الى مندوب الشركة المحدد');
                                        } else if (response.stop_convert) {
                                            alert('يرجى التحقق من بعض المنتجات فيها نقص في المعلومات')
                                        } else if (response.empty) {
                                            alert('يرجى تحديد او اضافة نواقص الى القائمة')
                                        }
                                    }
                                })

                            }else
                            {
                                return false;
                            }
                        });
                    });


                </script>

                <hr>
            </form>

        <?php } } ?>





<script>



    function mainCatgHtmlx(selectObject) {

        var value = selectObject.value;
        var id_html = selectObject.id;

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
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: auto;
        margin: 0 auto;
    }

    th,
    td {
        padding-left: 40px !important;
        padding-right: 40px !important;
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_item/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });





</script>










<br>
<br>
<br>



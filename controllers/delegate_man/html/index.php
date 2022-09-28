


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('delegate_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  عرض النواقص </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

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
                $(nRow).attr('id','row_'+ aData[13]);
            },
            "order": [[ 1, 'desc'] ],
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
            ,
            "columnDefs": [
                { className: "sale_quantity", "targets": [7] },
                { className: "piqe_quantity", "targets": [8] },
            ]

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

                <th>القسم</th>
                <th>اسم المادة</th>
                <th> نوع المشتريات </th>
                <th>كود</th>
                <th>اللون</th>
                <th>سعر اخر شراء</th>
                <th>الكمية المطلوبة</th>
                <th>الكمية تم شرائها</th>
                <th>  باقي الكمية </th>
                <th>   شراء   </th>
                <th>ملاحظة</th>
                <th>التاريخ</th>
                <th>صورة</th>

            </tr>
            </thead>

        </table>
        </div>
    </div>
</div>

    <?php  break; } else {  ?>

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
                        $(nRow).attr('id','row_'+ aData[13]);
                    },
                    "order": [[ 1, 'desc'] ],
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
                    ,
                    "columnDefs": [
                        { className: "sale_quantity", "targets": [7] },
                        { className: "piqe_quantity", "targets": [8] },
                    ]

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

                            <th>القسم</th>
                            <th>اسم المادة</th>
                            <th> نوع المشتريات </th>
                            <th>كود</th>
                            <th>اللون</th>
                            <th>سعر اخر شراء</th>
                            <th>الكمية المطلوبة</th>
                            <th>الكمية تم شرائها</th>
                            <th>  باقي الكمية </th>
                            <th>   شراء   </th>
                            <th>ملاحظة</th>
                            <th>التاريخ</th>
                            <th>صورة</th>

                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

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








<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" >

                  <h2>
                       شراء
                    </h2>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label  >  اسم المادة  </label>
                            <input type="text"  disabled  class="name_prod form-control  "   >
                        </div>

                        <div class="form-group">
                            <label  > فئة المنتج  </label>
                            <div type="text"     class="path_catg path_categ"   ></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img style="width: 100px" id="imgProd"  />
                    </div>

                </div>

                   <hr>
                <form id="purchasesForm" method="post"  >


                    <div class="col-12">
                        <label for="price_purchases"> سعر الشراء </label>
                        <input   name="price_purchases" type="text"  class="form-control "   id="price_purchases"   required/>
                    </div>


                    <div class="col-12">
                        <label for="sale_quantity"> الكمية التي تم شروائها </label>
                        <input   name="sale_quantity" type="number"  class="form-control "   id="sale_quantity"   required/>
                    </div>


                    <div class="col-12">
                        <label for="note_d"> ملاحظة المندوب </label>
                        <textarea rows="1" placeholder=" ملاحظة المندوب"  name="note_d"   id="note_d"  class="form-control" ></textarea>
                    </div>


                    <br>

                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="submit" value="شراء">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    var id=0;
    $('#exampleModal_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
          id = button.data('id');
        var path_catg = button.data('path_catg');
        var title = button.data('title');
        var image = button.data('image');
        var modal = $(this);

        modal.find('.name_prod').val(title);
        modal.find('.path_catg').html(path_catg);
        modal.find('#imgProd').attr('src',"<?php echo $this->save_file ?>"+image);

        modal.find('#purchasesForm').attr("action","<?php  echo url .'/'.$this->folder?>/purchases_add/"+id);

    });





    $(function() {
        $("#purchasesForm").submit(function (e) {
            e.preventDefault();
            var actionurl = e.currentTarget.action;

            quantity=parseInt($('#quantity').val());
            sale_quantity=parseInt($('#sale_quantity').val());

            if ( sale_quantity > quantity )
            {
                if (confirm('كمية الشراء اكبر من الكمية المطلوبة؟'))
                {

                    $.ajax({
                        url:  actionurl,
                        type: 'post',
                        cache: false,
                        data: $("#purchasesForm").serialize(),
                        success: function (data) {

                            if ("'"+data+"'" === "'"+id+"'")
                            {

                                $('#row_'+data).remove();
                                $('#exampleModal_edit').modal('hide');
                                alert('تمت عملية الشراء كل العناصر بنجاح');
                            }else if (data)
                            {
                                data= JSON.parse(data);

                                $('#row_'+data.id+ ' .sale_quantity').text(data.sale_quantity);
                                $('#row_'+data.id+ ' .piqe_quantity').text(data.piqe_quantity);
                                alert(' تم شراء ('+data.sale_quantity +') عنصر وباقي (' + data.piqe_quantity + ') عنصر ');
                                $('#exampleModal_edit').modal('hide');


                            }else
                            {
                                alert('حدث خطاء')
                            }
                        }
                    })
                }
                return false;
            }else
            {

                $.ajax({
                    url:  actionurl,
                    type: 'post',
                    cache: false,
                    data: $("#purchasesForm").serialize()+'&submit=submit',
                    success: function (data) {

                        if ("'"+data+"'" === "'"+id+"'")
                        {

                            $('#row_'+data).remove();
                            $('#exampleModal_edit').modal('hide');
                            alert('تمت عملية الشراء كل العناصر بنجاح');
                        }else if (data)
                        {
                            data= JSON.parse(data);

                            $('#row_'+data.id+ ' .sale_quantity').text(data.sale_quantity);
                            $('#row_'+data.id+ ' .piqe_quantity').text(data.piqe_quantity);
                            alert(' تم شراء ('+data.sale_quantity +') عنصر وباقي (' + data.piqe_quantity + ') عنصر ');
                            $('#exampleModal_edit').modal('hide');


                        }else
                        {
                            alert('حدث خطاء')
                        }
                    }
                })
            }


        });
    });



</script>


 <style>

     #purchasesForm div
     {
         margin-bottom: 12px;
     }
.path_categ
{
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #e9ecef;
    background-clip: padding-box;
    border: 1px solid #c8d1da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

 </style>

<br>
<br>
<br>



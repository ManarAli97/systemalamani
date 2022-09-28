


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchases_man') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('report_search_by_category') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>



    <form action="<?php  echo  url .'/'.$this->folder ?>/report_search_by_category" method="post">
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




<form id="checked_purchases_all"   method="post">


<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_report_report_search_by_category/<?php  echo $model ?>/<?php  echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[15]);
            },
            "order": [[ 1, 'desc'] ],
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


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th>  <input type='checkbox'   class="checkall" checked="checked" >  </th>
                <th>تم التدقيق</th>
                <th>القسم</th>
                <th>اسم المادة</th>
                <th>  نوع المشتريات </th>
                <th>كود</th>
                <th>اللون</th>
                <th>سعر اخر شراء</th>
                <th>الكمية المطلوبة</th>
                <th>الكمية تم شرائها</th>
                <th>  باقي الكمية </th>
                <th>ملاحظة</th>
                <th>التاريخ</th>
                <th>صورة</th>
                <th>المندوب</th>
            </tr>
            </thead>

        </table>

    </div>
</div>




    <div class="row justify-content-center">
        <div class="col-auto ">
            <input class="btn btn-warning"  name="submit"  value=" تم التدقيق"  type="submit">
        </div>
    </div>

</form>






<script>

    $(function(){
        $('.checkall').on('click', function() {
            $('.childcheckbox').prop('checked', this.checked)
        });
    });


    function checked_purchases(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder?>/checked_purchases/"+vis+'/'+id, function(){ })
    }



    $(function() {
        $("#checked_purchases_all").submit(function (e) {

                e.preventDefault();
                var actionurl = e.currentTarget.action;
                $.ajax({
                    url:  "<?php  echo url .'/'.$this->folder ?>/checked_purchases_all",
                    type: 'post',
                    cache: false,
                    data: $("#checked_purchases_all").serialize(),
                    success: function (data) {
                        var response = JSON.parse(data);
                        if(response.done) {
                            for (var prop in response.done) {

                                $('#checked_'+response.done[prop]).bootstrapToggle('on')
                            }
                            alert('تم التدقيق');
                        }else if (response.error_ch)
                        {
                            alert('يرجى تحديد فقط المشتريات التي لم يتم تحديدها')
                        }
                        else if (response.empty)
                        {
                            alert('فشل يرجى المحاولة لاحقا')
                        }
                    }
                })



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

<br>
<br>
<br>









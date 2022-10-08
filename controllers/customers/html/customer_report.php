<!-- <div style="text-align: center;">
رقم الهاتف : <input type="text" id="phone" value="<?php echo $phone?>">
</div>
 -->

<div class="main m-3" >
    <p>التسجيل في الموقع</p>
    <table id="register_user" class="table  table-bordered table-striped display d-table" style="width:100%" >
        <thead>
            <tr>
                <td> الاسم </td>
                <td> الرقم </td>
                <td> المحافظه </td>
                <td> سنه التسجيل في الموقع </td>
                <td> الملاحظه </td>
                <td>الحاله</td>
                <td> التاريخ  </td>
            </tr>
        </thead>
    </table>
</div>


<div class="main m-3" >
    <p> اطلب ما لم تجده</p>
    <table id="found" class="table  table-bordered table-striped display d-table" style="width:100%" >
        <thead>
            <tr>
                <td>المحتوى  </td>
                <td>الاتصال  </td>
                <td> ملاحظه المتصل </td>
                <td>التاريخ </td>
            </tr>
        </thead>
    </table>
</div>


<div class="main m-3">
    <p> شراء من الزبائن</p>
    <table  id="purchase_customer" class="table table-bordered table-striped display d-table"  >
        <thead>
        <tr>
            <th> اسم المنتج </th>
            <th> رقم الفاتوره</th>
            <th> سعر الشراء</th>
            <th> سعر البيع</th>
            <th> التأريخ  </th>
        </tr>
        </thead>
    </table>
</div>


<div class="main m-3">
    <p>تعويض الزبائن</p>
    <table id="customers_compensation" class="table table-bordered table-striped display d-table">
        <thead>
            <tr>
                <th> اسم الزبون </th>
                <th> رقم هاتف الزبون </th>
                <th>رقم الفاتورة</th>
                <th>تاريخ التسجيل</th>
                <th>اسم موظف الكول سنتر</th>
                <th>ملاحظة موظف الكول سنتر</th>
                <th>تاريخ التحقيق</th>
                <th>اسم موظف المبيعات</th>
                <th>ملاحظة موظف المبيعات</th>
                <th>الحالة</th>
            </tr>
        </thead>
    </table>
</div>

<div class="main m-3">
    <p>فائزين الكوبونات</p>
    <table  id="coupon" class="table table-bordered table-striped display d-table"  >
        <thead>
        <tr>
            <th> المجموعه </th>
            <th> اسم المستخدم</th>
            <th> عدد الكوبونات المستخدمه</th>
            <th> التأريخ  </th>
        </tr>
        </thead>
    </table>
</div>


<div class="main m-3">
    <p> فواتير الشراء</p>
    <table  id="cart_shop" class="table table-bordered display d-table"  >
        <thead>
        <tr>
            <th> رقم الفاتوره </th>
            <th> الطلبات</th>
            <th>  السعر الكلي</th>
            <th> التأريخ  </th>
        </tr>
        </thead>
    </table>
</div>


<div class="main m-3" >
    <p>تقييم الزبون للموظفين</p>
    <table id="staff_evaluation" class="table  table-bordered table-striped display d-table" style="width:100%" >
        <thead>
            <tr>
                <td>الموظف </td>
                <td>التقييم</td>
                <td>الملاحظه </td>
                <td>التاريخ  </td>
            </tr>
        </thead>
    </table>
</div>


<div class="main m-3" >
    <p>تقييم الموظفين للزبون</p>
    <table id="note_user" class="table  table-bordered table-striped display d-table" style="width:100%" >
        <thead>
            <tr>
                <td>اسم الموظف الي كتب الملاحظه</td>
                <td>الملاحظه </td>
                <td>مجموعه الموظف </td>
                <td>التاريخ  </td>
            </tr>
        </thead>
    </table>
</div>


<script>
$(document).ready(function() {
    var x = '';
    setInterval(()=>{  
        $.ajax({
            type: "POST",
            url:"<?php echo url . '/' . $this->folder ?>/search_phone_customer",
            success: function (phone) { console.log(phone);
                if (phone != null)
                {
                    if (phone != x){
                        x = phone ;
                        $.ajax({
                            type: "POST",
                            url:"<?php echo url . '/' . $this->folder ?>/get_id_customer/"+phone,
                            success: function (data) {
                                if (data != "")
                                {
                                    var id_cus = data.slice(0,-1);

                                    $('#register_user').DataTable().destroy();
                                    var register_user = $('#register_user').DataTable({
                                        scrollY: "200px",
                                        scrollX: true,
                                        scrollCollapse: true,
                                        scrollX: true,
                                        responsive: true,
                                        "processing": true,
                                        "serverSide": false,
                                        scrollCollapse: true,
                                        paging: false,
                                        "ajax": "<?php echo url . '/' . $this->folder ?>/register_user/"+id_cus,
                                        info: false,
                                        oLanguage: {
                                            sLoadingRecords: "تحميل ...",
                                            sProcessing: " معالجة ...",
                                            sLengthMenu: "عرض _MENU_ ",
                                            sSearch: " أبحث  ",
                                            oPaginate: {
                                                sFirst: "First",
                                                sLast: "Last",
                                                sNext: "&raquo;",
                                                sPrevious: "&laquo;"
                                            },
                                            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                            sSearchPlaceholder: "البحث"
                                            },
                                            bInfo: false,
                                            bFilter:false
                                    });
                                    $('#staff_evaluation').DataTable().destroy();
                                    var staff_evaluation = $('#staff_evaluation').DataTable({
                                        scrollY: "200px",
                                        scrollX: true,
                                        scrollCollapse: true,
                                        scrollX: true,
                                        responsive: true,
                                        "processing": true,
                                        "serverSide": false,
                                        scrollCollapse: true,
                                        paging: false,
                                        "ajax": "<?php echo url . '/' . $this->folder ?>/staff_evaluation/"+id_cus,
                                        info: false,
                                        oLanguage: {
                                            sLoadingRecords: "تحميل ...",
                                            sProcessing: " معالجة ...",
                                            sLengthMenu: "عرض _MENU_ ",
                                            sSearch: " أبحث  ",
                                            oPaginate: {
                                                sFirst: "First",
                                                sLast: "Last",
                                                sNext: "&raquo;",
                                                sPrevious: "&laquo;"
                                            },
                                            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                            sSearchPlaceholder: "البحث"
                                            },
                                            bInfo: false,
                                            bFilter:false
                                    });
                                    $('#note_user').DataTable().destroy();
                                    var note_user = $('#note_user').DataTable({
                                        scrollY: "200px",
                                        scrollX: true,
                                        scrollCollapse: true,
                                        scrollX: true,
                                        responsive: true,
                                        "processing": true,
                                        "serverSide": false,
                                        scrollCollapse: true,
                                        paging: false,
                                        "ajax": "<?php echo url . '/' . $this->folder ?>/note_user/"+id_cus,
                                        info: false,
                                        oLanguage: {
                                            sLoadingRecords: "تحميل ...",
                                            sProcessing: " معالجة ...",
                                            sLengthMenu: "عرض _MENU_ ",
                                            sSearch: " أبحث  ",
                                            oPaginate: {
                                                sFirst: "First",
                                                sLast: "Last",
                                                sNext: "&raquo;",
                                                sPrevious: "&laquo;"
                                            },
                                            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                            sSearchPlaceholder: "البحث"
                                            },
                                            bInfo: false,
                                            bFilter:false
                                    });
                                    $('#purchase_customer').DataTable().destroy();
                                    var purchase_customer = $('#purchase_customer').DataTable({
                                        scrollY: "200px",
                                        scrollX: true,
                                        scrollCollapse: true,
                                        scrollX: true,
                                        responsive: true,
                                        "processing": true,
                                        "serverSide": false,
                                        scrollCollapse: true,
                                        paging: false,
                                        "ajax": "<?php echo url . '/' . $this->folder ?>/purchase_customer/"+id_cus,
                                        info: false,
                                        oLanguage: {
                                            sLoadingRecords: "تحميل ...",
                                            sProcessing: " معالجة ...",
                                            sLengthMenu: "عرض _MENU_ ",
                                            sSearch: " أبحث  ",
                                            oPaginate: {
                                                sFirst: "First",
                                                sLast: "Last",
                                                sNext: "&raquo;",
                                                sPrevious: "&laquo;"
                                            },
                                            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                            sSearchPlaceholder: "البحث"
                                            },
                                            bInfo: false,
                                            bFilter:false
                                    });
                                    $('#cart_shop').DataTable().destroy();
                                    var cart_shop = $('#cart_shop').DataTable({
                                        scrollY: "300px",
                                        scrollX: true,
                                        scrollCollapse: true,
                                        scrollX: true,
                                        responsive: true,
                                        "processing": true,
                                        "serverSide": false,
                                        scrollCollapse: true,
                                        paging: false,
                                        "ajax": "<?php echo url . '/' . $this->folder ?>/cart_shop/"+id_cus,
                                        info: false,
                                        oLanguage: {
                                            sLoadingRecords: "تحميل ...",
                                            sProcessing: " معالجة ...",
                                            sLengthMenu: "عرض _MENU_ ",
                                            sSearch: " أبحث  ",
                                            oPaginate: {
                                                sFirst: "First",
                                                sLast: "Last",
                                                sNext: "&raquo;",
                                                sPrevious: "&laquo;"
                                            },
                                            sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                            sSearchPlaceholder: "البحث"
                                            },
                                            bInfo: false,
                                            bFilter:false
                                    });
                                }
                            }
                        });
                        $('#found').DataTable().destroy();
                        var found = $('#found').DataTable({
                            scrollY: "200px",
                            scrollX: true,
                            scrollCollapse: true,
                            scrollX: true,
                            responsive: true,
                            "processing": true,
                            "serverSide": false,
                            scrollCollapse: true,
                            paging: false,
                            "ajax": "<?php echo url . '/' . $this->folder ?>/found/"+phone,
                            info: false,
                            oLanguage: {
                                sLoadingRecords: "تحميل ...",
                                sProcessing: " معالجة ...",
                                sLengthMenu: "عرض _MENU_ ",
                                sSearch: " أبحث  ",
                                oPaginate: {
                                    sFirst: "First",
                                    sLast: "Last",
                                    sNext: "&raquo;",
                                    sPrevious: "&laquo;"
                                },
                                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                sSearchPlaceholder: "البحث"
                                },
                                bInfo: false,
                                bFilter:false
                        });
                        $('#customers_compensation').DataTable().destroy();
                        var customers_compensation = $('#customers_compensation').DataTable({
                            scrollY: "200px",
                            scrollX: true,
                            scrollCollapse: true,
                            scrollX: true,
                            responsive: true,
                            "processing": true,
                            "serverSide": false,
                            scrollCollapse: true,
                            paging: false,
                            "ajax": "<?php echo url . '/' . $this->folder ?>/customers_compensation/"+phone,
                            info: false,
                            oLanguage: {
                                sLoadingRecords: "تحميل ...",
                                sProcessing: " معالجة ...",
                                sLengthMenu: "عرض _MENU_ ",
                                sSearch: " أبحث  ",
                                oPaginate: {
                                    sFirst: "First",
                                    sLast: "Last",
                                    sNext: "&raquo;",
                                    sPrevious: "&laquo;"
                                },
                                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                sSearchPlaceholder: "البحث"
                                },
                                bInfo: false,
                                bFilter:false
                        });
                        $('#coupon').DataTable().destroy();
                        var coupon = $('#coupon').DataTable({
                            scrollY: "200px",
                            scrollX: true,
                            scrollCollapse: true,
                            scrollX: true,
                            responsive: true,
                            "processing": true,
                            "serverSide": false,
                            scrollCollapse: true,
                            paging: false,
                            "ajax": "<?php echo url . '/' . $this->folder ?>/coupon/"+phone,
                            info: false,
                            oLanguage: {
                                sLoadingRecords: "تحميل ...",
                                sProcessing: " معالجة ...",
                                sLengthMenu: "عرض _MENU_ ",
                                sSearch: " أبحث  ",
                                oPaginate: {
                                    sFirst: "First",
                                    sLast: "Last",
                                    sNext: "&raquo;",
                                    sPrevious: "&laquo;"
                                },
                                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                                sSearchPlaceholder: "البحث"
                                },
                                bInfo: false,
                                bFilter:false
                        });
                    }
                }
            }
        })
    },2000);
        

})
</script>

<style>
    .main{
        text-align: center;
        background: #e0e0eb;
        padding: 20px;
        border-radius: 10px; 
    }
    table{
        background: #fff;
    }
</style>
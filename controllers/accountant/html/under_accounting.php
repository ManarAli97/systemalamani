

<br>
<div class="row">
    <div class="col">

        <nav aria-label="breadcrumb" >

                    <ol class="breadcrumb"  >
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/under_accounting"><?php  echo $this->langControl('under_accounting') ?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات </li>

                    </ol>

        </nav>

    </div>
    <div class="col-auto">
        <div style="cursor: pointer" onclick="sun_total_money()" class="sumAllMoney"  data-toggle="tooltip" data-placement="top" title="  اضغط هنا لعرض المجموع الكلي " >
            <span> حساب المجموع الكلي </span>
        </div>
    </div>


</div>

<script>

    function  sun_total_money () {
        $( ".sumAllMoney" ).html(`
         <span>  جاري  حساب المبلغ   : </span>  <img style="width:18px" src="<?php echo $this->static_file_site ?>/image/site/loding.gif">
        ` );
        $.get( "<?php  echo url .'/'.$this->folder ?>/sun_total_money", function( data ) {
            if (data)
            {
                $( ".sumAllMoney" ).html(`
         <span>  المبلغ الكلي   : </span> <span>  ${data}  </span> <span> د.ع</span>
        ` );
            }
        });
    }



    $(document).ready(function() {


        $('#example').DataTable( {
            "processing": true,
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[12]);
            },
            "order": [[ 3, 'asc'] ],
            aLengthMenu: [ 10,25,75,100,200,-1],
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


<br>

<?php if (!empty($count_active)) {   ?>

<table id="example" class="table table-striped">
    <thead>
    <tr>

        <th scope="col">       <i   data-toggle="tooltip" data-placement="top" title="طلب مستعجل"   style=" color: red;" class="fa fa-star"></i></th>
        <th scope="col"> اسم الزبون</th>
        <th scope="col">رقم الموبايل</th>
        <th scope="col"> رقم الفاتورة</th>
        <th scope="col">  تاريخ الطلب </th>
        <th scope="col"> وقت الطلب</th>
        <th scope="col"> رقم الشاشة او اسم البائع </th>
        <th scope="col">  المبلغ الكلي</th>
        <th scope="col">   عرض الطلب  </th>
    </tr>
    </thead>
    <tbody id="reloadPage">
    <?php foreach ($count_active as $order)  {  ?>
    <tr>
        <td>
			<?php  if ($order['top']==1) {  ?>
                <i style="color: red;" class="fa fa-star"></i>
			<?php  } ?>
        </td>
        <td> <?php echo $order['name'] ?></td>
        <td>  <?php echo $order['phone'] ?></td>
        <td>  <?php echo $order['number_bill'] ?>  </td>
        <td>  <?php echo date('Y-m-d',$order['date_req']) ?>  </td>
        <td>   <?php echo date('h:i:s A', $order['date_req']) ?> </td>
        <td>  <?php echo $order['name_request'] ?>  </td>
        <td>  <?php echo $order['sum'] ?>  </td>
        <td>

          <a href="<?php echo url.'/'.$this->folder ?>/view_order_under_accounting_order/<?php echo $order['id'] ?>/<?php echo $order['number_bill'] ?>">  عرض الطلب </a>
        </td>

    </tr>
<?php  }  ?>
    </tbody>
</table>

<?php  }  else{ ?>
    <div class="alert alert-warning" role="alert">
        لاتوجد طلبات
    </div>
<?php   } ?>



<script>

    function send_data() {
        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#reloadPage').children();
            $('#reloadPage').empty().html(founddata);

        });
    }
    setInterval(send_data, 10000);



</script>


<style>
    .infoCustomer
    {
        display: block;
        text-decoration: none;
        background: #ecedee;
        margin: 7px 0 7px 0;
        padding: 5px 14px;

    }
    .infoCustomer:hover
    {

        text-decoration: none;


    }
    .result {


        overflow-y: auto;
    }
    .thisActive
    {
        background: #adb !important;
        color: #ffffff;
    }
    .thisActive:hover
    {
        
        color: #ffffff;
    }
</style>



<style>


    .g_account
    {
        background: #4CAF50;
        color: #ffff;
        padding: 0 6px;
        border-radius: 15px;
        display: block;
    }

    .n_account
    {
        background: #000000;
        color: #ffff;
        padding: 1px 6px;
        border-radius: 15px;
        display: block;
    }


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




.bell_style
    {
        font-size: 33px;
        color: red;
        margin-top: -10px;
    }
    .number_req
    {
        position: absolute;
        top: -14px;
        width: 25px;
        height: 25px;
        background: #007bff;
        text-align: center;
        left: 4px;
        border-radius: 50%;
        font-weight: bold;
        color: #ffffff;
    }
    .set_text_table
    {
        text-align:center;
    }
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


</style>






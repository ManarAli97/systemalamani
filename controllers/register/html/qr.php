
<script>
    $(document).ready(function() {

        var selected = [];

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_qr/<?php  echo $y ?>/<?php  echo $fromDate ?>/<?php  echo $toDate ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[5]);
            },
            "order": [[ 4, 'asc'] ],
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

    <div class="row align-items-center">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_registration"><?php  echo $this->langControl('registration') ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" >  الزبائن </li>
                    <li class="breadcrumb-item active" aria-current="page" >  رمز QR خاص في الزبائن  </li>
                </ol>
            </nav>
        </div>

    </div>
<hr>
<div class="row justify-content-between">
    <div class="col-auto">


        <form action="<?php echo url.'/'.$this->folder?>/subscribers_qr" method="get">

            <div class="row align-items-end">
                <div class="col-auto">
                    من تاريخ
                    <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
                </div>
                <div class="col-auto">
                    الى تاريخ
                    <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning" >بحث</button>
                    <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
                </div>
            </div>

        </form>


    </div>
    <div class="col-auto">


        <form action="<?php  echo url .'/'.$this->folder ?>/subscribers_qr" method="POST">
            <div class="row">
                <div class="col-auto">
                    <select class="custom-select custom-select-sm" name="year" >
                        <option value="0" >  اختر سنة </option>
                        <?php foreach ($year as $ye)  {     ?>
                            <option value="<?php echo $ye ?>"  <?php  if ($ye == $y) echo 'selected'?>  > <?php   echo $ye ?> </option>
                        <?php  }  ?>
                    </select>
                </div>

                <div class="col-auto">
                    <input type="submit" class="btn btn-primary btn-sm" name="submit" value="بحث">
                </div>
            </div>
        </form>

    </div>
</div>


<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th><?php  echo $this->langControl('name') ?></th>
                    <th><?php  echo $this->langControl('phone') ?></th>
                    <th><?php  echo $this->langControl('city') ?></th>
                    <th><?php  echo $this->langControl('address') ?></th>
                    <th>QR </th>

                    <th><?php  echo $this->langControl('date') ?></th>

                </tr>
                </thead>

            </table>

        </div>
    </div>



<div class="modal fade"  id="exampleModal_hello_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="width: 100%" class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <h5 style=" margin-top: 3px;   font-size: 26px;"  class="modal-title" id="exampleModalLabel">   <span class="name_customer"></span> </h5>
                    </div>

                    <div class="col-auto" style="padding: 0">
                        <img style="width: 70px;" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                    </div>
                </div>


            </div>
            <div class="modal-body" id="message_out" style="background: #f0f0f0">
                 <div class="logo_on_qr">
                    <div id="qrcode"></div>
                    <img class="img_logo_qr" src="<?php  echo  $this->static_file_site ?>/image/site/logo_notif.png">
                </div>
                <br>
                <div class="progress" style="height: 2px;">
                    <div  class="progress-bar progress_inter" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>


        </div>
    </div>
</div>

<script src="<?php echo $this->static_file_site ?>/js/qrcode.min.js"></script>
<script>

    function getQr(qr,costm) {
        $('#qrcode').empty();
        $('.name_customer').html(costm);


        var qrcode = new QRCode("qrcode", {
            text: qr,
            colorDark : "#284491",
            colorLight : "#ffffff",
        });



        // $('span.name_customer').text($('#first_name').val());
        $('#exampleModal_hello_customer').modal('show');
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
</style>




<style>

    button.btn.btn_send_search {
        background: #c5c5c5;
        border-radius: 0;
        width: 100%;
        color: #283581;
    }

    input.form-control.textbox_search {
        border-radius: 0;
    }
    select.form-control.form-control.dropdownCatg {
        padding: 0px 12px;
        border-radius: 0;
    }

    .categoryAndOffers
    {
        text-align: center;
        background: #c5c5c59e;
        color: #ffffff;
        padding: 8px 4px;
    }

    .bar_category
    {
        background: #283581;
        padding: 6px 0;
    }


    .bar_top
    {
        border-bottom: 1px solid #e3e3e3;
        height: 50px;
        transition: 0.3s;
    }


    .vodiapicker{
        display: none;
    }

    #a{

        margin: 0;
        padding: 0;
    }

    #a img, .btn-select img{
        width: 27px;

    }

    #a li{
        list-style: none;
        padding-top: 5px;
        padding-bottom: 2px;
        text-align: left;
        padding-right: 9px;
        cursor: pointer;
    }

    #a li:hover{
        background-color: #F4F3F3;
    }

    #a li img{
        margin: 5px;
    }

    #a li span, .btn-select li span{
        margin-left: 5px;
    }

    /* item list */

    .b{
        margin-top: -5px;
        display: none;
        width: 91px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px;
        position: absolute;
        background: #ffffff;
        z-index: 150000;
    }

    .open{
        display: show !important;
    }

    .btn-select{
        width: 91px;
        background-color: transparent;
        border: 1px solid transparent;
        margin-top: 6px;
        margin-bottom: 0;

    }
    .btn-select li{
        list-style: none;
        float: left;
        padding-bottom: 0px;
        padding-right: 7px;
    }

    .btn-select:hover li{
        margin-left: 0px;
    }

    .btn-select:hover{
        background-color: #F4F3F3;
        border: 1px solid transparent;
        box-shadow: inset 0 0px 0px 1px #ccc;


    }

    .btn-select:focus{
        outline:none;
    }

    a.nav-link.item_menu {
        color: rgba(0, 0, 0, .9) !important;
    }

    #qrcode img
    {
        display: initial !important;
    }

    .logo_on_qr
    {
        text-align: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo_on_qr .img_logo_qr
    {
        position: absolute;
        background: white;
        padding-right: 5px;
        width: 75px;
    }

</style>


<button class="btn btn-primary print_and_back" onclick="print_table()"> <i class="fa fa-print" aria-hidden="true"></i>  <span> طباعة </span></button>
<a  href="<?php echo url .'/'.$this->folder?>/list_page_serial_system" role="button"    class="btn btn-warning print_and_back"> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>  <span>  رجوع  </span> </a>

<div class="number_page" style="text-align: center;margin-bottom: 30px;font-weight: bold;font-size: 20px"><span> رقم الصفحة </span> ( <?php  echo $id ?> )</div>

<div class="print_table"   >

    <?php foreach ($print as $out) {   ?>

        <div class="row label align-items-center" style="margin: 0;" >
            <div class="col-12" style="padding: 0;">
            <div style="text-align: center;font-weight: bold;margin-bottom: 2px"><?php  $result= $this->data_code_print($out['code']); if (isset($result['title'])) echo $result['title'] ; else echo 'المادة غير معرفة في النظام' ?></div>
            <div style="text-align: center;font-weight: bold"><?php echo $out['code'] ?></div>
            <svg class="barcodeIMg barcode_<?php echo $out['id'] ?>"></svg>
            <script>
                JsBarcode(".barcode_<?php echo $out['id'] ?>", "<?php echo $out['serial_system'] ?>", {
                    height: 40,

                    displayValue: true
                });
            </script>
        </div>
       </div>
        <div class="page-break"></div>

    <?php }   ?>





</div>


<script>

    print_table()
    function print_table() {

        window.print()
    }

</script>

<style>




    body {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;

    }
    .label{
        margin: 0;
        padding-top: 10px;
        padding-right: 0px;
        padding-bottom: 0px;
        padding-left: 10px;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
        width: 100%;
        height: 145px;
        font-weight: bold;
        text-align: Left;
        overflow: hidden;
        zoom: 185% !important;
    }
    .page-break  {
        clear: left;
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        display:block;
        page-break-after:always;
    }



    @page {
        size: auto;
    }

    .page-break  {

        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        display:block;
        page-break-after:always;
    }

    .print_table svg
    {
        width: 100% !important;
    }

    @media print {


        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

        }
        .hide_print,.out_print,.print_and_back,.number_page
        {
            display: none;
        }
        .fixed-top,.down_fixed,.notShowInPrint,.menuControl
        {
            height: 0;
            display: none;
        }


        .result
        {
            height: auto !important;
            overflow: unset !important;
        }

        .bodyControl
        {
            overflow: unset;
            padding: 0;
        }


        .print_table{
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_table * {
            position: relative;
            visibility: visible;
        }



    }


</style>

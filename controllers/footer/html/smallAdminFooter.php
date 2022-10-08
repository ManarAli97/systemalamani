</div>
</div>
</div>


<style>
 .select_drop .bootstrap-select .dropdown-menu {
        min-width: auto !important;
    }

    .print_bill_casher
    {
        zoom: 200% !important;
    }


    .type_price_account
    {
        display: block;
        font-size: 12px;
        border-radius: 10px;
        background: #bcd4e6;
        padding: 2px 1px;
    }

    div.dataTables_wrapper div.dataTables_processing {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-left: 0;
        margin-top: 0;
        text-align: center;
        padding: 12px 0px;
        background: #151717 !important;
        color: #ffff !important;
        width: 200px !important;
        font-size: 20px !important;
        z-index: 150000 !important;
    }

    .error_code
    {
        background: #f44336;
        color: #fff;
    }
    .error_code:focus
    {
        background: #f44336;
        color: #fff;
    }


    .infoCustomer{
        color: #000;
        font-size: 18px;
    }
    .infoCustomer.thisActive{
        color: #ffffff;
        font-size: 18px;
    }
    .infoBillOpen
    {
        font-size: 18px;
        font-weight: bold;
    }

    .sumAllMoney {
        border: 1px solid #cdd4da;
        padding: 10px;
        border-radius: 5px;
        background: #fea;
        font-weight: bold;
    }


    div.dataTables_wrapper div.dataTables_info {
        padding-top: 0.85em;
        white-space: nowrap;
        float: right;
        margin-top: -7px;
    }

    td .color_item_table
    {
        border: 1px solid gainsboro;
    }
    .col-auto .card .card-body .card-text
    {
        width: 215px;
        height: 50px;
        overflow: hidden;
    }


    select.custom-select.custom-select-sm.form-control.form-control-sm {
        width: 126px !important;
    }


    div#editor {
        margin: auto;
        text-align: left;
    }

    div#editor div div div a {
        height: 0;
        overflow:hidden;
        padding: 0 !important;

    }

    div#editor .fr-element.fr-view a  {
        display:unset !important;
        overflow:unset !important;
        height:auto;
        padding: 0 24px !important;;
    }


    div#editor div div div a.fr-command {
        display: block !important;
        overflow:unset !important;
        height:auto;
        padding: 0 24px !important;;
    }
</style>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>





<style>

    .blah #blah {
        width: 168px;
        margin-top: 17px;
        border: 2px solid #28a745;
        padding: 5px;
    }

    .tags_tags .bootstrap-tagsinput{

        width: 100%;
        min-height: 95px;
        padding: 10px;
    }

    .tags_tags .bootstrap-tagsinput .tag{
        margin-right: 2px;
        background: #28a745;
        color: #fff;
        padding: 0 8px;
        border-radius:5px ;
        line-height: 39px;

    }

    .tags_tags .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "\f057";
        padding: 0 2px;
        font-family: FontAwesome;
    }

    .c-circle-menu__link
    {
        position: absolute;
        bottom: 7px;
        width: 40px;
        height: 40px;
        left: 7px;
        background: #283581;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
    }

    #snackbar {

        z-index: 1000000000 !important;
    }

    .copyToClipboard
    {
        cursor: pointer;
    }

</style>

<div id="snackbar">تم النسخ</div>

<script>

    function copy_text(e) {
        new Clipboard('.'+$(e).attr('class'));

        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
    }

    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};


</script>



<a href="<?php echo url ?>/contact" class="c-circle-menu__link">
    <i style="transform: rotate(-17deg);" class="fa fa-bullhorn"></i>
</a>







</body>
</html>
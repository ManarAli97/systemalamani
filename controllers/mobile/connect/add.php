
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_model_connect"><?php  echo $this->langControl($this->folder) ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >  ربط الاقسام المتشابهة  </li>
                <li class="breadcrumb-item active" aria-current="page" >  اضافة </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<form action="<?php echo url.'/'.$this->folder ?>/add_connect" method="post">



<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <div class="col-12">
                <label  > <span>    بحت عن اقسام متشابه    </span>   </label>
            </div>
            <div class="col-12">
                <input type="text"   onkeyup="showResult(this.value)" class="form-control" placeholder="بحث  " >
                <div id="livesearch"></div>
            </div>

        </div>

    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="customer_lest"></div>
    </div>

</div>


    <br>
    <hr>
    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input  class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save') ?>">
            </div>
        </div>
    </div>
</form>





<script>




    function showResult(str) {
        if (str.length==0) {
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {  // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                document.getElementById("livesearch").innerHTML=this.responseText;
                document.getElementById("livesearch").style.border="1px solid #d0d2d3";
                document.getElementById("livesearch").style.padding="5px";
            }
        };
        xmlhttp.open("GET","<?php echo url.'/'.$this->folder ?>/search?q="+str,true);
        xmlhttp.send();
    }

    function add_c(id) {
        $.get( "<?php echo url.'/'.$this->folder ?>/catg_info/"+id, function( data ) {

            $('.customer_lest').append(`

                    <div class="custom-control custom-checkbox custom-control-inline listCustom-checkbox" id="remove_${id}">
                      <input type="checkbox" id="customRadioInline_${id}" value="${id}" name="ids[${id}]" class="custom-control-input" checked>
                      <label class="custom-control-label" for="customRadioInline_${id}"> <span> ${data}  </span>  <button  class='btn' type="button" onclick="remove_this_costom(${id})">   <i class='fa fa-times-circle'></i> </button></label>
                    </div>

                    `);

            $("#c_"+id).remove()
        });

    }

    function remove_this_costom(id) {
        $("#remove_"+id).remove()
    }


</script>

<style>


    .remove_row{
        position: absolute;
        top: -10px;
        left: -10px;
        border-radius: 50%;
        font-size: 12px;
        width: 28px;
        height: 28px;
        padding: 0;
    }



    div#livesearch {

        border-radius: 5px;
        max-height: 500px;
        overflow: auto;
    }

    .dropdownCustomer {
        border-bottom: 1px solid #d0d2d3;
        padding: 0 12px 2px 2px;
    }

    .dropdownCustomer:hover {
        background: #e7eaec59;
    }

    .dropdownCustomer:last-child {
        border-bottom: 1px solid transparent;

    }

    .dropdownCustomer button  {
        padding: 0;
        color: #009688;
        font-size: 23px;
        margin: 0;
        padding-top: 3px;
        margin-left: 9px;
    }

    .listCustom-checkbox
    {
        padding-right: 36px;
        padding-left: 12px;
        border: 1px solid #edeeef;
        position: relative;
        border-radius: 50px;
        height: 40px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .listCustom-checkbox:hover
    {
        background:  #e7eaec59;
    }

    .listCustom-checkbox button
    {
        padding: 0;
        color: #fd3416;
        font-size: 23px;
        margin: 0;
        padding-top: 3px;
        margin-right: 9px;
        height: 35px;
    }
    .listCustom-checkbox  .custom-control-input:checked ~ .custom-control-label::before {
        color: #fff;
        border-color: #007bff;
        background-color: #007bff;
        top: 12px;
    }

    .custom-checkbox.listCustom-checkbox .custom-control-input:checked ~ .custom-control-label::after {
        top: 12px;
    }


</style>


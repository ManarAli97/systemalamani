
<script>
    var table;
    $(document).ready(function() {

        var selected = [];

        table =  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_quantity?cat=<?php echo $cat ?>&name_device=<?php echo $name_device ?>&device=<?php echo $device ?>&from_price=<?php echo $from_price ?>&to_price=<?php echo $to_price ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 0, 'asc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
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


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl($this->folder) ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > excel export   </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<a href="<?php echo url . '/' . $this->folder ?>/quantity2" class="btn btn-primary"> excel export  ثانوي</a>
<hr>

<form action="<?php  echo url.'/'.$this->folder?>/quantity" method="get">



    <div class="row mb-4">

        <div class="col-lg-3 col-md-3">
            الماركة
            <select class="custom-select dropdown_filter"   id="brand"  name="cat"  onchange="brandx()"    >
                <option value="all"> الكل </option>
                <?php foreach ($category as $key => $catg) {   ?>
                    <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                <?php  } ?>

            </select>
        </div>
        <div class="col-lg-3 col-md-3">
            السلسلة
            <select onchange="typeDevice_public()" class="custom-select dropdown_filter"  name="name_device"   id="nameDevice_public"  >
                <option value="">   اختر السلسلة </option>
            </select>
        </div>


        <div class="col-lg-4 col-md-4">
            الجهاز
            <select    class="custom-select dropdown_filter"   id="typeDevice_publicx" name="device"   >

                <option value="">   اختر الجهاز  </option>
            </select>
        </div>


    </div>


    <script>


        $(document).ready(function(){

            $("#brand option").each(function(){
                if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                    $(this).attr("selected","selected");
                    brandx();
                }
            });
        });


        function brandx() {

            $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice_public_export_excel/" + $('#brand option:selected').val(), function (data) {
                $('#nameDevice_public').html(data);

                if (data)
                {

                    $("#nameDevice_public option").each(function(){
                        if($(this).val()===localStorage.getItem("cats2admin")){ // EDITED THIS LINE
                            $(this).attr("selected","selected");
                        }
                    });

                    typeDevice_public($('#brand option:selected').val())

                }
            });

            localStorage.setItem("cats1admin",  $('#brand option:selected').val() );

        }

        function typeDevice_public() {

            $.get("<?php echo url . '/' . $this->folder ?>/typeDevice_public_export_excel/"+$('#nameDevice_public option:selected').val(), function (data) {
                $('#typeDevice_publicx').html(data);

                cats3="<?php  echo $device ?>";
                $("#typeDevice_publicx option").each(function(){
                    if($(this).val()===cats3){ // EDITED THIS LINE
                        $(this).attr("selected","selected");
                    }
                });

            });

            localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

        }
    </script>



    <div class="row">

        <div class="col-auto">
            <input style="width: 210px" type="number" value="<?php echo $from_price ?>" name="from_price" class="form-control" placeholder="من سعر">
        </div>
        <div class="col-auto">
            <input style="width: 210px"  type="number"  value="<?php echo $to_price ?>" name="to_price" class="form-control" placeholder="الى سعر">
        </div>

        <div class="col-auto">
            <button type="submit"    class="btn btn-warning" >بحث</button>
        </div>

    </div>
</form>


<hr>
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>

                <th>    السلسه  </th>
                <th>   نوع الجهاز  </th>
                <th> اسم الحافظة </th>
                <th> الباركود </th>
                <th> التاريخ </th>
                <th> الكمية </th>
                <th> السعر </th>
                <th> الموقع </th>
                <th> الصورة </th>
                <th> تاريخ  </th>
                <th>  المواقع  </th>


            </tr>
            </thead>

        </table>

    </div>
</div>


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



<script>

    function list_location(code,model) {

        $.get("<?php  echo url.'/'.$this->folder?>/list_location/"+code+'/'+model, function(data){
            if (data)
            {
                $('#data_location_'+code).html(data)
            }
        })
    }



    function visible_savers_location(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url .'/'.$this->folder ?>/visible_savers_location/"+vis+'/'+id, function(data){

            if (vis === 1)
            {
                $(".location_active_"+id).html(`<span   style='color: green;font-weight: bold'>ON</span>`)
            }else
            {
                $(".location_active_"+id).html(`<span   style='color: red;font-weight: bold'>OFF</span>`)

            }

            table.draw()

        })
    }



</script>



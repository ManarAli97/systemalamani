

<script>
    var table;
    $(document).ready(function() {

        var selected = [];

        table =  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_quantity/<?php echo $id ?>?switch_location=<?php echo $this->switch_location ?>&from_price=<?php echo $from_price ?>&to_price=<?php echo $to_price ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 1, 'asc'] ],
            aLengthMenu: [ 10,25, 50, 100,1000,2000,-1],
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

                <li class="breadcrumb-item active" aria-current="page" > export excel  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>

<form action="<?php  echo url.'/'.$this->folder?>/quantity" method="get">
   <div class="row">
       <div class="col">
           <div class="row">
               <div class="col-auto">
                   <input type="hidden" name="switch_location" value="<?php  echo $this->switch_location ?>">
                   <div class="form-group select_drop"  style="width: 100%" >
                       <select name="id"  class="selectpicker"  aria-expanded="false"  data-live-search="true"  >
                           <option value="all"  >    عرض الكل</option>

                           <?php foreach ($data_cat as $list_cat)  {     ?>
                               <option value="<?php   echo $list_cat['id'] ?>"  <?php   if ($list_cat['id'] == $id ) echo 'selected' ?>   > <?php   echo $list_cat['title'] ?> </option>
                           <?php  }  ?>

                       </select>
                   </div>

               </div>
               <div class="col-auto">
                   <input style="width: 210px" type="number" value="<?php echo $from_price ?>" name="from_price" class="form-control" placeholder="من سعر">
               </div>
               <div class="col-auto">
                   <input style="width: 210px"  type="number"  value="<?php echo $to_price ?>" name="to_price" class="form-control" placeholder="الى سعر">
               </div>

               <div class="col-auto">
                   <button type="submit"    class="btn btn-warning" >بحث</button>
                   <button type="button"  onclick="window.location='<?php  echo url ?>/<?php  echo $this->folder ?>/quantity'"  class="btn btn-primary" ><i class="fa fa-refresh"></i> </button>
               </div>


           </div>
       </div>
       <div class="col-auto">
           <input <?php  if ($this->switch_location == 1) echo 'checked' ?>   class='toggle-demo' onchange='switch_hide(this)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>  اخفاء مفتاح مواقع التجهيز

       </div>
   </div>

</form>

<hr>
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>

                <th> اسم القسم  </th>
                <th> اسم المادة </th>
                <th> الجهاز المربوط</th>
                <th> لون المادة </th>
                <th> الباركود </th>
                <th> التأريخ </th>
                <th> الكمية </th>
                <th> السعر </th>
                <th> موقع التجهيز </th>
                <th> الصورة </th>
                <th> تعديل </th>
                <th>  تحديد مواصفات </th>
                <th> مواصفات مختصره   </th>
                <th>  كلمات داله  </th>
                <th>  ننصح به </th>
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


    function visible_accessories_location(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/accessories/visible_accessories_location/"+vis+'/'+id, function(data){
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


    function switch_hide(e) {
        var vis=$(e).is( ':checked' )? 1:0;
        if (vis===1)
        {
          window.location="<?php  echo url .'/'.$this->folder ?>/quantity?switch_location=1";
        }else
        {
            window.location="<?php  echo url .'/'.$this->folder ?>/quantity?switch_location=0";
        }
    }



</script>



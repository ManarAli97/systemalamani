

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/subscribers"><?php  echo $this->langControl('registration') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > عرض الطلبات </li>

            </ol>
        </nav>

    </div>

    <div class="col-auto" style="position: relative">
       <a href="<?php  echo url .'/'.$this->folder ?>/all_active_buy">  <i class="fa fa-bell bell_style"> </i>  <span class="number_req" > <?php  echo $this-> all_notification_buy() ?> </span></a>
    </div>

</div>


<script>

    $(document).ready(function() {


        $('#loadTable').DataTable( {
            "processing": true,
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 3, 'asc'] ],
            aLengthMenu: [ 10,25,100, 200,-1],
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


            }
        } );
    } );

</script>

<br>


<table class="table table-striped display d-table  set_text_table" id="loadTable">
    <thead>
    <tr>

        <th scope="col">الاسم </th>
        <th scope="col"> الموبايل </th>
        <th scope="col">  تاريخ الطلب  </th>
        <th scope="col">  وقت الطلب  </th>
        <th scope="col">  المحافظة </th>
        <th scope="col"> العنوان </th>
        <th scope="col"> حالة الزبون  </th>
        <th scope="col"> عرض الطلب </th>

    </tr>
    </thead>
    <tbody id="livesearch">
    <?php  foreach ($count_active as $result )  { ?>
    <tr id="row_<?php echo $result['id'] ?>">
        <td><?php echo $result['name'] ?>  </td>
        <td> <?php echo $result['phone'] ?>  </td>
        <td> <?php echo date('Y-m-d', $result['date_req']) ?> </td>
        <td> <?php echo date('h:i:s A', $result['date_req']) ?> </td>
        <td> <?php echo $result['city'] ?>  </td>
        <td> <?php echo $result['address'] ?>  </td>
         <td>  <input type="checkbox" <?php if ($result['type_customer_12']  == 1 ) echo 'checked';  ?>  onchange="type_customer(this,<?php  echo $result['id']?>)"  data-toggle="toggle" data-on="مقتنع" data-off="غير مقتنع" data-onstyle="success" data-offstyle="danger"></td>
        <td> <a href="<?php echo url .'/'.$this->folder   ?>/view_req/<?php echo $result['id'] ?>"><?php  echo $this->notification_buy($result['id']) ?> </a>   </td>
    </tr>
     <?php  }  ?>
    </tbody>
</table>



<div class="modal fade" id="exampleModalXnortex" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> السبب </h5>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">السبب</label>
                    <textarea type="text" class="form-control" id="notethiscustomer"></textarea>
                </div>
                <input hidden id="id_customer">
                <input hidden id="typle_customer">



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="out_note_customer()" data-dismiss="modal">خروج</button>
                <button type="button" class="btn btn-primary" onclick="note_customer()"> موافق </button>
            </div>
        </div>
    </div>
</div>

<script>



    function type_customer(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;


        $('#id_customer').val(id);
        $('#typle_customer').val(vis);



        $('#exampleModalXnortex').modal({
            backdrop: 'static',
            keyboard: false
        });
    }


    function note_customer() {

        notex=$('#notethiscustomer').val();
        id=$('#id_customer').val();
        vis=$('#typle_customer').val();

        if (notex)
        {

            $.get("<?php echo url  .'/'. $this->folder?>/type_customer/"+vis+'/'+id,{note:notex}, function(){

                $('#exampleModalXnortex').modal('hide');
                $('textarea#notethiscustomer').val('');
                $('input#id_customer').val('');
                $('input#typle_customer').val('');
            })

        }   else
        {


            alert('يجب كتابة السبب')
        }


    }


    function out_note_customer() {
        vis=$('#typle_customer').val();
        id=$('#id_customer').val();

        if (vis === '0')
        {
            $('tr#row_'+id+' td div input').bootstrapToggle('on');
        }else {
            $('tr#row_'+id+' td div input').bootstrapToggle('off')
        }

    }


</script>

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
</style>

<br>
<br>
<br>
<br>


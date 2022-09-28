




<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('prepared_requests') ?>  </li>

            </ol>
        </nav>
        <hr>
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
            aLengthMenu: [ 10,25,50,75, 100,-1],
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
            <?php  if ($this->permit('export_excel',$this->folder)) { ?>
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



<table class="table table-striped display d-table" id="loadTable">
    <thead>
    <tr>

        <th scope="col">اسم  الزبون </th>
        <th scope="col">رقم الهاتف </th>
        <th scope="col">  رقم الفاتورة في كرستال  </th>
        <th scope="col">  تاريخ تجهيز الطلب  </th>
        <th scope="col">  وقت تجهيز الطلب  </th>

        <th scope="col">  تأكيد التجهيز </th>
        <th scope="col"> info </th>

    </tr>
    </thead>
    <tbody>
    <?php  foreach ($prepared_requests as $info )  { ?>
        <tr class="retn_<?php echo $info['date_d_r'] ?>">
            <td><?php echo $info['name'] ?>  </td>
            <td><?php echo $info['phone'] ?>  </td>
            <td> <?php echo $info['number_bill'] ?> </td>
            <td> <?php echo date('Y-m-d', $info['date_d_r']) ?> </td>
            <td> <?php echo date('h:i:s A', $info['date_d_r']) ?> </td>

            <td>

                    <button class="btn btn-success done_delivery" id="change_attr_<?php echo $info['date_d_r'] ?>" onclick="done_delivery(<?php echo $info['number_bill']  ?>,<?php echo $info['id_member_r']  ?>,<?php echo $info['date_d_r'] ?>)"   > <span>   تأكيد التجهيز   </span>   <i class="fa fa-shopping-bag"></i>  </button>

            </td>
            <td style="text-align: center;"> <a class="btn btn-danger" href="<?php echo url  ?>/register/view_req2/<?php echo $info['id_member_r'] ?>/<?php echo $info['number_bill'] ?>">    <i class="fa fa-info-circle"></i>   </td>


        </tr>
    <?php  }  ?>
    </tbody>
</table>






<div class="modal fade" id="exampleModal_delivery_service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">   اختر موضف التوصيل </h5>
            </div>
            <div class="modal-body">
                <label class="mr-sm-2" for="idGroups">  المجموعة </label>
                <select  class="custom-select mr-sm-2" id="idGroups">
                    <?php  foreach ($groups as $key => $gp)  {  ?>
                        <option <?php  if ($key == 0)  echo 'selected' ?> value="<?php   echo $gp['id'] ?>" >  <?php   echo $gp['name'] ?>  </option>
                    <?php  }  ?>
                </select>
                <br>
                <br>
                <label class="mr-sm-2" for="user_delivery">موضف التوصيل</label>
                <select  class="custom-select mr-sm-2" id="user_delivery">

                </select>
                <br>
                <br>
                <label class="mr-sm-2" for="number_bill"> رقم الفاتورة في كرستال   </label>
                <input type="text"  id="number_bill" class="form-control">
                <input id="date_d_r_c_d" type="hidden" >
                <input id="id_member_r" type="hidden" >

            </div>
            <div class="modal-footer">
                <button   onclick="processing_request()"   type="button" class="btn btn-warning"  > موافق </button>
            </div>

        </div>
    </div>
</div>





<script>




    function processing_request_delivery_service_prepared_requests(date_d_r,number_bill,delivery_user,id_member_r) {






        idG=$('#idGroups option:selected').val();

        $.get( "<?php echo url   ?>/register/user_delivery/"+idG, function( data ) {
            $( "#user_delivery" ).html( data );
            idDly=""+delivery_user+"";
            $(document).ready(function(){
                $("#user_delivery option").each(function(){
                    if($(this).val() === idDly){
                        $(this).attr("selected","selected");
                    }
                });
            });
        });




        $('#date_d_r_c_d').val(date_d_r);

        $('#number_bill').val(number_bill);
        $('#id_member_r').val(id_member_r);

        $('#exampleModal_delivery_service').modal('show')





    }


    function  processing_request() {

        idUser=$('#user_delivery option:selected').val();
        number_bill=$('#number_bill').val();
        date_d_r=$('#date_d_r_c_d').val();
        id_member_r= $('#id_member_r').val();

        if (idUser) {
            if (number_bill) {

                $.ajax({
                    type: 'GET',
                    url: '<?php echo url  ?>/register/processing_request_edit_delivery_user/'+id_member_r,
                    cache: false,
                    data: {date_d_r:date_d_r, idUser: idUser, number_bill: number_bill},
                    success: function (result) {

                        $('#exampleModal_delivery_service').modal('hide');

                        $('#change_attr_'+date_d_r).attr('onclick','done_delivery('+idUser+','+number_bill+','+id_member_r+','+date_d_r+')');
                        $('._id_u_'+date_d_r).text($('#user_delivery option:selected').text());
                    },
                });
            } else {
                alert('يجب ادخال رقم الفاتورة')
            }
        }else
        {
            alert('يجب اختيار موظف التوصيل')
        }
    }



    function load_table() {
        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#loadTable').children();
            $('#loadTable').empty().html(founddata);
        });
    }






    function done_delivery(number_bill,id_member_r,date_d_r) {
        if (confirm(' هل انت متأكد من  اكمال تجهيز الطلب ذو رقم الفاتورة:' + number_bill)) {


            $.ajax({
                type: 'GET',
                url: "<?php  echo url . '/' . $this->folder ?>/done_delivery",
                cache: false,
                data: {number_bill:number_bill,id_member_r:id_member_r,date_d_r:date_d_r},
                success: function (response) {

                    if (response)
                    {
                        $('.retn_' + date_d_r).remove();
                        window.location='';
                    }else
                    {
                        alert('حدث خطا')
                    }


                }
            });

        }

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


</style>

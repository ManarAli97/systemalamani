
<script>
    var table='';
    $(document).ready(function() {

        var selected = [];

        table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_active_customer",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [['8','DESC'],[ 7, 'DESC'] ],
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
                    <li class="breadcrumb-item active" aria-current="page" > حظور الزبائن </li>
                 </ol>
            </nav>
            <hr>
        </div>

    </div>

<br>

    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th> الاسم واللقب</th>
                    <th> المهنة </th>
                    <th><?php  echo $this->langControl('phone') ?></th>
                    <th><?php  echo $this->langControl('city') ?></th>
                    <th><?php  echo $this->langControl('address') ?></th>
                    <th>الجنس</th>
                    <th>تاريخ الميلاد</th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th>    <i class="fa fa-circle" style="color: #0a7817" ></i> <span> نشط </span>  (<span class="count_active"><?php echo $count ?></span>) </th>
                    <th>عدد مرات  استخدام الشاشة</th>
                    <th> موظف الشاشة </th>
                    <th>   ملاحظات عن الزبون  </th>
                 </tr>
                </thead>

            </table>

        </div>
    </div>




<div class="modal fade" id="exampleModalnote_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ملاحظات حول الزبون </h5>
            </div>
            <div class="modal-body">
                <div class="table_note"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">خروج</button>

            </div>
        </div>
    </div>
</div>

<script>


    function get_note(id) {

        $('#exampleModalnote_customer').modal('show');
        $.get("<?php echo url   ?>/note_user/get_note_customer/"+id, function(data){

            if (data)
            {
                $('.table_note').html(data);

            }
        })

    }




    function date_active_customer () {

        $.get("<?php echo url  .'/'.$this->folder ?>/date_active_customer", function(data){


            if (data ==='login')
            {
                count_active();
                var audio = new Audio('<?php echo $this->static_file_site ?>/login_sound/peep1.mp3');
                audio.play();
                table.draw();
               console.log(data)
            }else if (data === 'logout')
            {
                count_active();
                table.draw();
            }
        })

    }

    setInterval(function () {
        date_active_customer();
    },2000)


    function count_active() {

        $.get("<?php echo url  .'/'.$this->folder ?>/count_active", function(data){

            $('.count_active').html(data)

        })

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







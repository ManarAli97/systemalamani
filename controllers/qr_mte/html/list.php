
<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('qr_mte') ?> </a></li>
                <li class="breadcrumb-item"> عرض الزبائن  </li>
            </ol>
        </nav>

    </div>

</div>

<form id="readqrfromdevice" method="get" action="<?php  echo url .'/'.$this->folder ?>/camera">
    <input name="qr" style="width: 0;height: 0;padding: 0;margin: 0;box-shadow: unset;outline: unset;border: 0"   inputmode="none"      autocomplete="off"  id="id_readqr" class="form-control" required>
</form>



<script>



    var table;
    $(document).ready(function() {

        var selected = [];
         table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_qr_mte",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[2]);
            },
            "order": [[ 2, 'asc'] ],
             searching: false,
            aLengthMenu: [ 100,  200,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
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






    $("#readqrfromdevice").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var actionUrl = form.attr('action');

        var audio = new Audio('<?php echo $this->static_file_site ?>/camera/qr.mp3');
        audio.play();

        $.ajax({
            type: "GET",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {


                if (data === 'add') {

                   table.draw()
                    select_readqr()
                }   else {

                    alert('رمز Qr غير صالح')
                    table.draw()
                    select_readqr()
                }



            }
        });

    });



    select_readqr();
    function select_readqr() {
        $('#id_readqr').select().val('');
    }
    setInterval(function () {
        checkFocus()
    },2000);

    function checkFocus() {
        if (!$("#id_readqr").is(":focus")) {
            select_readqr()
        }
    }


    function hide_customer(id) {

        $.get("<?php echo url .'/'.$this->folder ?>/hide/"+id, function(data){
            if (data)
            {
                table.draw()
            }else
            {
                alert('فشل الاخفاء اعد المحاوله')
            }
        })

    }


</script>


<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">  اسم الزبون   </th>

        <th scope="col">   رقم الهاتف  </th>
        <th scope="col">    الوقت  </th>
        <th scope="col">    اخفاء  </th>
    </tr>
    </thead>
</table>


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

<br>
<br>
<br>
<br>


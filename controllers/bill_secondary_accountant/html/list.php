

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item"> تفاصيل المحاسبين الرئيسين </li>
            </ol>
        </nav>

    </div>

</div>




<br>

<script>
    $(document).ready(function() {

        var selected = [];
        $('#example').DataTable( {

            info:false,
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            }
            ,
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: false

        } );
    } );
</script>

<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col"> اسم المحاسب </th>
        <th scope="col">   مبلغ مجموع الفواتير  </th>
        <th scope="col">    عدد الفواتير  </th>

    </tr>
    </thead>
    <tbody>

    <?php foreach ($user as $usr) {   ?>
    <tr>
        <td>  <?php echo $usr['username']?> </td>
        <td>  <?php echo $usr['money']?>  د.ع </td>
        <td> <a class="btn btn-warning" title="عرض الفواتير" href="<?php  echo url .'/'.$this->folder ?>/bill/<?php echo $usr['id'] ?>"><?php echo $usr['number_bill']?>  </a>  </td>

    </tr>
    <?php  } ?>

    </tbody>
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>















<div class="modal fade" id="exampleModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="    padding: 6px;" >
                    <span class="col-auto">
                      سحب المبلغ من المحاسب
                    </span>

                <span id="xdiscount"></span>

            </div>
            <div class="modal-body">
                <form id="edit_region" action="" method="post">

                        <span> المبلغ المتوفر : </span> <span class="money"></span> د.ع
                      <hr>

                    <input name="discount" class="form-control" type="number"  placeholder="المبلغ المسحوب"  >

                    <br>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="submit" value="<?php  echo $this -> langControl('save')?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $('#exampleModal_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var id_user = button.data('id_user');
        var modal = $(this);
        $.ajax({
            url: "<?php  echo url . '/' . $this->folder?>/getUser/"+id+"/"+id_user,
            cache: false,
            success: function(data){
                if (data)
                {
                    var  response = JSON.parse(data);
                    modal.find('.money').text(numberWithCommas(response.money));
                    modal.find('#xdiscount').text(response.username);
                    modal.find('#edit_region').attr("action","<?php  echo url .'/'.$this->folder?>/disaccount/"+id+"/"+id_user);
                }
            }
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function () {
        $('#edit_region').on('submit', function (e) {
            e.preventDefault();
            data = $('#edit_region').serialize()
            $.ajax({
                type: 'post',
                url: this.action,
                data: data,
                success: function (date) {
                    console.log(date)
                    if (date==="0")
                    {
                        alert('لاتوجد مبالغ لسحبها من المحاسب')
                    }else {
                        alert("تم السحب بنجاح.")
                        window.location.reload()
                    }

                }
            });

        });

    });

</script>

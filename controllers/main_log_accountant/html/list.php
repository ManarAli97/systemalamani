

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('main_log_accountant') ?> </a></li>
                <li class="breadcrumb-item">  عرض المحاسبين  </li>
            </ol>
        </nav>

    </div>

</div>



<form action="<?php echo url.'/'.$this->folder?>/search" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="date" name="date" class="form-control"    required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="date" name="todate" class="form-control"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col"> اسم المحاسب </th>
        <th scope="col">    المبلغ من الزبائن     </th>
        <th scope="col">    عدد الفواتير  </th>
        <th scope="col">  سحب  المبلغ من  المحاسبين الثانوين     </th>
        <th scope="col">    المبالغ المسترجعة الى الزبائن   </th>
        <th scope="col">    المبلغ   من القاصة  </th>
        <th scope="col">    المبلغ المسحوبة من المحاسب الرئيسي  </th>
        <th scope="col"> مبالغ الشراء(الى الزبائن ) </th>
        <th scope="col">   المجموع    </th>
        <th scope="col">    سجل سحب الموضفين الثانوين    </th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($user as $usr) {   ?>
    <tr>
        <td>  <?php echo $usr['username']?> </td>
        <td>  <?php echo number_format($usr['bill_sale']) ?>  د.ع </td>
        <td> <a class="btn btn-warning" title="عرض الفواتير" href="<?php  echo url .'/'.$this->folder ?>/bill/<?php echo $usr['id_account'] ?>"><?php echo $usr['number_bill']?>  </a>  </td>
        <td>  <?php echo number_format( $usr['secondary_accountants'])?>   د.ع  </td>
        <td>  <?php echo number_format( $usr['review_to_customer'])?>    د.ع  </td>
        <td>  <?php echo number_format( $usr['amount_from_clipping']) ?>    د.ع  </td>
        <td>  <?php echo number_format( $usr['amount_to_clipping']) ?>    د.ع  </td>
        <td>  <?php echo number_format( $usr['bill_purchase'] )?>    د.ع  </td>
        <td>  <?php echo number_format($usr['sum'])?>   د.ع  </td>

        <td>   <a href="<?php  echo url .'/'.$this->folder ?>/log_discount/<?php   echo $usr['id_account'] ?>">سجل السحب</a>  </td>

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

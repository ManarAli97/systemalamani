<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <div class="row align-items-center justify-content-between">
                <div class="col">
                    <ol class="breadcrumb">


                        <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('insert_bills') ?>  </li>
                    </ol>
                </div>
                <?php  ?>


            </div>



        </nav>


        <hr>
    </div>
</div>


<div class="row justify-content-center">
    <div class="coll-lg-7">



        <?php  if ($save == true) {  ?>


            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span> تم حفط  </span> <span>  <?php  echo $count_bill ?>  </span> <span>  فاتورة </span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>





        <?php  }  ?>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="alert alert-primary   mesXom" role="alert">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <strong> اجمالي الفواتير </strong>
                        </div>

                        <div class="col-auto">

                            <div id="total_amount">0</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>





            <div class="row  x_report">

                <div class="col">
                    <form>
                        <div class="row">


                    <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                        <label class="mr-sm-2"  for="bbb">رقم الفاتورة</label>
                        <input type="text"  id="n_bill"  class="form-control"  placeholder="رقم الفاتورة" required>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                        <label class="mr-sm-2" for="aaa">مبلغ الفاتورة</label>
                        <input type="number"   onkeyup="sum()" id="n_amount"  class="form-control amount_bill"  placeholder="مبلغ الفاتورة" required>
                    </div>

                    <div style="text-align: center" class="col-lg-2 col-md-2 col-sm-2 col-2  align-self-end">
                        <button   id="add_new" onclick="add_new_row()"  type="submit" class="btn btn-success"> <i class="fa fa-plus-circle"></i> </button>
                    </div>
                        </div>
                      </form>
                  </div>


                    <div class="col-auto  align-self-end">
                        <button  id="save_bill"  style="    margin-bottom: 0 !important;"   type="button" class="btn btn-warning mb-2">حفظ</button>
                    </div>

            </div>




        <form id="add_bill_list" action="<?php  echo url .'/'.$this->folder ?>/insert_bills" method="post">
            <div class="add_new"> </div>

            <input type="hidden" name="submit_x" value="submit_x" >
        </form>

    </div>
</div>
<style>
    .x_report
    {
        border-bottom: 1px solid #e4e4e4;
        margin: 10px 0;
        padding: 7px 0;
        background: #e8e8e8;
    }

    @media (max-width: 460px) {
        .x_btn_save
        {
            width: 100%;
            text-align: center;
        }
    }
</style>


<script>


    $(document).ready(function() {
        $("#save_bill").click(function() {

            $("#add_bill_list").submit();

        });
    });





    count=0;
    function add_new_row() {
        n_bill=$('#n_bill').val();
        n_amount= $('#n_amount').val();

        if (n_bill && n_amount) {


            count += 1;


            $('.add_new').append(`


        <div class="row justify-content-center x_report remove_row_${count}" >

        <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                <input type="text" name="bill[]"  id="n_bill_${count}"   class="form-control"  placeholder="رقم الفاتورة" required>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                <input type="number" name="amount[]" onkeyup="sum()"  id="n_amount_${count}"      class="form-control amount_bill"  placeholder="مبلغ الفاتورة" required>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-2  align-self-end">
                   <button   id="add_new" onclick="remove_row(${count})"  type="button" class="btn btn-danger"> <i class="fa fa-minus"></i> </button>
            </div>
        </div>

        `)

            $('#n_bill_' + count).val(n_bill);
            $('#n_amount_' + count).val(n_amount);

            $('#n_bill').val('');
            $('#n_amount').val('');

        }



    }


    function  sum ()
    {

        max_valu=<?php echo $this->setting->get('amount_bill',7000000) ?>;
        valu= Array.from(
            document.querySelectorAll('.amount_bill')
        ).map(e=>parseInt(e.value)||0)
            .reduce((a,b)=>a+b,0);
        if (Number(valu) >= max_valu)
        {
            $('.mesXom').removeClass('alert-primary');
            $('div.mesXom').addClass('alert-danger')
        }else
        {
            $('.mesXom').removeClass('alert-danger');
            $('div.mesXom').addClass(' alert-primary')
        }

        $('#total_amount').text(formatter.format(valu) +' د.ع ')
    }

    var formatter = new Intl.NumberFormat('en-US', {

        currency: 'USD',
    });



    function remove_row(id) {
        $('.remove_row_'+id).remove();
        sum();
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

</style>



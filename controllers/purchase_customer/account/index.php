<div class="hide_print">
    <br>
    <div class="row">
        <div class="col">

            <nav aria-label="breadcrumb" >

                <ol class="breadcrumb"  >
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('purchase_customer') ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('account_bill_purchase_customer') ?> </li>

                </ol>

            </nav>

        </div>
    </div>

    <hr>
</div>
    <div class="row">

        <div class="col-lg-3">
            <div class="hide_print">
            <div class="list_customer">

                <?php  foreach ($bill as $data) {   ?>

                    <div class="btn_list_user" id="bill<?php  echo $data['number_bill'] ?>" onclick="getDateBill(this,<?php  echo $data['id'] ?>,<?php  echo $data['id_customer'] ?>,<?php  echo $data['number_bill'] ?>)"  >
                        <div class="name_customer"> <span> <?php  echo $data['name'] ?> </span> ( <span> <?php  echo $data['number_bill'] ?> </span> ) </div>
                        <div class="phone_number" dir="ltr">

							<?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
								<?php echo  $data['phone'] ?>
							<?php }else{ ?>
								<?php echo substr($data['phone'], 0, 3) . "*****" . substr($data['phone'], 8) ?>
							<?php  }  ?>

                        </div>
                    </div>

                <?php  } ?>
            </div>
            </div>
        </div>
        <div class="col-lg-9">
              <div class="result"></div>
        </div>

    </div>

    <script>

        function getDateBill(e,id_bill,id_customer,number_bill) {

            $('.btn_list_user').removeClass('active_bill');
            $(e).addClass('active_bill');


            $.get( "<?php echo url .'/'.$this->folder ?>/getDateBill",{id_bill:id_bill,id_customer:id_customer,number_bill:number_bill}, function( datax ) {
                if (datax)
                {

                    $('.result').html(datax);

                }
            });

        }


        function payToCustomer(id_customer,number_bill) {

            if (confirm('هل انت متاكد من تسديد الزبون ؟'))

            {
                $.get( "<?php echo url .'/'.$this->folder ?>/pay",{id_customer:id_customer,number_bill:number_bill}, function( data ) {


                    console.log(data);
                    if (data==='true')
                    {
                        print_bill_sale_casher();
                        $( "#bill"+number_bill ).remove();
                        $( ".result" ).empty();
                    }else if (data==='-1')
                    {
                        alert('لا يوجد مبلغ كافي في حسابك لتسديد الزبون ')
                    }
                    else
                    {
                        alert('حدثت مشكلة اعد المحاولة')
                    }
                });
            }return false;


        }


    </script>


    <style>

        .active_bill
        {
            background: #add !important;
        }
        .list_customer
        {
            border: 2px solid #eaeaea;
            height: 700px;
            overflow: auto;
            padding: 5px;
        }
        .btn_list_user {
            background: #ecedee;
            cursor: pointer;
            margin-bottom: 5px;
            padding: 10px 9px;
            font-size: 18px;
        }
        .name_customer {
            margin-bottom: 10px;
        }
        .phone_number {

        }

        .infoBill {
            font-size: 20px;
            font-weight: bold;
        }
        .type_price {
            padding: 0 5px;
            font-weight: bold;
        }
    </style>

    <br>
    <br>
    <br>
    <br>
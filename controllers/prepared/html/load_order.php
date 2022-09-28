<?php  foreach ($count_active as $result )  { ?>
    <div class="col-12 " >
        <a class="infoCustomer ifactive" id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">

            <div class='row align-items-center justify-content-between'>
                <div class='col'>
                    <div><?php echo $result['name'] ?>  (<?php  echo $result['number_bill']  ?>)</div>
                    <div  style="direction: ltr;">

                        <?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
                            <?php echo  $result['phone'] ?>
                        <?php }else{ ?>
                            <?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
                        <?php  }  ?>

                    </div>
                </div>
                <?php  if ($result['user_direct']){ ?>
                    <div class='col-auto'>
                        <div class='user_account'>     <?php echo $this->UserInfoBill($result['user_direct']) ?> </div>
                    </div>
                <?php } ?>
            </div>



        </a>
    </div>
<?php  }  ?>
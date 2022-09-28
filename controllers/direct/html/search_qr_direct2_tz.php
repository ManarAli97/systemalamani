

<?php if (!empty($data)) {  ?>

<div class="row">
<?php  foreach ($data as $result )  { ?>


        <div class="col-12 " >
            <a class="active_order_by_qr infoCustomer ifactive" id="row<?php echo $result['number_bill'] ?>" href="#" onclick="getOrder(<?php  echo $result['id']  ?>,'<?php  echo $result['number_bill']  ?>')">
                <div><?php echo $result['name'] ?>  (<?php echo $result['number_bill'] ?>)</div>
                <div  style="direction: ltr;">

                    <?php  if ($this->permit('number_phone_show',$this->folder)) {  ?>
                        <?php echo  $result['phone'] ?>
                    <?php }else{ ?>
                        <?php echo substr($result['phone'], 0, 3) . "*****" . substr($result['phone'], 8) ?>
                    <?php  }  ?>

                </div>

            </a>
        </div>


<?php  }  ?>
<?php  }  ?>
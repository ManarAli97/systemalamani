
<?php  foreach ($chat as $key  => $chx )  {  ?>


    <div class="day_message">   <span data-toggle="collapse" data-target="#id_d<?php echo $key ?>" aria-expanded="true" aria-controls="id_d<?php echo $key ?>"> <?php  echo date('Y-m-d', $key)?> </span></div>

    <div class="show collapse  <?php   if (strtotime(date('Y-m-d',time())) == $key)  echo 'show' ?>" style="padding: 0 8px;" id="id_d<?php echo $key ?>"   aria-labelledby="id_d<?php echo $key ?>" data-parent="#accordion"  >

        <?php  foreach ($chx as $ch ) { ?>

            <div    class="m-position <?php  echo $ch['direction']  ?>"  >

                <span class="line_message  <?php   if ($this->get_num_of_words($ch['message']) >  15) echo 'block'; ?> " data-toggle="tooltip" data-placement="right" title="<?php  echo date('Y-m-d h:i:s a',  $ch['date'])  ?>"> <?php   echo $ch['message'] ?>

                </span>

            </div>

        <?php  }  ?>
    </div>

<?php  }  ?>
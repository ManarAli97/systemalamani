

<table class="table table-striped set_text_table">

    <?php  foreach ($count_active as $result )  { ?>
    <tr>
        <td><?php echo $result['name'] ?>  </td>
        <td> <?php echo $result['username'] ?> </td>
        <td> <?php echo date('Y-m-d', $result['date_req']) ?> </td>
        <td> <?php echo date('h:i:s A', $result['date_req']) ?> </td>
        <td> <?php echo $result['email'] ?>   </td>
        <td> <?php echo $result['phone'] ?>  </td>
        <td> <?php echo $result['city'] ?>  </td>
        <td> <?php echo $result['address'] ?>  </td>
        <td> <a href="<?php echo url .'/'.$this->folder   ?>/view_req/<?php echo $result['id'] ?>"><?php  echo $this->notification_buy($result['id']) ?> </a>   </td>
    </tr>
     <?php  }  ?>

</table>


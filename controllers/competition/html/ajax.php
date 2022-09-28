<?php  if (!empty($result))   {  ?>

<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>

                <th>#</th>
                <th><?php echo $this->langControl('name') ?> </th>
                <th><?php echo $this->langControl('phone') ?> </th>
                <th>  الاجابة  </th>
                <th>  نوع الاختيار  </th>
                <th><?php echo $this->langControl('date') ?> </th>
            </tr>
            </thead>
            <tbody>

           <?php  foreach ($result as $key=> $resl ) { ?>
            <tr>
                <td><?php echo $key+1  ?></td>
                <td><?php echo $resl['name'] ?></td>
                <td><?php echo $resl['phone'] ?></td>
                <td><?php echo $resl['correct'] ?></td>
                <td><?php echo $resl['id_ans'] ?></td>
                <td><?php echo $resl['date'] ?></td>
            </tr>
            <?php  }  ?>
            </tbody>


        </table>

    </div>
</div>

<?php   } else  {  ?>
    <div class="alert alert-warning" role="alert">
       لا يوجد اي فائز
    </div>
<?php   }   ?>

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
    .p_nm
    {
        margin: 0;
    }
</style>

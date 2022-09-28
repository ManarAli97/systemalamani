<table class="requ_on table table-striped">
    <thead>


    <tr style="background: #125da9;color: #ffffff">
        <th style="background: #125da9;color: #ffffff" scope="col">صورة</th>

        <th style="background: #125da9;color: #ffffff" scope="col">القياس</th>
        <th style="background: #125da9;color: #ffffff" scope="col">اللون</th>
        <th style="background: #125da9;color: #ffffff" scope="col">العدد</th>


    </tr>

    </thead>
    <tbody>



        <tr>
            <td ><img class="image_prod"   alt="image" title="image" style="display:block" src="<?php  echo $result['image'] ?>"></td>
            <td ><?php  echo $result['size'] ?></td>
            <td style="text-align: center"><span class="color_item_table" style="background: <?php  echo $result['color'] ?>">  </span></td>
            <td  ><?php  echo $result['number'] ?></td>


        </tr>


    </tbody>
</table>
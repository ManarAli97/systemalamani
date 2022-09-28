<!DOCTYPE html>
<html>
<head>
    <title> Install DataBase </title>
</head>
<body style="text-align: center">


<?php if (!empty($table))  { ?>

<div class="body_border">


    <?php if (empty($table[1])) { ?>

        <div class="succeeded">
            &#10004;
        </div>
    <?php } ?>


    <?php if (!empty($table[1])) { ?>

        <div class="fail">
            &#10006;
        </div>
    <?php } ?>


    <h2>  <?php echo $modules ?> انشاء جداول </h2>
    <?php if (!empty($table[0])) { ?>
        <table>
            <tr>
                <th>No.</th>
                <th>Table</th>

            </tr>


            <h3> Created Table </h3>
            <?php foreach ($table[0] as $key => $foundTB) {

                ?>

                <tr>
                    <td>  <?php echo $key + 1 ?> </td>
                    <td>  <?php echo $foundTB ?> </td>
                </tr>

            <?php } ?>

        </table>
    <?php } ?>
    <?php if (!empty($table[1])) { ?>
        <table>
            <tr>
                <th>No.</th>
                <th>Table</th>

            </tr>

            <h3 style="color: red"> Not Created Table </h3>
            <?php foreach ($table[1] as $key => $foundTB) {

                ?>
                <tr>
                    <td>  <?php echo $key + 1 ?> </td>
                    <td>  <?php echo $foundTB ?> </td>
                </tr>

            <?php } ?>

        </table>
    <?php } ?>
    <?php } ?>
</div>
</body>
</html>


<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #bcb7b7;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .body_border {
        border: 2px solid #393d74;
        padding: 18px;
        margin-bottom: 32px;
        border-radius: 15px;

        max-width: 500px;
        position: relative;
    }

    .succeeded {
        position: absolute;
        width: 25px;
        height: 23px;
        right: 0;
        border-radius: 50%;
        text-align: center;
        padding-top: 1px;
        color: #fff;
        background: #73d473;
        margin-right: 8px;
        margin-top: -8px;

    }

    .fail {
        position: absolute;
        width: 25px;
        height: 23px;
        right: 0;
        border-radius: 50%;
        text-align: center;
        padding-top: 1px;
        color: #fff;
        background: red;
        margin-right: 8px;
        margin-top: -8px;

    }

</style>


<?php if (!empty($data)) { ?>



    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                aLengthMenu: [ 10,25, 50, 100,-1],
                oLanguage: {
                    sLoadingRecords: "تحميل ...",
                    sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                    sLengthMenu: "عرض _MENU_ ",
                    sSearch: " أبحث  ",
                    oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                    sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                    sSearchPlaceholder: "البحث"


                },
                dom: 'Bfrtip',
                buttons: [
                    'excel'  ,
                    'pageLength'
                ],
                bFilter: true, bInfo: true
            } );
        } );
    </script>





    <table class="table table-bordered" id="example">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">صورة</th>
        <th scope="col">القسم</th>
        <th scope="col">اسم الماده</th>
        <th scope="col">رمز المادة</th>
        <th scope="col"> سيريال</th>
        <th scope="col">رقم الفاتورة</th>
        <th scope="col" style="background: darkseagreen">حركة السيريال</th>
        <th scope="col">التاريخ</th>
        <th scope="col">المستخدم</th>


    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $key => $d)  {  ?>

    <tr>


        <th scope="row"> <?php echo $key + 1 ?>  </th>
        <td><img width="40" src="<?php  echo $this->save_file.$d['img'] ?>"></td>
        <td><?php echo  $d['model'] ?></td>
        <td><?php echo  $d['title'] ?></td>
        <td><?php echo  $d['code'] ?></td>
        <td><?php echo  $d['serial'] ?></td>
        <td><?php echo  $d['number_bill'] ?></td>
        <td style="background: darkseagreen"><?php echo  $d['move'] ?></td>
        <td><?php echo  date('Y-m-d h:i:s a',$d['date']) ?></td>
        <td><?php echo  $d['user'] ?></td>
    </tr>
 <?php  }  ?>

    </tbody>

</table>

<?php  }  else {  ?>

    <div class="alert alert-warning" role="alert">
      لا توجد بيانات لهذا السيريال
    </div>

<?php  }   ?>


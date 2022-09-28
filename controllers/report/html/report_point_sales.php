    

    <div class="form-row m-4">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="validationServer-fromdate_normal">القسم<span style="color: red;font-size: 14px;"> </span>  </label>
            <select name="category[1]" class=" dropdown_filter selectpicker form-control" data-live-search="true"  id="section" required>
                <?php foreach ($this->category_website as $key => $value) {   ?>
                    <option value="<?=$key?>"><?= $value?></option>
                <?php  } ?>
            </select>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="validationServer-fromdate_normal">  من تاريخ   <span style="color: red;font-size: 14px;"> </span>  </label>
            <input name="fromdate_normal" class="form-control"  id="fromdate_normal"    type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  required>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="validationServer-todate_normal">  الى تاريخ  <span style="color: red;font-size: 14px;"> </span>  </label>
            <input name="todate_normal" class="form-control"  id="todate_normal"    type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  required>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="validationServer-todate_normal">  .. <span style="color: red;font-size: 14px;"> </span>  </label>
            <button type="button" class="btn btn-success form-control" id="show_point">عرض </button>
        </div>
    </div>




    <table id="example" class="table table-striped display d-table">
        <thead>
            <tr>
                <th>الموظف</th>
                <th>النقاط</th>
            </tr>
        </thead>
    </table>



    <script>

    $('#show_point').on('click',function(){
        var model=$("#section").val() ;
        var fromdate_normal=$("#fromdate_normal").val();
        var todate_normal= $("#todate_normal").val();

        var table = $('#example').DataTable();
            table.destroy();
            $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url . '/' . $this->folder ?>/get_point/"+model+"/"+fromdate_normal+"/"+todate_normal+"",
            //aLengthMenu: [50, 100, 200, 300, -1],
                oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {
                    sFirst: "First",
                    sLast: "Last",
                    sNext: "&raquo;",
                    sPrevious: "&laquo;"
                },
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            },
            buttons: [
                'excel',
                'pageLength'
            ],
        });    

    });
</script>
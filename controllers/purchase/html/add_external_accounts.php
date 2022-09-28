
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('external_accountants') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<?php if ($this->permit('create_external_accountants','purchase')){ ?>
<form>

  <div class="form-group row">
    <div class="col-md-3">
       اسم المحاسب
      <input type="text" class="form-control" id="name_accountants" list='list'><datalist id="list"> </datalist>

    </div>
    <button type="button" id="external_accountants" class="btn btn-success" >اضافة</button>
  </div>

</form>
<?php } ?>
<hr>
<div class="row">
    <div class="col">
        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> التسلسل </th>
                <th> اسم المحاسب </th>
                <th> اسم المستخدم </th>
                <th> تاريخ الاضافة</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        var selected = [];
        var table = $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_external_accountants",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
            },

            'columnDefs': [{
                "targets": [0],
                "orderable": false
            }],

            aLengthMenu: [ 50,100, 200, 300,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            <?php  }  ?>
            bFilter: true, bInfo: true,

        } );
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();

            // Get the column API object
            var column = table.column( $(this).attr('data-column') );

            // Toggle the visibility
            column.visible( ! column.visible() );
        });

    });


    $('#name_accountants').on('input',function() {
      var  nameAccount = $('#name_accountants').val();
        var data={'name':nameAccount};
        // console.log(data);
        $.get( "<?php echo url .'/'.$this->folder ?>/selectUser/",{ jsonData: JSON.stringify(data)}, function(nameUser) {
            var user = JSON.parse(nameUser);
            allUser = '';
            for(var i=0;i<user.length;i++){
                allUser += '<option value="'+user[i].name+'"  />';
            }
            $('#list').html(allUser);
        });
    });

    $( "#external_accountants" ).click(function() {
        var name = $('#name_accountants').val();
        console.log(name);
        var  dataD={'name':name};
        if(name != ''){
            $.get( "<?php echo url .'/'.$this->folder ?>/create_external_accountants/",{ jsonData: JSON.stringify(dataD)}, function(data) {
                console.log(data);
        if(data != 1){
            alert( "تم اضافة '" + name + "'");
            location.reload();
        }
            else{
            alert( "لم تتم اضافة '" + name + "'");
            }
        });

        }else{
            alert('ادخل اسم المحاسب');
        }

    });

</script>

<style>
    .breadcrumb{
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background-color: rgba(121,169,197,.92) !important;
        -webkit-box-shadow: 0px -4px 3px #ccc;
        -moz-box-shadow: 0px -4px 3px #ccc;
        box-shadow: 0px -4px 10px #ccc;
    }
    .breadcrumb li {
        color: #fff !important;
    }
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
    input[type="text"]
    {
        border-radius: 6px;
        margin-top: 5px;
    }
    #external_accountants{
        border-radius: 6px;
        margin-top: 28px;
        height:38px;
        width:6%;
        color: #ffff;
    }
</style>


<br>
<br>
<br>



















<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('add_catg_account') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col">
        <form  action="<?php echo url.'/'.$this->folder ?>/add_catg_account" method="post" enctype="multipart/form-data">
            <div class="container-fluid" id="expand_menu">
                <div class="row selec_catg">
                    <div class="col-lg-3 col-md-3">
                        <label class="mr-sm-2" for="name_categ">   الاسم </label>
                        <input type="text" name="name_categ"  class="form-control" id="name_categ">
                    </div>
                    <select name="main_catg"  id="her_add_menu" class="custom-select  col-md-2 list_menu_categ" onchange="mainCatg(this)"  >
                        <option value="0" selected> نوع الحساب</option>
                        <?php foreach ($nameCategory as $key => $name) {   ?>
                            <option  value="<?php  echo $name['id']?>"><?php  echo $name['title']?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>

            <div class="container-fluid " id="expand_menu">
                <div class="row selec_branch">
                    <select name="main_branch"  id="sub_branch_p" class="custom-select  col-md-2 list_menu_categ" onchange="mainBranch(this)"  >
                        <option value="0" selected> الفرع </option>
                        <?php foreach ($nameBranch as $key => $name) {   ?>
                            <option  value="<?php  echo $name['id']?>"><?php  echo $name['title']?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>

            <div class="row justify-content-md-center  mb-4" style="clear: both;">
                <input class="btn btn-primary" id="save" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
            </div>
        </form>
    </div>
</div>


<script>
    function mainCatg(selectObject) {
        var idGategory = selectObject.value;

        var data={'id':idGategory};
        var id_html = selectObject.id;

        if (idGategory != '0') {
            $("select[name='sub_categ']").remove();
            $.get("<?php echo url . '/' . $this->folder ?>/get_sub_catg/",{ jsonData: JSON.stringify(data)}, function (data) {
                if (data) {
                    $('#' + id_html).nextAll('select').remove();
                    $('#' + id_html + ':last').after(data);
                }
            });
        }else{
            $("select[name='sub_categ']").remove();
        }
    }

    function sub_catgs(selectObject)
    {
        var idGategory = selectObject.value;

        var data={'id':idGategory};
        var id_html = selectObject.id;
        if (idGategory != '0') {
            $.get("<?php echo url . '/' . $this->folder ?>/get_sub_catgs/",{ jsonData: JSON.stringify(data)}, function (data) {
                if (data)
                {
                    $('#'+id_html).nextAll('select').remove();
                    $('#'+id_html+':last').after(data);
                }
                else
                {
                    $('#'+id_html).nextAll('select').remove();
                }
            });
        }else{
            $('#'+id_html).nextAll('select').remove();

        }
    }


    function mainBranch(selectObject) {
        var idBranch = selectObject.value;
        var data={'id':idBranch};
        var id_html = selectObject.id;
        if (idBranch != '0') {
            // $("select[name='sub_branch']").remove();
            $.get("<?php echo url . '/' . $this->folder ?>/get_sub_branch/",{ jsonData: JSON.stringify(data)}, function (data) {
                if (data) {
                    $('#' + id_html).nextAll('select').remove();
                    $('#' + id_html + ':last').after(data);
                }
            });
        }else{
            $('#' + id_html).nextAll('select').remove();
        }
    }

    function sub_branches(selectObject)
    {
        var idBranch = selectObject.value;
        var data={'id':idBranch};
        var id_html = selectObject.id;
        if (idBranch != '0') {
            $.get("<?php echo url . '/' . $this->folder ?>/get_sub_branches/",{ jsonData: JSON.stringify(data)}, function (data) {
                if (data)
                {
                    console.log(id_html);
                    $('#'+id_html).nextAll('select').remove();
                    $('#'+id_html+':last').after(data);
                }
                else
                {
                    $('#'+id_html).nextAll('select').remove();
                }
            });
        }else{
            $('#'+id_html).nextAll('select').remove();

        }
    }

    setInterval(function() {
        // var o = $('.selec_catg select:last').val();
        // console.log(o);

        var name = $('#name_categ').val();
        var relid = $('.selec_catg select:last').val();
        // var idbranch = $('.selec_branch select:last').val();
        var relidl = $('.selec_catg :nth-last-child(-1)').val();
        console.log(relidl);
        // console.log(relid);
        // console.log(idbranch);
    }, 1000);

    $('#save').on('click',function () {
        var name = $('#name_categ').val();
        var relid = $('.selec_catg select:last').val();
        var relidl = $('.selec_catg select:last[-1]').val();
        var idbranch = $('.selec_branch select:last').val();
        console.log(name);
        console.log(relid);
        console.log(relidl);
        console.log(idbranch);
        var data={'name':name,'relid':relid,'idbranch':idbranch};
        // if(name != ''){
        //     $.get( "<?php echo url ?>/create_account_catg", { jsonData: JSON.stringify(data)},function( data ) {
        //         if(data == 1){
        //             alert(' تمت الاضافة');
        //         }else{
        //             alert('لم تتم الاضافة');
        //         }
        //     });
        // }
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
.list_menu_categ
{
    outline: none;
    box-shadow: unset;
    margin-top: 30px;
}
.list_menu_categ:focus
{
    outline: none;
    box-shadow: unset;
}

</style>
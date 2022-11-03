<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" ><?php  echo $this->langControl('edit_catg_account') ?> </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col">
        <form  action="<?php echo url.'/'.$this->folder ?>/edit_catg_account/<?php echo $id ?>" method="post" enctype="multipart/form-data">
            <div class="container-fluid" id="expand_menu">
                <div class="row selec_catg">
                    <div class="col-lg-3 col-md-3">
                        <label class="mr-sm-2" for="name_categ">   الاسم </label>
                        <input type="text" name="name_categ" value="<?php echo $accountCatg[0]['title'] ?>" class="form-control" id="name_categ">
                    </div>
                    <select name="main_catg"  id="main_catg" class="custom-select  col-md-2 mr-4 list_menu_categ" >
                        <option value="0" selected> نوع الحساب</option>
                        <?php foreach ($nameCategory as $key => $name) {   ?>
                            <option  value="<?php  echo $name['id']?>"<?php  if ($name['id']==$accountCatg[0]['relid'])  echo 'selected' ?>><?php  echo $name['title']?></option>
                        <?php  } ?>
                    </select>

                    <select name="main_branch"  id="main_branch" class="custom-select  col-md-2 list_menu_categ">
                        <?php foreach ($nameBranch as $key => $name) {   ?>
                            <option  value="<?php  echo $name['id']?>"<?php  if ($name['id']==$accountCatg[0]['idbranch'])  echo 'selected' ?>><?php  echo $name['title']?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>



            <div class="row justify-content-md-center  mt-4">
                <input type="submit" name="submit" class="btn btn-primary" id="save" value="<?php  echo $this->langControl('save') ?>">
            </div>
        </form>
    </div>
</div>


<script>



    // $('#save').on('click',function () {
    //     var name = $('#name_categ').val();
    //     var relid = $('#main_catg').val();
    //     var idbranch = $('#main_branch').val();
    //     console.log(name);
    //     console.log(relid);
    //     console.log(idbranch);
    //     var data={'name':name,'relid':relid,'idbranch':idbranch};
    //     if(name != ''){
    //         $.get( "< ?php echo url .'/'.$this->folder ?>/create_account_catg",{jsonData: JSON.stringify(data)},function(result) {
    //             console.log(result);
    //             if(result == 1){
    //                 alert(' تمت الاضافة');
    //                 location.reload();
    //             }else{
    //                 alert('لم تتم الاضافة');
    //             }
    //         });
    //     }
    // });

    $('#main_branch').on('change',function () {
        var idbranch = $('#main_branch').val();
        console.log(idbranch);
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
#save{
        border-radius: 6px;
        margin-top: 28px;
        height:38px;
        width:6%;
        color: #ffff;
    }

</style>
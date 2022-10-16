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


<div class="content">
    <form  action="<?php echo url.'/'.$this->folder ?>/add_catg_account" method="post" enctype="multipart/form-data">

        <div class='part_1'>
            <div class="form-row row mb-4 add">

                <div class="col-lg-3 col-md-2 mr-4">
                    <label class="mr-sm-2" for="name_categ">   الاسم </label>
                    <input type="text" name="name_categ"  class="form-control" id="name_categ">
                </div>

                <div class="col-lg-2 col-md-2 mr-4">
                    <label class="mr-sm-2" for="type_account_1">نوع الحساب </label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="type_account" id="type_account_1" required>
                        <option value = '0'> نوع الحساب </option>
                        <?php foreach ($nameCategory as $key => $name) {   ?>
                                <option  value="<?php  echo $name['id']?>"><?php  echo $name['title']?></option>
                            <?php  } ?>
                    </select>

                    <p id="f"></p>
                </div>
            </div>
        </div>

        <!-- <div class='part_2'>
            <div class="form-row row mb-4">
                <div class="col-lg-3 col-md-2 mr-4">
                    <label class="mr-sm-2" for="select_name_supplier">نوع الحساب </label>
                    <select class="form-control dropdown_filter selectpicker" data-live-search="true" name="name_supplier" id="select_name_supplier" required>
                        <option value = '0'> نوع الحساب </option>
                        <?php foreach ($nameCategory as $key => $name) {   ?>
                                <option  value="<?php  echo $name['id']?>"><?php  echo $name['title']?></option>
                            <?php  } ?>
                    </select>
                </div>
            </div>
        </div> -->
        <div class="row justify-content-md-center  mb-4" >
            <input class="btn btn-primary" id="save" value="<?php  echo $this->langControl('save') ?>"  type="submit" name="submit">
        </div>
    </form>
</div>


<script>
    $('#type_account_1').on('change',function() {
        var idGategory = $("#type_account_1").val();
        if(idGategory != '0'){
            console.log(idGategory);
            var data={'id':idGategory};
            $.get( "<?php echo url .'/'.$this->folder ?>/get_sub_catg/",{ jsonData: JSON.stringify(data)}, function(namecatg) {

                console.log(namecatg);
                var namecatg = JSON.parse(namecatg);
                var  addSelect = `<div class="col-lg-2 col-md-2  mb-4 mr-2">
                    <label class="mr-sm-2" for="type_account4">نوع الحساب </label>
                    <select class=" form-control" >
                    <option value = "0"> نوع الحساب </option>`;
                    for(var i=0;i<namecatg.length;i++){
                        addSelect += `<option value="${namecatg[i].id}"> ${namecatg[i].title} </option>`;

                    }
                    addSelect += `</select></div>`;
                $('.add').append(addSelect);

            });
        }
    });



</script>


<style>

select option {
  background: #fff;
  color: #000;
}
</style>
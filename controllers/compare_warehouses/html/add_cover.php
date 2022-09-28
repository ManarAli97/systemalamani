<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/add"> رفع ملف اكسل اجهزة الموبايل </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<br>
<table border="1" style="text-align: center">
    <thead>
    <tr>
        <th>الحقل الاول</th>
        <th>الحقل الثاني</th>
        <th>الحقل الثالث</th>
        <th>الحقل الرابع</th>
        <th>الحقل الخامس</th>
        <th>الحقل السادس</th>



    </tr>
    </thead>
    <tbody>
    <tr>
        <td>الباركود</td>
        <td>اسم المادة</td>
        <td> الاسم الاتيني  </td>
        <td> الكمية من المستودع 1  </td>
        <td>    .....  </td>
        <td>   المستودع رقم 25 </td>

    </tr>

    </tbody>
</table>

<hr>




<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active title_normal" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">  رقع ملف اكسل للمقارنة المستودعات</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active normal" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


        <br>

        <form    action="<?php echo url.'/'.$this->folder ?>/add_cover"  method="post" enctype="multipart/form-data">


            <div class="row align-items-end">

                <div class="col-lg-3 col-md-3">
                    الماركة
                    <select class="custom-select dropdown_filter" name="brand" id="brand"   onchange="brandx()"    >
                        <option>   اختر الماركة </option>
                        <?php foreach ($category as $key => $catg) {   ?>
                            <option    value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
                        <?php  } ?>

                    </select>
                </div>
                <div class="col-lg-2 col-md-2">
                    السلسلة
                    <select onchange="typeDevice_publicx()" class="custom-select dropdown_filter" name="series"   id="nameDevice_public"  >
                        <option>   اختر السلسلة </option>
                    </select>
                </div>


                <div class="col-lg-3 col-md-3">
                    الجهاز
                    <select name="id_device" class="custom-select dropdown_filter"   id="typeDevice_public"  >

                        <option>   اختر الجهاز  </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-2">
                    النوع
                    <select id="type_cover"  name="type_cover"  class="custom-select dropdown_filter"     required>

                        <option <?php  if ($type=='all') echo 'selected' ?>  value="all" >الكل</option>
                        <option  <?php  if ($type=='ml') echo 'selected' ?>  value="ml" >   رجالي  </option>
                        <option <?php  if ($type=='fa') echo 'selected' ?>  value="fa" >   نسائي  </option>

                    </select>
                </div>



            </div>
            <script>

                $(document).ready(function(){

                    $("#brand option").each(function(){
                        if($(this).val()===localStorage.getItem("cats1admin")){ // EDITED THIS LINE
                            $(this).attr("selected","selected");
                            brandx();
                        }
                    });
                });


                function brandx() {


                    $.get("<?php echo url  ?>/savers/getNmaDevice_public/" + $('#brand option:selected').val(), function (data) {
                        $('#nameDevice_public').html(data);

                        if (data)
                        {

                            $("#nameDevice_public option").each(function(){
                                if($(this).val()===localStorage.getItem("cats2admin")){ // EDITED THIS LINE
                                    $(this).attr("selected","selected");
                                }
                            });

                            typeDevice_publicx($('#brand option:selected').val())


                        }
                    });

                    localStorage.setItem("cats1admin",  $('#brand option:selected').val() );


                }

                function typeDevice_publicx() {

                    $.get("<?php echo url  ?>/savers/typeDevice_public/"+$('#nameDevice_public option:selected').val(), function (data) {
                        $('#typeDevice_public').html(data);

                        cats3="<?php  echo $id ?>";
                        $("#typeDevice_public option").each(function(){
                            if($(this).val()===cats3){ // EDITED THIS LINE
                                $(this).attr("selected","selected");
                            }
                        });

                    });

                    localStorage.setItem("cats2admin", $('#nameDevice_public option:selected').val());

                }




            </script>





            <div class="form-row">
                <div class="col-md-12 mb-12 lg-12">
                    <style>

                        .label_image
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                        .label_files
                        {
                            float: right;
                            padding: 7px;
                            background: #eeeff0;
                        }
                    </style>


                    <span style="color: red;font-size: 14px;" id="files_normal"> </span>
                    <br>

                    <textarea name="files_normal" id="files_data_normal" hidden  class="form-control"></textarea>
                    <label class="label_files" >    رفع ملف الاكسل فقط  </label>
                    <div class="fileupload-wrapper">
                        <div id="myUpload_files_normal">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <hr>

            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-auto">
                        <input class="btn  btn-primary" type="submit" name="submit" value="حفظ">
                    </div>
                </div>
            </div>


        </form>


        <script>


            $("#myUpload_files_normal").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_normal').val(response);
                        console.log(response)
                    }
                }
            );

            $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls')

        </script>


        <?php if(!empty($this->error_form ))  { ?>
            <script>

                var error=<?php echo $this->error_form ?>;
                for (var prop in error) {
                    $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
                    $("*[name='"+prop+"']").addClass('error_border_red');
                }
            </script>
            <style>
                .error_border_red
                {
                    border: 1px solid red !important;
                    box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
                }
            </style>
        <?php  } ?>




    </div>

</div>





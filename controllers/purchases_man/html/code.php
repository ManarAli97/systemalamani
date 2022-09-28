 <br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"> مدير المشتريات  </a></li>
                <li class="breadcrumb-item active" aria-current="page" >  اضاقة نواقص  بواسطة  الكود   </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>




    <div class="form-row align-items-center">

        <div class="col-auto">
            الكود
        </div>

        <div class="col-lg-3 col-md-4 col-sm-5">
            <input type="text" name="code"   class="form-control" id="code" placeholder="الكود" required>
        </div>

        <div class="col-auto">

            <select name="cat" class="custom-select mr-sm-2" id="cat_site"  onchange="settingCat()" required>
                <option   selected   >  اختر القسم  </option>
                <?php  foreach ($this->category_website as $key  => $c ) { ?>
                   <option value="<?php echo $key ?>"><?php  echo $c ?></option>
                 <?php }  ?>

            </select>
        </div>

        <div class="col-auto">
            <div class="add_color"></div>
        </div>


        <div class="col-auto">
            <button onclick="codeData()"  style="    margin: 0 !important;" type="button" class="btn btn-primary mb-2">بحث</button>
        </div>
    </div>


<hr>

    <div class="msg_withdrow"></div>
<div class="data_get"></div>




<script>


    function settingCat() {
        cat=$('#cat_site option:selected').val();
        code=$('#code').val();
         if (code) {

             if (cat === 'savers') {
                 $('.add_color').html(`<input type="text" name="color"   class="form-control" id="add_color" placeholder="لون المادة في كرستال" required>`);

             } else if (cat === 'accessories') {
                 $.get("<?php echo url . '/' . $this->folder ?>/color_list/" + code + '/' + cat, function (data) {

                     $('.add_color').html(data);
                 });

             } else {
                 $('.add_color').empty();
             }
         }else
         {
             alert('يرجى كتابة كود المادة قبل اختيار القسم')
         }
    }


    function codeData()
    {

        code=$("#code").val();
        cat=$('#cat_site option:selected').val();

       if (code) {

           if (cat === 'savers') {

               color = $("#add_color").val();

               if (color)
               {
                   $.ajax({
                       url: "<?php  echo url . '/' . $this->folder?>/get",
                       type: 'post',
                       data: {code: code, cat: cat, color: color},
                       success: function (data) {

                           $('.data_get').html(data);

                       }
                   });
               }else
               {
               alert('يجب اضافة اسم لون المادة الموجود في كرستال')
               }


           }else if (cat === 'accessories')
           {


               color = $('#color_name_acc option:selected').val();

               if (color)
               {
                   $.ajax({
                       url: "<?php  echo url . '/' . $this->folder?>/get",
                       type: 'post',
                       data: {code: code, cat: cat, color: color},
                       success: function (data) {

                           $('.data_get').html(data);

                       }
                   });
               }else
               {
                   alert('اختيار لون المادة')
               }

           }


               else {
               $('.add_color').empty();
               $.ajax({
                   url: "<?php  echo url . '/' . $this->folder?>/get",
                   type: 'post',
                   data: {code: code, cat: cat},
                   success: function (data) {

                       $('.data_get').html(data);

                   }
               });
           }
       }else
       {
           alert('اضف كود المنتج')
       }
    }


</script>



 <style>

     .table_style1
     {
         border-radius: 5px;
     }

     .table_style1 thead
     {
         background: #009688;

     }
     .table_style1 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table1 {
         background: #009688;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }

     .table_style2
     {
         border-radius: 5px;
     }

     .table_style2 thead
     {
         background: #2196f3a1;

     }
     .table_style2 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table2 {
         background: #2196f3a1;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }
     .table_style3
     {
         border-radius: 5px;
     }

     .table_style3 thead
     {
         background: #607d8bad;

     }
     .table_style3 thead tr th
     {

         color: #ffff;
         font-weight: unset;
     }

     .title_table3 {
         background: #607d8bad;
         color: #fff;
         padding: 5px 19px;
         border-radius: 15px 15px 0 0;
     }

 </style>




 <br>
<br>
<br>
<br>
<br>

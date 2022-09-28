<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_savers"><?php  echo $this->langControl('savers') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('connect_between_cover_and_excel') ?>  </li>

            </ol>
        </nav>


        <hr>
    </div>
</div>



 <form   id="idForm"  action="<?php  echo url .'/'.$this->folder?>/excel_ajax" method="post" enctype="multipart/form-data">


     <br>
     <div style="color: red"> ملاحظة* يجب حذف عنوان الاعمدة من ملف الاكسل </div>
     <table border="1" style="text-align: center">
         <thead>
         <tr>
             <th>العمود 0</th>
             <th>العمود 1</th>
             <th>العمود 2</th>
             <th>العمود 3</th>
             <th>العمود 4</th>
             <th>العمود 5</th>
             <th>العمود 6</th>
             <th>العمود 7</th>
         </tr>
         </thead>
         <tbody>
         <tr>
             <td> الكود القديم  </td>
             <td> لون المادة القديم  </td>
             <td> الكود الجديد</td>
             <td>  اسم المادة الجديد  </td>
             <td> اللون الجيد </td>
             <td> الرمز </td>
             <td> الاسم الاتيني </td>
             <td>    تفاصيل </td>

         </tr>

         </tbody>
     </table>

     <hr>




     <nav>
         <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <a class="nav-item nav-link active title_normal" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">   رفع ملف اكسل الحافظات </a>

         </div>
     </nav>
     <div class="tab-content" id="nav-tabContent">

         <div class="tab-pane fade show active normal" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


             <br>


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

             <div class="progress_upload" style="display: none">
                 <div class="progress">
                     <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                 </div>
                 <br>
             </div>

                 <div class="container">
                     <div class="row justify-content-center ">
                         <div class="col-auto">
                             <input  class="btn  btn-primary stopPress" type="submit" name="submit" value="حفظ">
                         </div>
                     </div>
                 </div>
               <div class="datax"></div>




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

                 $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls') .attr('required','required');

                 $("#idForm").submit(function(e) {


                     $('.stopPress').attr('disabled','disabled');
                     $('.progress_upload').show();

                     e.preventDefault(); // avoid to execute the actual submit of the form.

                     var form = $(this);
                     var url = form.attr('action');

                     $.ajax({
                         type: "POST",
                         url: url,
                         data: form.serialize()+"&submit=submit", // serializes the form's elements.
                         success: function(data)
                         {
                             $('.progress_upload').hide();
                             $('.datax').html(data);


                             $('.stopPress').removeAttr('disabled');

                             if (data ==='a')
                             {
                                 alert("يرجى تعديل ملف الاكسل على حسب المثال في الاعلى")
                             }else if (data ==='b')
                             {
                                 alert("يرجى اعادة رفع الملف")
                             }else
                             {
                                 alert(" تم تحديث البيانات ");

                             }

                         }
                     });


                 });

             </script>



         </div>

     </div>










     <hr>

   </form>

        <script>

            brand();
            function brand() {

                $.get("<?php echo url . '/' . $this->folder ?>/getNmaDevice/" + $('#brand option:selected').val(), function (data) {
                    $('#nameDevice').html(data);

                    if (data)
                    {
                        typeDevice($('#brand option:selected').val())
                    }
                });
            }

          function typeDevice() {

                $.get("<?php echo url . '/' . $this->folder ?>/typeDevice/"+$('#nameDevice option:selected').val(), function (data) {
                    $('#typeDevice').html(data);

                });
            }




        </script>


<style>

    .colorBox
    {
        margin-bottom: 15px;
    }
    .add_color
    {
        background: #4CAF50;
        margin-right: 18px;
        border-radius: 50%;
        font-size: 23px;
        padding: 3px;
        width: 40px;
        height: 40px;
        text-align: center;
        color: #ffffff;
    }

    .delete_row
    {
        padding: 0;
    }

    .delete_row button
    {
        padding: 0;
        border-radius: 0;
        height: 100%;
        width: 38px;
    }

</style>

<br>
<br>
<br>
<br>
<br>
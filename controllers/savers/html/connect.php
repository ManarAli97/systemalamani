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



<div class="row">
    <div class="col-md-3 mb-3">
        <label for="brand"> اختر الماركة </label>
        <select class="custom-select" name="brand" id="brand"   onchange="brand()"   required>
            <?php foreach ($category as $key => $catg) {   ?>
                <option   <?php  if ($id ==  $catg['id']   ) echo 'selected'; else  if ($key == 0 )  echo 'selected'?>  value="<?php  echo $catg['id']?>"><?php  echo $catg['title']?></option>
            <?php  } ?>

        </select>
    </div>

</div>
 <br>
<div class="row">
    <div class="col-md-3 mb-3">
        <label for="nameDevice"> اختر السلسة </label>
        <select onchange="typeDevice()" class="custom-select"  name="nameDevice" id="nameDevice" required>

        </select>
    </div>
</div>
 <br>

 <form   id="myform"  action="<?php  echo url .'/'.$this->folder?>/color" method="post">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="typeDevice"> اختر نوع الجهاز </label>
            <select  onchange="getColor()" class="custom-select"  name="typeDevice" id="typeDevice" required>

            </select>
        </div>
    </div>
     <br>
     <label  ><span>      لون المادة في كرستال</span>       <button onclick="add_color()" class="add_color btn" type="button">  <i class="fa fa-plus-circle"></i> </button></label>

        <br>
     <br>
           <div class="msg_x"></div>


        <div class='row'>
            <div class='col-lg-7 col-md-8 col-sm-12'>
                <div id="getColor">    </div>

             </div>
        </div>


     <hr>
     <div class="container">
         <div class="row justify-content-md-center ">
             <div class="col-md-auto">
                 <input  class="btn btn-primary" type="submit" name="submit" value="حفظ">
             </div>
         </div>
     </div>
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
                    if (data)
                    {
                        getColor()
                    }

                });
            }

          function getColor() {

                $.get("<?php echo url . '/' . $this->folder ?>/getColor/"+$('#typeDevice option:selected').val(), function (data) {
                    $('#getColor').html(data);
                });
            }
            count=0;
          function add_color() {
                    count++;
                    $('#getColor').append(`

                    <div class='row delete_html_${count}'>
                        <div class='col-2'>
                           <input  type='color' name='color_code[new${count}]'   class='form-control colorBox'  required>
                           </div>
                        <div class='col'>
                         <div class='input-group colorBox '>
                          <input  type='text' name='color[new${count}]'   class='form-control'  placeholder='لون المادة في كرستال'>
                               <div class="input-group-prepend">
                                <div class="input-group-text delete_row">  <button onclick="delete_html(${count})" class="btn btn-danger" type="button"> <i class="fa fa-trash"></i> </button>  </div>
                            </div>
                          </div>
                      </div>


                           `);
                   }



                   function delete_html(count) {
                       $('.delete_html_'+count).remove();
                   }




            $(function() {

                $("#myform").submit(function(e) {
                    $('.msg_x').empty();
                    e.preventDefault();
                    var actionurl = e.currentTarget.action;
                    $.ajax({
                        url: actionurl,
                        type: 'post',
                        data: $("#myform").serialize()+'&submit',
                        success: function(data) {
                            if (data==='true')
                            {
                                getColor();
                                $('.msg_x').html(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                              تم الحفظ.
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>

                                `);
                            }else {
                                $('.msg_x').html(`
                                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                فشل الحفظ !
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>
                                `);
                            }
                        }
                    });

                });

            });

            function delete_db_color(id) {
                $.get( "<?php echo url.'/'.$this->folder ?>/delete_db_color/"+id, function( data ) {
                    $('.delete_db_color'+id).remove();
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
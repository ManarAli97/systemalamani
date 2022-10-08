</div>
</div>
</div>


<style>

 .select_drop .bootstrap-select .dropdown-menu {
        min-width: auto !important;
    }

    .print_bill_casher
    {
        zoom: 200% !important;
    }


    .type_price_account
    {
        display: block;
        font-size: 12px;
        border-radius: 10px;
        background: #bcd4e6;
        padding: 2px 1px;
    }

    div.dataTables_wrapper div.dataTables_processing {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        margin-left: 0;
        margin-top: 0;
        text-align: center;
        padding: 12px 0px;
        background: #151717 !important;
        color: #ffff !important;
        width: 200px !important;
        font-size: 20px !important;
        z-index: 150000 !important;
    }

    .error_code
    {
        background: #f44336;
        color: #fff;
    }
    .error_code:focus
    {
        background: #f44336;
        color: #fff;
    }


    .infoCustomer{
        color: #000;
        font-size: 18px;
    }
    .infoCustomer.thisActive{
        color: #ffffff;
        font-size: 18px;
    }
    .infoBillOpen
    {
        font-size: 18px;
         font-weight: bold;
    }

    .sumAllMoney {
        border: 1px solid #cdd4da;
        padding: 10px;
        border-radius: 5px;
        background: #fea;
        font-weight: bold;
    }


    div.dataTables_wrapper div.dataTables_info {
        padding-top: 0.85em;
        white-space: nowrap;
        float: right;
        margin-top: -7px;
    }

    td .color_item_table
    {
        border: 1px solid gainsboro;
    }
  .col-auto .card .card-body .card-text
  {
    width: 215px;
    height: 50px;
    overflow: hidden;
  }


  select.custom-select.custom-select-sm.form-control.form-control-sm {
      width: 126px !important;
  }


  div#editor {
    margin: auto;
    text-align: left;
  }

  div#editor div div div a {
  height: 0;
    overflow:hidden;
    padding: 0 !important;

  }

  div#editor .fr-element.fr-view a  {
    display:unset !important;
    overflow:unset !important;
    height:auto;
    padding: 0 24px !important;;
  }


  div#editor div div div a.fr-command {
    display: block !important;
    overflow:unset !important;
    height:auto;
    padding: 0 24px !important;;
  }
</style>


<script>





  $(function () {
    $('#edit')
            .on('froalaEditor.initialized', function (e, editor) {
              // $('#edit').parents('form').on('submit', function () {
              //     console.log($('#edit').val());
              //     return false;
              // })
            })

            .froalaEditor({
              enter: $.FroalaEditor.ENTER_P, placeholderText: null, language: '<?php echo $this->langControl ?>', direction: '<?php  echo $this->dirControl ?>'

            })

            .on('froalaEditor.image.beforeUpload', function (e, editor, files) {
              if (files.length) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  var result = e.target.result;

                  editor.image.insert(result, null, null, editor.image.get());
                };

                reader.readAsDataURL(files[0]);
              }

              return false;
            })


  });


  $(document).ready(function(){

      setTimeout(function () {
          $('div#editor div div div a[href="https://www.froala.com/wysiwyg-editor?k=u"]').remove();
      },1000);
  });

</script>

<!--editor css -->

 <!--cdn-->
<script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/codemirror.min.js"></script>
<script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/xml.min.js"></script>

  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/save.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/quote.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/plugins/quick_insert.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->static_file_control ?>/editor/froala/js/languages/ar.js"></script>


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>



<script type="text/javascript" src="<?php echo $this->static_file_control ?>/tags/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->static_file_site ?>/tags/bootstrap-tagsinput.css">


<script>

    tags();
    function tags()
    {

        $('input.tags').tagsinput({
            tagClass: 'big'
        });

    }

</script>


<style>

    .blah #blah {
        width: 168px;
        margin-top: 17px;
        border: 2px solid #28a745;
        padding: 5px;
    }

    .tags_tags .bootstrap-tagsinput{

        width: 100%;
        min-height: 95px;
        padding: 10px;
    }

    .tags_tags .bootstrap-tagsinput .tag{
        margin-right: 2px;
        background: #28a745;
        color: #fff;
        padding: 0 8px;
        border-radius:5px ;
        line-height: 39px;

    }

    .tags_tags .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "\f057";
        padding: 0 2px;
        font-family: FontAwesome;
    }

    .c-circle-menu__link
    {
        position: absolute;
        bottom: 7px;
        width: 40px;
        height: 40px;
        left: 7px;
        background: #283581;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
    }



    #snackbar {

        z-index: 1000000000 !important;
    }

    .copyToClipboard
    {
        cursor: pointer;
    }

</style>

<div id="snackbar">تم النسخ</div>

<script>

    function copy_text(e) {
        new Clipboard('.'+$(e).attr('class'));

        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
    }

    $('body').tooltip({selector: '[data-toggle="tooltip"]'});

    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

</script>



<!-- Button trigger modal -->
<button onclick="writeNoteAboutCustomer()" type="button" class="btn writeNote"  data-toggle="tooltip" data-placement="top" title="كتابة ملاحظة حول الزبون">
<i class="fa fa-pencil"></i>
</button>

 <style>

     .writeNote
     {
         background: #cddc39;
         position: fixed;
         bottom: 52px;
         left: 11px;
         padding: 0;
         font-size: 22px;
         width: 37px;
         height: 37px;
         border-radius: 50%;
     }

     .list_name {
         position: absolute;
         z-index: 1000;
         width: 100%;
         border: 1px solid #cec8c8;
         box-shadow: 5px 4px 6px 0px #0000003b;
         display: none;
         height: 300px;
         overflow: auto;
         background: #FFFFFF;
     }
 </style>
<div class="modal fade" id="ModalwriteNoteAboutCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">كتابة ملاحظة حول الزبون</h5>

            </div>
            <form id="formNote_custom" action="<?php echo url ?>/note_user/save_note" method="post">
            <div class="modal-body">
                <div class="mb-3" style="position: relative">
                    <label>ابحث عن اسم الزبون او رقم الهاتف</label>
                    <input  type="text" oninput="search_customer_note()"   id="name_custom_get" class=" form-control" name="name" placeholder="ابحث عن اسم الزبون او رقم الهاتف"   autocomplete="off" required>
                    <div class="list_name"></div>
                </div>
                <input type="hidden" name="id" id="id_custom_get">

                <div>
                    <label>ملاحظة</label>
                    <textarea name="note" rows="3" id="note_custom_get" class="form-control" required></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">حفظ</button>
                <button type="button" class="btn btn-danger" onclick="empty_fild()" data-dismiss="modal">خروج</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>

    function writeNoteAboutCustomer() {
        $('#ModalwriteNoteAboutCustomer').modal('show')
    }


    function search_customer_note() {

        if ($('#name_custom_get').val())
        {
            $.get( "<?php  echo url  ?>/customers/name",{name:$('#name_custom_get').val()}, function( data ) {
                if (data)
                {
                    $('.list_name').html(data).show()
                }else
                {
                    $('.list_name').hide().empty()
                }
            });

        }else {
            $('.list_name').hide().empty()

        }


    }


    $("#name_custom_get").focusout(function(){
        setTimeout(function () {
            $('.list_name').hide()

        },500)
    });

    function print_name(e,id) {
        $('#name_custom_get').val($(e).text())
        $('#id_custom_get').val(id)
        $('.list_name').hide().empty()
    }

    function empty_fild() {
        $('#name_custom_get').val('')
        $('#id_custom_get').val('')
        $('#note_custom_get').val('')
    }
    $("#formNote_custom").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                console.log(data)
                empty_fild()
                $('#ModalwriteNoteAboutCustomer').modal('hide')
            }
        });

    });
</script>

<a href="<?php echo url ?>/contact" class="c-circle-menu__link">
    <i style="transform: rotate(-17deg);" class="fa fa-bullhorn"></i>
</a>





<div class="modal  bd-example-modal-lg"  id="modal_crop"  tabindex="-1" role="dialog" aria-labelledby="modal_crop" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> تعديل الصورة </h5>
            </div>
            <div class="modal-body" id="html_data">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> خروج </button>
            </div>
        </div>
    </div>
</div>
<style>
    .cropper-container
    {
        width: 100% !important;
        padding: 15px;
    }
</style>

<script type="text/javascript">

    $(function () {

        var html_data=`
                   <div class="crop_image_parent" xmlns="http://www.w3.org/1999/html">
                                    <div  class="row justify-content-center">
                                        <div class="col-12">
                                            <img   style="max-height: 500px" id="crop_image">
                                            </div>
                                        </div>
                                    </div>
                                  <hr>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-success" type="button" id="crop">  <span>معاينة</span> <i class="fa fa-eye"></i> </button>
                                    <button class="btn btn-sm btn-warning" type="button" id="cropEdit">  <span> تعديل القص</span>  <i class="fa fa-crop"></i> </button>
                                    <button class="btn btn-sm btn-danger" type="button" id="cropSave"> <span>حفظ</span> <i class="fa fa-save"></i> </button>
                                    <button class="btn btn-sm btn-primary" type="button" id="rotateRight"> <i class="fa fa-repeat"></i> </button>
                                    <button class="btn btn-sm btn-primary" type="button" id="rotateLeft">  <i class="fa fa-undo"></i> </button>
                                    <button class="btn btn-sm btn-primary" type="button" id="zoomIn">  <i class="fa fa-search-plus"></i> </button>
                                    <button class="btn btn-sm btn-primary" type="button" id="zoomOut"> <i class="fa fa-search-minus"></i> </button>
                                    <button class="btn btn-sm btn-warning" type="button" id="reset"> <i class="fa fa-refresh"></i> </button>
                                    </div>
                                    <br>
                                <div  class="row justify-content-center">
                                    <div id="crop_result" ></div>
                              </div>
                  `;

        var cropper = null;
        var name_image=null;
        var url=null;
        var ids=null;
        var table=null;

        $(document).on('click','.crop_image',function(e){
            $('#html_data').html(html_data);

            var ths = $(this);
            $('#zoomIn').show();
            $('#zoomOut').show();
            $('#rotateRight').show();
            $('#rotateLeft').show();
            $('#reset').show();
            $('#croped_image').hide();

            name_image=ths.attr('img');
            url=ths.attr('url');
            ids=ths.data('ids');
            table=ths.data('table');
            $('#crop_image').attr('src', url );
            $('.crop_image_parent').show();
            createCrop();
            $('#modal_crop').modal('show');
        });

        $(document).on('click','#cropEdit',function(){
            $(this).hide();
            $('#crop').show();
            $('#zoomIn').show();
            $('#zoomOut').show();
            $('#reset').show();
            $('#rotateRight').show();
            $('#rotateLeft').show();
            $('#cropSave').show();
            $('.crop_image_parent').show();
        });
        $(document).on('click','#cropSave',function(){
            var a = document.getElementById('croped_image');

            if(a != null){
                if(a.getAttribute('src') != ''){
                    saveCrop(a.getAttribute('src'));
                }else{
                    alert('يرجى اختيار صورة');
                }
            }else{
                $('#crop').click();
                $('#cropSave').click();
            }

        });
        function saveCrop(base64Img){

            $('#modal_crop').modal('hide');
            $.ajax({
                url:"<?php  echo url .'/files' ?>/crop",
                type: "POST",
                data:{image: base64Img,name_image:name_image,table:table,ids:ids},
                success:function(result){
                    if (result)
                    {

                        console.log(result)

                        resp=JSON.parse(result);

                        $("#image_device_"+ids).attr('src',"<?php  echo $this->save_file ?>"+resp.img);
                        $("#btn_crop_image_"+ids).attr('img',resp.img).attr('url',"<?php  echo $this->save_file ?>"+resp.img);
                        $(".card_"+ids+" .image_manager").attr('href',"<?php  echo $this->save_file ?>"+resp.img);


                        if (resp.file_size < 300000 )
                        {
                            $(".card_"+ids+" .card_file").removeClass('bigSize')
                        }else {
                            $(".card_"+ids+" .card_file").addClass('bigSize')
                        }
                        $(".size_file_"+ids).text(resp.file_size_kb)


                        alert('تم حفظ الصورة')
                    }else
                    {
                        alert('فشل حفظ الصورة')
                    }
                }
            });

        }

        function createCrop(){
            var image = document.getElementById('crop_image');
            var crop = document.getElementById('crop');
            var zoomIn = document.getElementById('zoomIn');
            var zoomOut = document.getElementById('zoomOut');
            var reset = document.getElementById('reset');
            var rotateRight = document.getElementById('rotateRight');
            var rotateLeft = document.getElementById('rotateLeft');
            var result = document.getElementById('crop_result');

            var croppable = false;
            cropper = new Cropper(image, {
                dragMode: 'move',
                zoomable:true,
                aspectRatio: NaN,
                responsive: true,
                autoCropArea: 0.65,
                restore: true,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: true,
                ready: function () { croppable = true;},
            });

            crop.onclick = function () {
                $('.crop_image_parent').hide();
                $('#cropSave').show();
                $('#cropEdit').show();
                $('#crop').hide();
                $('#zoomIn').hide();
                $('#zoomOut').hide();
                $('#reset').hide();
                $('#rotateRight').hide();
                $('#rotateLeft').hide();
                var croppedCanvas;
                var roundedCanvas;
                var roundedImage;
                if (!croppable) { return; }
                croppedCanvas = cropper.getCroppedCanvas();
                roundedCanvas = getRoundedCanvas(croppedCanvas);
                roundedImage = document.createElement('img');
                roundedImage.id = 'croped_image';
                roundedImage.width = 200;
                roundedImage.src = roundedCanvas.toDataURL();
                result.innerHTML = '';
                result.appendChild(roundedImage);
                var objDiv = document.getElementById("modal_crop");
                objDiv.scrollTop = objDiv.scrollHeight;
            };
            zoomIn.onclick = function () { cropper.zoom(0.1); };
            zoomOut.onclick = function () { cropper.zoom(-0.1); };
            rotateRight.onclick = function () { cropper.rotate(1); };
            rotateLeft.onclick = function () { cropper.rotate(-1); };
            reset.onclick = function () { cropper.reset(); };
        }
        function getRoundedCanvas(sourceCanvas) {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var width = sourceCanvas.width;
            var height = sourceCanvas.height;
            canvas.width = width;
            canvas.height = height;
            context.imageSmoothingEnabled = true;
            context.drawImage(sourceCanvas, 0, 0, width, height);
            context.globalCompositeOperation = 'destination-in';
            context.beginPath();
            return canvas;
        }
    })
</script>

<link rel="stylesheet" href="<?php echo $this->static_file_control ?>/crop/cropper.css"   />
<script src="<?php echo $this->static_file_control ?>/crop/cropper.js" ></script>






</body>
</html>
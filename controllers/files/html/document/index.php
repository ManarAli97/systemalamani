
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">  <?php  echo $this->langControl($this->folder) ?>  </h2>
            <p class="pageheader-text"></p>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php  echo url ?>/home" class="breadcrumb-link"><?php  echo $this->langControl('cpanel') ?> </a></li>
                        <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/document"><?php  echo $this->langControl('files_manger') ?> </a></li>
                        <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('documents') ?>  </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="uploadImage">
    <div class="inAdd">
        <div class="form-row">
            <div class="col-md-12 mb-12 lg-12">
                <div class="fileupload-wrapper">
                    <div id="myUploadPdf">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $("#myUploadPdf").bootstrapFileUpload({
        url: "<?php echo url ?>/files/upload_file_files_manger",
        inputName: 'files',
        multiFile: true,
        multiUpload: true,
        fileTypes: {
            archives: [],
            audio: [],
            files: [],
        },
        onUploadSuccess: function(response) {
            if (response)
            {
                window.location='<?php  echo url .'/'.$this->folder ?>/file'
            }

        } ,
        onInit: function () {
            $('#myUploadPdf .btnAddFile').html(`<i class="fa fa-upload"></i>  <span>&nbsp;   <?php echo $this->langSite('upload_files') ?>   </span>`);
        },
        onUploadReset: function () {

            $('#myUploadPdf .fileupload-reset').remove();
            $('#myUploadPdf .label_files').remove();
            $('#myUploadPdf .fileupload-add').remove();
        }
    });




</script>

<div class="wrapper">
    <div id="results" class="text-center card-group row"></div>
</div>

<script>

    (function($){
        $.fn.loaddata = function(options) {// Settings
            var settings = $.extend({
                loading_gif_url	: "<?php echo $this->static_file_site ?>/image/site/loader.gif", //url to loading gif
                end_record_text	: '<?php  echo  $this->langSite('not_found_date')  ?>', //no more records to load
                data_url 		: '<?php  echo  url .'/'. $this->folder ?>/load_file/application', //url to PHP page
                start_page 		: 1 //initial page
            }, options);

            var el = this;
            loading  = false;
            end_record = false;
            contents(el, settings); //initial data load


            $(window).scroll(function() { //detact scroll

                if($(window).scrollTop() + $(window).height() >= $(document).height() ){ //scrolled to bottom of the page
                    contents(el, settings); //load content chunk
                }
            });
        };
        //Ajax load function
        function contents(el, settings){
            var load_img = $('<img/>').attr('src',settings.loading_gif_url).addClass('loading-document'); //create load document
            var record_end_txt = $('<div/>').text(settings.end_record_text).addClass('end-record-info'); //end record text

            if(loading == false && end_record == false){
                loading = true; //set loading flag on
                el.append(load_img); //append loading document
                $.post( settings.data_url, {'page': settings.start_page}, function(data){ //jQuery Ajax post
                    if(data.trim().length == 0){ //no more records
                        el.append(record_end_txt); //show end record text
                        load_img.remove(); //remove loading img
                        end_record = true; //set end record flag on
                        return; //exit
                    }
                    loading = false;  //set loading flag off
                    load_img.remove(); //remove loading img
                    el.append(data);  //append content
                    settings.start_page ++; //page increment
                })
            }
        }

    })(jQuery);
    $("#results").loaddata(); //load the results into element

</script>

<style>

    .page-header {
          margin-bottom: 0px;
    }

    .document_manager
    {
        height: 250px;
        background-position: center;
        background-repeat:no-repeat ;
        background-size: 35%;
    }

    .card_file
    {
        background: #ffffff;
        border: 1px solid  #eeeeee ;
        margin-bottom: 30px;
    }

    .card_file .card-title{
        font-size: 16px;
        width: -webkit-fill-available;
        width: -moz-available;
        white-space: nowrap;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }
    .table_tooltip
    {
        color: #ffffff;
        margin: 0;
    }

    .icon_ .btn
    {
        padding: 0;
    }

    .icon_ .btn i
    {
        font-size: 30px;
    }
    .icon_ .btn i.fa-refresh
    {
        font-size: 30px;
        color: #03a9f4;
    }

    .icon_ .btn i.fa-info-circle
    {
        font-size: 30px;
        color: #009688;
    }

    .icon_ .btn i.fa-trash-o
    {
        font-size: 30px;
        color: red;
    }

</style>






<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"> <?php  echo $this->langControl("are_you_sure") ?> ?  <span> من حذف الملف من الموقع بالكامل  </span>   </h6>

            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?php  echo $this -> langControl('close')?></button>
                <button type="button" value="" id='save' class="btn btn-danger"><?php  echo $this -> langControl('delete')?> </button>
            </div>
        </div>
    </div>
</div>


<script>

    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)

    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.post( "<?php echo url .'/'.$this->folder ?>/delete_file_and_row/"+id, function( data ) {
            $('.card_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
</script>



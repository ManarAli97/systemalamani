<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" > مدير الملفات  </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl($model) ?>  </li>
            </ol>
        </nav>

        <hr>
    </div>
</div>


<a class="btn btn-danger" href="<?php echo url .'/'. $this->folder ?>/resize/<?php  echo $model ?>"> ضغط  الصور   </a>
<br>
<br>
<div class="modal fade  bd-example-modal-lg" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تغير الصورة</h5>

            </div>
            <div class="modal-body result_edit">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(id,model)
    {
        $( ".result_edit" ).empty();
        $('#exampleModalEdit').modal('show')
        $.get( "<?php  echo url .'/'.$this->folder ?>/edit_media/"+id+"/"+model, function( data ) {
            $( ".result_edit" ).html( data );
        });
    }



</script>









<div class="wrapper">
    <div id="results" class="text-center card-group row"></div>
</div>

<script>

    (function($){
        $.fn.loaddata = function(options) {// Settings
            var settings = $.extend({
                loading_gif_url	: "<?php echo $this->static_file_site ?>/image/site/loding.gif", //url to loading gif
                end_record_text	: 'لا توجد بيانات بعد', //no more records to load
                data_url 		: '<?php  echo  url .'/'. $this->folder ?>/load/<?php echo $model ?>', //url to PHP page
                start_page 		: 1 //initial page
            }, options);

            var el = this;
            loading  = false;
            end_record = false;
            contents(el, settings); //initial data load


            $('.bodyControl').scroll(function() { //detact scroll

                if($('.bodyControl').scrollTop() + $('.bodyControl').height() >= $(document).height() ){ //scrolled to bottom of the page
                    contents(el, settings); //load content chunk
                }
            });
        };
        //Ajax load function
        function contents(el, settings){
            var load_img = $('<img/>').attr('src',settings.loading_gif_url).addClass('loading-image'); //create load image
            var record_end_txt = $('<div/>').text(settings.end_record_text).addClass('end-record-info'); //end record text

            if(loading == false && end_record == false){
                loading = true; //set loading flag on
                el.append(load_img); //append loading image
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


<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
    <div class="slides"></div>
    <h3 class="title" ></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<script>


    $(document).ready(function() {
        var myEle = document.getElementById("links");
        if(myEle){
            document.getElementById('links').onclick = function (event) {
                blueimp.Gallery(
                    document.getElementById('links').getElementsByTagName('a'),
                    {
                        container: '#blueimp-gallery',
                        carousel: true,
                        onslide: function (index, slide) {
                            var unique_id = this.list[index].getAttribute('data-unique-id');
                        }
                    }
                );
            }
        }
    });


</script>









<style>

    .bigSize
    {
        border: 2px solid #dc3545 !important;
        background: #dc3545 !important;
    }

    .bigSize .card-footer
    {
        background: #dc3545;
    }

    .page-header {
        margin-bottom: 0px;
    }
    .image_manager
    {
        height: 250px;
        background-position: center;
        background-size: contain;
        background-repeat:no-repeat ;
        display: block;
        text-align: center;
    }

    .image_manager img
    {
        height: 250px;
        width: auto;
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

    .loading-image
    {
        width: 100px;
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

<link rel="stylesheet"  href="<?php echo $this->static_file_site ?>/slider/blueimp-gallery.min.css" >
<script src="<?php echo $this->static_file_site ?>/slider/blueimp-gallery.min.js"></script>
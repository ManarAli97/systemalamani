
<div class="card" style="width: 18rem;">
    <img class="card-img-top" id="new_image" src="<?php  echo $result['url'] ?>" alt="Card image cap">
</div>


<div class="uploadImage">
    <div class="inAdd">
        <div class="form-row">
            <div class="col-md-12 mb-12 lg-12">
                <div class="fileupload-wrapper">
                    <div id="myUploadImage">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script>



    $("#myUploadImage").bootstrapFileUpload({
        url: "<?php echo url ?>/files/save_image_manager/<?php  echo $id ?>/<?php  echo $model ?>",
        inputName: 'image',
        multiFile: false,
        multiUpload: true,
        fileTypes: {
            images: []
        },
        onUploadSuccess: function(response) {
            if (response)
            {
                data =JSON.parse(response);
                $("#image_device_<?php  echo $id ?>").attr('src',"<?php  echo $this->save_file ?>"+data[0].rand_name);
                $("#btn_crop_image_<?php  echo $id ?>").attr('img',data[0].rand_name).attr('url',"<?php  echo $this->save_file ?>"+data[0].rand_name);
                $(".card_<?php  echo $id ?> .image_manager").attr('href',"<?php  echo $this->save_file ?>"+data[0].rand_name);

                if (data[0].file_size < 300000 )
                {

                    $(".card_<?php  echo $id ?> .card_file").removeClass('bigSize')
                }else {
                    $(".card_<?php  echo $id ?> .card_file").addClass('bigSize')
                }
                $(".size_file_<?php  echo $id ?>").text(data[0].file_size_kb)

                $('#exampleModalEdit').modal('hide')
            }
        } ,
        onInit: function () {
            $('#myUploadImage .btnAddFile').html(`<i class="fa fa-upload"></i>  <span>&nbsp;   تغير الصورة    </span>`);
        },
        onUploadReset: function () {

            $('#myUploadImage .fileupload-reset').remove();
            $('#myUploadImage .label_files').remove();
            $('#myUploadImage .fileupload-add').remove();
        }
    });




</script>
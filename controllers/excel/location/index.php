
<br>




<div class="row">
    <div class="col-auto">
        <label> الباركود  </label>
        <div class="alert alert-secondary" role="alert">
             <?php echo $code ?>
        </div>
    </div>
    <div class="col-auto">
        <label>   الكمية الكلية  </label>
        <div class="alert alert-secondary" role="alert">
            <?php echo $quantity ?>
        </div>
    </div>
    <div class="col-auto">
        <label>  الكمية في انتظار تأكيد الموقع </label>
        <div class="alert alert-secondary" role="alert">
            <?php echo $quantity_confirm ?>
        </div>
    </div>
    <div class="col-auto">
        <label>   كمية المواقع </label>
        <div class="alert alert-secondary" role="alert">
            <?php echo $quantity_location ?>
        </div>
    </div>

</div>
<hr>
<form id="idFormsetLocation" action="<?php echo url .'/'.$this->folder ?>/inst_location/<?php echo $model.'/'.$code ?>" method="post">
    <input type="hidden" name="locationOldquantity"  value="<?php  echo $quantity_location ?>" >

    <div class="row">


        <?php  foreach ($location as $key=>$d ) {  ?>
            <div class="col-lg-4 col-md-4 col-sm-6" style="margin-bottom: 25px">
                <label> موقع: <?php  echo  $this->tamayaz_locations($d['location'])  ?>  </label>
                <input type="number" min="0" class="form-control" name="indexLocation[<?php  echo $d['id']  ?>]" value="<?php  echo $d['quantity']  ?>" required>
             </div>
        <?php  }  ?>
        <div class="col-12 text-center">
            <hr>
            <input type="submit" class="btn btn-primary" name="submit" value="حفظ">
        </div>
    </div>

</form>

<script>
    $("#idFormsetLocation").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {

                if (data==='-q')
                {
                    alert("مجموع كمية المواقع اكبر من الكمية الكلية!")
                }else
                {
                    $('#exampleModalLocation').modal('hide')

                }

            }
        });


    });
</script>
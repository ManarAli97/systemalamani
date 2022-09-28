<br>



<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"> مدير المشتريات  </a></li>

                <li class="breadcrumb-item active" aria-current="page" > اضافة نقاط   </li>
                <li class="breadcrumb-item active" aria-current="page" >  <?php echo $result['username'] ?>  </li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<form  id="randomInsert"  action="<?php echo url.'/'.$this->folder ?>/add_point/<?php  echo $id ?>" method="post"  >

    <div class="form-row">
        <div class="col-6  co-6">
            <label for="validationServer01">  <?php  echo $this->langControl('points') ?> <span style="color: red;font-size: 14px;" id="points"> </span>  </label>
            <input name="points" class="form-control"  id="validationServer01"  value="<?php  echo $data['points']  ?>" type="text">
        </div>

        <div class="col-md-6  co-lg-6">
            <label for="validationServer01">  <?php  echo $this->langControl('date') ?> <span style="color: red;font-size: 14px;" id="date"> </span>  </label>
            <input name="date" class="form-control"    id="validationServer01"  value="<?php echo date('Y-m-d',$data['date'])   ?>" type="date">
        </div>
    </div>

    <hr>

    <div class="container">
        <div class="row justify-content-md-center ">
            <div class="col-md-auto">
                <input class="btn btn-primary" type="submit" name="submit" value="حفظ">
            </div>
        </div>
    </div>

</form>


<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("input[name='"+prop+"']").addClass('error_border_red');
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

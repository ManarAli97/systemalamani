
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('statistics')?> </li>
                <li class="breadcrumb-item active" aria-current="page" >   <?php  echo $this->langControl('view_statistics')?>  </li>
            </ol>
        </nav>

    </div>
</div>


<br>





<form action="<?php echo url.'/'.$this->folder?>" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>

<br>




<div class="alert alert-primary" role="alert">
    <span>عدد الطلبات الكلي: </span>  <?php  echo count($total_req) ?>
</div>

<div class="alert alert-success" role="alert">
    <span>   عدد الطلبات المباعة : </span>  <?php  echo count($total_req2) ?>
</div>
<div class="alert alert-danger" role="alert">
    <span> عدد الطلبات الملغية : </span>  <?php  echo count($total_req3) ?>
</div>
<div class="alert alert-warning" role="alert">
    <span> عدد المواد المباعة : </span>  <?php  echo $total_req4 ?>
</div>
<div class="alert alert-secondary" role="alert">
    <span> عدد المواد المرتجعة : </span>  <?php  echo $total_req5  ?>
</div>




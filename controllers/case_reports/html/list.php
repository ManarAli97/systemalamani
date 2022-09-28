
<br>

<div class="row">
	<div class="col">
		<span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_location/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" >  <?php  echo   $this->langControl( $model)  ?></li>
                </ol>
            </nav>

		<hr>
	</div>
</div>

<?php  echo $this->tab($model) ?>

<style>
    .button_report
    {
        margin-bottom: 15px;
    }
    .active_case
    {
        background: #4caf50;
        border: 1px solid #4caf50;
    }

    table thead tr
    {
        text-align: center;
    }

    table tbody tr td
    {
        text-align: center;
    }


    .d-table
    {
        width:100%;
        border: 1px solid #c4c2c2;
        border-radius: 5px;
    }
    .class_delete_row
    {
        background: transparent;
        border-radius: 50%;
        padding: 0;
        width: 35px;
        height: 35px;
        font-size: 28px;
        margin: 0;
    }
</style>



<br>
<br>
<br>





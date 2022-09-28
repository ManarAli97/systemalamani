
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item active" aria-current="page"> <?php // echo $this->UserInfo($this->userid) ?>  </li> -->
                <li class="breadcrumb-item active" aria-current="page"> <?php  echo $this->langControl('permit') ?>  </li>
                <li class="breadcrumb-item active" aria-current="page"> <?php  echo $data[0]['username']?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


            <?php foreach ($permitGroups as $titleGroup) { ?>

                <fieldset class="fieldsetCatg">
                    <legend> <?php echo $this->langControl($titleGroup['groupName'])  ?> </legend>

                     <div class="row">
                            <?php foreach ($titleGroup['statement_group'] as $row) { ?>
                         <div class="col-lg-auto">
                                <input  <?php  echo $row['checked']  ?> type="checkbox" onchange="activPermit(this,<?php echo $id_user ?>,<?php echo $row['id'] ?>)"   data-on="On" data-off="Off" id="toggle-event"  data-toggle="toggle" datax-stylex="iosx" data-onstyle="success" data-size="small"> <label>  <?php  echo  $this->langControl($row['aclname'])   ?></label>
                         </div>

                             <?php } ?>
                     </div>
                </fieldset>

            <?php } ?>




<style>
    .fieldsetCatg {

        margin-bottom: 35px;
    }
</style>


<script>

   function activPermit (e,idGroup,idParmit) {
       var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/permit/activPermit_user/"+vis+'/'+idGroup+'/'+idParmit, function(data){})
    }

</script>
<br>



<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view/<?php  echo $model?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  <?php  echo $this->langControl('location_'. $model ) ?></li>
			</ol>
		</nav>

		<hr>
	</div>
</div>

مثال على ملف الاكسل :

<br>
<table border="1" style="text-align: center">
	<thead>
	<tr>
		<th>الحقل الاول</th>
		<th>الحقل الثاني</th>
		<th>الحقل الثالث</th>

	</tr>
	</thead>
	<tbody>
	<tr>
		<td> رمز المادة   </td>
		<td> الموقع  </td>
		<td>  الكمية  </td>



	</tr>

	</tbody>
</table>

<hr>




<nav>
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
<!--		<a class="nav-item nav-link  --><?php //echo $class1 ?><!--   title_normal" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">   رفع ملف الاكسيل  حذف واستبدال </a>-->
		<a class="nav-item nav-link  <?php echo $class2 ?>   title_normal" id="nav-cumulative-tab" data-toggle="tab" href="#nav-cumulative" role="tab" aria-controls="nav-cumulative" aria-selected="true">   رفع ملف الاكسيل تراكمي </a>

	</div>
</nav>
<div class="tab-content" id="nav-tabContent">

	<div class="tab-pane fade  <?php echo $class1 ?>  normal" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


		<br>



		<form    action="<?php echo url.'/'.$this->folder ?>/add/<?php  echo $model?>/1"  method="post" enctype="multipart/form-data">



			<div class="form-row">
				<div class="col-md-12 mb-12 lg-12">
					<style>

						.label_image
						{
							float: right;
							padding: 7px;
							background: #eeeff0;
						}
						.label_files
						{
							float: right;
							padding: 7px;
							background: #eeeff0;
						}
					</style>


					<span style="color: red;font-size: 14px;" id="files_normal"> </span>
					<br>

					<textarea name="files_normal" id="files_data_normal" hidden  class="form-control"></textarea>
					<label class="label_files" >    رفع ملف الاكسل فقط  </label>
					<div class="fileupload-wrapper">
						<div id="myUpload_files_normal">
						</div>
					</div>
				</div>
			</div>
			<br>

			<hr>

			<div class="container">
				<div class="row justify-content-center ">
					<div class="col-auto">
						<input class="btn  btn-primary" type="submit" name="submit" value="حفظ">
					</div>
				</div>
			</div>


		</form>


		<script>


            $("#myUpload_files_normal").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_normal').val(response);
                        console.log(response)
                    }
                }
            );

            $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls')

		</script>


		<?php if(!empty($this->error_form ))  { ?>
			<script>

                var error='<?php echo $this->error_form ?>';

                  $('#files_normal').html('&nbsp;&nbsp;' + error  + '*');



			</script>
			<style>
				.error_border_red
				{
					border: 1px solid red !important;
					box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
				}
			</style>
		<?php  } ?>




	</div>

	<div class="tab-pane fade  <?php echo $class2 ?>   normal" id="nav-cumulative" role="tabpanel" aria-labelledby="nav-cumulative-tab">


		<br>



		<form    action="<?php echo url.'/'.$this->folder ?>/add_cumulative/<?php  echo $model?>/2"  method="post" enctype="multipart/form-data">



			<div class="form-row">
				<div class="col-md-12 mb-12 lg-12">
					<style>

						.label_image
						{
							float: right;
							padding: 7px;
							background: #eeeff0;
						}
						.label_files
						{
							float: right;
							padding: 7px;
							background: #eeeff0;
						}
					</style>


					<span style="color: red;font-size: 14px;" id="files_normal2"> </span>
					<br>

					<textarea name="files_normal2" id="files_data_normal2" hidden  class="form-control"></textarea>
					<label class="label_files" >    رفع ملف الاكسل فقط  </label>
					<div class="fileupload-wrapper">
						<div id="myUpload_files_normal2">
						</div>
					</div>
				</div>
			</div>
			<br>

			<hr>

			<div class="container">
				<div class="row justify-content-center ">
					<div class="col-auto">
						<input class="btn  btn-primary" type="submit" name="submit" value="حفظ">
					</div>
				</div>
			</div>


		</form>


		<script>


            $("#myUpload_files_normal2").bootstrapFileUpload({
                    url: "<?php echo url ?>/files/save_files",
                    inputName: 'files',
                    multiFile: false,
                    multiUpload: true,
                    fileTypes: {
                        files: []
                    },
                    onUploadSuccess: function(response) {
                        $('#files_data_normal2').val(response);

                    }
                }
            );

            $('.btn.btn-success.fileupload-add input').attr('accept','.xlsx, .xls')

		</script>


		<?php if(!empty($this->error_form ))  { ?>
			<script>

                var error='<?php echo $this->error_form ?>';
                $('#files_normal2').html('&nbsp;&nbsp;' + error  + '*');


            </script>
			<style>
				.error_border_red
				{
					border: 1px solid red !important;
					box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
				}
			</style>
		<?php  } ?>




	</div>

</div>



<br>
<br>
<br>
<br>
<br>


<?php  if (!empty($data_view)){ ?>
<?php foreach ($data_view as $printContent) {   ?>

	<div class="col-lg-4 col-md-4 col-sm-6 col-6 xBoxG">

		<div  class="infoDevice">
			<?php  if ($printContent['bast_it'] == 1 ) { ?>
				<div class="bast_device">
					<?php echo $this->langSite('bast_it') ?>
				</div>
			<?php } ?>


			<a href="<?php echo url ?>/mobile/details/<?php echo $printContent['id'] ?>"  >

				<div class="hoverBtn">
					<button class="btn"><i class="fa fa-search"></i> </button>
				</div>
				<div class="imageDevise">
					<img   src="<?php echo $printContent['image'] ?>" alt="لا توجد صورة">
					<?php  if ($printContent['cuts'] == 1 ) { ?>
						<div class="price_cuts_note">
							<?php echo $this->langSite('price_cuts') ?>
						</div>

					<?php } ?>
				</div>
			</a>

			<div class="nameDevice">
				<?php echo $printContent['title'] ?>
			</div>
			<textarea  disabled class="form-control description"><?php echo $printContent['description'] ?></textarea>

			<?php  if ($printContent['cuts'] == 1 ) { ?>
				<div class="pricDevice" style="display: block">
					<!--                                            <div class="oldXPrice" style="text-decoration: line-through;">--><?php //echo $printContent['price'] ?><!-- </div>-->
					<div class="price_cuts" style="color: green;font-weight: bold"> <?php echo $printContent['price_cuts'] ?> د.ع   </div>
				</div>
			<?php  } else{ ?>
				<div class="pricDevice" >
					<?php echo $printContent['price'] ?>
				</div>
			<?php } ?>

			<div class="c_device">
				<div class="addedToCart_mobile<?php echo $printContent['id'] ?>"></div>

				<div class="row align-items-center justify-content-center">

					<div class="col-lg-7 col-md-12 col-sm-auto  xcartp"  >

						<?php if (isset($_SESSION['username_member_r']) || $this->isDirect() ) { ?>


							<?php if ($this->phone=='true' || $this->isDirect()) {   ?>

								<button type="button" class="btn btn_cart" onclick="addToCart(<?php echo $printContent['id'] ?>,'<?php echo $printContent['size'] ?>','<?php echo $printContent['priceC'] ?>','<?php echo $printContent['nameImage'] ?>','<?php echo $printContent['code_color'] ?>','<?php echo $printContent['code'] ?>')">
									<span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
								</button>
							<?php  }else{   ?>

								<button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#add_phone">
									<span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
								</button>

							<?php  }  ?>
						<?php } else { ?>

							<button type="button" class="btn btn_cart"    data-toggle="modal" data-target="#login_site">
								<span>اضف الى السلة </span> <i class="fa fa-cart-plus"></i>
							</button>

						<?php } ?>


					</div>
					<div class="col-lg-5 col-md-12 col-sm-auto">
						<?php if (isset($_SESSION['username_member_r'])) { ?>

							<button   type="button" class="btn btn_like  style_btn_like_mb  L_<?php echo $printContent['id']  ?> <?php  if ($printContent['like']) echo 'unlike'; else echo  'like' ?>"  onclick=<?php  if ($printContent['like']) echo "unlike_d(".$printContent['id'].",'mobile')"; else echo "like_d(".$printContent['id'].",'mobile')" ?>   >
								<i class="fa fa-heart"></i>
							</button>

							<button    title="اضافة المنتج الى خانة المقارنة بين المنتجات"  type="button" class="btn comparison comp_<?php echo $printContent['id']  ?> <?php  if ($printContent['comparison']) echo 'un_comparison'; else echo  'comparison' ?>"  onclick=<?php  if ($printContent['comparison']) echo "un_comparison_d(".$printContent['id'].",'mobile')"; else echo "comparison_d(".$printContent['id'].",'mobile')" ?>   >
								<i class="fa fa-exchange"></i>
							</button>

						<?php } else { ?>

							<button type="button" class="btn btn_like style_btn_like_mb  "   data-toggle="modal" data-target="#login_site">
								<i class="fa fa-heart"></i>
							</button>
							<button  type="button" class="btn comparison"   data-toggle="modal" data-target="#login_site">
								<i class="fa fa-exchange"></i>
							</button>

						<?php } ?>

					</div>
				</div>

			</div>

		</div>

	</div>
<?php  } ?>

<?php  }else {   ?>

	<div class="col-12">

		<div class="alert alert-warning" role="alert">
            لا توجد اجهزة مشابهه من هذه الفئة يرجى اختيار فئة اخرى
		</div>
	</div>

<?php  }  ?>
<?php
 class  Search extends  Controller
{




     function __construct()
     {
         parent::__construct();
         $this->menu=new Menu();
     }



    public  function  index()
    {

        $content = array();

        if (isset($_GET['submit'])) {

            $search = strip_tags(trim($_GET['search']));
            $q = '%' . $search . '%';
            $typeCat = strip_tags(trim($_GET['cat']));


            $date=time();

            $stmtOffer = $this->db->prepare("SELECT offers.*  FROM `offers` INNER  JOIN  offers_item ON offers_item.id_offer = offers.id WHERE offers_item.code=? AND   offers.`active`   =  1  AND  offers.`delete` =  0   AND {$date} BETWEEN  offers.`fromdate` AND  offers.`todate`    ");
            $stmtOffer->execute(array(str_replace(array(' ','%'),'',$q)));


            $offers=array();
            while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
            {

                $row['dollar']= $this->priceDollarOffer($row['id'],3);

                if ($row['range_price'] == 0)
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    if ($this->loginUser())
                    {
                        $row['priceC']=$this->priceDollarOffer($row['id'],4);
                        $row['range']=$row['priceC'] . '  د.ع ';

                    }else
                    {
                        $row['priceC']=$this->priceDollarOffer($row['id'],5);
                        $row['range']=$row['priceC'] . '  د.ع ';

                    }

                }
                $row['image']=$this->show_file_site.$row['img'];
                $offers[]=$row;
            }




            if ($typeCat == 'all') {

				if ($this->thisCatg('mobile')) {
					$mobile = new mobile();


					$stmtcode = $this->db->prepare("SELECT mobile.`price_cuts`, mobile.`id`,mobile.`title`,mobile.`bast_it`,mobile.`price_dollars`,mobile.description,mobile.cuts,mobile.stop,excel.price_dollars as excel_price_dollars  ,excel.quantity,color.img,color.code_color,code.size,code.code,excel.wholesale_price,excel.wholesale_price2,excel.cost_price FROM code inner JOIN color ON code.id_color = color.id   inner JOIN mobile ON color.id_item = mobile.id   inner JOIN excel ON excel.code = code.code WHERE  ( mobile.title LIKE ? OR  mobile.tags LIKE ?  OR  code.code=?  )    AND  mobile.`active` = 1 AND  mobile.`is_delete` = 0  ORDER BY excel.quantity ASC ");
					$stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
					if ($stmtcode->rowCount() > 0) {
						while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

							$row['type_cat'] = 'mobile';

									$row['image'] = $this->save_file . $row['img'];

									$stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

										if ($row['quantity'] > 0) {
											$row['q'] = 1;
										} else {
											$row['q'] = 0;
										}

										$row['priceC'] = $stmt_price;
										$row['price'] = $stmt_price . ' د.ع ';


                                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                                           $row['nameImage'] = $row['img'];

										$row['like'] = $mobile->ckeckLick($row['id']);
										$row['comparison'] = $mobile->check_comparison($row['id']);
										$content[$row['id'].'m'] = $row;

						  }

					}


				}
				if ($this->thisCatg('camera')) {

				    $camera = new camera();
					$stmtcode = $this->db->prepare("SELECT   camera.`price_cuts`, camera.`id`,camera.`title`,camera.`bast_it`,camera.`price_dollars`,camera.description,camera.cuts,excel_camera.price_dollars as excel_price_dollars  ,excel_camera.quantity,color_camera.img,color_camera.code_color,code_camera.size,code_camera.code,excel_camera.wholesale_price,excel_camera.wholesale_price2,excel_camera.cost_price   FROM code_camera inner JOIN color_camera ON code_camera.id_color = color_camera.id inner JOIN camera ON color_camera.id_item = camera.id  inner JOIN excel_camera ON excel_camera.code = code_camera.code WHERE  ( camera.title LIKE ? OR  camera.tags LIKE ?  OR code_camera.code=?)    AND camera.`active` = 1 AND camera.`is_delete` = 0  AND excel_camera.quantity > 0 ");
					$stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
					if ($stmtcode->rowCount() > 0) {
						while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

							$row['type_cat'] = 'camera';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';



                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['nameImage'] = $row['img'];

                            $row['like'] = $camera->ckeckLick($row['id']);
                          $content[$row['id'].'m'] = $row;

						}
					}


				}


				if ($this->thisCatg('printing_supplies')) {


                    $printing_supplies = new printing_supplies();
                    $stmtcode = $this->db->prepare("SELECT   printing_supplies.`price_cuts`, printing_supplies.`id`,printing_supplies.`title`,printing_supplies.`bast_it`,printing_supplies.`price_dollars`,printing_supplies.description,printing_supplies.cuts,excel_printing_supplies.price_dollars as excel_price_dollars  ,excel_printing_supplies.quantity,color_printing_supplies.img,color_printing_supplies.code_color,code_printing_supplies.size,code_printing_supplies.code,excel_printing_supplies.wholesale_price,excel_printing_supplies.wholesale_price2,excel_printing_supplies.cost_price   FROM code_printing_supplies inner JOIN color_printing_supplies ON code_printing_supplies.id_color = color_printing_supplies.id inner JOIN printing_supplies ON color_printing_supplies.id_item = printing_supplies.id  inner JOIN excel_printing_supplies ON excel_printing_supplies.code = code_printing_supplies.code WHERE  ( printing_supplies.title LIKE ? OR  printing_supplies.tags LIKE ?  OR code_printing_supplies.code=?)    AND printing_supplies.`active` = 1 AND printing_supplies.`is_delete` = 0   AND excel_printing_supplies.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'printing_supplies';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';


                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['nameImage'] = $row['img'];

                            $row['like'] = $printing_supplies->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }


                }



				if ($this->thisCatg('computer')) {



                    $computer = new computer();
                    $stmtcode = $this->db->prepare("SELECT   computer.`price_cuts`, computer.`id`,computer.`title`,computer.`bast_it`,computer.`price_dollars`,computer.description,computer.cuts,excel_computer.price_dollars as excel_price_dollars  ,excel_computer.quantity,color_computer.img,color_computer.code_color,code_computer.size,code_computer.code,excel_computer.wholesale_price,excel_computer.wholesale_price2,excel_computer.cost_price    FROM code_computer inner JOIN color_computer ON code_computer.id_color = color_computer.id inner JOIN computer ON color_computer.id_item = computer.id  inner JOIN excel_computer ON excel_computer.code = code_computer.code WHERE  ( computer.title LIKE ? OR  computer.tags LIKE ?  OR code_computer.code=?)    AND computer.`active` = 1  AND computer.`is_delete` = 0 AND excel_computer.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'computer';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';


                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['nameImage'] = $row['img'];

                            $row['like'] = $computer->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }


                }




				if ($this->thisCatg('games')) {


                    $games = new games();
                    $stmtcode = $this->db->prepare("SELECT   games.`price_cuts`, games.`id`,games.`title`,games.`bast_it`,games.`price_dollars`,games.description,games.cuts,excel_games.price_dollars as excel_price_dollars  ,excel_games.quantity,color_games.img,color_games.code_color,code_games.size,code_games.code ,excel_games.wholesale_price,excel_games.wholesale_price2,excel_games.cost_price  FROM code_games inner JOIN color_games ON code_games.id_color = color_games.id inner JOIN games ON color_games.id_item = games.id  inner JOIN excel_games ON excel_games.code = code_games.code WHERE  ( games.title LIKE ? OR  games.tags LIKE ?  OR code_games.code=?)    AND games.`active` = 1 AND games.`is_delete` = 0 AND excel_games.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'games';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';


                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['nameImage'] = $row['img'];

                            $row['like'] = $games->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }


                }

				if ($this->thisCatg('network')) {



                    $network = new network();
                    $stmtcode = $this->db->prepare("SELECT   network.`price_cuts`, network.`id`,network.`title`,network.`bast_it`,network.`price_dollars`,network.description,network.cuts,excel_network.price_dollars as excel_price_dollars  ,excel_network.quantity,color_network.img,color_network.code_color,code_network.size,code_network.code,excel_network.wholesale_price,excel_network.wholesale_price2,excel_network.cost_price   FROM code_network inner JOIN color_network ON code_network.id_color = color_network.id inner JOIN network ON color_network.id_item = network.id  inner JOIN excel_network ON excel_network.code = code_network.code WHERE  ( network.title LIKE ? OR  network.tags LIKE ?  OR code_network.code=?)    AND network.`active` = 1 AND network.`is_delete` = 0  AND excel_network.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'network';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';


                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['nameImage'] = $row['img'];

                            $row['like'] = $network->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }
                }


            	if ($this->thisCatg('accessories')) {
					$accessories = new accessories();


                    $ids = array();
                    $stmt_cat = $this->db->prepare('SELECT `id`,`title`as title_device FROM `category_accessories` WHERE `title` like ?');
                    $stmt_cat->execute(array($q));
                    if($stmt_cat->rowCount() > 0){
                        $row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                        $id = $row_cat['id'];
                        $stmt_ch = $this->db->prepare("SELECT `ids` FROM `category_accessories_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
                        $stmt_ch->execute(array($id));
                        if($stmt_ch->rowCount() > 0){
                            $row_ch = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                            $ids = $row_ch['ids'];
                        }else{
                            $ids = $id;
                        }


                        $stmtcode = $this->db->prepare("SELECT accessories.`price_cuts`, accessories.id_cat,accessories.`id`,accessories.`title`,accessories.`bast_it`,accessories.`price_dollars`,accessories.description,accessories.cuts ,color_accessories.img,color_accessories.code,color_accessories.color,color_accessories.code_color  ,excel_accessories.price_dollars as excel_price_dollars,excel_accessories.wholesale_price,excel_accessories.wholesale_price2,excel_accessories.cost_price  FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id   inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code    WHERE ( accessories.title LIKE ? OR  accessories.tags LIKE ? OR color_accessories.code=? OR accessories.id_cat IN ($ids))  AND accessories.`active` = 1 AND accessories.`is_delete` = 0  AND  excel_accessories.quantity > 0 ");
					    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
					if ($stmtcode->rowCount() > 0) {
						while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
							$row['type_cat'] = 'accessories';
                            $row['image'] = $this->save_file . $row['img'];
                            $stmt_price = $this->getPriceSearch($row['price_dollars'],$row['excel_price_dollars']);

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['priceC'] = $stmt_price;
                            $row['id_cat'] = $row['id_cat'];
                            $row['id_cat_customer'] = $row_cat['id'];
                            $row['price'] = $stmt_price . ' د.ع ';
                            $row['nameImage'] =  $row['img'];
                            $row['like'] = $accessories->ckeckLick($row['id']);
                            $row['title'] = $row_cat['title_device'];
                            $row['comparison'] = '';
                            $content[] = $row;
						}
					}
                    }else{
                        $stmtcode = $this->db->prepare("SELECT accessories.`price_cuts`,accessories.`id`,accessories.`title`,accessories.`bast_it`,accessories.`price_dollars`,accessories.description,accessories.cuts ,color_accessories.img,color_accessories.code,color_accessories.color,color_accessories.code_color  ,excel_accessories.price_dollars as excel_price_dollars,excel_accessories.wholesale_price,excel_accessories.wholesale_price2,excel_accessories.cost_price  FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id   inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code    WHERE ( accessories.title LIKE ? OR  accessories.tags LIKE ? OR color_accessories.code=? )  AND accessories.`active` = 1 AND accessories.`is_delete` = 0  AND  excel_accessories.quantity > 0 ");
					$stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
					if ($stmtcode->rowCount() > 0) {
						while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
							$row['type_cat'] = 'accessories';
                            $row['image'] = $this->save_file . $row['img'];
                            $stmt_price = $this->getPriceSearch($row['price_dollars'],$row['excel_price_dollars']);

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';
                            $row['nameImage'] =  $row['img'];
                            $row['id_cat'] = 0;
                            $row['id_cat_customer'] = 0;
                            $row['like'] = $accessories->ckeckLick($row['id']);

                            $row['comparison'] = '';
                            $content[] = $row;

						}
					}
                    }

				}

// 				if ($this->thisCatg('accessories')) {
// 					$accessories = new accessories();

// 					$stmtcode = $this->db->prepare("SELECT accessories.`price_cuts`,accessories.`id`,accessories.`title`,accessories.`bast_it`,accessories.`price_dollars`,accessories.description,accessories.cuts ,color_accessories.img,color_accessories.code,color_accessories.color,color_accessories.code_color  ,excel_accessories.price_dollars as excel_price_dollars,excel_accessories.wholesale_price,excel_accessories.wholesale_price2,excel_accessories.cost_price  FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id   inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code    WHERE ( accessories.title LIKE ? OR  accessories.tags LIKE ? OR color_accessories.code=? )  AND accessories.`active` = 1 AND accessories.`is_delete` = 0  AND  excel_accessories.quantity > 0 ");
// 					$stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
// 					if ($stmtcode->rowCount() > 0) {
// 						while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
// 							$row['type_cat'] = 'accessories';
//                             $row['image'] = $this->save_file . $row['img'];
//                             $stmt_price = $this->getPriceSearch($row['price_dollars'],$row['excel_price_dollars']);

//                             $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
//                             $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
//                             $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';


//                             $row['priceC'] = $stmt_price;
//                             $row['price'] = $stmt_price . ' د.ع ';
//                             $row['nameImage'] =  $row['img'];
//                             $row['like'] = $accessories->ckeckLick($row['id']);
//                             $row['comparison'] = '';
//                             $content[] = $row;

// 						}
// 					}


// 				}

//                 if ($this->thisCatg('savers')) {
//                     $savers = new savers();
//                     $stmt = $this->db->prepare("SELECT  type_device.title as title_device,`product_savers`.*,excel_savers.price_dollars as excel_price_dollars,excel_savers.wholesale_price,excel_savers.wholesale_price2,excel_savers.cost_price  from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ?) AND product_savers.`active`=1 AND product_savers.`is_delete` = 0 AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0");
//                     $stmt->execute(array($q, $q, str_replace(array(' ', '%'), '', $q)));
//                     if ($stmt->rowCount() > 0) {
//                         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

//                             if (empty($row['latiniin']) ) {


//                                 $row['image'] = $this->save_file . $row['img'];
//                                 $row['type_cat'] = 'savers';

//                                 $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
//                                 $row['price'] = $row['priceC'] . ' د.ع ';

//                                 $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
//                                 $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
//                                 $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';


//                                 $content[] = $row;
//                             }else   if (!$this->checkOfferCover($row['latiniin'])    ) {


//                                 $row['image'] = $this->save_file . $row['img'];
//                                 $row['type_cat'] = 'savers';

//                                 $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
//                                 $row['price'] = $row['priceC'] . ' د.ع ';

//                                 $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
//                                 $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
//                                 $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';


//                                 $content[] = $row;
//                             }

//                         }

//                     }

//                 }




             if ($this->thisCatg('savers')) {
                    $savers = new savers();
                    $ids = array();
                    $stmt_cat = $this->db->prepare('SELECT `id`,`title`as title_device FROM `type_device` WHERE `title` like ?');
                    $stmt_cat->execute(array($q));
                    if($stmt_cat->rowCount() > 0){
                        $row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                        $id = $row_cat['id'];
                        $stmt_ch = $this->db->prepare("SELECT `ids` FROM `product_savers_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
                        $stmt_ch->execute(array($id));
                        if($stmt_ch->rowCount() > 0){
                            $row_ch = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                            $ids = $row_ch['ids'];
                        }else{
                            $ids = $id;
                        }

                        $stmt = $this->db->prepare("SELECT  type_device.title as title_device,`product_savers`.*,excel_savers.price_dollars as excel_price_dollars,excel_savers.wholesale_price,excel_savers.wholesale_price2,excel_savers.cost_price  from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ? OR product_savers.id_device  IN ($ids)) AND product_savers.`active`=1 AND product_savers.`is_delete` = 0 AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0");
                        $stmt->execute(array($q, $q,str_replace(array(' ', '%'), '', $q)));
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                if (!$this->checkOfferCover($row['latiniin'])) {


                                    $row['image'] = $this->save_file . $row['img'];
                                    $row['type_cat'] = 'savers';

                                    $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
                                    $row['price'] = $row['priceC'] . ' د.ع ';

                                    $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
                                    $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
                                    $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';
                                    $row['id_cat'] = $row['id_device'];
                                    $row['id_cat_customer'] = $row_cat['id'];
                                    $row['title'] = $row_cat['title_device'];
                                    $content[] = $row;
                                }

                            }

                        }


                    }else{
                        $stmt = $this->db->prepare("SELECT  type_device.title as title_device,`product_savers`.*,excel_savers.price_dollars as excel_price_dollars,excel_savers.wholesale_price,excel_savers.wholesale_price2,excel_savers.cost_price  from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ?) AND product_savers.`active`=1 AND product_savers.`is_delete` = 0 AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0");
                        $stmt->execute(array($q, $q,str_replace(array(' ', '%'), '', $q)));
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                if (!$this->checkOfferCover($row['latiniin'])) {


                                    $row['image'] = $this->save_file . $row['img'];
                                    $row['type_cat'] = 'savers';

                                    $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
                                    $row['price'] = $row['priceC'] . ' د.ع ';

                                    $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
                                    $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
                                    $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';
                                    $row['id_cat'] = 0;
                                    $row['id_cat_customer'] = 0;
                                    $row['title_device'] = $row['title_device'];
                                    $content[] = $row;
                                }

                            }

                        }
                    }




                }


//  end all search
            } else {

                $typeCat = explode('-', $typeCat);


                $id = $typeCat[0];
                $type = $typeCat[1];


                if ($type == 'savers'  && $this->thisCatg('savers') )
                {

                    $savers = new savers();
                    $stmt = $this->db->prepare("SELECT  type_device.title as title_device,`product_savers`.*,excel_savers.price_dollars as excel_price_dollars,excel_savers.wholesale_price,excel_savers.wholesale_price2,excel_savers.cost_price  from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ?) AND product_savers.`active`=1 AND product_savers.`is_delete` = 0 AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0");
                    $stmt->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
                    if ($stmt->rowCount() > 0 ){
                        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            if (empty($row['latiniin']) ) {


                                $row['image'] = $this->save_file . $row['img'];
                                $row['type_cat'] = 'savers';

                                $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
                                $row['price'] = $row['priceC'] . ' د.ع ';

                                $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
                                $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
                                $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';


                                $content[] = $row;
                            }else     if (!$this->checkOfferCover($row['latiniin'])) {
                                $row['image'] = $this->save_file . $row['img'];
                                $row['type_cat'] = 'savers';

                                $row['priceC'] = $this->getPriceSearch(1, $row['excel_price_dollars']);
                                $row['price'] = $row['priceC'] . ' د.ع ';

                                $row['wholesale_price'] = $this->getPriceSearch(1, $row['wholesale_price']) . ' د.ع ';
                                $row['wholesale_price2'] = $this->getPriceSearch(1, $row['wholesale_price2']) . ' د.ع ';
                                $row['cost_price'] = $this->getPriceSearch(1, $row['cost_price']) . ' د.ع ';

                                $content[] = $row;
                            }
                        }
                    }

				}


                if ($type == 'mobile'  && $this->thisCatg('mobile') ) {
                    $mobile = new mobile();
                    $Id_cat = implode(',', $mobile->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT mobile.`price_cuts`, mobile.`id`,mobile.`title`,mobile.`bast_it`,mobile.`price_dollars`,mobile.description,mobile.cuts,mobile.stop,excel.price_dollars as excel_price_dollars  ,excel.quantity,color.img,color.code_color,code.size,code.code,excel.wholesale_price,excel.wholesale_price2,excel.cost_price FROM code inner JOIN color ON code.id_color = color.id   inner JOIN mobile ON color.id_item = mobile.id   inner JOIN excel ON excel.code = code.code WHERE  ( mobile.title LIKE ? OR  mobile.tags LIKE ?  OR  code.code=?  )    AND mobile.`active` = 1 AND mobile.`is_delete` = 0  AND mobile.`id_cat` IN ({$Id_cat})  ORDER BY excel.quantity ASC   ");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'mobile';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';



                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';



                            $row['nameImage'] = $row['img'];

                            $row['like'] = $mobile->ckeckLick($row['id']);
                            $row['comparison'] = $mobile->check_comparison($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }

                    }


                }


                if ($type == 'camera'   && $this->thisCatg('camera') ) {
                    $camera = new camera();
                    $Id_cat = implode(',', $camera->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT   camera.`price_cuts`, camera.`id`,camera.`title`,camera.`bast_it`,camera.`price_dollars`,camera.description,camera.cuts,excel_camera.price_dollars as excel_price_dollars  ,excel_camera.quantity,color_camera.img,color_camera.code_color,code_camera.size,code_camera.code ,excel_camera.wholesale_price,excel_camera.wholesale_price2,excel_camera.cost_price FROM code_camera inner JOIN color_camera ON code_camera.id_color = color_camera.id inner JOIN camera ON color_camera.id_item = camera.id  inner JOIN excel_camera ON excel_camera.code = code_camera.code WHERE  ( camera.title LIKE ? OR  camera.tags LIKE ?  OR code_camera.code=?)    AND camera.`active` = 1  AND camera.`is_delete` = 0   AND camera.`id_cat` IN ({$Id_cat})  AND excel_camera.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'camera';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                            $row['nameImage'] = $row['img'];

                            $row['like'] = $camera->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }

                }




                if ($type == 'printing_supplies'    && $this->thisCatg('printing_supplies')) {
                    $printing_supplies = new printing_supplies();
                    $Id_cat = implode(',', $printing_supplies->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT   printing_supplies.`price_cuts`, printing_supplies.`id`,printing_supplies.`title`,printing_supplies.`bast_it`,printing_supplies.`price_dollars`,printing_supplies.description,printing_supplies.cuts,excel_printing_supplies.price_dollars as excel_price_dollars  ,excel_printing_supplies.quantity,color_printing_supplies.img,color_printing_supplies.code_color,code_printing_supplies.size,code_printing_supplies.code,excel_printing_supplies.wholesale_price,excel_printing_supplies.wholesale_price2,excel_printing_supplies.cost_price   FROM code_printing_supplies inner JOIN color_printing_supplies ON code_printing_supplies.id_color = color_printing_supplies.id inner JOIN printing_supplies ON color_printing_supplies.id_item = printing_supplies.id  inner JOIN excel_printing_supplies ON excel_printing_supplies.code = code_printing_supplies.code WHERE  ( printing_supplies.title LIKE ? OR  printing_supplies.tags LIKE ?  OR code_printing_supplies.code=?)    AND printing_supplies.`active` = 1  AND printing_supplies.`is_delete` = 0   AND printing_supplies.`id_cat` IN ({$Id_cat})   AND excel_printing_supplies.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'printing_supplies';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                            $row['nameImage'] = $row['img'];

                            $row['like'] = $printing_supplies->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }

				}



                if ($type == 'computer' && $this->thisCatg('computer')) {
                    $computer = new computer();
                    $Id_cat = implode(',', $computer->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT   computer.`price_cuts`, computer.`id`,computer.`title`,computer.`bast_it`,computer.`price_dollars`,computer.description,computer.cuts,excel_computer.price_dollars as excel_price_dollars  ,excel_computer.quantity,color_computer.img,color_computer.code_color,code_computer.size,code_computer.code,excel_computer.wholesale_price,excel_computer.wholesale_price2,excel_computer.cost_price   FROM code_computer inner JOIN color_computer ON code_computer.id_color = color_computer.id inner JOIN computer ON color_computer.id_item = computer.id  inner JOIN excel_computer ON excel_computer.code = code_computer.code WHERE  ( computer.title LIKE ? OR  computer.tags LIKE ?  OR code_computer.code=?)    AND computer.`active` = 1  AND computer.`is_delete` = 0  AND computer.`id_cat` IN ({$Id_cat})  AND excel_computer.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'computer';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                            $row['nameImage'] = $row['img'];

                            $row['like'] = $computer->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }



                }


                if ($type == 'games' && $this->thisCatg('games')) {
                    $games = new games();
                    $Id_cat = implode(',', $games->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT   games.`price_cuts`, games.`id`,games.`title`,games.`bast_it`,games.`price_dollars`,games.description,games.cuts,excel_games.price_dollars as excel_price_dollars  ,excel_games.quantity,color_games.img,color_games.code_color,code_games.size,code_games.code,excel_games.wholesale_price,excel_games.wholesale_price2,excel_games.cost_price   FROM code_games inner JOIN color_games ON code_games.id_color = color_games.id inner JOIN games ON color_games.id_item = games.id  inner JOIN excel_games ON excel_games.code = code_games.code WHERE  ( games.title LIKE ? OR  games.tags LIKE ?  OR code_games.code=?)    AND games.`active` = 1  AND games.`is_delete` = 0  AND games.`id_cat` IN ({$Id_cat})   AND excel_games.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'games';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                            $row['nameImage'] = $row['img'];

                            $row['like'] = $games->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }

                }


                if ($type == 'network'  && $this->thisCatg('network')) {
                    $network = new network();
                    $Id_cat = implode(',', $network->getLoopId($id));

                    $stmtcode = $this->db->prepare("SELECT   network.`price_cuts`, network.`id`,network.`title`,network.`bast_it`,network.`price_dollars`,network.description,network.cuts,excel_network.price_dollars as excel_price_dollars  ,excel_network.quantity,color_network.img,color_network.code_color,code_network.size,code_network.code,excel_network.wholesale_price,excel_network.wholesale_price2,excel_network.cost_price  FROM code_network inner JOIN color_network ON code_network.id_color = color_network.id inner JOIN network ON color_network.id_item = network.id  inner JOIN excel_network ON excel_network.code = code_network.code WHERE  ( network.title LIKE ? OR  network.tags LIKE ?  OR code_network.code=?)    AND network.`active` = 1  AND network.`is_delete` = 0  AND network.`id_cat` IN ({$Id_cat})  AND excel_network.quantity > 0");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {

                            $row['type_cat'] = 'network';

                            $row['image'] = $this->save_file . $row['img'];

                            $stmt_price = $this->getPriceSearch( $row['price_dollars'],$row['excel_price_dollars'] );

                            if ($row['quantity'] > 0) {
                                $row['q'] = 1;
                            } else {
                                $row['q'] = 0;
                            }

                            $row['priceC'] = $stmt_price;
                            $row['price'] = $stmt_price . ' د.ع ';

                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';

                            $row['nameImage'] = $row['img'];

                            $row['like'] = $network->ckeckLick($row['id']);
                            $content[$row['id'].'m'] = $row;

                        }
                    }


				}


                if ($type == 'accessories'  && $this->thisCatg('accessories')  ) {
                    $accessories = new accessories();
                    $Id_cat = implode(',', $accessories->getLoopId($id));


                    $stmtcode = $this->db->prepare("SELECT accessories.`price_cuts`,accessories.`id`,accessories.`title`,accessories.`bast_it`,accessories.`price_dollars`,accessories.description,accessories.cuts ,color_accessories.img,color_accessories.code,color_accessories.color,color_accessories.code_color ,excel_accessories.price_dollars as excel_price_dollars,excel_accessories.wholesale_price,excel_accessories.wholesale_price2,excel_accessories.cost_price FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id   inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code    WHERE ( accessories.title LIKE ? OR  accessories.tags LIKE ? OR color_accessories.code=? )  AND accessories.`active` = 1  AND accessories.`is_delete` = 0  AND accessories.`id_cat` IN ({$Id_cat})  AND  excel_accessories.quantity > 0 ");
                    $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));
                    if ($stmtcode->rowCount() > 0) {
                        while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                            $row['type_cat'] = 'accessories';
                            $row['image'] = $this->save_file . $row['img'];
                            $stmt_price = $this->getPriceSearch($row['price_dollars'],$row['excel_price_dollars']);
                            $row['priceC'] = $stmt_price['price'];
                            $row['price'] = $stmt_price['price'] . ' د.ع ';


                            $row['wholesale_price'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->getPriceSearch($row['price_dollars'],$row['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->getPriceSearch($row['price_dollars'],$row['cost_price']). ' د.ع ';






                            $row['nameImage'] =  $row['img'];
                            $row['like'] = $accessories->ckeckLick($row['id']);
                            $row['comparison'] = '';
                            $content[] = $row;

                        }
                    }


                }


            }


        }

        require ($this->render($this->folder,'html','search','php'));

    }


    function  smartsearch()
    {

         $val=strip_tags(trim($_GET['val']));
         $cat=strip_tags(trim($_GET['cat']));

         if (!empty($val)) {

             $q = '%' . $val . '%';

             if ($cat == 'all') {


                 $contentAll = array();
                 $html='';
		         if ($this->thisCatg('mobile')) {



                     $stmtcode = $this->db->prepare("SELECT  mobile.`id`, mobile.`title`, mobile.`bast_it` FROM code inner JOIN color ON code.id_color = color.id   inner JOIN mobile ON color.id_item = mobile.id   inner JOIN excel ON excel.code = code.code WHERE  ( mobile.title LIKE ? OR  mobile.tags LIKE ?  OR  code.code=?  )    AND  mobile.`active` = 1  AND mobile.`is_delete` = 0 and color.is_delete=0 GROUP BY mobile.title ORDER BY mobile.bast_it  DESC  LIMIT 10 ");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));

                         if ($stmtcode->rowCount() > 0) {
						 while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }
						 }
					 }


				 }


				if ($this->thisCatg('savers')) {

                    $savers = new savers();
                    $stmt = $this->db->prepare("SELECT  `product_savers`.`id` ,`product_savers`.`title` ,`product_savers`.latiniin from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ?) AND product_savers.`active`=1  AND product_savers.`is_delete` = 0  AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0  LIMIT 10");
                    $stmt->execute(array($q,$q,str_replace(' ','',$val)));
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if (!$this->checkOfferCover($row['latiniin'])) {
                                $row['bast_it'] = 0;
                                $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';
                            }
                        }

                    }

                    $stmt_cat = $this->db->prepare("SELECT `title` FROM `type_device` WHERE `title` like ? AND `active` = 1 AND `is_delete` = 0 LIMIT 10");
                    $stmt_cat->execute(array($q));
                    if ($stmt_cat->rowCount() > 0) {

                        while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                            $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] .'&quot;)"  class="rowSearch"><span>  ' . $row['title'] . '</span> <span class="cat_search"> حافظات  </span></div>';
                        }
                    }


				 }




             	 if ($this->thisCatg('accessories')) {


                     $stmtcode = $this->db->prepare("SELECT    accessories.`id`,accessories.`title`,accessories.`bast_it`  FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id   inner JOIN excel_accessories ON excel_accessories.code = color_accessories.code    WHERE ( accessories.title LIKE ? OR  accessories.tags LIKE ? OR color_accessories.code=? )  AND accessories.`active` = 1  AND accessories.`is_delete` = 0  AND  excel_accessories.quantity > 0 GROUP BY accessories.title  ORDER BY accessories.bast_it DESC  LIMIT 10  ");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',$q)));

					 if ($stmtcode->rowCount() > 0) {
						 while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }
						 }
					 }

                     $stmt_cat = $this->db->prepare("SELECT `title` , `id` FROM `category_accessories` WHERE `title` like ? AND `active` = 1 AND `is_delete` = 0 LIMIT 10");
                     $stmt_cat->execute(array($q));
                     if ($stmt_cat->rowCount() > 0) {
                         while ($row = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                            $id_catgory = $row['id'];
                            $result_check = $this->check_id_catge($id_catgory);
                            if($result_check == 1){
                                $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] .'&quot;)"  class="rowSearch"><span>  ' . $row['title'] .'</span> <span class="cat_search"> اكسسوارات  </span></div>';
                            }
                        }
                     }



				 }




				 if ($this->thisCatg('games')) {

                     $stmtcode = $this->db->prepare("SELECT   games.`id`,games.`title`,games.`bast_it`   FROM code_games inner JOIN color_games ON code_games.id_color = color_games.id inner JOIN games ON color_games.id_item = games.id  inner JOIN excel_games ON excel_games.code = code_games.code WHERE  ( games.title LIKE ? OR  games.tags LIKE ?  OR code_games.code=?)    AND games.`active` = 1  AND games.`is_delete` = 0  AND excel_games.quantity > 0  GROUP BY games.title  ORDER BY games.bast_it DESC LIMIT 10");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
					 if ($stmtcode->rowCount() > 0) {
						 while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }

						 }
					 }

				 }
				 if ($this->thisCatg('camera')) {
                     $stmtcode = $this->db->prepare("SELECT   camera.`id`,camera.`title`,camera.`bast_it`   FROM code_camera inner JOIN color_camera ON code_camera.id_color = color_camera.id inner JOIN camera ON color_camera.id_item = camera.id  inner JOIN excel_camera ON excel_camera.code = code_camera.code WHERE  ( camera.title LIKE ? OR  camera.tags LIKE ?  OR code_camera.code=?)    AND camera.`active` = 1  AND camera.`is_delete` = 0  AND excel_camera.quantity > 0  GROUP BY camera.title  ORDER BY camera.bast_it DESC LIMIT 10");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                     if ($stmtcode->rowCount() > 0) {
                         while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }

                         }
                     }


                 }
				 if ($this->thisCatg('printing_supplies')) {
                     $stmtcode = $this->db->prepare("SELECT   printing_supplies.`id`,printing_supplies.`title`,printing_supplies.`bast_it`   FROM code_printing_supplies inner JOIN color_printing_supplies ON code_printing_supplies.id_color = color_printing_supplies.id inner JOIN printing_supplies ON color_printing_supplies.id_item = printing_supplies.id  inner JOIN excel_printing_supplies ON excel_printing_supplies.code = code_printing_supplies.code WHERE  ( printing_supplies.title LIKE ? OR  printing_supplies.tags LIKE ?  OR code_printing_supplies.code=?)    AND printing_supplies.`active` = 1 AND printing_supplies.`is_delete` = 1  AND excel_printing_supplies.quantity > 0  GROUP BY printing_supplies.title  ORDER BY printing_supplies.bast_it DESC LIMIT 10");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                     if ($stmtcode->rowCount() > 0) {
                         while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }

                         }
                     }


                 }
				 if ($this->thisCatg('computer')) {
                     $stmtcode = $this->db->prepare("SELECT   computer.`id`,computer.`title`,computer.`bast_it`   FROM code_computer inner JOIN color_computer ON code_computer.id_color = color_computer.id inner JOIN computer ON color_computer.id_item = computer.id  inner JOIN excel_computer ON excel_computer.code = code_computer.code WHERE  ( computer.title LIKE ? OR  computer.tags LIKE ?  OR code_computer.code=?)    AND computer.`active` = 1  AND computer.`is_delete` = 0   AND excel_computer.quantity > 0 GROUP BY computer.title  ORDER BY computer.bast_it DESC LIMIT 10");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                     if ($stmtcode->rowCount() > 0) {
                         while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }

                         }
                     }

                 }
				 if ($this->thisCatg('network')) {
                     $stmtcode = $this->db->prepare("SELECT   network.`id`,network.`title`,network.`bast_it`   FROM code_network inner JOIN color_network ON code_network.id_color = color_network.id inner JOIN network ON color_network.id_item = network.id  inner JOIN excel_network ON excel_network.code = code_network.code WHERE  ( network.title LIKE ? OR  network.tags LIKE ?  OR code_network.code=?)    AND network.`active` = 1  AND network.`is_delete` = 0  AND excel_network.quantity > 0  GROUP BY network.title ORDER BY network.bast_it DESC LIMIT 10");
                     $stmtcode->execute(array($q,$q,str_replace(array(' ','%'),'',trim($q))));
                     if ($stmtcode->rowCount() > 0) {
                         while ($row = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
                             if ($row['bast_it']==1)
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                             }else
                             {
                                 $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                             }

                         }
                     }


                 }


                 if (!empty($html)) {
                     echo $html;
                 }


             } else {

                 $contentAll = array();
                 $typeCat = explode('-', $cat);


                 $id = $typeCat[0];
                 $type = $typeCat[1];

				 if ($this->thisCatg('mobile')) {
					 if ($type == 'mobile') {

						 $mobile = new mobile();
						 $Id_cat = implode(',', $mobile->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars` FROM `mobile` WHERE ( title LIKE ? OR  tags LIKE ? ) AND `id_cat` IN ({$Id_cat}) AND `active` = 1 AND is_delete=0 AND {$this->bast_it}  LIMIT 10");
						 $stmt->execute(array($q, $q));

						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'mobile')) {
									 $contentAll[] = $row;
								 }
							 }
						 }

						 $stmtcode = $this->db->prepare("SELECT mobile.`id`,mobile.`title`,mobile.`bast_it`,mobile.`price_dollars` FROM code inner JOIN color ON code.id_color = color.id inner JOIN mobile ON color.id_item = mobile.id WHERE code.code=? and mobile.is_delete =0 ");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'mobile')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }



					 }
				 }

				 if ($this->thisCatg('savers')) {
					 if ($type == 'savers') {

						 $savers = new savers();
                         $stmt = $this->db->prepare("SELECT  type_device.title as title_device,`product_savers`.`id` ,`product_savers`.`title`,`product_savers`.latiniin  from `product_savers`  LEFT JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN  excel_savers ON excel_savers.code = product_savers.code WHERE (product_savers.title LIKE ?  OR product_savers.tags LIKE ?  OR product_savers.code = ?) AND product_savers.`active`=1  AND product_savers.`is_delete` = 0  AND  product_savers.`img` <> ''  AND  excel_savers.quantity > 0  LIMIT 10");
						 $stmt->execute(array($q,str_replace(' ','',$val)));
						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                 if (empty($row['latiniin']) ) {

                                     $row['bast_it'] = 0;

                                     $contentAll[] = $row;

                                 }else   if (!$this->checkOfferCover($row['latiniin'])) {
                                     $row['bast_it'] = 0;

                                     $contentAll[] = $row;
                                 }
							 }

						 }

					 }
				 }



				 if ($this->thisCatg('accessories')) {
					 if ($type == 'accessories') {
						 $accessories = new accessories();
						 $Id_cat = implode(',', $accessories->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars`  FROM `accessories` WHERE ( title LIKE ? OR  tags LIKE ? )  AND  `id_cat` IN ({$Id_cat})   AND `active` = 1 AND is_delete=0 AND {$this->bast_it}  LIMIT 10");
						 $stmt->execute(array($q, $q));
						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFoundedAccessories($row['id'], $row['price_dollars'], 'accessories')) {
									 $contentAll[] = $row;
								 }
							 }
						 }
					 }


					 $stmtcode = $this->db->prepare("SELECT accessories.`id`,accessories.`title`,accessories.`bast_it`,accessories.`price_dollars` FROM color_accessories inner JOIN accessories ON color_accessories.id_item = accessories.id WHERE color_accessories.code=?  and accessories.is_delete=0 ");
					 $stmtcode->execute(array(str_replace(' ','',$val)));
					 if ($stmtcode->rowCount() > 0) {
						 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
							 if ($this->checkFoundedAccessories($row_code['id'], $row_code['price_dollars'], 'accessories')) {
								 $contentAll[] = $row_code;
							 }
						 }
					 }





				 }
				 if ($this->thisCatg('games')) {
					 if ($type == 'games') {
						 $games = new games();
						 $Id_cat = implode(',', $games->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT   `id`,`title`,`bast_it`,`price_dollars` FROM `games` WHERE ( title LIKE ? OR  tags LIKE ? )  AND  `id_cat` IN ({$Id_cat})    AND `active` = 1 and is_delete =0 AND {$this->bast_it} LIMIT 10");
						 $stmt->execute(array($q, $q));

						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'games')) {
									 $contentAll[] = $row;
								 }
							 }
						 }
						 $stmtcode = $this->db->prepare("SELECT games.`id`,games.`title`,games.`bast_it`,games.`price_dollars` FROM code_games inner JOIN color_games ON code_games.id_color = color_games.id inner JOIN games ON color_games.id_item = games.id WHERE code_games.code=?  games.is_delete=0 ");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'games')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }
					 }
				 }
				 if ($this->thisCatg('camera')) {
					 if ($type == 'camera') {
						 $camera = new camera();
						 $Id_cat = implode(',', $camera->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT  `id`,`title`,`bast_it`,`price_dollars` FROM `camera` WHERE ( title LIKE ? OR  tags LIKE ? )   AND  `id_cat` IN ({$Id_cat})  AND `active` = 1 AND is_delete =0 AND {$this->bast_it} LIMIT 10");
						 $stmt->execute(array($q, $q));

						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'camera')) {
									 $contentAll[] = $row;
								 }
							 }
						 }

						 $stmtcode = $this->db->prepare("SELECT camera.`id`,camera.`title`,camera.`bast_it`,camera.`price_dollars` FROM code_camera inner JOIN color_camera ON code_camera.id_color = color_camera.id inner JOIN camera ON color_camera.id_item = camera.id WHERE code_camera.code=? AND camera.is_delete=0 ");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'camera')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }
					 }
				 }
				 if ($this->thisCatg('printing_supplies')) {
					 if ($type == 'printing_supplies') {
						 $printing_supplies = new printing_supplies();
						 $Id_cat = implode(',', $printing_supplies->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT  `id`,`title`,`bast_it`,`price_dollars` FROM `printing_supplies` WHERE ( title LIKE ? OR  tags LIKE ? )   AND  `id_cat` IN ({$Id_cat})  AND `active` = 1 AND is_delete=0 AND {$this->bast_it} LIMIT 10");
						 $stmt->execute(array($q, $q));

						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'printing_supplies')) {
									 $contentAll[] = $row;
								 }
							 }
						 }
						 $stmtcode = $this->db->prepare("SELECT printing_supplies.`id`,printing_supplies.`title`,printing_supplies.`bast_it`,printing_supplies.`price_dollars` FROM code_printing_supplies inner JOIN color_printing_supplies ON code_printing_supplies.id_color = color_printing_supplies.id inner JOIN printing_supplies ON color_printing_supplies.id_item = printing_supplies.id WHERE code_printing_supplies.code=? printing_supplies.is_delete=0 ");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'printing_supplies')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }
					 }
				 }
				 if ($this->thisCatg('computer')) {
					 if ($type == 'computer') {
						 $computer = new computer();
						 $Id_cat = implode(',', $computer->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT  `id`,`title`,`bast_it`,`price_dollars` FROM `computer` WHERE ( title LIKE ? OR  tags LIKE ? )   AND  `id_cat` IN ({$Id_cat})  AND `active` = 1 AND is_delete=0 AND {$this->bast_it} LIMIT 10");
						 $stmt->execute(array($q, $q));

						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'computer')) {
									 $contentAll[] = $row;
								 }
							 }
						 }

						 $stmtcode = $this->db->prepare("SELECT computer.`id`,computer.`title`,computer.`bast_it`,computer.`price_dollars` FROM code_computer inner JOIN color_computer ON code_computer.id_color = color_computer.id inner JOIN computer ON color_computer.id_item = computer.id WHERE code_computer.code=? AND computer.is_delete=0");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'computer')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }

					 }
				 }
				 if ($this->thisCatg('network')) {
					 if ($type == 'network') {
						 $network = new network();
						 $Id_cat = implode(',', $network->getLoopId($id));
						 $stmt = $this->db->prepare("SELECT `id`,`title`,`bast_it`,`price_dollars`  FROM `network` WHERE ( title LIKE ? OR  tags LIKE ? )   AND  `id_cat` IN ({$Id_cat})   AND `active` = 1 AND is_delete=0 AND {$this->bast_it} LIMIT 10");
						 $stmt->execute(array($q, $q));
						 if ($stmt->rowCount() > 0) {
							 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row['id'], $row['price_dollars'], 'network')) {
									 $contentAll[] = $row;
								 }
							 }
						 }

						 $stmtcode = $this->db->prepare("SELECT network.`id`,network.`title`,network.`bast_it`,network.`price_dollars` FROM code_network inner JOIN color_network ON code_network.id_color = color_network.id inner JOIN network ON color_network.id_item = network.id WHERE code_network.code=? AND network.is_delete=0");
						 $stmtcode->execute(array(str_replace(' ','',$val)));
						 if ($stmtcode->rowCount() > 0) {
							 while ($row_code = $stmtcode->fetch(PDO::FETCH_ASSOC)) {
								 if ($this->checkFounded($row_code['id'], $row_code['price_dollars'], 'network')) {
									 $contentAll[] = $row_code;
								 }

							 }
						 }



					 }
				 }


                 $html = '';

                 foreach ($contentAll as $row) {

                     if ($row['bast_it']==1)
                     {
                         $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch"> <span>  ' . $row['title'] . '</span> <span class="bast_it_search"> ننصح به </span></div>';

                     }else
                     {
                         $html .= '<div   onclick="searchThisRow(&quot;' . $row['title'] . '&quot;)"  class="rowSearch">' . $row['title'] . '</div>';

                     }
                 }

                 if (!empty($html)) {
                     echo $html;
                 }

             }


         }


    }





    function checkFounded($id,$price_dollars,$model)
    {

        $idItemC = array();
        $funs=new $model;
        $stmtIdItC = $funs->numberItems($id);
        while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
            $idItemC[] = $rowiIdIt;
        }
        if (!empty($idItemC)) {
            foreach ($idItemC as $idItc) {
                $stmt_img_id = $funs->getImage($idItc['id'], 1);
                $stmt_price = $funs->getPrice($stmt_img_id['id'], 1,$price_dollars);

               if ($model=='mobile')
			   {

				   if ($funs->smt_ch_code($stmt_price['code'])) {

					   return true;
				   }
				   else
				   {
			        	continue;
				   }

			   }else
			   {

				   $smt_ch_q = $funs->smt_ch_q($stmt_price['code']);
				   if ($smt_ch_q->rowCount() > 0) {
					   return true;
				   }else
				   {
					  continue;
				   }
			   }


            }
        }
    }



    function checkFoundedAccessories($id,$price_dollars,$model)
    {

        $idItemC = array();
        $funs=new $model;
        $stmtIdItC = $funs->numberItems($id);
        while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
            $idItemC[] = $rowiIdIt;
        }

        if (!empty($idItemC)) {

            foreach ($idItemC as $idItc) {

                $stmt_img_id = $funs->getImage($idItc['id'], 1);

                $smt_ch_q = $funs->smt_ch_q($stmt_img_id['code'],$stmt_img_id['color']);
                if ($smt_ch_q->rowCount() > 0) {
                    return true;
                }else
                {
                continue;
                }
            }
        }
    }



    function checkOfferCover($latiniin)
    {
        $date=time();
        $stmtOffer = $this->db->prepare("SELECT offers.id  FROM `offers_item` INNER  JOIN  offers ON offers.id = offers_item.id_offer WHERE    offers.`active`   =  1  AND  offers.`delete` =  0   AND {$date} BETWEEN  offers.`fromdate` AND  offers.`todate`  AND offers_item.latiniin_or_code=? ");
        $stmtOffer->execute(array($latiniin));
        if ($stmtOffer->rowCount() > 0)
        {
            return true;
        }

    }


}
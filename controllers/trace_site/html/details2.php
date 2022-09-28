
<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item active" aria-current="page" > <a href="<?php  echo url .'/'.$this->folder ?>/list_trace_site"> <?php  echo $this->langControl('trace_site')?> </a> </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('details') ?>  </li>
            </ol>
        </nav>

    </div>
</div>

<br>
<div class="fr-view" >
<div class="row">
    <div class="col">

        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> القسم </th>
                <th> الحركة </th>
                <th>  العنوان القديم </th>
                <th>  العنوان الجديد </th>
                <th>  المستخدم </th>
                <th>  التاريخ </th>



            </tr>
            </thead>
            <thead>
            <tr>
                <td> <?php echo $this->langControl($result['table'])   ?> </td>
                <td> <?php echo    $this->langControl( $result['type'] ) ?> </td>
                <td> <?php echo $result['old_title']  ?> </td>
                <td> <?php echo $result['new_title']  ?> </td>
                <td> <?php echo $this->UserInfo( $result['userId'] ) ?> </td>
                <td> <?php echo $result['createDate']  ?> </td>

            </tr>
            </thead>

        </table>

    </div>
</div>


<?php  if (!empty($oldData)) { ?>

    <div class="alert alert-warning" role="alert">
        البيانات القديمة
    </div>
    <div class="overflow-auto">
        <table class="table table-striped">

            <thead>
            <tr>
                <th>العنوان</th>
                <th>التفاصيل</th>

            </tr>
            </thead>

            <tbody>

			<?php foreach ($oldData as $odata) {   ?>
                <tr>
                    <td>id</td>
                    <td><?php echo $odata['id'] ?></td>
                </tr>
                <tr>
                    <td>العنوان</td>
                    <td><?php echo $odata['title'] ?></td>
                </tr>

                <tr>
                    <td> نشر  </td>
                    <td><?php echo $odata['active'] ?></td>
                </tr>

                <tr>
                    <td>  التحقق من الباركودات البديلة قبل البيع  </td>
                    <td><?php echo $odata['serial_flag'] ?></td>
                </tr>

                <tr>
                    <td>  تفعيل  موقع الكميات</td>
                    <td><?php echo $odata['locationTag'] ?></td>
                </tr>

                <tr>
                    <td>  تفعيل ادخال السيريلات   </td>
                    <td><?php echo $odata['enter_serial'] ?></td>
                </tr>


                <tr>
                    <td> التفاصيل </td>
                    <td><?php echo $odata['content'] ?></td>
                </tr>

                <tr>
                    <td> latiniin </td>
                    <td><?php echo $odata['latiniin'] ?></td>
                </tr>

                <tr>
                    <td> المواقع </td>
                    <td><?php echo $odata['location'] ?></td>
                </tr>

                <tr>
                    <td> الباركودات البديلة </td>
                    <td><?php echo $odata['serial'] ?></td>
                </tr>

                <tr>
                    <td>  صورة </td>
                    <td><img width="50" src="<?php echo $this->save_file.$odata['img'] ?>"></td>
                </tr>


                <tr>
                    <td> التاريخ </td>
                    <td><?php echo date('Y-m-d h:i:s a',$odata['date']) ?></td>
                </tr>
			<?php  } ?>

            </tbody>

        </table>

    </div>
<?php  }  ?>

<hr>

<?php  if (!empty($newData)) { ?>

    <div class="alert alert-primary" role="alert">
        البيانات الحديثة
    </div>
    <div class="overflow-auto">
        <table class="table table-striped">

            <thead>
            <tr>
                <th>العنوان</th>
                <th>التفاصيل</th>

            </tr>
            </thead>

            <tbody>

			<?php foreach ($newData as $ndata) {   ?>


                <tr>
                    <td>id</td>
                    <td><?php echo $ndata['id'] ?></td>
                </tr>
                <tr>
                    <td>العنوان</td>
                    <td><?php echo $ndata['title'] ?></td>
                </tr>

                <tr>
                    <td> نشر  </td>
                    <td><?php echo $ndata['active'] ?></td>
                </tr>

                <tr>
                    <td>  التحقق من الباركودات البديلة قبل البيع  </td>
                    <td><?php echo $ndata['serial_flag'] ?></td>
                </tr>

                <tr>
                    <td>  تفعيل  موقع الكميات</td>
                    <td><?php echo $ndata['locationTag'] ?></td>
                </tr>

                <tr>
                    <td>  تفعيل ادخال السيريلات   </td>
                    <td><?php echo $ndata['enter_serial'] ?></td>
                </tr>


                <tr>
                    <td> التفاصيل </td>
                    <td><?php echo $ndata['content'] ?></td>
                </tr>

                <tr>
                    <td> latiniin </td>
                    <td><?php echo $ndata['latiniin'] ?></td>
                </tr>

                <tr>
                    <td> المواقع </td>
                    <td><?php echo $ndata['location'] ?></td>
                </tr>

                <tr>
                    <td> الباركودات البديلة </td>
                    <td><?php echo $ndata['serial'] ?></td>
                </tr>

                <tr>
                    <td>  صورة </td>
                    <td><img width="50" src="<?php echo $this->save_file.$ndata['img'] ?>"></td>
                </tr>


                <tr>
                    <td> التاريخ </td>
                    <td><?php echo date('Y-m-d h:i:s a',$ndata['date']) ?></td>
                </tr>


			<?php  } ?>

            </tbody>

        </table>

    </div>
<?php  }  ?>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

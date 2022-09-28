<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_page_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > توليد سيريلات  </li>
                <li class="breadcrumb-item active" aria-current="page" >  <span>رقم الصفحة </span>  <?php  echo $id ?> </li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<script>
    var table='';
    $(document).ready(function() {

        var selected = [];

        table=   $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing/<?php  echo $id ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[5, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                sProcessing: " معالجة ...",
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: true
        } );
    } );
</script>




<div class="row">
    <div class="col">

        <form id="idForm" action="<?php echo url.'/'.$this->folder ?>/form_generation_serial/<?php  echo $id ?>" method="post">


            <div class="row">
                <div class="col-auto">
                    <label for="validationServer-length"> <span>  طول السيريال  </span> <span style="color: red;font-size: 14px;" id="length"></span>  </label>
                    <input    autocomplete="off" name="length"   type="number" class="form-control " id="validationServer-length" required >
                </div>

                <div class="col-auto">
                    <label for="validationServer-number"> <span>   العدد </span> <span style="color: red;font-size: 14px;" id="number"></span>  </label>
                    <input   name="number"  autocomplete="off"   type="number" class="form-control " id="validationServer-number" required >
                </div>
                <div class="col-auto">
                    <label for="validationServer-code"> <span>   رمز المادة </span> <span style="color: red;font-size: 14px;" id="code"></span>  </label>
                    <input   name="code"  autocomplete="off"   type="text" class="form-control " id="validationServer-code" required >
                </div>
                <div class="col-auto align-self-end">


                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"   value="1" id="customradioInline-1" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-1">   ارقام  </label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"    value="2" id="customradioInline-2" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-2">   حروف  </label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"    value="3" id="customradioInline-3" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-3">   ارقام وحروف  </label>
                    </div>


                </div>
            </div>

            <hr>
            <div class="container">
                <div class="row justify-content-md-center align-items-center ">
                    <div class="col-md-auto">
                        <button    class="btn btn-primary" type="submit" name="submit"  id="btn_generation_serial" >توليد سيريلات </button>
                        <a  href="<?php echo url .'/'.$this->folder?>/list_page_serial_system" role="button"    class="btn btn-warning"> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>  <span>  رجوع  </span> </a>

                    </div>
                </div>
            </div>
        </form>




        <script>


            // this is the id of the form
            $("#idForm").submit(function(e) {

                $("#btn_generation_serial").attr('disabled','disabled').html(`  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`)

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var actionUrl = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize()+"&submit=submit", // serializes the form's elements.
                    success: function(data)
                    {

                        console.log(data)
                        if (data ==='true')
                        {
                            $("#validationServer-code").val('').select();
                            table.draw()

                        }
                        else if (data ==='code_note_found')
                        {
                            alert('رمز المادة غير موجود في النظام');
                        }else if (data==='not_found_quantity')
                        {
                            alert('لا توجد كمية من المادة لتوليد سيريلات لها')
                        }else if (data==='over_quantity')
                        {
                            alert('لم يتم توليد كل السيريلات لان الكمية غير كافية للمادة')
                            table.draw()
                        }
                        else
                        {

                            alert('حدث خطأ')
                        }
                        $("#btn_generation_serial").removeAttr('disabled','disabled').html(`توليد سيريلات`)
                    }
                });

            });


        </script>

<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("*[name='"+prop+"']").addClass('error_border_red');
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





        <hr>
        <a target="_blank"  href="<?php echo url .'/'.$this->folder?>/print_serial/<?php  echo  $id ?>"   role="button"    class="btn btn-warning btn-sm"> <i class="fa fa-print" aria-hidden="true"></i>  <span>  طباعة السيريلات </span> </a>


        <table  id="example" class="table table-striped display d-table"  >
            <thead>
            <tr>
                <th> رقم الصفحة </th>
                <th> الباركود </th>
                <th> السيريال </th>
                <th> طول السيريال</th>
                <th> المستخدم </th>
                <th>تاريخ  </th>


            </tr>
            </thead>

        </table>








        <style>

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
            .herderDoc
            {
                visibility: hidden;
                height: 0;
                overflow: hidden;
            }


            .footerDoc
            {
                visibility: hidden;
                height: 0;
                overflow: hidden;
            }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                    color-adjust: exact !important; /*Firefox*/
                }

                body * {
                    visibility: hidden;
                    height: 0;
                }

                .print   {
                    position: relative;
                }

                .print * {
                    visibility: visible;
                    height: auto;
                }
                .hidePrint *
                {
                    display: none;
                }

                .herderDoc {
                    visibility: visible;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    padding: 10px 35px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                    height: auto;
                    overflow: auto;
                }

                .logoDoc
                {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;

                }

                .logoDoc img
                {
                    width: 100%;
                    height: 100%;

                }


                .footerDoc {
                    visibility: visible;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    padding: 10px 35px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                    position: fixed;
                    bottom: 0 !important;
                    width: 100%;
                    left: 2px;
                    height: auto;
                    overflow: auto;
                }

                .logoDocFooter
                {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;

                }


                .logoDocFooter img
                {
                    width: 100%;
                    height: 100%;

                }


                .number
                {
                    text-align: left;
                    font-size: 18px !important;
                    padding:   8px 0  8px 15px !important;

                }

                .mail
                {
                    text-align: left;
                    font-size: 18px !important;
                    padding:   8px 0  8px 15px !important;
                }

                .icon_print
                {
                    display: none;
                }


                .border_xxx
                {
                    visibility: visible;
                    margin-top: 30px;
                    padding: 20px;
                    height: 1080px;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                }


            }


            #showPassword
            {
                padding: 0;
                margin: 0;
                background: transparent;
                border: 0;
                cursor: pointer;
                outline: none;
                box-shadow: unset;
            }


        </style>


        <br>
        <br>
        <br
        <br>
        <br>
        <br>
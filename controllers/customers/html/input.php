<!-- <?php //$this->publicHeader($this->langSite('inbox'));  
        ?> -->
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <br>
            <nav aria-label="breadcrumb" class="path_bread">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> اضافة تعويض الزبائن</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col">
                    <!-- <?php if ($sendProd) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            تم اضافة البيانات بنجاح
                            <a type="button" href="<?php echo url ?>" class="close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                    <?php   }  ?> -->
                    <form action="<?php echo url . '/' . $this->folder ?>/add_customers_compensation" method="post" enctype="multipart/form-data">
                        <div class="box_notFound">
                            <div class="row">
                                <!-- <div class="col-12" style="display: none;">
                                    <label for="validationServer02">id</label>
                                    <input autocomplete="off" name="id" type="text" class="form-control" id="validationServer02">
                                    <br>
                                </div> -->
                                <div class="col-12">
                                    <label for="validationServer02">اسم الزبون</label>
                                    <input autocomplete="off" name="customer_name" placeholder="ادخل اسم الزبون" type="text" class="form-control" id="customer_name" required>
                                    <br>
                                </div>
                                <div class="col-12">
                                    <label for="validationServer02"> رقم هاتف الزبون </label>
                                    <input autocomplete="off" name="customer_number" type="number" min="0" class="form-control" id="customer_number" required >
                                    <br>
                                </div>
                                <!-- <div class="col-12" style="display: none;">
                                    <label for="validationServer02">date_called</label>
                                    <input autocomplete="off" name="date_called" type="text" class="form-control" id="validationServer02">
                                    <br>
                                </div> -->
                                <div class="col-12">
                                    <label for="validationServer02"> ملاحضة موظف الاتصال </label>
                                    <textarea autocomplete="off" rows="5" name="note_called" type="text" class="form-control" id="note_called" required></textarea>
                                    <br>
                                </div>
                                <div class="col-12">
                                    <label for="validationServer02"> رقم الفاتورة (اختياري)</label>
                                    <input autocomplete="off" name="id_bill" type="text" class="form-control" id="id_bill">
                                    <br>
                                </div>
                                <!-- <div class="col-12">
                                    <label for="validationServer03"> ملاحضة موضف الاتصال </label>
                                    <textarea name="content" type="text" class="form-control" id="validationServer03"></textarea>
                                    <br>
                                </div> -->
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="row justify-content-md-center ">
                                <div class="col-md-auto">
                                    <input class="btn btn-primary" value="ارسال" type="submit" name="submit" id="add_viwe">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br><br>
        </div>
    </div>
</div>

<style>
    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    .x_down div {
        margin-bottom: 30px;
    }

    .code_m {
        margin-top: 15px;
    }

    button.btn.add_new_sub_row {
        padding: 0;
        background: transparent;
        color: #218838;
        font-size: 25px;
    }

    button.btn.remove_sub_row {
        padding: 0;
        background: transparent;
        color: red;
        font-size: 25px;
    }

    .remove_div {
        position: absolute;
        left: 13px;
        padding: 0;
        top: -14px;
        background: #f5f6f7;
        border: 0;
    }

    .remove_div i {
        color: red;
        font-size: 28px;
    }

    .addPs {
        color: #FFFFFF !important;
    }

    .x_down {
        position: relative;
        margin-bottom: 25px;
        border: 1px solid #eeeff0;
        border-bottom: 1px solid #d5d7d8;
        padding-bottom: 22px;
        background: #eeeff08a;
    }

    .note-popover .popover-content .dropdown-menu,
    .card-header.note-toolbar .dropdown-menu {
        left: unset !important;
    }

    .custom-control {
        position: relative;
        display: -ms-inline-flexbox;
        display: inline-flex;
        min-height: 1.5rem;
        padding-left: 1.5rem;
        margin-right: 1rem;
    }

    .box_notFound {
        background: white;
        padding: 16px 11px;
        border: 2px solid #d6d6d6;
        border-radius: 5px;
    }
</style>
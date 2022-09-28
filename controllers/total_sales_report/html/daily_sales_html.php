<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" />

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">تقرير مجموع المبيعات</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col w3-row ">
        <!-- add two input field there type is datetime with submit btn in bosttrap -->
        <form action="<?php echo url . '/' . $this->folder ?>/total_sales_report" method="post">
            <div class="date-group">
                <label for="from">من:</label>
                <input type="datetime-local" class="date-input" value="" id="from" name="from" placeholder="من">

                <label for="to" style="margin-right: 7px;">الى:</label>
                <input type="datetime-local" class="date-input" value="" id="to" name="to" placeholder="الى">
            </div>
            <!-- هنا نختار الموديل  -->
            <div class="row align-item-center" style="margin-top: 10px;">
                <div class="col-auto col-lg-3 mt-3">
                    <label for="model"> البحث بواسطة الباركود: </label>
                    <div class="form-group select_drop" style="width: 100%">
                        <!-- <label for="code" style="margin-right:600px">البحث بواسطة الباركود:</label> -->
                        <input type="text" class="date-input" value="" id="code" name="code" placeholder="ادخل باركود المادة">
                    </div>
                </div>
                <div class="col-auto col-lg-3 mt-3">
                    <label for="model"> الموديل </label>
                    <div class="form-group select_drop" style="width: 100%">
                        <select name="model" id="model" class="selectpicker" aria-expanded="false" data-live-search="true">
                            <option value="0">الكل</option>
                            <?php foreach ($this->category_website as $key => $value) { ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                            <!-- <option value="01">اللواصق</option> -->
                        </select>
                    </div>
                </div>
                <div class="col-auto col-l-3 mt-3 mb-3">
                    <label for="id_cat">الفئة</label>
                    <div class="form-group select_drop" id='div_cat' style="width: 100%">
                        <select name="id_cat" id="id_cat">
                            <?php if ($id_cat == 0) { ?>
                                <option class="dropdown-item" value="0" selected>الكل</option>
                            <?php } elseif ($id_cat == 01) { ?>
                                <option value="<?= $id_cat ?>">الفئة المختارة</option>
                            <?php } else { ?>
                                <option value="<?= $id_cat ?>">الفئة المختارة</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- new -->
                <!-- <div class="col-lg-3 mt-3" style="margin-top: -20px ;">
                    <label>مجموعة الموضف : </label>
                    <div class="form-group select_drop">
                        <select name="user_sale_group" id="user_sale_group" class="form-control menu_user" style="padding-bottom: 4px; padding-top: 0;">
                            <option value="0">الكل</option>
                        </select>
                    </div>
                </div> -->
            </div>
            <button type="button" style="margin-top: 20px;" class="btn btn-primary " onclick="search_selas_between_date()">إرسال</button>
    </div>
    </form>
</div>

<div id='charts'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <canvas id="myChart" style="width:100%; "></canvas>
    <br><br>
    <canvas id="myChart2" style="width:100%; "></canvas>
</div>
<script>
    // function generateRandomColor() {
    //     var letters = '0123456789ABCDEF';
    //     var color = '#';
    //     for (var i = 0; i < 6; i++) {
    //         color += letters[Math.floor(Math.random() * 16)];
    //     }
    //     return color;
    // }

    function search_selas_between_date() {

        // create xValues has dates from  input from to input to
        $("#charts").empty();
        // add canvas to charts
        $("#charts").append('<canvas id="myChart" style="width:100%; "></canvas><br><br>');
        $("#charts").append('<canvas id="myChart2" style="width:100%; "></canvas>');


        // create xValues has dates from  input from to input to
        var xValues = [];
        var model = document.getElementById('model').value;
        var id_cat = document.getElementById('id_cat').value;
        var code = document.getElementById('code').value;
        var from = document.getElementById('from').value;
        var to = document.getElementById('to').value;
        // var id_group = document.getElementById('user_sale_group').value;
        var fromDate = new Date(from);
        var toDate = new Date(to);
        var diff = toDate.getTime() - fromDate.getTime();
        var diffDays = diff / (1000 * 3600 * 24);
        for (var i = 0; i <= diffDays; i++) {
            var date = new Date(fromDate.getTime() + (1000 * 3600 * 24 * i));
            xValues.push(date.toLocaleDateString());
        }


        // get username by user_id 
        // ajax to get id_user and put it in array
        // var id_user = [];
        var data = [];
        var label = [];
        var borderColor = [];
        var borderWidth = [];
        var datasets = [];
        var datasets2 = [];
        $.ajax({
            url: '<?php echo url . '/' . $this->folder ?>/daily_sales_count',
            type: 'POST',
            dataType: 'json',
            data: {
                from: from,
                to: to,
                model: model,
                id_cat: id_cat,
                code: code,
                // id_group: id_group
            },

            success: function(data) {
                // for (var i = 0; i < data.length; i++) {
                // add all to datasets
                datasets.push({
                    label: 'عدد المبيعات',
                    data: data.sales,
                    fill: false,
                    borderColor: "#" + Math.floor(Math.random() * 16777215).toString(16),
                    borderWidth: 2,
                });
                datasets2.push({
                    label: '(بالدولار)مبلغ المبيعات',
                    data: data.price_dollars,
                    fill: false,
                    borderColor: "#" + Math.floor(Math.random() * 16777215).toString(16),
                    borderWidth: 2,
                });
                // }
                new Chart("myChart", {
                    type: "line",
                    data: {
                        labels: xValues,
                        datasets: datasets,
                    },
                    options: {
                        title: {
                            display: true,
                            text: "التقرير الإجمالي للمبيعات حسب مجموع المبيعات",
                            fontSize: 30,
                            fontColor: '#000',
                        },
                        legend: {
                            display: true,
                            // position: 'right',
                            labels: {
                                fontColor: '#000',
                                fontSize: 20,
                            }
                        },
                    }
                });

                new Chart("myChart2", {
                    type: "line",
                    data: {
                        labels: xValues,
                        datasets: datasets2,
                    },
                    options: {
                        title: {
                            display: true,
                            text: "التقرير الإجمالي للمبيعات حسب مجموع الاسعار",
                            fontSize: 30,
                            fontColor: '#000',
                        },
                        legend: {
                            display: true,
                            labels: {
                                fontColor: '#000',
                                fontSize: 20,
                            }
                        },
                    }
                });
            },
        });
    }

    /**@abstract
     * ملء الفئات عند اختيار نوع المودل 
     */
    $('#model').on('change', function() {
        var value = $(this).val();
        // if not all or empty or null
        if (value != '0' && value != null) {
            $.post("<?php echo url . '/' . $this->folder . '/getCatgry/' ?>" + value,
                function(data, status) {
                    var jsonData = JSON.parse(data);
                    $("#id_cat").empty();
                    $("#id_cat").append(new Option('الكل', 0));
                    $.each(jsonData, function(index, value) {
                        $("#id_cat").append(new Option(value['title'], value['id']));
                    });
                    $("#id_cat").select2();
                });
        } else {
            $('#id_cat').empty();
            $('#id_cat').append('<option value="all">الكل</option>');
        }
    });

    // get current date and time to put it in value type datetiem local
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('from').value = now.toISOString().slice(0, 16)
    document.getElementById('to').value = now.toISOString().slice(0, 16)
</script>
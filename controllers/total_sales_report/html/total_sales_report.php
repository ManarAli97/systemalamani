<script src="<?php echo $this->static_file_control ?>/select/select2.min.js"></script>
<link href="<?php echo $this->static_file_control ?>/select/select2.min.css" rel="stylesheet" />
<style>
    .date-group {
        /* padding-left: 110px; */
        position: absolute;
    }

    .date-input {
        padding: 3px;
    }

    .model-option {
        text-align: center;
    }

    .selection_model_and_cat {
        margin-top: 30px;
        display: grid;
        column-gap: 50px;
        grid-template-columns: auto auto auto;
    }

    .cat-from {
        margin-top: 9px;
        margin-right: -300px;
    }

    .form-cat {
        margin-right: 50px;
    }

    .id_cat {
        margin-top: -60px;
        width: 200px;
    }


    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 12px 16px;
        z-index: 3;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>


<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">تقرير مبيعات الموظفين</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <!-- add two input field there type is datetime with submit btn in bosttrap -->
        <form action="<?php echo url . '/' . $this->folder ?>/total_sales_report" method="post">
            <div class="date-group">
                <label for="from">من:</label>
                <input type="datetime-local" class="date-input"  id="from" name="from" placeholder="من">

                <label for="to" style="padding-right: 7px;">الى:</label>
                <input type="datetime-local" class="date-input"  id="to" name="to" placeholder="الى">
            </div>
            <!-- add input search for barcode of item -->
            <div class="row">
                <label for="code" style="margin-right:600px">البحث بواسطة الباركود:</label>
                <input type="text" class="date-input" value="" id="code" name="code" placeholder="ادخل باركود المادة">
            </div>
            <!-- هنا نختار الموديل  -->
            <div class="row align-item-center" style="margin-top: 20px;">
                <div class="col-auto ">
                    <label for="model"> الموديل </label>
                    <div class="form-group select_drop" style="width: 100%">
                        <select name="model" id="model" class="selectpicker" aria-expanded="false" data-live-search="true">
                            <option value="0">الكل</option>
                            <?php foreach ($this->category_website as $key => $value) { ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-auto">
                    <label for="id_cat">الفئة</label>
                    <div class="form-group select_drop" id='div_cat' style="width: 100%">
                        <select name="id_cat" id="id_cat">
                            <?php if ($id_cat == 0) { ?>
                                <option class="dropdown-item" value="0" selected>الكل</option>
                            <?php } else { ?>
                                <option value="<?= $id_cat ?>">الفئة المختارة</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <button type="button" style="margin-top: 30px;height: 40px;" class="btn btn-primary " onclick="search_selas_between_date()">بحث</button>
            </div>
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <canvas id="myChart" style="width:100%; "></canvas>
    <script>
        // function generateRandomColor() {
        //     var letters = '0123456789ABCDEF';
        //     var color = '#';
        //     for (var i = 0; i < 6; i++) {
        //         color += letters[Math.floor(Math.random() * 16)];
        //     }
        //     return color;
        // }
        // 
        function search_selas_between_date() {

            // create xValues has dates from  input from to input to
            var xValues = [];
            var model = document.getElementById('model').value;
            var id_cat = document.getElementById('id_cat').value;
            var code = document.getElementById('code').value;
            var from = document.getElementById('from').value;
            var to = document.getElementById('to').value;
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
            var id_user = [];
            var data = [];
            var label = [];
            var borderColor = [];
            var borderWidth = [];
            var datasets = [];
            $.ajax({
                url: '<?php echo url . '/' . $this->folder ?>/get_users_id_whose_sales',
                type: 'POST',
                dataType: 'json',
                data: {
                    from: from,
                    to: to,
                    model: model,
                    id_cat: id_cat,
                    code: code
                },

                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        // console.log(data[i].user_id);
                        // add all to datasets
                        datasets.push({
                            label: data[i].name,
                            data: data[i].sales,
                            fill: false,
                            borderColor: "#" + Math.floor(Math.random() * 16777215).toString(16),
                            borderWidth: 2,
                        });
                    }
                    new Chart("myChart", {
                        type: "line",
                        data: {
                            labels: xValues,
                            datasets: datasets,
                        },
                        options: {
                            title: {
                                display: true,
                                text: "التقرير الإجمالي للمبيعات",
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
                }
            });
        }

        /**@abstract
         * ملء الفئات عند اختيار نوع المودل 
         */
        $('#model').on('change', function() {
            var value = $(this).val();
            // if not all or empty or null

            if (value != 'all' && value != 'product_savers' && value != null) {
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
    </script>

    <script>
        var selected = [];

        function search() {
            var model = $('#model').val();
            var day_count = $('#day_count').val();
            var id_cat = $('#id_cat').val();

            window.location.href = "<?php echo url . '/goods_availability' ?>/shortage_report/" + day_count + "/" + model + "/" + id_cat;
            return false;

        }

        /**@abstract
         * هاي الدالة ترسل نوع المودل المختار حتى يتم الفلتره على الي مختاري
         */
        $('#modelSearch').on('change', function(e) {
            $.get("<?php echo url ?>/found/setModelSession/" + e.target.value, function() {});

            table.draw();
        });

        /**@abstract
         * هاي الدالة ترسل نوع الفئة المختار حتى يتم الفلتره على الي مختاري
         */
        $('#search').on('click', function(e) {
            var day_count = $('#day_count').val();
            $.get("<?php echo url ?>/goods_availability/shortage_report/" + day_count, function() {});

            // table.draw();
        });
        /**@abstract
         * ملء الفئات عند اختيار نوع المودل 
         */
        $('#modelSearch').on('change', function() {
            var value = $(this).val();
            $.post("<?php echo url . '/' . $this->folder . '/getCatgry/' ?>" + value,
                function(data, status) {
                    var jsonData = JSON.parse(data);
                    $("#id_catSearch").empty();
                    $("#id_catSearch").append(new Option("الكل", 0));
                    $.each(jsonData, function(index, value) {

                        $("#id_catSearch").append(new Option(value['title'], value['id']));
                    });
                    $("#id_catSearch").select2();

                });
        });
    </script>
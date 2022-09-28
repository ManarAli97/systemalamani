<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><?php  echo $this->langControl('purchase_customer') ?> </a></li>
                <li class="breadcrumb-item">  بحث عن فاتورة </li>
            </ol>
        </nav>

    </div>

</div>

<form id="search_bill"  action="<?php  echo url .'/'. $this->folder ?>/data" method="get">
<div class="row">

    <div class="col-auto">
        <input type="number" name="bill" class="form-control" placeholder="رقم الفاتورة" required>
    </div>

    <div class="col-auto">
        <button  class="btn btn-warning" type="submit" >بحث</button>
    </div>

</div>
</form>
<hr>


<div class="result"></div>


<script>

    $("#search_bill").submit(function(e) {

        $('.result').html(`
              <div class="text-center"> <img style="width:85px" src="<?php echo $this->static_file_site ?>/image/site/loding.gif"></div>
        `);


        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "GET",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                if (data)
                {
                    $('.result').html(data)
                }else
                {
                    $('.result').html(`

                    <div class="alert alert-danger" role="alert">
                         الفاتورة غير موجودة
                        </div>

                    `)

                }


            }
        });

    });


</script>


<style>


    .image_prod
    {
        height: 50px;
    }

    .tableBill.table-bordered tr td {
        border: 4px solid black !important;
        padding: 2px 5px;
        vertical-align: inherit;

    }

    .tableBill_casher.table-bordered tr td {
        border: 5px solid black !important;

    }

    table.requ_on td  {
        vertical-align: middle;
    }
    .color_item_table
    {
        width: 27px;
        height: 27px;
        display: block;
    }

</style>

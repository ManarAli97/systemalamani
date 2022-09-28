<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/view_competition">  القرعة الالكترونية للمسابقة الاسبوعية </a></li>
            </ol>
        </nav>
        <hr>
    </div>
</div>


<div class="number_q">
 <span> عدد السؤال </span>  : <span><?php  echo $result['number_q'] ?>  </span>
</div>

<div class="questions_n">
<span> السؤال هو </span> : <span>  <?php  echo $result['questions'] ?> </span>
</div>
<hr>
<div class="row justify-content-center">
    <div class="col-auto">
        <button type="button"  onclick="select()" class="btn btn-success">  اجراء قرعة الالكترونية </button>
    </div>
</div>

<div class="win">

</div>



<div class="loading"></div>

<script>

function select()
{
    $('.win').empty();

    $('.loading').html(`
              <img class="loding" src="<?php echo $this->static_file_site ?>/image/site/loding2.gif">
             `);

    $.ajax({
        type: "GET",
        url: "<?php echo url . '/' . $this->folder ?>/select_win/<?php  echo $id?>",
        success: function (data) {
            if (data)
            {

                setTimeout(function () {
                    $('.loading').empty();

                    $('.win').html(
                        `
                       <div class="fiez">  الفائزين في المسابقة الاسبوعية </div>
                        <div class="this_win"> ${data} </div>

                        `
                    )
                },3000);

            }

        }
    });
}



</script>

<style>

    .loading
    {
        text-align: center;
    }
    .this_win {
        text-align: center;
        font-size: 18px;
    }

    .fiez
    {
        text-align: center;
        font-size: 26px;
        margin-top: 29px;
        margin-bottom: 15px;
        color: #28a745;
        border-top: 1px solid #d0d0d04f;
        padding-top: 5px;
    }

    .mprok
    {
        text-align: center;
        font-size: 36px;
    }
    .number_q {
        text-align: center;
        margin-top: 10px;
        font-size: 19px;
    }
    .questions_n {
        text-align: center;
        margin-top: 10px;
        font-size: 19px;
        color: #007afd;
    }
</style>


<br>
<br>
<br>
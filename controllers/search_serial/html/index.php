
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('search_serial') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>




<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">بحث عن سيريال مباع</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">حركة سيريال</a>
    </li>

</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


        <div class="row">
            <div class="col-auto">
                <input type="text"  autocomplete="off" placeholder="بحث عن سيريال منتج مباع" class="form-control" id="serial">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" id="search"   onclick="search()" > بحث </button>
            </div>
        </div>

        <br>

        <div class="result"></div>


    </div>
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


        <div class="row">
            <div class="col-auto">
                <input type="text"  autocomplete="off" placeholder="بحث عن سيريال " class="form-control" id="serial_movement">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" id="search_serial_movement"   onclick="search_serial_movement()" > بحث </button>
            </div>
        </div>

        <br>

        <div class="result_serial_movement"></div>



    </div>

</div>








<script>

    function search() {
        $(".result").empty();
        if ($("#serial").val())
        {
            $.get( "<?php echo url .'/'.$this->folder  ?>/get",{value:$("input#serial").val()}, function( data ) {
                $( ".result" ).html( data );
            });
        }else
        {
            alert("يجب ادخال سيرايل الجهاز")
        }



    }



    function search_serial_movement() {
        $(".result_serial_movement").empty();
        if ($("#serial_movement").val())
        {
            $.get( "<?php echo url .'/'.$this->folder  ?>/get_serial_movement",{value:$("input#serial_movement").val()}, function( data ) {

                console.log(data)
                $( ".result_serial_movement" ).html( data );
            });
        }else
        {
            alert("يجب ادخال سيرايل الجهاز")
        }



    }




    function save_note(id)
    {

        var  note=$("#id_save_note_"+id).val()
        if (note) {

            $.ajax({
                type: "GET",
                url: "<?php   echo url . '/' . $this->folder ?>/save_note/" + id,
                data: {note_search_serial: note}, // serializes the form's elements.
                success: function (data) {
                    $("#writer_note_"+id).text(data)
                }
            });
        }else
        {
            alert('حقل الملاحظة فارغ')
        }

    }


</script>
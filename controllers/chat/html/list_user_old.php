<br>
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_user"><?php  echo $this->langControl('chat') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>




<script>
    function showResult(str) {

        if (str.length==0) {
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            return;
        }
        $.get( "<?php  echo url . '/' . $this->folder ?>/search_live?q="+str, function( data ) {
            if (data === '0')
            {
                $( "#livesearch" ).html("<span style='color:red'> لا توجد نتائج  </span>");
            }else
            {
                document.getElementById("livesearch").style.border="2px solid #edeeef";

                $( "#livesearch" ).html( data );

            }

        });

    }
</script>


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12" >

        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i>  <i class="fa fa-user"></i> </div>
            </div>
            <input type="text"  class="form-control" size="30" placeholder="بحث عن زبون او رقم الهاتف" onkeyup="showResult(this.value)">
        </div>



        <div id="livesearch"></div>

    </div>
</div>


<br>



<div class="row">
    <div class="col-3">
        <div class="userList">

                <div class="col-lg-12" id="results"></div>
                <div id="loader_image" ><img src="<?php echo $this->static_file_site ?>/image/site/loadchat.gif" > </div>
                <div class="margin10"></div>
                <div id="loader_message"></div>


        </div>



    </div>

    <div class="col-9"  >
        <div class="controlBoxChat">
            <div class="selectChat">  يرجى اختبار شخص للمحادثة  </div>
            <div id="accordion" ></div>
            <div id="accordion">
                <div class="boxChat" id="boxChat">


                </div>

            </div>

            <form id="idForm" action="<?php  echo  url  .'/'. $this->folder?>/chatCenter_admin/<?php echo  $id ?>" method="post">
                <div class="row">

                    <div class="col">
                        <input name="message"  type="text" class="form-control sendMg"    placeholder="رسالة" required>
                    </div>

                    <div class="col-auto">
                        <input type="submit" value="ارسال" class="btn btn-info">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>

    $("#idForm").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()+'&submit=submit', // serializes the form's elements.
            success: function(data)
            {
                $('.sendMg').val('');
                load_message();

            }
        });
    });

    if(!window.Notification){
        console.log("Notification not supported!");
    }else{
        Notification.requestPermission().then(function(permission) {
            console.log(permission);
            if(permission === 'denied'){

                    load_message();

            }else if(permission === 'granted'){
                console.log('You Have Granted notification.');
            }
        })
    }


    function load_message() {
        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#boxChat').children()
            $('#boxChat').empty().html(founddata);
            scrollChat();
        });
    }

    function scrollChat() {

        var objDiv = document.getElementById("boxChat");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    // window.setInterval(function(){
    //     load_message();
    // }, 5000);

</script>


<style>

    .loader_image
    {
        text-align: center;
    }

    .newMessage
    {
        background: red;
        height: 21px;
        width: 21px;
        border-radius: 50%;
        display: block;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
    }




.phone_user_chat
{
    background: #00bcd440;
    padding: 0 18px 0 0;
    border-radius: 5px;
    font-size: 15px;
}

    .day_message {
        text-align: center;
        margin: 27px 0;
        border-top: 1px solid #125da92e;
        position: relative;
        padding-left: 60px;
    }

    .day_message  span{
        position: absolute;
        top: -15px;
        background: #e4e2e2;
        padding: 0 18px;
        border-radius: 11px;
        border: 1px solid #125da92e;
        cursor: pointer;
    }


    .day_message  span:hover{

        background: #bfbaba;

    }



    .boxChat {
        height: 500px;
        background: #f3f2f2;
        padding: 12px;
        border: 2px solid #125da92e;
        margin-bottom: 15px;
        overflow: auto;
    }


    .userList {
        height: 553px;
        overflow-y: auto;
        border: 2px solid #cad8e6;
        padding: 4px;
        background: #fbfbfb;
    }

    .userOpen {
        display: block;
        background: #ecedee;
        margin-bottom: 5px;
        padding: 9px;
        color: black;
        position: relative;

    }




    .userOpen.active{
        background: #28a745;
        color: #ffff;
        border-radius: 5px;
    }

    .userOpen:hover{
        background: #35a24ead;
        color: #ffff;
        border-radius: 5px;
        text-decoration: none;
    }

    .controlBoxChat
    {
        position: relative;
    }


    .selectChat {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 15;
        background: #98a3af63;
        display: flex;
        align-items: center;
        justify-content: center;
    }





    .m-position
    {
        position: relative;
        margin-bottom: 15px;
    }



    .m-position.right
    {

        text-align: right;
    }


    .m-position.right span
    {
        padding: 2px 21px;
        border-radius: 16px;
        background: #17a2b8;
        position: relative;
        color: #fff;
        line-height: 35px;
    }

    .m-position.right span.block
    {
        display: block;
    }

    .m-position.right span:before
    {
        content: '\f0da';
        position: absolute;
        right: -7px;
        top: -1px;
        font-family: FontAwesome;
        color: #17a2b8;
        font-size: 26px;
    }

    /*----------left---------*/

    .m-position.left
    {
        text-align: left;
    }


    .m-position.left span
    {
        padding: 2px 21px;
        border-radius: 16px;
        background: darkseagreen;
        position: relative;
        line-height: 35px;
    }

    .m-position.left span.block
    {
        display: block;
        text-align: right;
    }

    .m-position.left span:after
    {
        content: '\f0d9';
        position: absolute;
        left: -7px;
        top: -1px;
        font-family: FontAwesome;
        color: #8fbc8f;
        font-size: 26px;


    }


    a.customer_live {
        display: block;
        margin: 9px;
        background: #607D8B;
        padding: 6px 18px;
        border-radius: 9px;
        color: #ffffff;
        text-decoration: none !important;
        font-size: 18px;
    }

    a.customer_live:hover {

        background: #7497a7;

    }
    a.customer_live .number_phone {

        color: #FFEB3B;
        font-size: 14px;

    }

    #loader_message,#loader_image
    {
        text-align: center;
    }
    .no_thing
    {
        display: block;
        background: #5b6d80;
        border-radius: 5px;
        color: #fff;
        margin: 4px 0;
    }

</style>


<div class="modal fade" id="exampleModal_notification" tabindex="-1" role="dialog" aria-labelledby="exampleModal_notification" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">

                <div class="notif">
                    <i class="fa fa-bell"></i>
                </div>

                <div class="mesg_notf">
                    يرجى تفعيل الاشعارات لستلام الرسائل.
                </div>

            </div>

            <div class="done_notf">
                <button type="button" class="btn" data-dismiss="modal">اغلاق </button>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        Notification.requestPermission().then(function(result) {
            if (result === 'denied' || result === 'default' ) {
                $('#exampleModal_notification').modal('show')
            }
        });

    });

</script>

<style>
    .notif
    {
        font-size: 58px;
        text-align: center;
        transform: rotate(-38deg);
        color: red;
        margin-bottom: 15px;
    }

    .mesg_notf
    {
        margin-bottom: 20px;
        text-align: center;
        font-size: 18px;
    }

    .done_notf
    {
        text-align: center;
        margin-bottom: 15px;
    }
    .done_notf button
    {
        text-align: center;
        background: transparent;
        border: 1px solid #cfced0;
        box-shadow: 2px 2px 3px #d6d6d69c;
    }
    .userOpen
    {
        cursor: pointer;
    }



</style>



<script type="text/javascript">
    function getMessage(id) {
       alert(id)
    }













    var busy = false;
    var limit = 9
    var offset = 0;

    function displayRecords(lim, off) {
        $.ajax({
            type: "GET",
            async: false,
            url: "<?php echo url .'/'.$this->folder ?>/loadmore",
            data: "limit=" + lim + "&offset=" + off,
            cache: false,
            beforeSend: function() {
                $("#loader_message").html("").hide();
                $('#loader_image').show();
            },
            success: function(html) {
                $("#results").append(html);
                $('#loader_image').hide();
                if (html == "") {
                    $("#loader_message").html('<span class="no_thing"> لا يوجد شي </span>').show()
                } else {
                    $("#loader_message").html('<img src="<?php echo $this->static_file_site ?>/image/site/loadchat.gif" >').show();
                }
                window.busy = false;

            }
        });
    }

    $(document).ready(function() {
        // start to load the first set of data
        if (busy == false) {
            busy = true;
            // start to load the first set of data
            displayRecords(limit, offset);
        }


        $('.userList').scroll(function() {
            // make sure u give the container id of the data to be loaded in.

            if ($('.userList').scrollTop() + $('.userList').height() > $("#results").height() && !busy) {
                busy = true;
                offset = limit + offset;

                // this is optional just to delay the loading of data
                setTimeout(function() { displayRecords(limit, offset); }, 500);

                // you can remove the above code and can use directly this function
                // displayRecords(limit, offset);

            }
        });

    });

</script>































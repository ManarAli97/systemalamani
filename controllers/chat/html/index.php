<?php  $this->publicHeader($this->langSite('chat'));  ?>



<div class="center_cat">
    <?php  echo $this->langSite('chat') ?>
</div>
<div class="container ">
    <div class="row">
        <div class="col-12">
            <div id="accordion">
            <div class="boxChat" id="boxChat">

                <?php  foreach ($chat as  $key => $chx )  {  ?>

                    <div class="day_message r_d_<?php echo $key ?>">
                        <span data-toggle="collapse" data-target="#id_d<?php echo $key ?>" aria-expanded="true" aria-controls="id_d<?php echo $key ?>"> <?php  echo date('Y-m-d', $key)?> </span>

                    </div>

                   <div class="show  collapse r_d_<?php echo $key ?>  <?php   if (strtotime(date('Y-m-d',time())) == $key)  echo 'show' ?>" style="padding: 0 8px;" id="id_d<?php echo $key ?>"   aria-labelledby="id_d<?php echo $key ?>" data-parent="#accordion"  >
                    <?php  foreach ($chx as $ch ) { ?>

                        <div class="row  m-position <?php  if ($ch['direction'] =='right') echo 'justify-content-end'?> ">

                            <div class="col-auto line_message  <?php  echo $ch['direction']  ?>"    <?php   if ($this->get_num_of_words($ch['message']) >  15) echo 'style="width:100%"'; ?> >
                              <div>   <?php   echo $ch['message'] ?> </div>
                            </div>
                        </div>


                <?php  }  ?>
            </div>

                <?php  }  ?>
            </div>

        </div>
        </div>



        <div class="col-12">
        <form id="idForm" action="<?php  echo  url  .'/'. $this->folder?>/chatCenter/<?php echo  $_SESSION['id_member_r'] ?>" method="post">
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
         data_msg=form.serialize()+'&submit=submit';

        msg=$('.sendMg').val();


        msgLive(msg);
        $.ajax({
            type: "POST",
            url: url,
            data:data_msg , // serializes the form's elements.
            success: function(data)
            {

               $('.sendMg').val('');
             //   load_message();
            }
        });


    });


function msgLive() {
    $('#boxChat').append(`<div class="show ">

                       <div class="row  m-position  ">
                            <div class="col-auto line_message  left">
                              <div> ${msg}  </div>
                      </div>
                  </div></div>
          `);
    scrollChat();
    $('.sendMg').val('');
}


</script>



    <style>



        .send_url
        {
            color: #FFEB3B;
            font-weight: bold;
        }


        .send_url:hover
        {
            color: #FFEB3B;
            font-weight: bold;
        }


        .day_message {

            margin: 27px 0;
            border-top: 1px solid #125da92e;
            position: relative;
            padding-left: 60px;
            text-align: center;

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


        .day_message  button{
            position: absolute;
            top: -18px;
            background: transparent;
            padding: 0;
            border-radius: 11px;
            left: 0;
            font-size: 23px;
            color: red;
        }
        .day_message button.btn.focus, .day_message button.btn:focus {
            outline: 0;
            box-shadow: unset !important;
        }

        .boxChat {

            height: 500px;
            padding: 12px;
            border: 2px solid #125da92e;
            margin-bottom: 15px;
            overflow-x: hidden;
            border-radius: 8px;
        }

        @media (max-width: 570px) {
            .boxChat {
                height: 320px;
            }
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


        .m-position
        {
            position: relative;
            margin-bottom: 15px;
        }



        .line_message.left
        {

            text-align: right;
        }


        @media  (max-width:640px ){
            .line_message.left
            {
                text-align: right;
                width: 100%;
            }
        }





        .line_message.left div
        {
            padding: 2px 21px;
            border-radius: 16px;
            background: #17a2b8;
            position: relative;
            color: #fff;
            line-height: 35px;
        }


        .line_message.left div:before
        {
            content: '\f0da';
            position: absolute;
            right: -7px;
            top: -1px;
            font-family: FontAwesome;
            color: #17a2b8;
            font-size: 26px;
        }

/*---------------right------------------*/

        .line_message.right
        {
            text-align: left;
        }
        @media  (max-width:640px ){
            .line_message.right
            {
                text-align: right;
                width: 100%;
            }
        }


        .line_message.right div
        {
            padding: 2px 21px;
            border-radius: 16px;
            background: darkseagreen;
            position: relative;
            line-height: 35px;
            min-height: 34px;
        }

        /*.m-position.right span.block*/
        /*{*/
        /*    display: block;*/
        /*    text-align: right;*/
        /*}*/

        .line_message.right div:after
        {
            content: '\f0d9';
            position: absolute;
            left: -7px;
            top: 1px;
            font-family: FontAwesome;
            color: #8fbc8f;
            font-size: 26px;


        }
        .center_cat {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 24px 0 9px 0;
        }
    </style>


<br>
<br>


<script>


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
            var founddata = $(data).find('#boxChat').children();
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
</style>


<?php $this->publicFooter(); ?>
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/send_direct"><?php  echo $this->langControl('api') ?> </a></li>

                <li class="breadcrumb-item active" aria-current="page" >ارسال مباشر</li>
            </ol>
        </nav>
        <hr>
    </div>
</div>
<br>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >الجملة كاملة</span>
  </div>
  <input type="text" id="str_input" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >نوع الدالة</span>
  </div>
  <input type="text" id="function" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" >الجدول</span>
  </div>
  <input type="text" id="table_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
</div>
<div class="progress">
  <div id="prog_bar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0</div>
</div>
<br>
<h4 ><span id='done_count' class="badge badge-info"></span></h4>
<h4 ><span id='done_pircenteg' class="badge badge-info"></span></h4>
<br>
<button id="addion_bt" type="button" class="btn btn-primary">تنفيذ</button>
<hr>
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">With textarea</span>
  </div>
  <textarea id='report' class="form-control" aria-label="With textarea"></textarea>
</div>
<script>
     $(document).ready(function(){
		console.log('test hfguiorehfguirehgreuigh');
        $( "#addion_bt" ).click(function() {
            imput = $("#str_input").val();
            // console.log(imput);
            // ids = [];
            // s ='asdsad';
            var report ="";
            $.post("<?php echo url ?>/api/get_ids",
            {
                str: imput
            },
            function(data, status){
                   var ids= JSON.parse(data) ;
                   var count_ids = ids.length;
            		$('#prog_bar').attr('aria-valuemax', count_ids);
            		var i = 0;
            		// هذا 
            		var ids_rep = ids;
            		console.log('ids befor while'+ids.toString());
            		console.log('ids_rep befor while'+ids_rep.toString());
            		
                  
                    	ids = ids_rep;
                    	ids_rep = [];
                    	console.log('ids after while'+ids.toString());
            			console.log('ids_rep after while'+ids_rep.toString());
                   		
                   		send_ajax(ids,$("#function").val(),$("#table_name").val());
                    //    console.log(value);
                        	
                       
                    	
                    
                  
                });
                // $("#report").text(report);
                
       
            // items = items + 200;
            // wid = items*100/all_item;
            // console.log(items);
            // console.log(wid);
           
            // $('#prog_bar').attr('aria-valuenow', items).css('width', wid+'%');
            });
     function send_ajax(id_row,function_name,table_name)
     {
     	var temp = id_row.shift();
     	console.log('temp '+temp);
     	$.post("<?php echo url ?>/api/synchronization_direct",
        {
        	id_rec: temp,
            function: function_name,
            table_name: table_name
        },
        function(data, status){
        	console.log('status'+status);
            if(status=='success'){
            	var dd = JSON.parse(data);
                console.log('dd'+dd);
                console.log('id_row'+temp);
             
                if( parseInt(dd) >0)
                {
                	report+= 'id : ' +temp+ ' is add sccess \n';
                 	$("#report").text(report);
                    // console.log(dd);
                    // $("#prog_bar").text('The value at arr[' + index + '] is: ' + value);
                }else{
                	report+= 'id : ' +temp+ ' is has error \n';
                    $("#report").text(report);
                }
                // var index_show = index+1;
            	var i = $('#prog_bar').attr('aria-valuenow');
            	var count_ids = $('#prog_bar').attr('aria-valuemax');
            	i++;
                var wid = i*100/count_ids;

                // console.log('The value at arr[' + index + '] is: ' + value);
                // $("#prog_bar").text( i + ' / ' + count_ids);
                $('#prog_bar').attr('aria-valuenow', i).css('width', wid+'%');
            	$("#done_count").text( 'تمت مزامنة '+i + ' من اصل  ' + count_ids);
            	$("#done_pircenteg").text( "نسبة التقدم : "+ wid+'%');
                //ids_rep.push(value);
            	if(id_row.length>0){
            	send_ajax(id_row,function_name,table_name);
                }
                
            }else
                
            {
             console.log(" add agin in ids_rep :"+temp);
            id_row.unshift(temp);
            send_ajax(id_row,function_name,table_name);
            // ids_rep.push(id_row);
            // check_all=true;
            
   
            }
        })
     }
            
            
            
   
});

</script>
  
<br>
<br>
<br>



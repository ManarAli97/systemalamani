<?php  $this->publicHeader('qr');  ?>






<br>
<br>
    <script  src="<?php echo $this->static_file_site ?>/camera/app.js"></script>


<br>
<br>
    <input type="text" id="ccccc" class="readonly" autocomplete="off" required />

    <script>


        $(".readonly").on('keydown paste focus ', function(e){
           console.log(e.keyCode)
            if(e.keyCode != 9) // ignore tab
                e.preventDefault();
        });
    </script>
<input class="form-control" inputmode="none"   type="text">




<br>



<button  onclick="openVideo()" class="btn btn-primary"> qr </button>

    <style>


        #webcam-preview2
        {
            width: 100% !important;
            height: 400px !important;
            border-radius: 5px;
        }
        .resultErrorcam
        {
            color: red;
        }


    </style>

<div class="container">

    <video id="webcam-preview2"></video>
    <p id="result2"></p>
    <script>



        function openVideo() {

            $('#qqqr').select();
            const codeReader = new ZXing.BrowserQRCodeReader();

            codeReader.decodeFromVideoDevice(null, 'webcam-preview2', (result, err) => {
                if (result) {
                    // properly decoded qr code
                    console.log('Found QR code!', result)
                    $('#qqqr').val(result.text);


                    // codeReader.reset();
                    // codeReader.stopContinuousDecode();
                    var audio = new Audio('<?php echo $this->static_file_site ?>/camera/qr.mp3');
                    audio.play();
                }

                if (err) {

                    if (err instanceof ZXing.NotFoundException) {
                        console.log('No QR code found.')
                    }

                    if (err instanceof ZXing.ChecksumException) {
                        console.log('A code was found, but it\'s read value was not valid.')
                    }

                    if (err instanceof ZXing.FormatException) {
                        console.log('A code was found, but it was in a invalid format.')
                    }
                }
            })
        }
    </script>
    <br>
    <br>

    <br>
    <br>
</div>



<?php $this->publicFooter(); ?>
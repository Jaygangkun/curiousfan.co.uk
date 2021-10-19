<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo e(config('app.url')); ?>/css/bootstrap.min.css">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>
    <!--<link rel="Stylesheet" type="text/css" href="demo/prism.css" />-->
    <link rel="Stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.css" />
    <link rel="Stylesheet" type="text/css" href="<?php echo e(config('app.url')); ?>/js/croppie/croppie.css" />
    <!--<link rel="Stylesheet" type="text/css" href="demo/demo.css" />-->
    <style>
        button.profilePicture-result,
        a.file-btn {
            color: white;
            cursor: pointer;
            text-decoration: none;
            text-shadow: none;
            display: inline-block;
        }
        a.file-btn span{color:#FFFFFF;}
        input[type="file"] {
            cursor: pointer;
            color:#FFFFFF;
        }
        button:focus {
            outline: 0;
        }

        .file-btn {
            position: relative;
        }
        .file-btn input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
        }
        .uploadProfilePicture .upload-profilePicture-wrap,
        .uploadProfilePicture .profilePicture-result,
        .uploadProfilePicture.ready .profilePicture-msg {
            display: none;
        }
        .uploadProfilePicture.ready .upload-profilePicture-wrap {
            display: block;
        }
        .uploadProfilePicture.ready .profilePicture-result {
            display: inline-block;
        }
        .upload-profilePicture-wrap {
            width: 400px;
            height: 400px;
            margin: 0 auto;
        }

        .profilePicture-msg {
            text-align: center;
            padding: 50px;
            font-size: 22px;
            color: #aaa;
            width: 260px;
            margin: 50px auto;
            border: 1px solid #aaa;
        }
    </style>
</head>
<body>
<div class="uploadProfilePicture">
    <div class="container">
        <div class="grid">
            <div class="col-md-12">
                <div class="actions text-center">
                    <br><span>Click below Button to upload Image</span><br><br>
                    <a class="btn file-btn btn-primary">
                        <span>Upload Image</span>
                        <input type="file" id="profilePicture" value="Choose a file" accept="image/*" />
                    </a>
                    <button class="btn btn-success profilePicture-result">Save Image</button>
                </div>
            </div>
            <div class="col-md-12" style="margin-top:20px; margin-bottom: 50px; ">
                <div class="profilePicture-msg">
                    Upload a Profile Picture to start cropping
                </div>
                <div class="upload-profilePicture-wrap">
                    <div id="upload-profilePicture"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="bower_components/jquery/dist/jquery.min.js"><\/script>')</script>
<!--<script src="demo/prism.js"></script>-->
<script src="<?php echo e(config('app.url')); ?>/js/bootstrap.min.js"></script>
<script src="https://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo e(config('app.url')); ?>/js/croppie/croppie.js"></script>
<!--<script src="demo/demo.js"></script>-->
<script src="https://foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>
<script>
    function popupResult(result) {
        var html;
        if (result.html) {
            html = result.html;
        }
        if (result.src) {
            html = '<img src="' + result.src + '" />';
        }
        swal({
            title: '',
            html: true,
            text: html,
            allowOutsideClick: true
        });
        setTimeout(function(){
            $('.sweet-alert').css('margin', function() {
                var top = -1 * ($(this).height() / 2),
                    left = -1 * ($(this).width() / 2);

                return top + 'px 0 0 ' + left + 'px';
            });
        }, 1);
    }
    var $uploadCrop;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.uploadProfilePicture').addClass('ready');
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });

            }

            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-profilePicture').croppie({
        viewport: {
            width: 300,
            height: 300,
            //type: 'circle'
        },
        enableExif: true
    });

    $('#profilePicture').on('change', function () { readFile(this); });
    $('.profilePicture-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            /*popupResult({
                src: resp
            });*/
            $.ajax({
                url:'<?php echo e(config('app.url')); ?>/profile/profileImageUpdate',
                type:'POST',
                data:{"profilePic":resp, "img_type":"profile_image", "_token": "<?php echo e(csrf_token()); ?>"},
                success:function(data){
                    /*$('#imageModel').modal('hide');*/
                    //alert('Crop image has been uploaded');
                    //window.top.location.reload(true);
                    window.parent.closeModal(data.updated_pic);
                }
            });
        });
    });
    /*$('#saveProfilePicture').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $.ajax({
                url:'<?php echo e(config('app.url')); ?>/profile/profileImage',
                type:'POST',
                data:{"profilePic":response, "_token": "<?php echo e(csrf_token()); ?>"},
                success:function(data){
                    /!*$('#imageModel').modal('hide');*!/
                    alert('Crop image has been uploaded');
                }
            });
        });});*/
</script>
</body>
</html><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/profile/imageIframe.blade.php ENDPATH**/ ?>
<!doctype html>
<html>
<head>
    <style type="text/css">
    .tlogin{
        position: absolute;
        right: 0px;
        top:0px;
        width: 100px;
        height: 40px;
    }
    </style>
    <link href="<?php echo e(URL::asset('/css/style_log.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('/css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('/css/userpanel.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('/css/jquery.ui.all.css')); ?>">
</head>
<body class="login" mycollectionplug="bind">
<div class="login_m">
    <div class="login_logo"><img src="<?php echo e(URL::asset('/css/logo.png')); ?>" width="196" height="46"></div>
    <div class="login_boder">
<div>
    <button  class="tlogin">注册</button>
</div>

        <div class="login_padding" id="login_model">

            <h2>USERNAME</h2>
            <label>
                <input type="text" class="tname" onfocus="if (value ==&#39;Your name&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;Your name&#39;}" value="Your name">
            </label>
            <h2>PASSWORD</h2>
            <label>
                <input type="password"  class="tpwd" onfocus="if (value ==&#39;******&#39;){value =&#39;&#39;}" onblur="if (value ==&#39;&#39;){value=&#39;******&#39;}" value="******">
            </label>
            <div class="rem_sub">
                <label>
                    <input type="submit" class="button1" value="SIGN-IN" style="opacity: 0.7;">
                </label>
            </div>
        </div>
<p id="user" hidden="hidden"><?php echo e(Redis::get('user')); ?></p>
</body>
<script type="text/javascript" src="<?php echo e(URL::asset('/js/jquery.min.js')); ?>"></script>
<script type="text/javascript">
    var session = $('#user').text();
    if(session != ""){
        window.location.href ="http://"+window.location.host+"/search";
    }

$(".button1").click(function () {
    var string = "?";
    string = string +"tname="+$('.tname').val()+"&";
    string = string +"tpwd="+$('.tpwd').val();// alert(string);
   $.ajax({
      type:"get",
      url:"/login1"+string,
      success:function (data) {
        if(data == 1){
            window.location.href="http://"+window.location.host+"/teacherinfo";
        }else if(data == 2){
            alert("该用户不存在");
        }else if(data == 3){
            alert("用户名和密码不匹配");
        }
      }
   });
});
    $('.tlogin').click(function () {
        window.location.href = "http://"+window.location.host+"/register";
    });
</script>
</html>
<!doctype html>
<html>
<head>
<style type="text/css">
    #teacher_register{
        position: absolute;
        left: 30%;
        top:30%;
    }
    #axc-success{
        position: absolute;
        left: 30%;
        top: 30%;
        width: 300px;
        height: 20px;
        background: aliceblue;
        border: solid 1px #cccccc;
    }
</style>
</head>
<body>
<div id="axc-success" hidden="hidden">
    注册成功，将要跳到登录页面
</div>
<div id="teacher_register" >
    老师id：<input type="text" class="tid"><br>
    姓名:<input type="text" class="tname"><br>
    密码 : <input type="text" class="tpwd"><br>
    确认密码： <input type="text" class="tpwd1"><br>
    <button class="button1" type="button" name="ok">确定</button>
    <button class="button2" type="button" name="cancel">取消</button>
</div>
<p id="user" hidden="hidden">{{Cookie::get('user')}}</p>
</body>
<script type="text/javascript" src="{{ URL::asset('/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    var session = $('#user').text();
    if(session != ""){
        window.location.href ="http://"+window.location.host+"/teacherinfo";
    }
    $(".button1").click(function(){
        if($(".tid").val() == ""){
            alert("请输入工号");
        }
        if($(".tname").val() == ""){
            alert("请输入名字");
        }
        if($(".tpwd").val() == ""){
            alert("请输入密码");
        }
        if($(".tpwd").val() != $(".tpwd1").val()){
            alert("密码不相同，请重新输入");
        }
        var string = "?";
        string = string +"tid="+$(".tid").val()+"&";
        string = string +"tname="+$(".tname").val()+"&";
        string = string +"tpwd="+$(".tpwd").val();
        // alert(string);
        $.ajax({

            type:"get",
            url:"/register1"+string,

            success:function (data) {
               if(data == 1){
                   var path = "http://"+window.location.host+ '/login';
                       $(location).attr('href',path)
               }else if(data == 2){
                   alert("老师工号已存在，请重新输入");
               }else if(data == 3){
                   alert("老师姓名已存在，请重新输入");
               }
            }

        });
        

    });
</script>
</html>
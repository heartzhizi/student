<!doctype html>
<html>
<head>
    <style type="text/css">

    #teacherinfo {
        border: 1px solid #000000;
        position:absolute;
        top:20%;
        left:30%;
        border-collapse: collapse;
    }
    #teacherinfo td{
        padding: 10px 20px;
        border:  1px solid #000000;
        border-collapse: collapse;
    }
    #teacherinfo  button{
        padding: 10px 20px;
    }
    .div_teacher{
        position:absolute;
        top:10%;
        left:50%;
        width: 100px;
        height: 50px;
        background-color: #d9edf7;
    }
    .studentinfo{
        width: 100px;
        height: 50px;
    }
    .user{
        position:absolute;
        top: 0%;
        right:100px;
        width: 200px;
        height: 50px;
        /*background-color: #d9edf7;*/
    }
    </style>
</head>
<body>
        <div class="div_teacher">
            <button type="button" class="studentinfo">学生信息</button>
        </div>

        <div class="user">
            <p class="p1"></p>
            <a href="/logout">退出登录</a>
        </div>
        <table id="teacherinfo">
            <tr>
                <td>老师</td>
                <td>学生数量</td>
                <td colspan="2"></td>
            </tr>
        </table>
    <p id="user" hidden="hidden">{{ Cookie::get('user') }}</p>
</body>
<script type="text/javascript" src="{{ URL::asset('/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    var session = $('#user').text();
    if(session == ""){
        window.location.href= "http://"+window.location.host+"/login";
    }else {
        $('.user .p1').text(session);
    }
    var teacher =@json($teacher);
   var tNode = function (data) {
       var tElement = '<tr class=' +data.tname+ '><td >'
                    +data.tname+
                    '</td><td>'
                    +data.snum+
                    '</td><td><button type="button" class='+data.tname+' name="search">查询</button>'+
               '<button style="margin-left:20px" type="button" name ="delt" class='+data.tname+'>删除</button></tr>'
       return tElement;
   }

   for(var i =0; i< teacher.length;i++){
       $('#teacherinfo').append(tNode(teacher[i]));
   }
    $('button').click(function () {
        var temp = $(this).parent().parent();
        var tname = $(this).attr('class');
        // alert();
        if($(this).text()== "删除"){
            $.ajax({
              type:'get',
                url:'/delteacher?tname='+tname,
                success:function (data) {
                    temp.remove();
                }
            });
        } else if($(this).text()== "查询"){
                    window.location.href = "http://"+window.location.host+"/showtid?tname="+tname;
        }
    });
   $('.studentinfo').click(function () {
       window.location.href = "http://"+ window.location.host+"/search";
   });
</script>
</html>

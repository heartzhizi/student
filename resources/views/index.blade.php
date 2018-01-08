<html>

<style type="text/css">

    #stutable {
        border: 1px solid #000000;
        position:absolute;
        top:20%;
        left:30%;
        border-collapse: collapse;
    }

    #stutable td{
        padding: 10px 20px;
        border:  1px solid #000000;
        border-collapse: collapse;
    }
    #stutable button{
        padding: 10px 20px;
        /*border:  1px solid #000000;*/
        /*border-collapse: collapse;*/
    }
    .div_teacher{
        position:absolute;
        top:10%;
        left:50%;
        width: 100px;
        height: 50px;
        background-color: #d9edf7;
    }
 .teacherinfo{
     width: 100px;
     height: 50px;
 }
    #editdiv input{
        margin-bottom: 10px;
        font-size: 16px;

    }
    #editdiv td{
        position: relative;
        left:100px;
        width: 100px;
    }
</style>
<body>
        <div class="div_teacher">
            <button class="teacherinfo">老师信息</button>
        </div>
        <table id="stutable" >
            <tr >
                <td>姓名</td>
                <td>性别</td>
                <td>年龄</td>
                <td>班级</td>
                <td>老师</td>
                <td colspan="2"><button class="button3" type="button"> 添加用户</button></td>
            </tr>
        </table>
        {{--修改--}}
        <div id="editdiv" hidden="hidden">
           用户名 ： <input type="text" class="name"><br>
            性别 :    <select id="sexedit"  style="width: 180px">
                <option value="男">男</option>
                <option value="女">女</option>
            </select><br>
             年龄 :  <input type="text" class="age"><br>
             班级 :  <input type="text" class="classid"><br>
            老师 :    <select id="tname" style="width: 180px">

            </select><br>
            <button class="button1" type="button" name="ok">确定</button>
            <button class="button2" type="button" name="cancel">取消</button>
        </div>
        <!--添加-->
        <div id="editdiv1" hidden="hidden">
            用户名：<input type="text" class="nameadd"><br>
            性别:<select id="sexadd" class="sexadd" style="width: 180px">
                <option value="男">男</option>
                <option value="女">女</option>
            </select><br>
            年龄 : <input type="text" class="ageadd"><br>
            班级:<input type="text" class="classidadd"><br>
            老师:<select id="ts" style="width: 180px">

                 </select><br>
            <button class="button4" type="button" name="ok">确定</button>
            <button class="button5" type="button" name="cancel">取消</button>
        </div>
        <p id="userid" hidden="hidden">{{ Cookie::get('user') }}</p>
</body>
<script type="text/javascript" src="{{ URL::asset('/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
    var session = $('#userid').text();
    if(session == ""){
        window.location.href= "http://"+window.location.host+"/login";
    }else {
        $('.user .p1').text(session);
    }
    var temp =@json($stud);
    {{--var tname=@json($tname);--}}
//    展示学生信息
    var Student = function (temp) {
        var node = '<tr class='+temp.Id+'><td>'
        +temp.name+
        '</td><td>'
        +temp.sex+
        '</td><td>'
        +temp.age+
        '</td><td>'
        +temp.classid+
         '</td><td>'
        +temp.tname+
        '</td><td><button name="edit" class='+temp.Id+'>编辑</button></td><td><button name="delete" class='+temp.Id+'>删除</button></td></tr>';

        return node;
    }

    function createstudent(temp) {
        for(var i = 0; i< temp.length;i++){
            $('#stutable tbody').append(Student(temp[i]));
        }
    }
    createstudent(temp);


//  验证是否为数字
    function isNumber(value) {
        var patrn = /^(-)?\d+(\.\d+)?$/;
        if (patrn.exec(value) == null || value == "") {
            return false
        } else {
            return true
        }
    }

    var verify = function (name,age,classid) {
        if(name == ''){
            alert("请输入姓名");
            return false;
        }

        if(!isNumber(age) || age == ''){
            alert("年龄请输入数字");
            return false;
        }

        if(!isNumber(classid) || classid == ''){
            alert("班级请输入数字");
            return false;
        }
    }

//    eidt or delete student
    $('button').unbind('click').click(function () {
        var type = $(this).attr('name');
        var p = $(this).parent().parent();
//        编辑学生
        if(type == "edit"){
            $("#editdiv").show();
            $("#editdiv1").hide();
            var id = $(this).attr('class');
            var array = {};
            p.find('td').each(function (i) {
                array[i] = $(this).html();
            });
            $('#editdiv .name').val(array[0]);
            $('#editdiv .age').val(array[2]);
            $('#editdiv .classid').val(array[3]);
            $.ajax({
                type:'get',
                url:'/showname',
                success:function (data) {
                    $('#tname').empty();
                    for(var i = 0; i<data.length ;i++){
                        $('#tname').append(option1(data[i].tname));
                    }
                }
            });

            var oldtname = array[4];
            $(".button1").unbind('click').click(function(){
                if(verify($('.name').val(),$('.age').val(),$('.classid').val()) == false)
                    return false;
                var string = "?";
                var sex = $('#sexedit option:selected');
                var tname = $('#tname option:selected');
                string = string+"id="+id+"&"+"name="+$('.name').val()+"&"+"sex="+sex.val()+"&"
                        +"age="+$('.age').val()+"&"+"classid="+$('.classid').val()+"&"+"tname="+tname.val()+"&"
                        +"oldtname="+oldtname;

                $.ajax({
                    type:'get',
                    url:'edit/'+string,
                    success:function ( data ) {
                        var a1 = {};
                        for(var i = 1; i<=5 ; i++)
                            a1[i-1] = data[i];
                            if(p.attr('class') == data[0]){
                                p.find('td').each(function(i){
                                    if( i< 5){
                                        $(this).text(a1[i]);
//
                                    }
                                });
                            }
//                        });
                        $('#editdiv').hide();
                    }
                });
            });

        }else if(type == 'delete'){

            var i = $(this).attr('class');
            $.ajax({
                type:'get',
                url:'del/'+i,
                success:function ( data ) {
                    $("button").each(function () {
                        if($(this).attr('name') == 'delete' ){
                            if( $(this).attr('class') == data){
                                var p =  $(this).parent().parent();
                                var pp = p.parent();
                                p.remove();
                            }
                        }
                    });
                    $('#editdiv').hide();
                    $('#editdiv1').hide();
                }
            });


        }
    })


    $(".button2").click(function(){
        $("#editdiv").hide();
    });
    $(".button5").click(function(){
        $("#editdiv1").hide();
    });
//    展示老师信息
    var option1 = function (data) {
        var tNode = '<option value='+data+'>'+data+'</option>';
        return tNode;
    }
    //添加学生
    $('.button3').unbind('click').click(function(){
       $('#editdiv').hide();
      $('#editdiv1').show();
        //需要得到所有老师的信息；
        $.ajax({
            type:'get',
            url:'/showname',
            success:function (data) {
                $('#ts').empty();
                for(var i = 0; i<data.length ;i++){
                    $('#ts').append(option1(data[i].tname));
                }
            }
        });

//  添加学生信息
       $('.button4').unbind('click').click(function(){
           var tname1 = $('#ts option:selected');
           var sex = $('#sexadd option:selected');
           if(verify($('.nameadd').val(),$('.ageadd').val(),$('.classidadd').val()) == false)
               return false;
           var string ='?';
           string = string+"name="+$('.nameadd').val()+"&"+"sex="+sex.val()+"&"+"age="+$('.ageadd').val()+"&"+
               "classid="+$('.classidadd').val()+"&"+"tname="+tname1.val();

           $.ajax({
               type:'get',
               url:'create/'+string,
               success:function ( data ) {

                   var temp = new Object();
                   temp.name = data[0];
                   temp.sex = data[1];
                   temp.age = data[2];
                   temp.classid = data[3];
                   temp.tname = data[4];
                   $('#stutable tbody').append(createstudent(new Array(temp)));
                   $('#editdiv1').hide();
                   $('#editdiv1 input').each(function () {
                       $(this).val('');
                   });
                   $('#editdib').hide();

               }
           });
       });

   });
    $('.teacherinfo').click(function () {
        window.location.href = "http://"+ window.location.host+"/teacherinfo";
    });
</script>

</html>

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
            性别 :    <input type="text" class="sex"><br>
             年龄 :  <input type="text" class="age"><br>
             班级 :  <input type="text" class="classid"><br>
            老师 :    <input type="text" class="tname"><br>
            <button class="button1" type="button" name="ok">确定</button>
            <button class="button2" type="button" name="cancel">取消</button>
        </div>
        <!--添加-->
        <div id="editdiv1" hidden="hidden">
            用户名：<input type="text" class="nameadd"><br>
            性别:<input type="text" class="sexadd"><br>
            年龄 : <input type="text" class="ageadd"><br>
            班级:<input type="text" class="classidadd"><br>
            {{--老师:<input type="text" class="tnameadd"><br>--}}
            老师:<select id="ts" style="width: 180px">

                 </select><br>
            <button class="button4" type="button" name="ok">确定</button>
            <button class="button5" type="button" name="cancel">取消</button>
        </div>
</body>
<script type="text/javascript" src="{{ URL::asset('/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
    var temp =@json($stud);
    var tname=@json($tname);

    function init( temp,tname){
        var innerHtml = document.getElementById("stutable");
        for(var i = 0; i<temp.length; i++){
            var tr = document.createElement("tr");
            var j = temp[i].Id;
            tr.className = j;
            var td = document.createElement("td");
            td.innerHTML = temp[i].name;
            tr.appendChild(td);
            var td = document.createElement("td");
            td.innerHTML = temp[i].sex;
            tr.appendChild(td);
            var td = document.createElement("td");
            td.innerHTML = temp[i].age;
            tr.appendChild(td);
            var td = document.createElement("td");
            td.innerHTML = temp[i].classid;
            tr.appendChild(td);
            var td = document.createElement("td");
            td.innerHTML = tname[i][0].tname;
            tr.appendChild(td);
            var td = document.createElement("td");

            var button = document.createElement("button");
            button.name= 'edit';
            button.className = j;
            button.innerHTML = '编辑';
            button.onclick = function () {
                $("#editdiv").show();
                $("#editdiv1").hide();
                var p =   $(this).parent().parent();
                var id = $(this).attr('class');
                var array = {};
                p.find('td').each(function (i) {
                    array[i] = $(this).html();
                });
                $("#editdiv").find('input').each(function(i){
                    $(this).val(array[i]);
                });
                var oldtname = array[4];
                $(".button1").click(function(){
                    var string = "?";
                    string = string+"id="+id+"&"+"name="+$('.name').val()+"&"+"sex="+$('.sex').val()+"&"
                        +"age="+$('.age').val()+"&"+"classid="+$('.classid').val()+"&"+"tname="+$('.tname').val()+"&"
                        +"oldtname="+oldtname;
                    $.ajax({
                        type:'get',
                        url:'edit/'+string,
                        success:function ( data ) {

                            var a1 = {};
                            for(var i = 1; i<=5 ; i++)
                                a1[i-1] = data[i];

                            $('#stutable').find('tr').each(function(j){
                                //填充数据
                                if($(this).attr('class') == data[0]){
                                    $(this).find('td').each(function(i){
                                        if( i< 5){
                                            $(this).text(a1[i]);
//                                            alert($(this).text());
                                        }
                                    });
                                }
                            });
                            $('#editdiv').hide();
                        }
                    });
                });

            }
            td.appendChild(button);
            tr.appendChild(td);
            var td = document.createElement("td");
            var button = document.createElement("button");
            button.name = 'delete';
            button.className = j;
            button.innerHTML = '删除';
            button.onclick = function () {
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
            td.appendChild(button);
            tr.appendChild(td);
            innerHtml.appendChild(tr);
        }
    }
    init(temp,tname);

    $(".button2").click(function(){
        $("#editdiv").hide();
    });
    $(".button5").click(function(){
        $("#editdiv1").hide();
    });
    var option1 = function (data) {
        var tNode = '<option value='+data+'>'+data+'</option';
        return tNode;
    }
    //添加学生
    $('.button3').click(function(){
       $('#editdiv').hide();
      $('#editdiv1').show();
        //需要得到所有老师的信息；
        $.ajax({
            type:'get',
            url:'/showname',
            success:function (data) {
                for(var i = 0; i<data.length ;i++){
                    $('#ts').append(option1(data[i].tname));
                }
            }
        });


       $('.button4').click(function(){
           var tname1 = $('#ts option:selected');
           var string ='?';
           string = string+"name="+$('.nameadd').val()+"&"+"sex="+$('.sexadd').val()+"&"+"age="+$('.ageadd').val()+"&"+
               "classid="+$('.classidadd').val()+"&"+"tname="+tname1.val();

           $.ajax({
               type:'get',
               url:'create/'+string,
               success:function ( data ) {

                   var temp = new Object();
                  // temp.Id = data[0];
                   temp.name = data[0];
                   temp.sex = data[1];
                   temp.age = data[2];
                   temp.classid = data[3];
                   var t = new Object();
                   t.tname = data[4];
                   init(new Array(temp),new Array(new Array(t)));
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

<!DOCTYPE h/tml>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

            <center>
            <form action="/menu_do" method="post">
                @csrf
            菜单等级<select name="type" id="ch">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select><br>

                <div id="first_name">
                    一级菜单名称：<input type="text" name="first_name">
                </div><br>

                <div id="name" style="display:none">
                    一级菜单名称:<select name="name" id="">
                        <option value="">1</option>
                    </select><br>

                    二级菜单名称: <input type="text" name="second_name">
                </div>

                <div id="event">
                     菜单事件类型: <select name="event" id="">
                        <option value="click">click</option>
                        <option value="view">view</option>
                    </select><br>

                    菜单事件值<input type="text" name="event_key">
                </div>
                <input type="submit" >
            </form>
            </center>

</body>
</html>
<script src="/jquery.js"></script>

<script>
        $(function(){
            $(document).on('change','#ch',function(){
                    var type_val= this.value;
                    //console.log(type_val);
                    if(type_val==2){

                    }
            });
    });
</script>

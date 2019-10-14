<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <form action="/tag_user_add" method="post">
        @csrf
        <input type="hidden" name="tag_id" value="{{$tag_id}}">          
        <table border="2">
            <tr>
               <td></td>
               <td>Openid</td>
                <td>操作</td>
            </tr>
          
            @foreach ($list as $v)
            <tr>
                <td><input type="checkbox" name="openid_list[]" value="{{$v}}"></td>
               <td>{{$v}}</td>
               <td><a href="/tag_sou?openid={{$v}}">查看用户标签</a></td>
            </tr>
            @endforeach        
        </table>
            <input type="submit" value="提交信息">
        </form>
</body>
</html>
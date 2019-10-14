<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
          
            <table border="border"   >
            <a href="/user_add_tag" >添加</a>
          
                    <tr>
                        <td>ID</td>
                        <td>标签</td>
                        
                        <td>操作</td>
                        <td>用户操作</td>
                    </tr>

                    @foreach ($data as $v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['name']}}</td>
                        <td><a href="/tag_del?tag_id={{$v['id']}}">删除</a>||<a href="/tag_edit?tag_id={{$v['id']}}&tag_name={{$v['name']}}">修改</a></td>
                        <td><a href="/tag_user?tag_id={{$v['id']}}">给用户打标签</a></td>
                    </tr>
                    @endforeach
            </table>
</body>
</html>
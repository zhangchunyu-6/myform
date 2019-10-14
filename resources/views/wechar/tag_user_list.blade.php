<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
            <table border="2">
                    <tr>
                        <td>ID</td>
                        <td>标签名</td>
                    </tr>

                    @foreach ($list as $v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['name']}}</td>
                    </tr>
                    @endforeach            
            </table>
</body>
</html>
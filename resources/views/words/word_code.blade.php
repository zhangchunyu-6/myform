<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <form action="/word_do" method="post">
        @csrf
            <table border="1" align="center" width="300px" height="200px">
            <input type="hidden" name="openid" value="{{$openid}}">
            <tr>
            <td><input type="text" name="content">内容</td>

            </tr>
            <tr>
            <td><button type="submit">点击群发</button></td>
            </tr>    
            </table>
        </form>
</body>
</html>
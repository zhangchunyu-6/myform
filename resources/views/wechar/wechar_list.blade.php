<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>
    <title>微信二维码</title>
</head>
<body>
        <table border="border" align="center" width="500px">
            <tr>
                <td>用户名</td>
                <td>二维码</td>
                <td>推广数量</td>
                <td>操作</td>
            </tr>
            @foreach ($list as $v)
            <tr>
                <td>{{$v->name}}</td>
                <td><img src="{{asset($v->qrcode_url)}}" width="50px"></td>
                <td>{{$v->share_num}}</td>
                <td><a href="/save_code?uid={{$v->id}}">生成二维码</a></td>
            </tr>
            @endforeach
        </table>

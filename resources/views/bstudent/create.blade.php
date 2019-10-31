@extends('layout.layout')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
            <table align="center" style="margin-top:50px;" width="500" border="border">
                @foreach($list as $v)
                <tr >
                    <td><img src="{{$v['headimgurl']}}" alt=""></td>
                </tr>
                @endforeach

                <tr>
                    <td>性别</td>
                </tr>

                @foreach($list as $v)
                <tr>
                    <td>@if ($v['sex']==1)
                            男
                        @else
                            女
                        @endif</td>
                </tr>
                @endforeach

                <tr>
                    <td>昵称</td>
                </tr>
                @foreach($list as $v)
                <tr>
                    <td>{{$v['nickname']}}</td>
                </tr>
                @endforeach
            </table>
</body>
</html>

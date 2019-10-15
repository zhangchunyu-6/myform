<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
  <script src="{{ asset('jquery.js') }}"></script>
</head>
<body>/
            <table width="1000px" border="list-group">
                    <tr>
                        <td>名称</td>
                        <td>头像</td>
                        <td>国家</td>
                        <td>所在地</td>
                        <td>性别</td>
                    </tr>
                    @foreach ($list as $v)
                    <tr>
                        <td>{{$v['nickname']}}</td>
                        <td><img src="{{$v['headimgurl']}}" alt=""></td>
                        <td>{{$v['country']}}</td>
                        <td>{{$v['city']}}</td>
                        <td>@if ($v['sex']==1)
                            男
                            @else
                            女
                            @endif
                            </td>
                    </tr>
                    @endforeach
                        </table>
</body>
</html>
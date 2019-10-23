<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
  <script src="{{ asset('jquery.js') }}"></script>
    <title>Document</title>
</head>
<body>
            <table border="border" width="1500px">
                    <tr>
                        <td><input type="checkbox" class="che" ></td>
                        <td>openid</td>
                        <td>名称</td>
                        <td>性别</td>
                        <td>城市</td>
                        <td>国家</td>
                        <td>头像</td>
                        <td>关注时间</td>
                        <td>操作</td>
                    </tr>
                    @foreach ($list as $v)
                    <tr>
                        <td><input type="checkbox" class="chek"></td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['nickname']}}</td>
                        <td>@if ($v['sex']==1)
                            男
                            @else
                            女
                            @endif</td>
                        <td>{{$v['city']}}</td>
                        <td>{{$v['country']}}</td>
                        <td><img src="{{$v['headimgurl']}} " alt=""></td>
                        <td>{{$v['subscribe_time']}}</td>
                        <td><a href="/word_code?openid={{$v['openid']}}">给用户留言</a></td>
                    </tr>
                                     
                    @endforeach
                   
            </table>
</body>
</html>

<script>
    $(document).on('click','.che',function(){
        //alert(1111);
        var esx= $('.che').prop('checked');
        $('.chek').prop('checked',esx);

    })
</script>
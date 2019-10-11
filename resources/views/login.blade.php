<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
            <button id="myform">发送code!</button>
</body>
</html>
    <script src="/jquery.js"></script>
<script>
        $(function(){
                 $(document).on('click','#myform',function(){
                         location.href="{{url(env('APP_URL').'/wechar_login')}}";
                 })
        })
</script>

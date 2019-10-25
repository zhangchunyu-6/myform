@extends('layout.layout')
<!doctype html>

<html lang="en">
<body>
<center style="margin-top:200px;">
    <button type="button" class="btn btn-success">点击授权登陆</button>
</center>
</body>
</html>
<script src="/jquery.js"></script>
<script>
    $('button').click(function () {
        window.location.href='/wechar_login'
    })
</script>

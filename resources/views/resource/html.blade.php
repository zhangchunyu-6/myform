<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
            <form action="/wechar/uplod_do" method="post" enctype="multipart/form-data">
                @csrf
                <select name="leixing" id=""><br>
                    <option value="image">图片</option>
                    <option value="voice">音频</option>
                    <option value="thumb">缩略图</option>
                    <option value="video">视频</option>                    
                </select><br>
                <input type="file" name="resource">
                <button type="submit">提交</button>
            </form>
</body>
</html>
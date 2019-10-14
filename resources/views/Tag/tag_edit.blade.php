<form action="/tag_update" method="post">
            @csrf
            <input type="hidden" name="tag_id" value="{{$tag_id}}">
            <input type="text" name="tag_name" value="{{$tag_name}}">
            <input type="submit" value="修改">
</form>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                @foreach($users as $key => $value)
                <form method="post" action="{{route('chat')}}">
                  {{ csrf_field() }}
                  <input type="text" name="nick" placeholder="nick" value="{{$value}}"><br>
                  <input type="text" name="pass" value="{{$key}}"><br>
                  <input type="submit" value="Join">
                </form>
                @endforeach
            </div>
        </div>
    </body>

</html>

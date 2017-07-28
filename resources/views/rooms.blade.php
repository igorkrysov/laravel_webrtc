<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Styles -->
        <script src="{{ URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
              <div class="row">
                <div class="col-xs-7 col-md-4 col-xs-offset-8 col-md-offset-4">
                  <form class="" id="create" action="{{route('rooms.store')}}" method="post">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">+</span>
                      {{ csrf_field() }}
                      <input type="text" class="form-control" placeholder="room" aria-describedby="basic-addon1" name='room'>
                      <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Add">
                      </span>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-7 col-md-4 col-xs-offset-8 col-md-offset-4">
                  <table class="table table-striped">
                    <tr>
                      <th>Name</th>
                      <th>Remove</th>
                      <th>Settings</th>
                    </tr>
                    @foreach($rooms as $room)
                    <tr>
                      <td>{{ $room->name }}</td>
                      <td>
                        <form action="{{route('rooms.destroy',['id' => $room->id])}}" method="post">
                          {{ csrf_field() }}
                          <input type='hidden' name="_method" value='DELETE'>
                          <input type='submit' class="btn btn-danger" value='delete'>
                        </form>
                      </td>
                      <td>
                        <a href="{{ route('setting_room',['id' => $room->id]) }}" class="btn btn-success">Settings</a>
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>

            </div>


        </div>
    </body>
    <script>

    </script>
</html>

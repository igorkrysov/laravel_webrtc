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

              </div>
              <div class="row">
                <div class="col-xs-7 col-md-4 col-xs-offset-8 col-md-offset-4">
                  <h1>{{$room->name}}</h1>

                  <form action="{{route('setting_generate')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$room->id}}">
                    <div class="input-group">
                      <label>Количество пользователей в комнате</label>
                      <input type="text" id="count_users" name="count_users" value="{{$room->count_users}}">
                    </div>

                    <div class="input-group">
                    <input type='submit' class="btn btn-success" value='generate'>
                    </div>
                  </form>

                </div>
              </div>
              <div class="row">
                <div class="col-xs-7 col-md-4 col-xs-offset-8 col-md-offset-4">
                  <table class="table table-striped">
                    <tr>
                      <th>nick</th>
                      <th>pass</th>
                    </tr>
                    @foreach($room->setting as $setting)
                    <tr>
                      <td>{{$setting->nick}}</td>
                      <td>
                        {{ $setting->pass }}
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

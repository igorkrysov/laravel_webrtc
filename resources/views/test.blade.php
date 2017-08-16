<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>chat</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Styles -->
        <script src="{{ URL::asset('js/jquery-3.2.1.min.js')}}" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <style type="text/css">
          html { height: 100%; }
          body { height: 100%; margin: 0; background: #333; text-align: center; }
          .video { height: 200px; width: 300px; margin-top: 5%; background: #000; }
          .localVideo { margin-left: 200px; width: 150px; bottom: 1em; border: 1px solid #333; background: #000; }
          #callButton { position: absolute; display: none; left: 50%; font-size: 2em; bottom: 5%; border-radius: 1em; }

          .outer {
            /*width: 300px;*/
    /*border: 1px solid red;*/
    margin: auto;
          }
          .ontop {
    height: 100px;
    background-color: #d00;
    position: absolute;
    top: 100px;
    right: 0;
    left: 0;
}
          .chat
          {
            height: 100%;
          }
          .chat-messages
          {
            width: 192px;
            padding:10px;
            min-height: 500px;
            max-height: 500px;
            overflow-y: auto;; /* прокрутка по вертикали */
            margin-bottom: 10px;
            background-color: #202432;
            text-align: left;
          }
          .title
          {
            color: #27ed35;
            font-weight: bold
          }
          .message
          {
            color: #edf3f4;
          }
        </style>
    </head>


    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
              <div class="row">
                <div class="col-md-9">
                    <br>


                    <div class="row">

                    </div>
                    <div class="row">
                      <div class="col-md-1 col-md-offset-6">
                        <button id="callButton" onclick="createOffer()">✆</button>
                        <video id="localVideo" src="" class="localVideo" autoplay muted></video>
                      </div>
                    </div>
                </div>
                <div class="col-md-2" >
                  <div class="chat" style="width: 200px; padding-top:50px; min-height: 500px;">
                    <div class="chat-messages" style="">
                    </div>

                    <button class="btn btn-default" id="send_message" style="width:190px;">Отправить</button>
                      <br>
                    <textarea id="message" style="width:188px; height:100px;;margin-top:10px; margin-left:-3px;"></textarea>
                  </div>
                </div>
              </div>

            </div>
        </div>
    </body>
    <script>

    $( document ).ready(function() {
              //


    });




    </script>
</html>

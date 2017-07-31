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
                    <h1 style="color:white;">{{$nick}}</h1>
                    <br>


                    <div class="row">
                      @php $counter = 0; @endphp
                      @foreach($users as $user)
                        @if($user == $nick)
                          @continue;
                        @endif

                        @if($counter % 2 == 0)
                        </div>
                        <div class="row">
                        @endif
                        @php $counter++; @endphp
                        @if($counter % 2 != 0)
                          <div class="col-md-1 col-md-offset-2">
                        @else
                          <div class="col-md-1 col-md-offset-4">
                        @endif
                          <video id="remoteVideo-{{$user}}" class='video' autoplay></video>
                          <input type='hidden' id="online-{{$user}}" value="0">
                          <div  class="col-md-24 outer"><h4 id="text-{{$user}}" style="color:white;">{{$user}}</h1></div>
                        </div>
                      @endforeach
                    </div>
                    <div class="row">
                      <div class="col-md-1 col-md-offset-6">
                        <button id="callButton" onclick="createOffer()">✆</button>
                        <video id="localVideo-{{$nick}}"  class="localVideo" autoplay muted></video>
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

              setTimeout(
              function()
              {
                //do something special
                sendMessage({
                  type: 'request',
                  online: 'true',
                  fio: '{{$fio}}',
                }, 'broadcast');
              }, 1000);

              $('#send_message').click(function(){
                if($('#message').val() === ''){
                  return;
                }
                $('.chat-messages').prepend( "<p><span class='title'>{{$fio}}</span><br><span class='message'>" + $('#message').val() + "</span></p><hr>" );
                sendMessage({
                    type: 'message',
                    message: $('#message').val(),
                }, 'broadcast');

                $('#message').val('');
              })
    });

      var PeerConnection = window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
      var IceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;
      var SessionDescription = window.mozRTCSessionDescription || window.RTCSessionDescription;
      navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

      @foreach($users as $user)
        @if($user == $nick)
          @continue;
        @endif
        var pc_{{$user}};
      @endforeach


      // Step 1. getUserMedia
      navigator.getUserMedia(
        @if($microphoneonly == "2")
          { audio: true},
        @else
          { audio: true, video: true },
        @endif

      //    { audio: true },
        //{ video: true },
        gotStream,
        function(error) { console.log(error) }
      );

      function gotStream(stream) {
        document.getElementById("callButton").style.display = 'inline-block';
        document.getElementById("localVideo-{{$nick}}").src = URL.createObjectURL(stream);
        console.log(URL.createObjectURL(stream));

          //eval('pc_' + getUser()) = new PeerConnection(null);

          @foreach($users as $user)
            @if($user == $nick)
              @continue;
            @endif
            pc_{{$user}} = new PeerConnection(null);
            pc_{{$user}}.addStream(stream);
            pc_{{$user}}.onicecandidate = gotIceCandidate_{{$user}};
            pc_{{$user}}.onaddstream = gotRemoteStream_{{$user}};
          @endforeach

      }

      function createOffer() {

          //console.log(getUser());

          @foreach($users as $user)
            @if($user == $nick)
              @continue;
            @endif

            if($('#online-{{$user}}').val() === '1'){
              pc_{{$user}}.createOffer(
                gotLocalDescription_{{$user}},
                function(error) { console.log(error) },
                { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
              );
            }
            else {
            }
          @endforeach

          //  );
        console.log("WE CALLED!")
      }

      @foreach($users as $user)
        @if($user == $nick)
          @continue;
        @endif
        function createAnswer_{{$user}}(message) {
          console.log("createAnswer_{{$user}}");
          console.log('message.type', message.type );
           pc_{{$user}}.setRemoteDescription(new SessionDescription(message));
           pc_{{$user}}.createAnswer(
             gotLocalDescription_{{$user}},
             function(error) { console.log(error) },
             { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
           );
           console.log("WE ANSWERED!");
        }

        function gotLocalDescription_{{$user}}(description){
          pc_{{$user}}.setLocalDescription(description);
          sendMessage(description, "{{$user}}");
        }

        function gotIceCandidate_{{$user}}(event){
          if (event.candidate) {
            sendMessage({
              type: 'candidate',
              label: event.candidate.sdpMLineIndex,
              id: event.candidate.sdpMid,
              candidate: event.candidate.candidate
            }, "{{$user}}");
          }
        }



        function gotRemoteStream_{{$user}}(event){
            document.getElementById("remoteVideo-{{$user}}").src = URL.createObjectURL(event.stream);
        }
      @endforeach





        function getUser() {
          if("{{$nick}}" == "user1")
            return "user2";

          return "user1";
        }



      // WebSocket
      var conn = new WebSocket('wss://webrtc.local:443/wss2/');
      conn.open = function(e){
        console.log("Connection established!");;


      }

      conn.onmessage = function(str){
        //obj = Object.create(message[0]);
        //console.log("we got str: " + str.data);


        message = JSON.parse(str.data);
          if(message.dst === "broadcast"){
            //console.log(message.fio);;
            if(message.type==="message"){
              $('.chat-messages').prepend( "<p><span class='title'>"+$('#text-' + message.src).text() +"</span><br><span class='message'>" + message.message + "</span></p><hr>" );
            }
            if(message.online === 'true'){
              $('#text-'+message.src).text(message.fio);
              $('#online-' + message.src).val(1);

              if(message.type === 'request'){
                sendMessage({
                    type: 'answer',
                    online: 'true',
                    fio: '{{$fio}}',
                }, 'broadcast');
              }
            }

          }

          if(message.dst === "{{$nick}}")
          {
            var src = message.src;
            var variable = 'pc_' + src;

            //console.log("I: {{$nick}} src: ",message.src, " type: ",message.type);
            if (message.type === 'offer') {
                //console.log('message.type', message.type );
                eval(variable).setRemoteDescription(new SessionDescription(message));
                //createAnswer_user1();
                eval("createAnswer_" + src + '(message)');
                //console.log("createAnswer_" + src + '()' );
            }
            else if (message.type === 'answer') {

              eval(variable).setRemoteDescription(new SessionDescription(message));
            }
            else if (message.type === 'candidate') {
                //alert(3);
                var candidate = new IceCandidate({sdpMLineIndex: message.label, candidate: message.candidate});
                eval(variable).addIceCandidate(candidate);
                //alert(4);
            }
          }


      }
      //


      function sendMessage(message, dst){
        var str = JSON.stringify(message);
        str = str.replace("{", '{"src":"{{$nick}}", "dst":"' + dst + '",');
       console.log("We sending: ", str);
          //console.log("we sending: ", str);
          conn.send(str);
      }


    </script>
</html>

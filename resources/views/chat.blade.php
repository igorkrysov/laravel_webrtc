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
        <style type="text/css">
          html { height: 100%; }
          body { height: 100%; margin: 0; background: #333; text-align: center; }
          .video { height: 200px; margin-top: 5%; background: #000; }
          .localVideo { width: 150px; position: absolute; right: 1.1em; bottom: 1em; border: 1px solid #333; background: #000; }
          #callButton { position: absolute; display: none; left: 50%; font-size: 2em; bottom: 5%; border-radius: 1em; }
        </style>
    </head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
              <video id="localVideo-{{$nick}}"  class="localVideo" autoplay muted></video>

              <button id="callButton" onclick="createOffer()">✆</button>
                @foreach($users as $user)
                  <video id="remoteVideo-{{$user}}" class='video' autoplay></video>
                @endforeach
                <button onclick="send();">Send</button>
            </div>
        </div>
    </body>
    <script>

      var PeerConnection = window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
      var IceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;
      var SessionDescription = window.mozRTCSessionDescription || window.RTCSessionDescription;
      navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

      @foreach($users as $user)
        @if($user == $nick)
          @continue;
        @endif
        var pc{{$user}};
      @endforeach


      // Step 1. getUserMedia
      navigator.getUserMedia(
        //  { audio: true, video: true },
        { video: true },
        gotStream,
        function(error) { console.log(error) }
      );

      function gotStream(stream) {
        document.getElementById("callButton").style.display = 'inline-block';
        document.getElementById("localVideo-{{$nick}}").src = URL.createObjectURL(stream);
        console.log(URL.createObjectURL(stream));
        @foreach($users as $user)
          @if($user == $nick)
            @continue;
          @endif
          pc{{$user}} = new PeerConnection(null);
          pc{{$user}}.addStream(stream);
          pc{{$user}}.onicecandidate = gotIceCandidate{{$user}};
          pc{{$user}}.onaddstream = gotRemoteStream{{$user}};
        @endforeach

      }

      function createOffer() {
        @foreach($users as $user)
          @if($user == $nick)
            @continue;
          @endif
          pc{{$user}}.createOffer(
            gotLocalDescription{{$user}},
            function(error) { console.log(error) },
            { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
          );
        @endforeach
        console.log("WE CALLED!")
      }

      // Step 2. createOffer
      @foreach($users as $user)
        @if($user == $nick)
          @continue;
        @endif


        function createAnswer{{$user}}() {
           pc{{$user}}.createAnswer(
             gotLocalDescription{{$user}},
             function(error) { console.log(error) },
             { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
           );
           console.log("WE ANSWERED!");
        }

        function gotLocalDescription{{$user}}(description){
          description.uniq_id="1";
          pc{{$user}}.setLocalDescription(description);
          console.log("description: ", description);
          sendMessage(description);
        }

        function gotIceCandidate{{$user}}(event){
          if (event.candidate) {
            sendMessage({
              type: 'candidate',
              label: event.candidate.sdpMLineIndex,
              id: event.candidate.sdpMid,
              candidate: event.candidate.candidate
            });
          }
        }

        function gotRemoteStream{{$user}}(event){
          console.log("event: ", event);
          console.log("remote_stream1: ", URL.createObjectURL(event.stream));
          console.log('document.getElementById("remoteVideo-serzh").src = "' + URL.createObjectURL(event.stream) + '"');

          document.getElementById("remoteVideo-{{$user}}").src = URL.createObjectURL(event.stream);

        }
      @endforeach




      // function createAnswer() {
      //    pc.createAnswer(
      //      gotLocalDescription,
      //      function(error) { console.log(error) },
      //      { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
      //    );
      //    console.log("WE ANSWERED!");
      // }







      // WebSocket
      var conn = new WebSocket('wss://webrtc.local:443/wss2/');
      conn.open = function(e){
        console.log("Connection established!");;
      }

      conn.onmessage = function(str){
        //obj = Object.create(message[0]);
        //console.log("we got str: " + str.data);
        message = JSON.parse(str.data);
        console.log("we got data: " + message.type);
        @foreach($users as $user)
          @if($user == $nick)
            @continue;
          @endif
          if (message.type === 'offer') {
              pc{{$user}}.setRemoteDescription(new SessionDescription(message));
              createAnswer{{$user}}();
            }
            else if (message.type === 'answer') {
              pc{{$user}}.setRemoteDescription(new SessionDescription(message));
            }
            else if (message.type === 'candidate') {
              var candidate = new IceCandidate({sdpMLineIndex: message.label, candidate: message.candidate});
              pc{{$user}}.addIceCandidate(candidate);
            }

        @endforeach
      }
      //
      // function send(){
      //     var data = 'Data for sending: ' + Math.random();
      //     conn.send(data);
      //     console.log('Sent: ' + data);
      // }

      function sendMessage(message){
        var str = JSON.stringify(message);
      //  console.log("We sending: ", str);
        //  conn.send(str);
          conn.send(str);
      }

    </script>
</html>

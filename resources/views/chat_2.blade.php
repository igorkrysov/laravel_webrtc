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
              <h1 style="color:white;">{{$nick}}</h1>
              <br>
              <video id="localVideo-{{$nick}}"  class="localVideo" autoplay muted></video>

              <button id="callButton" onclick="createOffer()">✆</button>
              <video id="remoteVideo-user1" class='video' autoplay></video>
              <video id="remoteVideo-user2" class='video' autoplay></video>

            </div>
        </div>
    </body>
    <script>

      var PeerConnection = window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
      var IceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;
      var SessionDescription = window.mozRTCSessionDescription || window.RTCSessionDescription;
      navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

      var pc_user1;
      var pc_user2;
      var pc_user3;


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

          //eval('pc_' + getUser()) = new PeerConnection(null);
          pc_user1 = new PeerConnection(null);
          pc_user2 = new PeerConnection(null);

          eval('pc_' + getUser()).addStream(stream);
          eval('pc_' + getUser()).onicecandidate = eval('gotIceCandidate_' + getUser());
          eval('pc_' + getUser()).onaddstream = eval('gotRemoteStream_' + getUser());

          // pc_user1 = new PeerConnection(null);
          // pc_user1.addStream(stream);
          // pc_user1.onicecandidate = gotIceCandidate_user1;
          // pc_user1.onaddstream = gotRemoteStream_user1;
          //
          // pc_user2 = new PeerConnection(null);
          // pc_user2.addStream(stream);
          // pc_user2.onicecandidate = gotIceCandidate_user2;
          // pc_user2.onaddstream = gotRemoteStream_user2;
          //
          // pc_user3 = new PeerConnection(null);
          // pc_user3.addStream(stream);
          // pc_user3.onicecandidate = gotIceCandidate_user3;
          // pc_user3.onaddstream = gotRemoteStream_user3;


      }

      function createOffer() {

          console.log(getUser());


          eval('pc_' + getUser()).createOffer(
            eval('gotLocalDescription_' + getUser()),
            function(error) { console.log(error) },
            { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
          );
          // pc_user1.createOffer(
          //   gotLocalDescription_user1,
          //   function(error) { console.log(error) },
          //   { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
          // );
          //  pc_user2.createOffer(
          //    gotLocalDescription_user2,
          //    function(error) { console.log(error) },
          //    { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
          //  );
        console.log("WE CALLED!")
      }


        function createAnswer_user1() {
          console.log("createAnswer_user1");
           pc_user1.createAnswer(
             gotLocalDescription_user1,
             function(error) { console.log(error) },
             { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
           );
           console.log("WE ANSWERED!");
        }

        function gotLocalDescription_user1(description){
          pc_user1.setLocalDescription(description);
          sendMessage(description, getUser());
        }

        function gotIceCandidate_user1(event){
          if (event.candidate) {
            sendMessage({
              type: 'candidate',
              label: event.candidate.sdpMLineIndex,
              id: event.candidate.sdpMid,
              candidate: event.candidate.candidate
            }, getUser());
          }
        }

        function gotRemoteStream_user1(event){

          document.getElementById("remoteVideo-user1").src = URL.createObjectURL(event.stream);

        }




        function getUser() {
          if("{{$nick}}" == "user1")
            return "user2";

          return "user1";
        }
///////////////////

function createAnswer_user2() {
  console.log("createAnswer_user2");
   pc_user2.createAnswer(
     gotLocalDescription_user2,
     function(error) { console.log(error) },
     { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
   );
   console.log("WE ANSWERED!");
}

function gotLocalDescription_user2(description){
  pc_user2.setLocalDescription(description);
  sendMessage(description, getUser());
}

function gotIceCandidate_user2(event){
  if (event.candidate) {
    sendMessage({
      type: 'candidate',
      label: event.candidate.sdpMLineIndex,
      id: event.candidate.sdpMid,
      candidate: event.candidate.candidate
    }, getUser());
  }
}

function gotRemoteStream_user2(event){

  document.getElementById("remoteVideo-user2").src = URL.createObjectURL(event.stream);

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


          if(message.dst === "{{$nick}}")
          {
            var src = message.src;
            var variable = 'pc_' + src;

            console.log(message);
            if (message.type === 'offer') {
                console.log('message.type', message.type );
                eval(variable).setRemoteDescription(new SessionDescription(message));
                //createAnswer_user1();
                eval("createAnswer_" + src + '()');
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
      // function send(){
      //     var data = 'Data for sending: ' + Math.random();
      //     conn.send(data);
      //     console.log('Sent: ' + data);
      // }

      function sendMessage(message, dst){
        var str = JSON.stringify(message);
        str = str.replace("{", '{"src":"{{$nick}}", "dst":"' + dst + '",');
       console.log("We sending: ", str);
          //console.log("we sending: ", str);
          conn.send(str);
      }

      // function sendMessage(message){
      //   var str = JSON.stringify(message);
      //  console.log("We sending: ", str);
      //     //console.log("we sending: ", str);
      //     conn.send(str);
      // }

    </script>
</html>

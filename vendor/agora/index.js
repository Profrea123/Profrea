// Client Version

function mobileCheck() {
  let check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

// create Agora client
var client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });

var localTracks = {
  videoTrack: null,
  audioTrack: null
};

var localTracksMuteStatus = {
  video: false,
  audio: false,
  call: false
};

var remoteUsers = {};
// Agora client RTCOptions
var RTCOptions = {
  //appid: '8f2a3971274449f281ddc9cb25eabc2a',
  appid: 'b0f2efac08d548239012af03cd1f5730',
  channel: null,
  uid: null,
  token: null
};

var urlChannel = '';

$(() => {
  var urlParams = new URL(location.href).searchParams;
  urlChannel = urlParams.get("channel") ?? '';

urlToken = urlParams.get("token");
errorFreeToken = urlToken.replace(' ', '+');

  console.log('local channel' + urlChannel) ;
console.log('local token' + errorFreeToken) ;

  if (urlChannel && errorFreeToken) {
   $("#channel").val(urlChannel);
    RTCOptions.token = errorFreeToken;
    RTCOptions.channel = urlChannel;
 } else {
      alert('Invalid url');
  }
})

async function joinCall () {
  console.log('Token -- ' + RTCOptions.token);
  console.log('channel -- ' + RTCOptions.channel);
  console.log('uid -- ' + RTCOptions.uid);
  console.log('app id -- ' + RTCOptions.appid);
  try {
    if (urlChannel === '' || errorFreeToken === '') {
        alert('Invalid url');
        return;
    }
    RTCOptions.channel = urlChannel;
    RTCOptions.token = errorFreeToken;
 
    console.log('Before join app id -- ' + RTCOptions.appid);
    await join();
    console.log('JOINED-- ');
   
  } catch (error) {
    console.error(error);
  } finally {
    var intervalId = setInterval(function() {
    var durationInSec = client.getLocalVideoStats().totalDuration;
    if (durationInSec != 0) {
         $("#durationText").text("Duration: " + (secondsToHms(durationInSec)));
    } else {
         $("#durationText").text("Call Status: Inactive");
    }
    }, 1000);
  }
}

function toggleCall() {

  localTracksMuteStatus.call = !localTracksMuteStatus.call;
  console.log(localTracksMuteStatus.call);
  if (localTracksMuteStatus.call) {
    console.log('submit');
    joinCall();
  } else {
      leave();
      localTracksMuteStatus.audio = false;
      localTracksMuteStatus.video = false;
  }

}

function toggleAudio() {
    localTracksMuteStatus.audio = !localTracksMuteStatus.audio;
    localTracks.audioTrack.setMuted(localTracksMuteStatus.audio);
}

function toggleVideo () {
  localTracksMuteStatus.video = !localTracksMuteStatus.video;
  localTracks.videoTrack.setMuted(localTracksMuteStatus.video) ;
}




async function join() {
  try {
    client.on("user-published", handleUserPublished);
    client.on("user-unpublished", handleUserUnpublished);

    client.on("token-privilege-did-expire", async function () {
      alert('Meeting Ended, If you wish to continue, please contact host.')
      leave();
    });


    [RTCOptions.uid, localTracks.audioTrack, localTracks.videoTrack] = await Promise.all([
      client.join(RTCOptions.appid, RTCOptions.channel, RTCOptions.token),
    //  client.join(RTCOptions.token, RTCOptions.channel, null),
      AgoraRTC.createMicrophoneAudioTrack(),
      AgoraRTC.createCameraVideoTrack()
    ]);
    // client.onError(function (e) {
    //   alert('ERRRRRRRR');
    // });

  
    localTracks.videoTrack.play("local-video-frame");
    await client.publish(Object.values(localTracks));
    console.log("publish success");
  } catch (e) {
    if (e.message.includes('expired')) {
      alert('This meeting has ended.');
    } else if (e.message.includes('authorized failed')) {
      alert('You are not authorized to join this meeting. Please contact host');
    } else if (e.message.includes('invalid vendor key')) {
      alert('Invalid Key. Please contact host');
    } else
      alert('Unknown Error: Please contact host. Error Message: ' + e.message);
    }
}

async function leave() {
  for (trackName in localTracks) {
    var track = localTracks[trackName];
    if(track) {
      track.stop();
      track.close();
      localTracks[trackName] = undefined;
    }
  }

  // remove remote users and player views
  remoteUsers = {};

  // leave the channel
  await client.leave();

  $("#local-player-name").text("");
  $("#join").attr("disabled", false);

  console.log("client leaves channel success");
}

async function subscribe(user, mediaType) {
  const uid = user.uid;
  RTCOptions.uid = user.uid;
  // subscribe to a remote user
  await client.subscribe(user, mediaType);
  console.log("subscribe success");
  if (mediaType === 'video') {
    remoteUsers = {};
    user.videoTrack.play("remote-video-frame");
  }
  if (mediaType === 'audio') {
    user.audioTrack.play();
  }
}

function handleUserPublished(user, mediaType) {
  const id = user.uid;
  remoteUsers[id] = user;
  subscribe(user, mediaType);
}

function handleUserUnpublished(user) {
  const id = user.uid;
  delete remoteUsers[id];
  $(`#player-wrapper-${id}`).remove();
}

function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    // var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "0";
    // var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "0";
    // var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";

    var hDisplay = h > 9 ? h : "0" + h;
    var mDisplay = m > 9 ? m : "0" + m;
    var sDisplay = s > 9 ? s : "0" + s;

    return hDisplay + " : " +mDisplay +" : "+ sDisplay;
}
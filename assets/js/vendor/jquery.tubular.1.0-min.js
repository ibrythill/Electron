/* jQuery tubular plugin
|* by Sean McCambridge
|* http://www.seanmccambridge.com/tubular
|* version: 1.0
|* updated: October 1, 2012
|* since 2010
|* licensed under the MIT License
|* Enjoy.
|* 
|* Thanks,
|* Sean */
!function(u,l){
// test for feature support and return if failure
// defaults
var i={ratio:16/9,// usually either 4/3 or 16/9 -- tweak as needed
videoId:"ZCAnLxRvNNc",// toy robot in space is a good default, no?
mute:!0,repeat:!0,width:u(l).width(),wrapperZIndex:99,playButtonClass:"tubular-play",pauseButtonClass:"tubular-pause",muteButtonClass:"tubular-mute",volumeUpClass:"tubular-volume-up",volumeDownClass:"tubular-volume-down",increaseVolumeBy:10,start:0},t=function(e,o){// should be called on the wrapper div
var o=u.extend({},i,o),t=u("body");// cache body node
$node=u(e);// cache wrapper node
// build container
var a='<div id="tubular-container" style="overflow: hidden; position: fixed; z-index: 1; width: 100%; height: 100%"><div id="tubular-player" style="position: absolute"></div></div><div id="tubular-shield" style="width: 100%; height: 100%; z-index: 2; position: absolute; left: 0; top: 0;"></div>';
// set up css prereq's, inject tubular container and set up wrapper defaults
u("html,body").css({width:"100%",height:"100%"}),t.prepend(a),$node.css({position:"relative","z-index":o.wrapperZIndex}),
// set up iframe player, use global scope so YT api can talk
l.player,l.onYouTubeIframeAPIReady=function(){player=new YT.Player("tubular-player",{width:o.width,height:Math.ceil(o.width/o.ratio),videoId:o.videoId,playerVars:{controls:0,showinfo:0,modestbranding:1,wmode:"transparent"},events:{onReady:onPlayerReady,onStateChange:onPlayerStateChange}})},l.onPlayerReady=function(e){n(),o.mute&&e.target.mute(),e.target.seekTo(o.start),e.target.playVideo()},l.onPlayerStateChange=function(e){0===e.data&&o.repeat&&// video ended and repeat option is set true
player.seekTo(o.start)}
// resize handler updates width, height and offset of player after resize/init;
var n=function(){var e=u(l).width(),t,// player width, to be defined
a=u(l).height(),n,// player height, tbd
i=u("#tubular-player");
// when screen aspect ratio differs from video, video must center and underlay one dimension
e/o.ratio<a?(// if new video height < window height (gap underneath)
t=Math.ceil(a*o.ratio),// get new player width
i.width(t).height(a).css({left:(e-t)/2,top:0})):(// new video width < window width (gap to right)
n=Math.ceil(e/o.ratio),// get new player height
i.width(e).height(n).css({left:0,top:(a-n)/2}))}
// events;
u(l).on("resize.tubular",function(){n()}),u("body").on("click","."+o.playButtonClass,function(e){// play button
e.preventDefault(),player.playVideo()}).on("click","."+o.pauseButtonClass,function(e){// pause button
e.preventDefault(),player.pauseVideo()}).on("click","."+o.muteButtonClass,function(e){// mute button
e.preventDefault(),player.isMuted()?player.unMute():player.mute()}).on("click","."+o.volumeDownClass,function(e){// volume down button
e.preventDefault();var t=player.getVolume();t<o.increaseVolumeBy&&(t=o.increaseVolumeBy),player.setVolume(t-o.increaseVolumeBy)}).on("click","."+o.volumeUpClass,function(e){// volume up button
e.preventDefault(),player.isMuted()&&player.unMute();// if mute is on, unmute
var t=player.getVolume();t>100-o.increaseVolumeBy&&(t=100-o.increaseVolumeBy),player.setVolume(t+o.increaseVolumeBy)})}
// load yt iframe js api
,e=document.createElement("script");
// methods
e.src="//www.youtube.com/iframe_api";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(e,a),
// create plugin
u.fn.tubular=function(e){return this.each(function(){u.data(this,"tubular_instantiated")||// let's only run one
u.data(this,"tubular_instantiated",t(this,e))})}}(jQuery,window);
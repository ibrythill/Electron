/*
 * YoutubeBackground - A wrapper for the Youtube API - Great for fullscreen background videos or just regular videos.
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 *
 * Version:  1.0.5
 *
 */
// Chain of Responsibility pattern. Creates base class that can be overridden.
"function"!=typeof Object.create&&(Object.create=function(e){function t(){}return t.prototype=e,new t}),function(d,s,n){var i=function e(t){
// Load Youtube API
var o=n.createElement("script"),a=n.getElementsByTagName("head")[0];"file://"==s.location.origin?o.src="http://www.youtube.com/iframe_api":o.src="//www.youtube.com/iframe_api",a.appendChild(o),o=
// Clean up Tags.
a=null,r(t)},r=function e(t){
// Listen for Gobal YT player callback
"undefined"==typeof YT&&void 0===s.loadingPlayer?(
// Prevents Ready Event from being called twice
s.loadingPlayer=!0,
// Creates deferred so, other players know when to wait.
s.dfd=d.Deferred(),s.onYouTubeIframeAPIReady=function(){s.onYouTubeIframeAPIReady=null,s.dfd.resolve("done"),t()}):"object"==typeof YT?t():s.dfd.done(function(e){t()})};
// YTPlayer Object
YTPlayer={player:null,
// Defaults
defaults:{ratio:16/9,videoId:"LSmgKRx5pBo",mute:!0,repeat:!0,width:d(s).width(),playButtonClass:"YTPlayer-play",pauseButtonClass:"YTPlayer-pause",muteButtonClass:"YTPlayer-mute",volumeUpClass:"YTPlayer-volume-up",volumeDownClass:"YTPlayer-volume-down",start:0,pauseOnScroll:!1,fitToBackground:!0,playerVars:{iv_load_policy:3,modestbranding:1,autoplay:1,controls:0,showinfo:0,wmode:"opaque",branding:0,autohide:0},events:null},
/**
     * @function init
     * Intializes YTPlayer object
     */
init:function e(t,o){var a=this;return a.userOptions=o,a.$body=d("body"),a.$node=d(t),a.$window=d(s),
// Setup event defaults with the reference to this
a.defaults.events={onReady:function(e){a.onPlayerReady(e),
// setup up pause on scroll
a.options.pauseOnScroll&&a.pauseOnScroll(),
// Callback for when finished
"function"==typeof a.options.callback&&a.options.callback.call(this)},onStateChange:function(e){1===e.data?(a.$node.find("img").fadeOut(400),a.$node.addClass("loaded")):0===e.data&&a.options.repeat&&// video ended and repeat option is set true
a.player.seekTo(a.options.start)}},a.options=d.extend(!0,{},a.defaults,a.userOptions),a.options.height=Math.ceil(a.options.width/a.options.ratio),a.ID=(new Date).getTime(),a.holderID="YTPlayer-ID-"+a.ID,a.options.fitToBackground?a.createBackgroundVideo():a.createContainerVideo(),
// Listen for Resize Event
a.$window.on("resize.YTplayer"+a.ID,function(){a.resize(a)}),i(a.onYouTubeIframeAPIReady.bind(a)),a.resize(a),a},
/**
     * @function pauseOnScroll
     * Adds window events to pause video on scroll.
     */
pauseOnScroll:function e(){var t=this;t.$window.on("scroll.YTplayer"+t.ID,function(){var e;1===t.player.getPlayerState()&&t.player.pauseVideo()}),t.$window.scrollStopped(function(){var e;2===t.player.getPlayerState()&&t.player.playVideo()})},
/**
     * @function createContainerVideo
     * Adds HTML for video in a container
     */
createContainerVideo:function e(){var t=this,o=d('<div id="ytplayer-container'+t.ID+'" >                                    <div id="'+t.holderID+'" class="ytplayer-player-inline"></div>                                     </div>                                     <div id="ytplayer-shield" class="ytplayer-shield"></div>');
/*jshint multistr: true */t.$node.append(o),t.$YTPlayerString=o,o=null},
/**
     * @function createBackgroundVideo
     * Adds HTML for video background
     */
createBackgroundVideo:function e(){
/*jshint multistr: true */
var t=this,o=d('<div id="ytplayer-container'+t.ID+'" class="ytplayer-container background">                                    <div id="'+t.holderID+'" class="ytplayer-player"></div>                                    </div>                                    <div id="ytplayer-shield" class="ytplayer-shield"></div>');t.$node.append(o),t.$YTPlayerString=o,o=null},
/**
     * @function resize
     * Resize event to change video size
     */
resize:function e(t){
//var self = this;
var o=d(s);t.options.fitToBackground||(o=t.$node);var a=o.width(),n,// player width, to be defined
i=o.height(),r,// player height, tbd
l=d("#"+t.holderID);
// when screen aspect ratio differs from video, video must center and underlay one dimension
a/t.options.ratio<i?(n=Math.ceil(i*t.options.ratio),// get new player width
l.width(n).height(i).css({left:(a-n)/2,top:0})):(// new video width < window width (gap to right)
r=Math.ceil(a/t.options.ratio),// get new player height
l.width(a).height(r).css({left:0,top:(i-r)/2})),o=l=null},
/**
     * @function onYouTubeIframeAPIReady
     * @ params {object} YTPlayer object for access to options
     * Youtube API calls this function when the player is ready.
     */
onYouTubeIframeAPIReady:function e(){var t=this;t.player=new s.YT.Player(t.holderID,t.options)},
/**
     * @function onPlayerReady
     * @ params {event} window event from youtube player
     */
onPlayerReady:function e(t){this.options.mute&&t.target.mute(),t.target.playVideo()},
/**
     * @function getPlayer
     * returns youtube player
     */
getPlayer:function e(){return this.player},
/**
     * @function destroy
     * destroys all!
     */
destroy:function e(){var t=this;t.$node.removeData("yt-init").removeData("ytPlayer").removeClass("loaded"),t.$YTPlayerString.remove(),d(s).off("resize.YTplayer"+t.ID),d(s).off("scroll.YTplayer"+t.ID),t.$body=null,t.$node=null,t.$YTPlayerString=null,t.player.destroy(),t.player=null}},
// Scroll Stopped event.
d.fn.scrollStopped=function(e){var t=d(this),o=this;t.scroll(function(){t.data("scrollTimeout")&&clearTimeout(t.data("scrollTimeout")),t.data("scrollTimeout",setTimeout(e,250,o))})},
// Create plugin
d.fn.YTPlayer=function(o){return this.each(function(){var e=this;d(e).data("yt-init",!0);var t=Object.create(YTPlayer);t.init(e,o),d.data(e,"ytPlayer",t)})}}(jQuery,window,document);
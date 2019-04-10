/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/
!function(h){var l=h(window),f=l.height();l.resize(function(){f=l.height()}),h.fn.parallax=function(i,r,t){var u=h(this),o,c,n=0;
//get the starting position of each element to have parallax applied to it
u.each(function(){c=u.offset().top}),o=t?function(t){return t.outerHeight(!0)}:function(t){return t.height()},
// setup defaults if arguments aren't specified
(arguments.length<1||null===i)&&(i="50%"),(arguments.length<2||null===r)&&(r=.1),(arguments.length<3||null===t)&&(t=!0);
// function to be called whenever the window is scrolled or resized
var e={update:function(){var a=l.scrollTop();u.each(function(){var t=h(this),n=t.offset().top,e;
// Check if totally above or totally below viewport
n+o(t)<a||a+f<n||u.css("backgroundPosition",i+" "+Math.round((c-a)*r)+"px")})}};return l.bind("scroll",e.update).resize(e.update),e.update(),this.each(function(){var t=Object.create(e);h.data(this,"parallax",t)})}}(jQuery);
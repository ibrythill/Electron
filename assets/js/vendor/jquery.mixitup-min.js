/**!
 * MixItUp v2.1.11
 *
 * @copyright Copyright 2015 KunkaLabs Limited.
 * @author    KunkaLabs Limited.
 * @link      https://mixitup.kunkalabs.com
 *
 * @license   Commercial use requires a commercial license.
 *            https://mixitup.kunkalabs.com/licenses/
 *
 *            Non-commercial use permitted under terms of CC-BY-NC license.
 *            http://creativecommons.org/licenses/by-nc/3.0/
 */
!function(_,g){"use strict";
/**
	 * MixItUp Constructor Function
	 * @constructor
	 * @extends jQuery
	 */_.MixItUp=function(){var t=this;t._execAction("_constructor",0),_.extend(t,{
/* Public Properties
			---------------------------------------------------------------------- */
selectors:{target:".mix",filter:".filter",sort:".sort"},animation:{enable:!0,effects:"fade scale",duration:600,easing:"ease",perspectiveDistance:"3000",perspectiveOrigin:"50% 50%",queue:!0,queueLimit:1,animateChangeLayout:!1,animateResizeContainer:!0,animateResizeTargets:!1,staggerSequence:!1,reverseOut:!1},callbacks:{onMixLoad:!1,onMixStart:!1,onMixBusy:!1,onMixEnd:!1,onMixFail:!1,_user:!1},controls:{enable:!0,live:!1,toggleFilterButtons:!1,toggleLogic:"or",activeClass:"active"},layout:{display:"inline-block",containerClass:"",containerClassFail:"fail"},load:{filter:"all",sort:!1},
/* Private Properties
			---------------------------------------------------------------------- */
_$body:null,_$container:null,_$targets:null,_$parent:null,_$sortButtons:null,_$filterButtons:null,_suckMode:!1,_mixing:!1,_sorting:!1,_clicking:!1,_loading:!0,_changingLayout:!1,_changingClass:!1,_changingDisplay:!1,_origOrder:[],_startOrder:[],_newOrder:[],_activeFilter:null,_toggleArray:[],_toggleString:"",_activeSort:"default:asc",_newSort:null,_startHeight:null,_newHeight:null,_incPadding:!0,_newDisplay:null,_newClass:null,_targetsBound:0,_targetsDone:0,_queue:[],_$show:_(),_$hide:_()}),t._execAction("_constructor",1)},
/**
	 * MixItUp Prototype
	 * @override
	 */
_.MixItUp.prototype={constructor:_.MixItUp,
/* Static Properties
		---------------------------------------------------------------------- */
_instances:{},_handled:{_filter:{},_sort:{}},_bound:{_filter:{},_sort:{}},_actions:{},_filters:{},
/* Static Methods
		---------------------------------------------------------------------- */
/**
		 * Extend
		 * @since 2.1.0
		 * @param {object} new properties/methods
		 * @extends {object} prototype
		 */
extend:function(t){for(var e in t)_.MixItUp.prototype[e]=t[e]},
/**
		 * Add Action
		 * @since 2.1.0
		 * @param {string} hook name
		 * @param {string} namespace
		 * @param {function} function to execute
		 * @param {number} priority
		 * @extends {object} $.MixItUp.prototype._actions
		 */
addAction:function(t,e,a,i){_.MixItUp.prototype._addHook("_actions",t,e,a,i)},
/**
		 * Add Filter
		 * @since 2.1.0
		 * @param {string} hook name
		 * @param {string} namespace
		 * @param {function} function to execute
		 * @param {number} priority
		 * @extends {object} $.MixItUp.prototype._filters
		 */
addFilter:function(t,e,a,i){_.MixItUp.prototype._addHook("_filters",t,e,a,i)},
/**
		 * Add Hook
		 * @since 2.1.0
		 * @param {string} type of hook
		 * @param {string} hook name
		 * @param {function} function to execute
		 * @param {number} priority
		 * @extends {object} $.MixItUp.prototype._filters
		 */
_addHook:function(t,e,a,i,n){var r=_.MixItUp.prototype[t],o={};n=1===n||"post"===n?"post":"pre",o[e]={},o[e][n]={},o[e][n][a]=i,_.extend(!0,r,o)},
/* Private Methods
		---------------------------------------------------------------------- */
/**
		 * Initialise
		 * @since 2.0.0
		 * @param {object} domNode
		 * @param {object} config
		 */
_init:function(t,e){var a=this;if(a._execAction("_init",0,arguments),e&&_.extend(!0,a,e),a._$body=_("body"),a._domNode=t,a._$container=_(t),a._$container.addClass(a.layout.containerClass),a._id=t.id,a._platformDetect(),a._brake=a._getPrefixedCSS("transition","none"),a._refresh(!0),a._$parent=a._$targets.parent().length?a._$targets.parent():a._$container,a.load.sort&&(a._newSort=a._parseSort(a.load.sort),a._newSortString=a.load.sort,a._activeSort=a.load.sort,a._sort(),a._printSort()),a._activeFilter="all"===a.load.filter?a.selectors.target:"none"===a.load.filter?"":a.load.filter,a.controls.enable&&a._bindHandlers(),a.controls.toggleFilterButtons){a._buildToggleArray();for(var i=0;i<a._toggleArray.length;i++)a._updateControls({filter:a._toggleArray[i],sort:a._activeSort},!0)}else a.controls.enable&&a._updateControls({filter:a._activeFilter,sort:a._activeSort});a._filter(),a._init=!0,a._$container.data("mixItUp",a),a._execAction("_init",1,arguments),a._buildState(),a._$targets.css(a._brake),a._goMix(a.animation.enable)},
/**
		 * Platform Detect
		 * @since 2.0.0
		 */
_platformDetect:function(){var t=this,a=["Webkit","Moz","O","ms"],e=["webkit","moz"],i=window.navigator.appVersion.match(/Chrome\/(\d+)\./)||!1,n="undefined"!=typeof InstallTrigger,r,o=function(t){for(var e=0;e<a.length;e++)if(a[e]+"Transition"in t.style)return{prefix:"-"+a[e].toLowerCase()+"-",vendor:a[e]};return"transition"in t.style&&""}(t._domNode);t._execAction("_platformDetect",0),t._chrome=!!i&&parseInt(i[1],10),t._ff=!!n&&parseInt(window.navigator.userAgent.match(/rv:([^)]+)\)/)[1]),t._prefix=o.prefix,t._vendor=o.vendor,t._suckMode=!window.atob||!t._prefix,t._suckMode&&(t.animation.enable=!1),t._ff&&t._ff<=4&&(t.animation.enable=!1);
/* Polyfills
			---------------------------------------------------------------------- */
/**
			 * window.requestAnimationFrame
			 */
for(var s=0;s<e.length&&!window.requestAnimationFrame;s++)window.requestAnimationFrame=window[e[s]+"RequestAnimationFrame"];
/**
			 * Object.getPrototypeOf
			 */"function"!=typeof Object.getPrototypeOf&&("object"==typeof"test".__proto__?Object.getPrototypeOf=function(t){return t.__proto__}:Object.getPrototypeOf=function(t){return t.constructor.prototype})
/**
			 * Element.nextElementSibling
			 */,t._domNode.nextElementSibling===g&&Object.defineProperty(Element.prototype,"nextElementSibling",{get:function(){for(var t=this.nextSibling;t;){if(1===t.nodeType)return t;t=t.nextSibling}return null}}),t._execAction("_platformDetect",1)},
/**
		 * Refresh
		 * @since 2.0.0
		 * @param {boolean} init
		 * @param {boolean} force
		 */
_refresh:function(t,e){var a=this;a._execAction("_refresh",0,arguments),a._$targets=a._$container.find(a.selectors.target);for(var i=0;i<a._$targets.length;i++){var n;if((n=a._$targets[i]).dataset===g||e){n.dataset={};for(var r=0;r<n.attributes.length;r++){var o=n.attributes[r],s=o.name,l=o.value;if(-1<s.indexOf("data-")){var c=a._helpers._camelCase(s.substring(5,s.length));n.dataset[c]=l}}}n.mixParent===g&&(n.mixParent=a._id)}if(a._$targets.length&&t||!a._origOrder.length&&a._$targets.length){a._origOrder=[];for(var i=0;i<a._$targets.length;i++){var n=a._$targets[i];a._origOrder.push(n)}}a._execAction("_refresh",1,arguments)},
/**
		 * Bind Handlers
		 * @since 2.0.0
		 */
_bindHandlers:function(){var t=this,e=_.MixItUp.prototype._bound._filter,a=_.MixItUp.prototype._bound._sort;t._execAction("_bindHandlers",0),t.controls.live?t._$body.on("click.mixItUp."+t._id,t.selectors.sort,function(){t._processClick(_(this),"sort")}).on("click.mixItUp."+t._id,t.selectors.filter,function(){t._processClick(_(this),"filter")}):(t._$sortButtons=_(t.selectors.sort),t._$filterButtons=_(t.selectors.filter),t._$sortButtons.on("click.mixItUp."+t._id,function(){t._processClick(_(this),"sort")}),t._$filterButtons.on("click.mixItUp."+t._id,function(){t._processClick(_(this),"filter")})),e[t.selectors.filter]=e[t.selectors.filter]===g?1:e[t.selectors.filter]+1,a[t.selectors.sort]=a[t.selectors.sort]===g?1:a[t.selectors.sort]+1,t._execAction("_bindHandlers",1)},
/**
		 * Process Click
		 * @since 2.0.0
		 * @param {object} $button
		 * @param {string} type
		 */
_processClick:function(t,e){var n=this,a=function(t,e,a){var i=_.MixItUp.prototype;i._handled["_"+e][n.selectors[e]]=i._handled["_"+e][n.selectors[e]]===g?1:i._handled["_"+e][n.selectors[e]]+1,i._handled["_"+e][n.selectors[e]]===i._bound["_"+e][n.selectors[e]]&&(t[(a?"remove":"add")+"Class"](n.controls.activeClass),delete i._handled["_"+e][n.selectors[e]])};if(n._execAction("_processClick",0,arguments),!n._mixing||n.animation.queue&&n._queue.length<n.animation.queueLimit){if(n._clicking=!0,"sort"===e){var i=t.attr("data-sort");(!t.hasClass(n.controls.activeClass)||-1<i.indexOf("random"))&&(_(n.selectors.sort).removeClass(n.controls.activeClass),a(t,e),n.sort(i))}if("filter"===e){var r=t.attr("data-filter"),o,s="or"===n.controls.toggleLogic?",":"";n.controls.toggleFilterButtons?(n._buildToggleArray(),t.hasClass(n.controls.activeClass)?(a(t,e,!0),o=n._toggleArray.indexOf(r),n._toggleArray.splice(o,1)):(a(t,e),n._toggleArray.push(r)),n._toggleArray=_.grep(n._toggleArray,function(t){return t}),n._toggleString=n._toggleArray.join(s),n.filter(n._toggleString)):t.hasClass(n.controls.activeClass)||(_(n.selectors.filter).removeClass(n.controls.activeClass),a(t,e),n.filter(r))}n._execAction("_processClick",1,arguments)}else"function"==typeof n.callbacks.onMixBusy&&n.callbacks.onMixBusy.call(n._domNode,n._state,n),n._execAction("_processClickBusy",1,arguments)},
/**
		 * Build Toggle Array
		 * @since 2.0.0
		 */
_buildToggleArray:function(){var t=this,e=t._activeFilter.replace(/\s/g,"");if(t._execAction("_buildToggleArray",0,arguments),"or"===t.controls.toggleLogic)t._toggleArray=e.split(",");else{t._toggleArray=e.split("."),!t._toggleArray[0]&&t._toggleArray.shift();for(var a=0,i;i=t._toggleArray[a];a++)t._toggleArray[a]="."+i}t._execAction("_buildToggleArray",1,arguments)},
/**
		 * Update Controls
		 * @since 2.0.0
		 * @param {object} command
		 * @param {boolean} multi
		 */
_updateControls:function(t,a){var i=this,n={filter:t.filter,sort:t.sort},e=function(t,e){try{a&&"filter"===r&&"none"!==n.filter&&""!==n.filter?t.filter(e).addClass(i.controls.activeClass):t.removeClass(i.controls.activeClass).filter(e).addClass(i.controls.activeClass)}catch(t){}},r="filter",o=null;i._execAction("_updateControls",0,arguments),t.filter===g&&(n.filter=i._activeFilter),t.sort===g&&(n.sort=i._activeSort),n.filter===i.selectors.target&&(n.filter="all");for(var s=0;s<2;s++)(o=i.controls.live?_(i.selectors[r]):i["_$"+r+"Buttons"])&&e(o,"[data-"+r+'="'+n[r]+'"]'),r="sort";i._execAction("_updateControls",1,arguments)},
/**
		 * Filter (private)
		 * @since 2.0.0
		 */
_filter:function(){var t=this;t._execAction("_filter",0);for(var e=0;e<t._$targets.length;e++){var a=_(t._$targets[e]);a.is(t._activeFilter)?t._$show=t._$show.add(a):t._$hide=t._$hide.add(a)}t._execAction("_filter",1)},
/**
		 * Sort (private)
		 * @since 2.0.0
		 */
_sort:function(){var a=this,t=function(t){for(var e=t.slice(),a=e.length,i=a;i--;){var n=parseInt(Math.random()*a),r=e[i];e[i]=e[n],e[n]=r}return e};a._execAction("_sort",0),a._startOrder=[];for(var e=0;e<a._$targets.length;e++){var i=a._$targets[e];a._startOrder.push(i)}switch(a._newSort[0].sortBy){case"default":a._newOrder=a._origOrder;break;case"random":a._newOrder=t(a._startOrder);break;case"custom":a._newOrder=a._newSort[0].order;break;default:a._newOrder=a._startOrder.concat().sort(function(t,e){return a._compare(t,e)})}a._execAction("_sort",1)},
/**
		 * Compare Algorithm
		 * @since 2.0.0
		 * @param {string|number} a
		 * @param {string|number} b
		 * @param {number} depth (recursion)
		 * @return {number}
		 */
_compare:function(t,e,a){a=a||0;var i=this,n=i._newSort[a].order,r=function(t){return t.dataset[i._newSort[a].sortBy]||0},o=isNaN(1*r(t))?r(t).toLowerCase():1*r(t),s=isNaN(1*r(e))?r(e).toLowerCase():1*r(e);return o<s?"asc"===n?-1:1:s<o?"asc"===n?1:-1:o===s&&i._newSort.length>a+1?i._compare(t,e,a+1):0},
/**
		 * Print Sort
		 * @since 2.0.0
		 * @param {boolean} reset
		 */
_printSort:function(t){var e=this,a=t?e._startOrder:e._newOrder,i=e._$parent[0].querySelectorAll(e.selectors.target),n=i.length?i[i.length-1].nextElementSibling:null,r=document.createDocumentFragment();e._execAction("_printSort",0,arguments);for(var o=0;o<i.length;o++){var s=i[o],l=s.nextSibling;"absolute"!==s.style.position&&(l&&"#text"===l.nodeName&&e._$parent[0].removeChild(l),e._$parent[0].removeChild(s))}for(var o=0;o<a.length;o++){var c=a[o];if("default"!==e._newSort[0].sortBy||"desc"!==e._newSort[0].order||t)r.appendChild(c),r.appendChild(document.createTextNode(" "));else{var _=r.firstChild;r.insertBefore(c,_),r.insertBefore(document.createTextNode(" "),c)}}n?e._$parent[0].insertBefore(r,n):e._$parent[0].appendChild(r),e._execAction("_printSort",1,arguments)},
/**
		 * Parse Sort
		 * @since 2.0.0
		 * @param {string} sortString
		 * @return {array} newSort
		 */
_parseSort:function(t){for(var e=this,a="string"==typeof t?t.split(" "):[t],i=[],n=0;n<a.length;n++){var r="string"==typeof t?a[n].split(":"):["custom",a[n]],o={sortBy:e._helpers._camelCase(r[0]),order:r[1]||"asc"};if(i.push(o),"default"===o.sortBy||"random"===o.sortBy)break}return e._execFilter("_parseSort",i,arguments)},
/**
		 * Parse Effects
		 * @since 2.0.0
		 * @return {object} effects
		 */
_parseEffects:function(){var s=this,l={opacity:"",transformIn:"",transformOut:"",filter:""},c=function(t,e,a){if(-1<s.animation.effects.indexOf(t)){if(e){var i=s.animation.effects.indexOf(t+"(");if(-1<i){var n=s.animation.effects.substring(i),r,o;return{val:/\(([^)]+)\)/.exec(n)[1]}}}return!0}return!1},_=function(t,e){return e?"-"===t.charAt(0)?t.substr(1,t.length):"-"+t:t},t=function(t,e){for(var a=[["scale",".01"],["translateX","20px"],["translateY","20px"],["translateZ","20px"],["rotateX","90deg"],["rotateY","90deg"],["rotateZ","180deg"]],i=0;i<a.length;i++){var n=a[i][0],r=a[i][1],o=e&&"scale"!==n;l[t]+=c(n)?n+"("+_(c(n,!0).val||r,o)+") ":""}};return l.opacity=c("fade")?c("fade",!0).val||"0":"1",t("transformIn"),s.animation.reverseOut?t("transformOut",!0):l.transformOut=l.transformIn,l.transition={},l.transition=s._getPrefixedCSS("transition","all "+s.animation.duration+"ms "+s.animation.easing+", opacity "+s.animation.duration+"ms linear"),s.animation.stagger=!!c("stagger"),s.animation.staggerDuration=parseInt(c("stagger")&&c("stagger",!0).val?c("stagger",!0).val:100),s._execFilter("_parseEffects",l)},
/**
		 * Build State
		 * @since 2.0.0
		 * @param {boolean} future
		 * @return {object} futureState
		 */
_buildState:function(t){var e=this,a={};if(e._execAction("_buildState",0),a={activeFilter:""===e._activeFilter?"none":e._activeFilter,activeSort:t&&e._newSortString?e._newSortString:e._activeSort,fail:!e._$show.length&&""!==e._activeFilter,$targets:e._$targets,$show:e._$show,$hide:e._$hide,totalTargets:e._$targets.length,totalShow:e._$show.length,totalHide:e._$hide.length,display:t&&e._newDisplay?e._newDisplay:e.layout.display},t)return e._execFilter("_buildState",a);e._state=a,e._execAction("_buildState",1)},
/**
		 * Go Mix
		 * @since 2.0.0
		 * @param {boolean} animate
		 */
_goMix:function(t){var i=this,e=function(){i._chrome&&31===i._chrome&&r(i._$parent[0]),i._setInter(),a()},a=function(){var t=window.pageYOffset,e=window.pageXOffset,a=document.documentElement.scrollHeight;i._getInterMixData(),i._setFinal(),i._getFinalMixData(),window.pageYOffset!==t&&window.scrollTo(e,t),i._prepTargets(),window.requestAnimationFrame?requestAnimationFrame(n):setTimeout(function(){n()},20)},n=function(){i._animateTargets(),0===i._targetsBound&&i._cleanUp()},r=function(t){var e=t.parentElement,a=document.createElement("div"),i=document.createDocumentFragment();e.insertBefore(a,t),i.appendChild(t),e.replaceChild(t,a)},o=i._buildState(!0);i._execAction("_goMix",0,arguments),!i.animation.duration&&(t=!1),i._mixing=!0,i._$container.removeClass(i.layout.containerClassFail),"function"==typeof i.callbacks.onMixStart&&i.callbacks.onMixStart.call(i._domNode,i._state,o,i),i._$container.trigger("mixStart",[i._state,o,i]),i._getOrigMixData(),t&&!i._suckMode?window.requestAnimationFrame?requestAnimationFrame(e):e():i._cleanUp(),i._execAction("_goMix",1,arguments)},
/**
		 * Get Target Data
		 * @since 2.0.0
		 */
_getTargetData:function(t,e){var a=this,i;t.dataset[e+"PosX"]=t.offsetLeft,t.dataset[e+"PosY"]=t.offsetTop,a.animation.animateResizeTargets&&(i=a._suckMode?{marginBottom:"",marginRight:""}:window.getComputedStyle(t),t.dataset[e+"MarginBottom"]=parseInt(i.marginBottom),t.dataset[e+"MarginRight"]=parseInt(i.marginRight),t.dataset[e+"Width"]=t.offsetWidth,t.dataset[e+"Height"]=t.offsetHeight)},
/**
		 * Get Original Mix Data
		 * @since 2.0.0
		 */
_getOrigMixData:function(){var t=this,e=t._suckMode?{boxSizing:""}:window.getComputedStyle(t._$parent[0]),a=e.boxSizing||e[t._vendor+"BoxSizing"];t._incPadding="border-box"===a,t._execAction("_getOrigMixData",0),!t._suckMode&&(t.effects=t._parseEffects()),t._$toHide=t._$hide.filter(":visible"),t._$toShow=t._$show.filter(":hidden"),t._$pre=t._$targets.filter(":visible"),t._startHeight=t._incPadding?t._$parent.outerHeight():t._$parent.height();for(var i=0;i<t._$pre.length;i++){var n=t._$pre[i];t._getTargetData(n,"orig")}t._execAction("_getOrigMixData",1)},
/**
		 * Set Intermediate Positions
		 * @since 2.0.0
		 */
_setInter:function(){var t=this;t._execAction("_setInter",0),t._changingLayout&&t.animation.animateChangeLayout?(t._$toShow.css("display",t._newDisplay),t._changingClass&&t._$container.removeClass(t.layout.containerClass).addClass(t._newClass)):t._$toShow.css("display",t.layout.display),t._execAction("_setInter",1)},
/**
		 * Get Intermediate Mix Data
		 * @since 2.0.0
		 */
_getInterMixData:function(){var t=this;t._execAction("_getInterMixData",0);for(var e=0;e<t._$toShow.length;e++){var a=t._$toShow[e];t._getTargetData(a,"inter")}for(var e=0;e<t._$pre.length;e++){var a=t._$pre[e];t._getTargetData(a,"inter")}t._execAction("_getInterMixData",1)},
/**
		 * Set Final Positions
		 * @since 2.0.0
		 */
_setFinal:function(){var t=this;t._execAction("_setFinal",0),t._sorting&&t._printSort(),t._$toHide.removeStyle("display"),t._changingLayout&&t.animation.animateChangeLayout&&t._$pre.css("display",t._newDisplay),t._execAction("_setFinal",1)},
/**
		 * Get Final Mix Data
		 * @since 2.0.0
		 */
_getFinalMixData:function(){var t=this;t._execAction("_getFinalMixData",0);for(var e=0;e<t._$toShow.length;e++){var a=t._$toShow[e];t._getTargetData(a,"final")}for(var e=0;e<t._$pre.length;e++){var a=t._$pre[e];t._getTargetData(a,"final")}t._newHeight=t._incPadding?t._$parent.outerHeight():t._$parent.height(),t._sorting&&t._printSort(!0),t._$toShow.removeStyle("display"),t._$pre.css("display",t.layout.display),t._changingClass&&t.animation.animateChangeLayout&&t._$container.removeClass(t._newClass).addClass(t.layout.containerClass),t._execAction("_getFinalMixData",1)},
/**
		 * Prepare Targets
		 * @since 2.0.0
		 */
_prepTargets:function(){var t=this,e={_in:t._getPrefixedCSS("transform",t.effects.transformIn),_out:t._getPrefixedCSS("transform",t.effects.transformOut)};t._execAction("_prepTargets",0),t.animation.animateResizeContainer&&t._$parent.css("height",t._startHeight+"px");for(var a=0;a<t._$toShow.length;a++){var i=t._$toShow[a],n=_(i);i.style.opacity=t.effects.opacity,i.style.display=t._changingLayout&&t.animation.animateChangeLayout?t._newDisplay:t.layout.display,n.css(e._in),t.animation.animateResizeTargets&&(i.style.width=i.dataset.finalWidth+"px",i.style.height=i.dataset.finalHeight+"px",i.style.marginRight=-(i.dataset.finalWidth-i.dataset.interWidth)+1*i.dataset.finalMarginRight+"px",i.style.marginBottom=-(i.dataset.finalHeight-i.dataset.interHeight)+1*i.dataset.finalMarginBottom+"px")}for(var a=0;a<t._$pre.length;a++){var i=t._$pre[a],n=_(i),r=i.dataset.origPosX-i.dataset.interPosX,o=i.dataset.origPosY-i.dataset.interPosY,e=t._getPrefixedCSS("transform","translate("+r+"px,"+o+"px)");n.css(e),t.animation.animateResizeTargets&&(i.style.width=i.dataset.origWidth+"px",i.style.height=i.dataset.origHeight+"px",i.dataset.origWidth-i.dataset.finalWidth&&(i.style.marginRight=-(i.dataset.origWidth-i.dataset.interWidth)+1*i.dataset.origMarginRight+"px"),i.dataset.origHeight-i.dataset.finalHeight&&(i.style.marginBottom=-(i.dataset.origHeight-i.dataset.interHeight)+1*i.dataset.origMarginBottom+"px"))}t._execAction("_prepTargets",1)},
/**
		 * Animate Targets
		 * @since 2.0.0
		 */
_animateTargets:function(){var t=this;t._execAction("_animateTargets",0),t._targetsDone=0,t._targetsBound=0,t._$parent.css(t._getPrefixedCSS("perspective",t.animation.perspectiveDistance+"px")).css(t._getPrefixedCSS("perspective-origin",t.animation.perspectiveOrigin)),t.animation.animateResizeContainer&&t._$parent.css(t._getPrefixedCSS("transition","height "+t.animation.duration+"ms ease")).css("height",t._newHeight+"px");for(var e=0;e<t._$toShow.length;e++){var a=t._$toShow[e],i=_(a),n={x:a.dataset.finalPosX-a.dataset.interPosX,y:a.dataset.finalPosY-a.dataset.interPosY},r=t._getDelay(e),o={};a.style.opacity="";for(var s=0;s<2;s++){var l=0===s?l=t._prefix:"";t._ff&&t._ff<=20&&(o[l+"transition-property"]="all",o[l+"transition-timing-function"]=t.animation.easing+"ms",o[l+"transition-duration"]=t.animation.duration+"ms"),o[l+"transition-delay"]=r+"ms",o[l+"transform"]="translate("+n.x+"px,"+n.y+"px)"}(t.effects.transform||t.effects.opacity)&&t._bindTargetDone(i),t._ff&&t._ff<=20?i.css(o):i.css(t.effects.transition).css(o)}for(var e=0;e<t._$pre.length;e++){var a=t._$pre[e],i=_(a),n={x:a.dataset.finalPosX-a.dataset.interPosX,y:a.dataset.finalPosY-a.dataset.interPosY},r=t._getDelay(e);a.dataset.finalPosX===a.dataset.origPosX&&a.dataset.finalPosY===a.dataset.origPosY||t._bindTargetDone(i),i.css(t._getPrefixedCSS("transition","all "+t.animation.duration+"ms "+t.animation.easing+" "+r+"ms")),i.css(t._getPrefixedCSS("transform","translate("+n.x+"px,"+n.y+"px)")),t.animation.animateResizeTargets&&(a.dataset.origWidth-a.dataset.finalWidth&&1*a.dataset.finalWidth&&(a.style.width=a.dataset.finalWidth+"px",a.style.marginRight=-(a.dataset.finalWidth-a.dataset.interWidth)+1*a.dataset.finalMarginRight+"px"),a.dataset.origHeight-a.dataset.finalHeight&&1*a.dataset.finalHeight&&(a.style.height=a.dataset.finalHeight+"px",a.style.marginBottom=-(a.dataset.finalHeight-a.dataset.interHeight)+1*a.dataset.finalMarginBottom+"px"))}t._changingClass&&t._$container.removeClass(t.layout.containerClass).addClass(t._newClass);for(var e=0;e<t._$toHide.length;e++){for(var a=t._$toHide[e],i=_(a),r=t._getDelay(e),c={},s=0;s<2;s++){var l;c[(l=0===s?l=t._prefix:"")+"transition-delay"]=r+"ms",c[l+"transform"]=t.effects.transformOut,c.opacity=t.effects.opacity}i.css(t.effects.transition).css(c),(t.effects.transform||t.effects.opacity)&&t._bindTargetDone(i)}t._execAction("_animateTargets",1)},
/**
		 * Bind Targets TransitionEnd
		 * @since 2.0.0
		 * @param {object} $el
		 */
_bindTargetDone:function(e){var a=this,i=e[0];a._execAction("_bindTargetDone",0,arguments),i.dataset.bound||(i.dataset.bound=!0,a._targetsBound++,e.on("webkitTransitionEnd.mixItUp transitionend.mixItUp",function(t){(-1<t.originalEvent.propertyName.indexOf("transform")||-1<t.originalEvent.propertyName.indexOf("opacity"))&&_(t.originalEvent.target).is(a.selectors.target)&&(e.off(".mixItUp"),i.dataset.bound="",a._targetDone())})),a._execAction("_bindTargetDone",1,arguments)},
/**
		 * Target Done
		 * @since 2.0.0
		 */
_targetDone:function(){var t=this;t._execAction("_targetDone",0),t._targetsDone++,t._targetsDone===t._targetsBound&&t._cleanUp(),t._execAction("_targetDone",1)},
/**
		 * Clean Up
		 * @since 2.0.0
		 */
_cleanUp:function(){var t=this,e=t.animation.animateResizeTargets?"transform opacity width height margin-bottom margin-right":"transform opacity",a=function(){t._$targets.removeStyle("transition",t._prefix)};t._execAction("_cleanUp",0),t._changingLayout?t._$show.css("display",t._newDisplay):t._$show.css("display",t.layout.display),t._$targets.css(t._brake),t._$targets.removeStyle(e,t._prefix).removeAttr("data-inter-pos-x data-inter-pos-y data-final-pos-x data-final-pos-y data-orig-pos-x data-orig-pos-y data-orig-height data-orig-width data-final-height data-final-width data-inter-width data-inter-height data-orig-margin-right data-orig-margin-bottom data-inter-margin-right data-inter-margin-bottom data-final-margin-right data-final-margin-bottom"),t._$hide.removeStyle("display"),t._$parent.removeStyle("height transition perspective-distance perspective perspective-origin-x perspective-origin-y perspective-origin perspectiveOrigin",t._prefix),t._sorting&&(t._printSort(),t._activeSort=t._newSortString,t._sorting=!1),t._changingLayout&&(t._changingDisplay&&(t.layout.display=t._newDisplay,t._changingDisplay=!1),t._changingClass&&(t._$parent.removeClass(t.layout.containerClass).addClass(t._newClass),t.layout.containerClass=t._newClass,t._changingClass=!1),t._changingLayout=!1),t._refresh(),t._buildState(),t._state.fail&&t._$container.addClass(t.layout.containerClassFail),t._$show=_(),t._$hide=_(),window.requestAnimationFrame&&requestAnimationFrame(a),t._mixing=!1,"function"==typeof t.callbacks._user&&t.callbacks._user.call(t._domNode,t._state,t),"function"==typeof t.callbacks.onMixEnd&&t.callbacks.onMixEnd.call(t._domNode,t._state,t),t._$container.trigger("mixEnd",[t._state,t]),t._state.fail&&("function"==typeof t.callbacks.onMixFail&&t.callbacks.onMixFail.call(t._domNode,t._state,t),t._$container.trigger("mixFail",[t._state,t])),t._loading&&("function"==typeof t.callbacks.onMixLoad&&t.callbacks.onMixLoad.call(t._domNode,t._state,t),t._$container.trigger("mixLoad",[t._state,t])),t._queue.length&&(t._execAction("_queue",0),t.multiMix(t._queue[0][0],t._queue[0][1],t._queue[0][2]),t._queue.splice(0,1)),t._execAction("_cleanUp",1),t._loading=!1},
/**
		 * Get Prefixed CSS
		 * @since 2.0.0
		 * @param {string} property
		 * @param {string} value
		 * @param {boolean} prefixValue
		 * @return {object} styles
		 */
_getPrefixedCSS:function(t,e,a){var i=this,n={},r="",o=-1;for(o=0;o<2;o++)n[(r=0===o?i._prefix:"")+t]=a?r+e:e;return i._execFilter("_getPrefixedCSS",n,arguments)},
/**
		 * Get Delay
		 * @since 2.0.0
		 * @param {number} i
		 * @return {number} delay
		 */
_getDelay:function(t){var e=this,a="function"==typeof e.animation.staggerSequence?e.animation.staggerSequence.call(e._domNode,t,e._state):t,i=e.animation.stagger?a*e.animation.staggerDuration:0;return e._execFilter("_getDelay",i,arguments)},
/**
		 * Parse MultiMix Arguments
		 * @since 2.0.0
		 * @param {array} args
		 * @return {object} output
		 */
_parseMultiMixArgs:function(t){for(var e=this,a={command:null,animate:e.animation.enable,callback:null},i=0;i<t.length;i++){var n=t[i];null!==n&&("object"==typeof n||"string"==typeof n?a.command=n:"boolean"==typeof n?a.animate=n:"function"==typeof n&&(a.callback=n))}return e._execFilter("_parseMultiMixArgs",a,arguments)},
/**
		 * Parse Insert Arguments
		 * @since 2.0.0
		 * @param {array} args
		 * @return {object} output
		 */
_parseInsertArgs:function(t){for(var e=this,a={index:0,$object:_(),multiMix:{filter:e._state.activeFilter},callback:null},i=0;i<t.length;i++){var n=t[i];"number"==typeof n?a.index=n:"object"==typeof n&&n instanceof _?a.$object=n:"object"==typeof n&&e._helpers._isElement(n)?a.$object=_(n):"object"==typeof n&&null!==n?a.multiMix=n:"boolean"!=typeof n||n?"function"==typeof n&&(a.callback=n):a.multiMix=!1}return e._execFilter("_parseInsertArgs",a,arguments)},
/**
		 * Execute Action
		 * @since 2.0.0
		 * @param {string} methodName
		 * @param {boolean} isPost
		 * @param {array} args
		 */
_execAction:function(t,e,a){var i=this,n=e?"post":"pre";if(!i._actions.isEmptyObject&&i._actions.hasOwnProperty(t))for(var r in i._actions[t][n])i._actions[t][n][r].call(i,a)},
/**
		 * Execute Filter
		 * @since 2.0.0
		 * @param {string} methodName
		 * @param {mixed} value
		 * @return {mixed} value
		 */
_execFilter:function(t,e,a){var i=this;if(i._filters.isEmptyObject||!i._filters.hasOwnProperty(t))return e;for(var n in i._filters[t])return i._filters[t][n].call(i,a)},
/* Helpers
		---------------------------------------------------------------------- */
_helpers:{
/**
			 * CamelCase
			 * @since 2.0.0
			 * @param {string}
			 * @return {string}
			 */
_camelCase:function(t){return t.replace(/-([a-z])/g,function(t){return t[1].toUpperCase()})},
/**
			 * Is Element
			 * @since 2.1.3
			 * @param {object} element to test
			 * @return {boolean}
			 */
_isElement:function(t){return window.HTMLElement?t instanceof HTMLElement:null!==t&&1===t.nodeType&&"string"===t.nodeName}},
/* Public Methods
		---------------------------------------------------------------------- */
/**
		 * Is Mixing
		 * @since 2.0.0
		 * @return {boolean}
		 */
isMixing:function(){var t=this;return t._execFilter("isMixing",t._mixing)},
/**
		 * Filter (public)
		 * @since 2.0.0
		 * @param {array} arguments
		 */
filter:function(){var t=this,e=t._parseMultiMixArgs(arguments);t._clicking&&(t._toggleString=""),t.multiMix({filter:e.command},e.animate,e.callback)},
/**
		 * Sort (public)
		 * @since 2.0.0
		 * @param {array} arguments
		 */
sort:function(){var t=this,e=t._parseMultiMixArgs(arguments);t.multiMix({sort:e.command},e.animate,e.callback)},
/**
		 * Change Layout (public)
		 * @since 2.0.0
		 * @param {array} arguments
		 */
changeLayout:function(){var t=this,e=t._parseMultiMixArgs(arguments);t.multiMix({changeLayout:e.command},e.animate,e.callback)},
/**
		 * MultiMix
		 * @since 2.0.0
		 * @param {array} arguments
		 */
multiMix:function(){var t=this,e=t._parseMultiMixArgs(arguments);if(t._execAction("multiMix",0,arguments),t._mixing)t.animation.queue&&t._queue.length<t.animation.queueLimit?(t._queue.push(arguments),t.controls.enable&&!t._clicking&&t._updateControls(e.command),t._execAction("multiMixQueue",1,arguments)):("function"==typeof t.callbacks.onMixBusy&&t.callbacks.onMixBusy.call(t._domNode,t._state,t),t._$container.trigger("mixBusy",[t._state,t]),t._execAction("multiMixBusy",1,arguments));else{t.controls.enable&&!t._clicking&&(t.controls.toggleFilterButtons&&t._buildToggleArray(),t._updateControls(e.command,t.controls.toggleFilterButtons)),t._queue.length<2&&(t._clicking=!1),delete t.callbacks._user,e.callback&&(t.callbacks._user=e.callback);var a=e.command.sort,i=e.command.filter,n=e.command.changeLayout;t._refresh(),a&&(t._newSort=t._parseSort(a),t._newSortString=a,t._sorting=!0,t._sort()),i!==g&&(i="all"===i?t.selectors.target:i,t._activeFilter=i),t._filter(),n&&(t._newDisplay="string"==typeof n?n:n.display||t.layout.display,t._newClass=n.containerClass||"",t._newDisplay===t.layout.display&&t._newClass===t.layout.containerClass||(t._changingLayout=!0,t._changingClass=t._newClass!==t.layout.containerClass,t._changingDisplay=t._newDisplay!==t.layout.display)),t._$targets.css(t._brake),t._goMix(e.animate^t.animation.enable?e.animate:t.animation.enable),t._execAction("multiMix",1,arguments)}},
/**
		 * Insert
		 * @since 2.0.0
		 * @param {array} arguments
		 */
insert:function(){var t=this,e=t._parseInsertArgs(arguments),a="function"==typeof e.callback?e.callback:null,i=document.createDocumentFragment(),n=(t._refresh(),t._$targets.length?e.index<t._$targets.length||!t._$targets.length?t._$targets[e.index]:t._$targets[t._$targets.length-1].nextElementSibling:t._$parent[0].children[0]);if(t._execAction("insert",0,arguments),e.$object){for(var r=0;r<e.$object.length;r++){var o=e.$object[r];i.appendChild(o),i.appendChild(document.createTextNode(" "))}t._$parent[0].insertBefore(i,n)}t._execAction("insert",1,arguments),"object"==typeof e.multiMix&&t.multiMix(e.multiMix,a)},
/**
		 * Prepend
		 * @since 2.0.0
		 * @param {array} arguments
		 */
prepend:function(){var t=this,e=t._parseInsertArgs(arguments);t.insert(0,e.$object,e.multiMix,e.callback)},
/**
		 * Append
		 * @since 2.0.0
		 * @param {array} arguments
		 */
append:function(){var t=this,e=t._parseInsertArgs(arguments);t.insert(t._state.totalTargets,e.$object,e.multiMix,e.callback)},
/**
		 * Get Option
		 * @since 2.0.0
		 * @param {string} string
		 * @return {mixed} value
		 */
getOption:function(t){var e=this,a=function(t,e){for(var a=e.split("."),i=a.pop(),n=a.length,r=1,o=a[0]||e;(t=t[o])&&r<n;)o=a[r],r++;if(t!==g)return t[i]!==g?t[i]:t};return t?e._execFilter("getOption",a(e,t),arguments):e},
/**
		 * Set Options
		 * @since 2.0.0
		 * @param {object} config
		 */
setOptions:function(t){var e=this;e._execAction("setOptions",0,arguments),"object"==typeof t&&_.extend(!0,e,t),e._execAction("setOptions",1,arguments)},
/**
		 * Get State
		 * @since 2.0.0
		 * @return {object} state
		 */
getState:function(){var t=this;return t._execFilter("getState",t._state,t)},
/**
		 * Force Refresh
		 * @since 2.1.2
		 */
forceRefresh:function(){var t;this._refresh(!1,!0)},
/**
		 * Destroy
		 * @since 2.0.0
		 * @param {boolean} hideAll
		 */
destroy:function(t){var e=this,a=_.MixItUp.prototype._bound._filter,i=_.MixItUp.prototype._bound._sort;e._execAction("destroy",0,arguments),e._$body.add(_(e.selectors.sort)).add(_(e.selectors.filter)).off(".mixItUp");for(var n=0;n<e._$targets.length;n++){var r=e._$targets[n];t&&(r.style.display=""),delete r.mixParent}e._execAction("destroy",1,arguments),a[e.selectors.filter]&&1<a[e.selectors.filter]?a[e.selectors.filter]--:1===a[e.selectors.filter]&&delete a[e.selectors.filter],i[e.selectors.sort]&&1<i[e.selectors.sort]?i[e.selectors.sort]--:1===i[e.selectors.sort]&&delete i[e.selectors.sort],delete _.MixItUp.prototype._instances[e._id]}},
/* jQuery Methods
	---------------------------------------------------------------------- */
/**
	 * jQuery .mixItUp() method
	 * @since 2.0.0
	 * @extends $.fn
	 */
_.fn.mixItUp=function(){var a=arguments,i=[],t,n=function(t,e){var a=new _.MixItUp,i=function(){return("00000"+(16777216*Math.random()<<0).toString(16)).substr(-6).toUpperCase()};a._execAction("_instantiate",0,arguments),t.id=t.id?t.id:"MixItUp"+i(),a._instances[t.id]||(a._instances[t.id]=a)._init(t,e),a._execAction("_instantiate",1,arguments)};return t=this.each(function(){if(a&&"string"==typeof a[0]){var t=_.MixItUp.prototype._instances[this.id];if("isLoaded"===a[0])i.push(!!t);else{var e=t[a[0]](a[1],a[2],a[3]);e!==g&&i.push(e)}}else n(this,a[0])}),i.length?1<i.length?i:i[0]:t},
/**
	 * jQuery .removeStyle() method
	 * @since 2.0.0
	 * @extends $.fn
	 */
_.fn.removeStyle=function(r,o){return o=o||"",this.each(function(){for(var t=this,e=r.split(" "),a=0;a<e.length;a++)for(var i=0;i<4;i++){switch(i){case 0:var n=e[a];break;case 1:var n=_.MixItUp.prototype._helpers._camelCase(n);break;case 2:var n=o+e[a];break;case 3:var n=_.MixItUp.prototype._helpers._camelCase(o+e[a])}if(t.style[n]!==g&&"unknown"!=typeof t.style[n]&&0<t.style[n].length&&(t.style[n]=""),!o&&1===i)break}t.attributes&&t.attributes.style&&t.attributes.style!==g&&""===t.attributes.style.value&&t.attributes.removeNamedItem("style")})}}(jQuery);
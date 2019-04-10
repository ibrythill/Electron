/*
 *  Project:
 *  Description:
 *  Author:
 *  License:
 */
// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
!function(s,t,n,i){
// The actual plugin constructor
function e(t,n){this.element=s(t),
// jQuery has an extend method which merges the contents of two or
// more objects, storing the result in the first object. The first object
// is generally empty as we don't want to alter the default options for
// future instances of the plugin
this.options=s.extend({},u,n),this._defaults=u,this._name=o,this.init()}
// undefined is used here as the undefined global variable in ECMAScript 3 is
// mutable (ie. it can be changed by someone else). undefined isn't really being
// passed in so we can ensure the value of it is truly undefined. In ES5, undefined
// can no longer be modified.
// window and document are passed through as local variable rather than global
// as this (slightly) quickens the resolution process and can be more efficiently
// minified (especially when both are regularly referenced in your plugin).
// Create the defaults once
var o="ajaxedsearch",u={sourcefile:"rpc.php"};e.prototype={init:function(){
// Place initialization logic here
// You already have access to the DOM element and
// the options via the instance, e.g. this.element
// and this.options
// you can add more functions like the one below and
// call them like so: this.yourOtherFunction(this.element, this.options).
this.element.after('<div id="suggestions"></div>');var i=this.element.next("#suggestions"),e=this.options.sourcefile;this.element.blur(function(){i.fadeOut()}),this.element.bind("focus keyup",function(){var t=3,n;3<=s(this).val().length?s.post(e,{search:""+s(this).val()},function(t){// Do an AJAX call
i.fadeIn(),// Show the suggestions box
i.html(t)}):i.fadeOut()})},scrollRFunction:function(t,n){
// some logic
}},
// A really lightweight plugin wrapper around the constructor,
// preventing against multiple instantiations
s.fn[o]=function(t){return this.each(function(){s.data(this,"plugin_"+o)||s.data(this,"plugin_"+o,new e(this,t))})}}(jQuery,window,document);
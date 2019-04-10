/*
 * Inline Form Validation Engine 2.6.2, jQuery plugin
 *
 * Copyright(c) 2010, Cedric Dugas
 * http://www.position-absolute.com
 *
 * 2.0 Rewrite by Olivier Refalo
 * http://www.crionics.com
 *
 * Form validation engine allowing custom regex rules to be added.
 * Licensed under the MIT License
 */
!function(k){"use strict";var F={
/**
		* Kind of the constructor, called before any action
		* @param {Map} user options
		*/
init:function(e){var a=this;return a.data("jqv")&&null!=a.data("jqv")||(e=F._saveOptions(a,e),
// bind all formError elements to close on click
k(document).on("click",".formError",function(){k(this).fadeOut(150,function(){
// remove prompt once invisible
k(this).parent(".formErrorOuter").remove(),k(this).remove()})})),this},
/**
		* Attachs jQuery.validationEngine to form.submit and field.blur events
		* Takes an optional params: a list of options
		* ie. jQuery("#formID1").validationEngine('attach', {promptPosition : "centerRight"});
		*/
attach:function(e){var a=this,t;return(t=e?F._saveOptions(a,e):a.data("jqv")).validateAttribute=a.find("[data-validation-engine*=validate]").length?"data-validation-engine":"class",t.binded&&(
// delegate fields
a.on(t.validationEventTrigger,"["+t.validateAttribute+"*=validate]:not([type=checkbox]):not([type=radio]):not(.datepicker)",F._onFieldEvent),a.on("click","["+t.validateAttribute+"*=validate][type=checkbox],["+t.validateAttribute+"*=validate][type=radio]",F._onFieldEvent),a.on(t.validationEventTrigger,"["+t.validateAttribute+"*=validate][class*=datepicker]",{delay:300},F._onFieldEvent)),t.autoPositionUpdate&&k(window).bind("resize",{noAnimation:!0,formElem:a},F.updatePromptsPosition),a.on("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",F._submitButtonClick),a.removeData("jqv_submitButton"),
// bind form.submit
a.on("submit",F._onSubmitEvent),this},
/**
		* Unregisters any bindings that may point to jQuery.validaitonEngine
		*/
detach:function(){var e=this,a=e.data("jqv");
// unbind fields
return e.find("["+a.validateAttribute+"*=validate]").not("[type=checkbox]").off(a.validationEventTrigger,F._onFieldEvent),e.find("["+a.validateAttribute+"*=validate][type=checkbox],[class*=validate][type=radio]").off("click",F._onFieldEvent),
// unbind form.submit
e.off("submit",F._onSubmitEvent),e.removeData("jqv"),e.off("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",F._submitButtonClick),e.removeData("jqv_submitButton"),a.autoPositionUpdate&&k(window).off("resize",F.updatePromptsPosition),this},
/**
		* Validates either a form or a list of fields, shows prompts accordingly.
		* Note: There is no ajax form validation with this method, only field ajax validation are evaluated
		*
		* @return true if the form validates, false if it fails
		*/
validate:function(){var e=k(this),a=null;if(e.is("form")||e.hasClass("validationEngineContainer")){if(e.hasClass("validating"))
// form is already validating.
// Should abort old validation and start new one. I don't know how to implement it.
return!1;e.addClass("validating");var t=e.data("jqv"),a=F._validateFields(this);
// If the form doesn't validate, clear the 'validating' class before the user has a chance to submit again
setTimeout(function(){e.removeClass("validating")},100),a&&t.onSuccess?t.onSuccess():!a&&t.onFailure&&t.onFailure()}else if(e.is("form")||e.hasClass("validationEngineContainer"))e.removeClass("validating");else{
// field validation
var r=e.closest("form, .validationEngineContainer"),t=r.data("jqv")?r.data("jqv"):k.validationEngine.defaults,a;(a=F._validateField(e,t))&&t.onFieldSuccess?t.onFieldSuccess():t.onFieldFailure&&0<t.InvalidFields.length&&t.onFieldFailure()}return t.onValidationComplete?!!t.onValidationComplete(r,a):a},
/**
		*  Redraw prompts position, useful when you change the DOM state when validating
		*/
updatePromptsPosition:function(e){if(e&&this==window)var r=e.data.formElem,i=e.data.noAnimation;else var r=k(this.closest("form, .validationEngineContainer"));var o=r.data("jqv");
// No option, take default one
return r.find("["+o.validateAttribute+"*=validate]").not(":disabled").each(function(){var e=k(this);o.prettySelect&&e.is(":hidden")&&(e=r.find("#"+o.usePrefix+e.attr("id")+o.useSuffix));var a=F._getPrompt(e),t=k(a).find(".formErrorContent").html();a&&F._updatePrompt(e,k(a),t,void 0,!1,o,i)}),this},
/**
		* Displays a prompt on a element.
		* Note that the element needs an id!
		*
		* @param {String} promptText html text to display type
		* @param {String} type the type of bubble: 'pass' (green), 'load' (black) anything else (red)
		* @param {String} possible values topLeft, topRight, bottomLeft, centerRight, bottomRight
		*/
showPrompt:function(e,a,t,r){var i,o=this.closest("form, .validationEngineContainer").data("jqv");
// No option, take default one
return o||(o=F._saveOptions(this,o)),t&&(o.promptPosition=t),o.showArrow=1==r,F._showPrompt(this,e,a,!1,o),this},
/**
		* Closes form error prompts, CAN be invidual
		*/
hide:function(){var e,a=k(this).closest("form, .validationEngineContainer").data("jqv"),t=a&&a.fadeDuration?a.fadeDuration:.3,r;return r=k(this).is("form")||k(this).hasClass("validationEngineContainer")?"parentForm"+F._getClassName(k(this).attr("id")):F._getClassName(k(this).attr("id"))+"formError",k("."+r).fadeTo(t,.3,function(){k(this).parent(".formErrorOuter").remove(),k(this).remove()}),this},
/**
		 * Closes all error prompts on the page
		 */
hideAll:function(){var e,a=this.data("jqv"),t=a?a.fadeDuration:300;return k(".formError").fadeTo(t,300,function(){k(this).parent(".formErrorOuter").remove(),k(this).remove()}),this},
/**
		* Typically called when user exists a field using tab or a mouse click, triggers a field
		* validation
		*/
_onFieldEvent:function(e){var a=k(this),t,r=a.closest("form, .validationEngineContainer").data("jqv");r.eventTrigger="field",
// validate the current field
window.setTimeout(function(){F._validateField(a,r),0==r.InvalidFields.length&&r.onFieldSuccess?r.onFieldSuccess():0<r.InvalidFields.length&&r.onFieldFailure&&r.onFieldFailure()},e.data?e.data.delay:0)},
/**
		* Called when the form is submited, shows prompts accordingly
		*
		* @param {jqObject}
		*            form
		* @return false if form submission needs to be cancelled
		*/
_onSubmitEvent:function(){var e=k(this),a=e.data("jqv");
//check if it is trigger from skipped button
if(e.data("jqv_submitButton")){var t=k("#"+e.data("jqv_submitButton"));if(t&&0<t.length&&(t.hasClass("validate-skip")||"true"==t.attr("data-validation-engine-skip")))return!0}a.eventTrigger="submit";
// validate each field 
// (- skip field ajax validation, not necessary IF we will perform an ajax form validation)
var r=F._validateFields(e);return r&&a.ajaxFormValidation?(F._validateFormWithAjax(e,a),!1):a.onValidationComplete?!!a.onValidationComplete(e,r):r},
/**
		* Return true if the ajax field validations passed so far
		* @param {Object} options
		* @return true, is all ajax validation passed so far (remember ajax is async)
		*/
_checkAjaxStatus:function(e){var t=!0;return k.each(e.ajaxValidCache,function(e,a){if(!a)
// break the each
return t=!1}),t},
/**
		* Return true if the ajax field is validated
		* @param {String} fieldid
		* @param {Object} options
		* @return true, if validation passed, false if false or doesn't exist
		*/
_checkAjaxFieldStatus:function(e,a){return 1==a.ajaxValidCache[e]},
/**
		* Validates form fields, shows prompts accordingly
		*
		* @param {jqObject}
		*            form
		* @param {skipAjaxFieldValidation}
		*            boolean - when set to true, ajax field validation is skipped, typically used when the submit button is clicked
		*
		* @return true if form is valid, false if not, undefined if ajax form validation is done
		*/
_validateFields:function(t){var r=t.data("jqv"),i=!1;
// this variable is set to true if an error is found
// Trigger hook, start validation
t.trigger("jqv.form.validating");
// first, evaluate status of non ajax fields
var o=null;if(t.find("["+r.validateAttribute+"*=validate]").not(":disabled").each(function(){var e=k(this),a=[];if(k.inArray(e.attr("name"),a)<0){if((i|=F._validateField(e,r))&&null==o&&(o=e.is(":hidden")&&r.prettySelect?e=t.find("#"+r.usePrefix+F._jqSelector(e.attr("id"))+r.useSuffix):(
//Check if we need to adjust what element to show the prompt on
//and and such scroll to instead
e.data("jqv-prompt-at")instanceof jQuery?e=e.data("jqv-prompt-at"):e.data("jqv-prompt-at")&&(e=k(e.data("jqv-prompt-at"))),e)),r.doNotShowAllErrosOnSubmit)return!1;
//if option set, stop checking validation rules after one error is found
if(a.push(e.attr("name")),1==r.showOneMessage&&i)return!1}}),
// second, check to see if all ajax calls completed ok
// errorFound |= !methods._checkAjaxStatus(options);
// third, check status and scroll the container accordingly
t.trigger("jqv.form.result",[i]),i){if(r.scroll){var e=o.offset().top,a=o.offset().left,s=r.promptPosition;if("string"==typeof s&&-1!=s.indexOf(":")&&(s=s.substring(0,s.indexOf(":"))),"bottomRight"!=s&&"bottomLeft"!=s){var n=F._getPrompt(o);n&&(e=n.offset().top)}
// Offset the amount the page scrolls by an amount in px to accomodate fixed elements at top of page
// get the position of the first error, there should be at least one, no need to check this
//var destination = form.find(".formError:not('.greenPopup'):first").offset().top;
if(r.scrollOffset&&(e-=r.scrollOffset),r.isOverflown){var l=k(r.overflownDIV),d,u,c;if(!l.length)return!1;e+=l.scrollTop()+-parseInt(l.offset().top)-5,k(r.overflownDIV+":not(:animated)").animate({scrollTop:e},1100,function(){r.focusFirstField&&o.focus()})}else k("html, body").animate({scrollTop:e},1100,function(){r.focusFirstField&&o.focus()}),k("html, body").animate({scrollLeft:a},1100)}else r.focusFirstField&&o.focus();return!1}return!0},
/**
		* This method is called to perform an ajax form validation.
		* During this process all the (field, value) pairs are sent to the server which returns a list of invalid fields or true
		*
		* @param {jqObject} form
		* @param {Map} options
		*/
_validateFormWithAjax:function(l,d){var e=l.serialize(),a=d.ajaxFormValidationMethod?d.ajaxFormValidationMethod:"GET",t=d.ajaxFormValidationURL?d.ajaxFormValidationURL:l.attr("action"),u=d.dataType?d.dataType:"json";k.ajax({type:a,url:t,cache:!1,dataType:u,data:e,form:l,methods:F,options:d,beforeSend:function(){return d.onBeforeAjaxFormValidation(l,d)},error:function(e,a){F._ajaxError(e,a)},success:function(e){if("json"==u&&!0!==e){for(
// getting to this case doesn't necessary means that the form is invalid
// the server may return green or closing prompt actions
// this flag helps figuring it out
var a=!1,t=0;t<e.length;t++){var r=e[t],i=r[0],o=k(k("#"+i)[0]);
// make sure we found the element
if(1==o.length){
// promptText or selector
var s=r[2];
// if the field is valid
if(1==r[1])if(""!=s&&s){var n;
// the field is valid, but we are displaying a green prompt
if(d.allrules[s])(n=d.allrules[s].alertTextOk)&&(s=n);d.showPrompts&&F._showPrompt(o,s,"pass",!1,d,!0)}else
// if for some reason, status==true and error="", just close the prompt
F._closePrompt(o);else{var n;if(
// the field is invalid, show the red error prompt
a|=!0,d.allrules[s])(n=d.allrules[s].alertText)&&(s=n);d.showPrompts&&F._showPrompt(o,s,"",!1,d,!0)}}}d.onAjaxFormComplete(!a,l,e,d)}else d.onAjaxFormComplete(!0,l,e,d)}})},
/**
		* Validates field, shows prompts accordingly
		*
		* @param {jqObject}
		*            field
		* @param {Array[String]}
		*            field's validation rules
		* @param {Map}
		*            user options
		* @return false if field is valid (It is inversed for *fields*, it return false on validate and true on errors.)
		*/
_validateField:function(e,a,t){if(e.attr("id")||(e.attr("id","form-validation-field-"+k.validationEngine.fieldIdCounter),++k.validationEngine.fieldIdCounter),!a.validateNonVisibleFields&&(e.is(":hidden")&&!a.prettySelect||e.parent().is(":hidden")))return!1;var r=e.attr(a.validateAttribute),i=/validate\[(.*)\]/.exec(r);if(!i)return!1;var o,s=i[1].split(/\[|,|\]/),n=!1,l=e.attr("name"),d="",u="",c=!1,f=!1;a.isError=!1,a.showArrow=!0,
// If the programmer wants to limit the amount of error messages per field,
0<a.maxErrorsPerField&&(f=!0);
// Fix for adding spaces in the rules
for(var v=k(e.closest("form, .validationEngineContainer")),p=0;p<s.length;p++)s[p]=s[p].replace(" ",""),
// Remove any parsing errors
""===s[p]&&delete s[p];for(var p=0,m=0;p<s.length;p++){
// If we are limiting errors, and have hit the max, break
if(f&&m>=a.maxErrorsPerField){
// If we haven't hit a required yet, check to see if there is one in the validation rules for this
// field and that it's index is greater or equal to our current index
if(!c){var g=k.inArray("required",s);c=-1!=g&&p<=g}break}var h=void 0;switch(s[p]){case"required":c=!0,h=F._getErrorMessage(v,e,s[p],s,p,a,F._required);break;case"custom":h=F._getErrorMessage(v,e,s[p],s,p,a,F._custom);break;case"groupRequired":
// Check is its the first of group, if not, reload validation with first field
// AND continue normal validation on present field
var x="["+a.validateAttribute+"*="+s[p+1]+"]",_=v.find(x).eq(0);_[0]!=e[0]&&(F._validateField(_,a,t),a.showArrow=!0),(h=F._getErrorMessage(v,e,s[p],s,p,a,F._groupRequired))&&(c=!0),a.showArrow=!1;break;case"ajax":(
// AJAX defaults to returning it's loading message
h=F._ajax(e,s,p,a))&&(u="load");break;case"minSize":h=F._getErrorMessage(v,e,s[p],s,p,a,F._minSize);break;case"maxSize":h=F._getErrorMessage(v,e,s[p],s,p,a,F._maxSize);break;case"min":h=F._getErrorMessage(v,e,s[p],s,p,a,F._min);break;case"max":h=F._getErrorMessage(v,e,s[p],s,p,a,F._max);break;case"past":h=F._getErrorMessage(v,e,s[p],s,p,a,F._past);break;case"future":h=F._getErrorMessage(v,e,s[p],s,p,a,F._future);break;case"dateRange":var x="["+a.validateAttribute+"*="+s[p+1]+"]";a.firstOfGroup=v.find(x).eq(0),a.secondOfGroup=v.find(x).eq(1),
//if one entry out of the pair has value then proceed to run through validation
(a.firstOfGroup[0].value||a.secondOfGroup[0].value)&&(h=F._getErrorMessage(v,e,s[p],s,p,a,F._dateRange)),h&&(c=!0),a.showArrow=!1;break;case"dateTimeRange":var x="["+a.validateAttribute+"*="+s[p+1]+"]";a.firstOfGroup=v.find(x).eq(0),a.secondOfGroup=v.find(x).eq(1),
//if one entry out of the pair has value then proceed to run through validation
(a.firstOfGroup[0].value||a.secondOfGroup[0].value)&&(h=F._getErrorMessage(v,e,s[p],s,p,a,F._dateTimeRange)),h&&(c=!0),a.showArrow=!1;break;case"maxCheckbox":e=k(v.find("input[name='"+l+"']")),h=F._getErrorMessage(v,e,s[p],s,p,a,F._maxCheckbox);break;case"minCheckbox":e=k(v.find("input[name='"+l+"']")),h=F._getErrorMessage(v,e,s[p],s,p,a,F._minCheckbox);break;case"equals":h=F._getErrorMessage(v,e,s[p],s,p,a,F._equals);break;case"funcCall":h=F._getErrorMessage(v,e,s[p],s,p,a,F._funcCall);break;case"creditCard":h=F._getErrorMessage(v,e,s[p],s,p,a,F._creditCard);break;case"condRequired":void 0!==(h=F._getErrorMessage(v,e,s[p],s,p,a,F._condRequired))&&(c=!0);break;default:}var C=!1;
// If we were passed back an message object, check what the status was to determine what to do
if("object"==typeof h)switch(h.status){case"_break":C=!0;break;
// If we have an error message, set errorMsg to the error message
case"_error":h=h.message;break;
// If we want to throw an error, but not show a prompt, return early with true
case"_error_no_prompt":return!0;break;
// Anything else we continue on
default:break}
// If it has been specified that validation should end now, break
if(C)break;
// If we have a string, that means that we have an error, so add it to the error message.
"string"==typeof h&&(d+=h+"<br/>",a.isError=!0,m++)}
// If the rules required is not added, an empty field is not validated
!c&&!e.val()&&e.val().length<1&&(a.isError=!1);
// Hack for radio/checkbox group button, the validation go into the
// first radio/checkbox of the group
var b=e.prop("type"),E=e.data("promptPosition")||a.promptPosition;("radio"==b||"checkbox"==b)&&1<v.find("input[name='"+l+"']").size()&&(e=k("inline"===E?v.find("input[name='"+l+"'][type!=hidden]:last"):v.find("input[name='"+l+"'][type!=hidden]:first")),a.showArrow=!1),e.is(":hidden")&&a.prettySelect&&(e=v.find("#"+a.usePrefix+F._jqSelector(e.attr("id"))+a.useSuffix)),a.isError&&a.showPrompts?F._showPrompt(e,d,u,!1,a):F._closePrompt(e),e.trigger("jqv.field.result",[e,a.isError,d]);
/* Record error */
var T=k.inArray(e[0],a.InvalidFields);return-1==T?a.isError&&a.InvalidFields.push(e[0]):a.isError||a.InvalidFields.splice(T,1),F._handleStatusCssClasses(e,a),
/* run callback function for each field */
a.isError&&a.onFieldFailure&&a.onFieldFailure(e),!a.isError&&a.onFieldSuccess&&a.onFieldSuccess(e),a.isError},
/**
		* Handling css classes of fields indicating result of validation 
		*
		* @param {jqObject}
		*            field
		* @param {Array[String]}
		*            field's validation rules            
		* @private
		*/
_handleStatusCssClasses:function(e,a){
/* remove all classes */
a.addSuccessCssClassToField&&e.removeClass(a.addSuccessCssClassToField),a.addFailureCssClassToField&&e.removeClass(a.addFailureCssClassToField)
/* Add classes */,a.addSuccessCssClassToField&&!a.isError&&e.addClass(a.addSuccessCssClassToField),a.addFailureCssClassToField&&a.isError&&e.addClass(a.addFailureCssClassToField)},
/********************
		  * _getErrorMessage
		  *
		  * @param form
		  * @param field
		  * @param rule
		  * @param rules
		  * @param i
		  * @param options
		  * @param originalValidationMethod
		  * @return {*}
		  * @private
		  */
_getErrorMessage:function(e,a,t,r,i,o,s){
// If we are using the custon validation type, build the index for the rule.
// Otherwise if we are doing a function call, make the call and return the object
// that is passed back.
var n=jQuery.inArray(t,r),l;"custom"!==t&&"funcCall"!==t||(t=t+"["+r[n+1]+"]",
// Delete the rule from the rules array so that it doesn't try to call the
// same rule over again
delete r[n]);
// Change the rule to the composite rule, if it was different from the original
var d=t,u,c=(a.attr("data-validation-engine")?a.attr("data-validation-engine"):a.attr("class")).split(" "),f;
// If the original validation method returned an error and we have a custom error message,
// return the custom message instead. Otherwise return the original error message.
if(null!=(f="future"==t||"past"==t||"maxCheckbox"==t||"minCheckbox"==t?s(e,a,r,i,o):s(a,r,i,o))){var v=F._getCustomErrorMessage(k(a),c,d,o);v&&(f=v)}return f},_getCustomErrorMessage:function(e,a,t,r){var i=!1,o=/^custom\[.*\]$/.test(t)?F._validityProp.custom:F._validityProp[t];
// If there is a validityProp for this rule, check to see if the field has an attribute for it
if(null!=o&&null!=(i=e.attr("data-errormessage-"+o)))return i;
// If there is an inline custom error message, return it
if(null!=(i=e.attr("data-errormessage")))return i;var s="#"+e.attr("id");
// If we have custom messages for the element's id, get the message for the rule from the id.
// Otherwise, if we have custom messages for the element's classes, use the first class message we find instead.
if(void 0!==r.custom_error_messages[s]&&void 0!==r.custom_error_messages[s][t])i=r.custom_error_messages[s][t].message;else if(0<a.length)for(var n=0;n<a.length&&0<a.length;n++){var l="."+a[n];if(void 0!==r.custom_error_messages[l]&&void 0!==r.custom_error_messages[l][t]){i=r.custom_error_messages[l][t].message;break}}return i||void 0===r.custom_error_messages[t]||void 0===r.custom_error_messages[t].message||(i=r.custom_error_messages[t].message),i},_validityProp:{required:"value-missing",custom:"custom-error",groupRequired:"value-missing",ajax:"custom-error",minSize:"range-underflow",maxSize:"range-overflow",min:"range-underflow",max:"range-overflow",past:"type-mismatch",future:"type-mismatch",dateRange:"type-mismatch",dateTimeRange:"type-mismatch",maxCheckbox:"range-overflow",minCheckbox:"range-underflow",equals:"pattern-mismatch",funcCall:"custom-error",creditCard:"pattern-mismatch",condRequired:"value-missing"},
/**
		* Required validation
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @param {bool} condRequired flag when method is used for internal purpose in condRequired check
		* @return an error string if validation failed
		*/
_required:function(e,a,t,r,i){switch(e.prop("type")){case"text":case"password":case"textarea":case"file":case"select-one":case"select-multiple":default:var o=k.trim(e.val()),s=k.trim(e.attr("data-validation-placeholder")),n=k.trim(e.attr("placeholder"));if(!o||s&&o==s||n&&o==n)return r.allrules[a[t]].alertText;break;case"radio":case"checkbox":
// new validation style to only check dependent field
if(i){if(!e.attr("checked"))return r.allrules[a[t]].alertTextCheckboxMultiple;break}
// old validation style
var l=e.closest("form, .validationEngineContainer"),d=e.attr("name");if(0==l.find("input[name='"+d+"']:checked").size())return 1==l.find("input[name='"+d+"']:visible").size()?r.allrules[a[t]].alertTextCheckboxe:r.allrules[a[t]].alertTextCheckboxMultiple;break}},
/**
		* Validate that 1 from the group field is required
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_groupRequired:function(e,a,t,r){var i="["+r.validateAttribute+"*="+a[t+1]+"]",o=!1;if(
// Check all fields from the group
e.closest("form, .validationEngineContainer").find(i).each(function(){if(!F._required(k(this),a,t,r))return!(o=!0)}),!o)return r.allrules[a[t]].alertText},
/**
		* Validate rules
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_custom:function(e,a,t,r){var i=a[t+1],o=r.allrules[i],s;if(o)if(o.regex){var n=o.regex,l;if(!n)return void alert("jqv:custom regex not found - "+i);if(!new RegExp(n).test(e.val()))return r.allrules[i].alertText}else{if(!o.func)return void alert("jqv:custom type not allowed "+i);if("function"!=typeof(s=o.func))return void alert("jqv:custom parameter 'function' is no function - "+i);if(!s(e,a,t,r))return r.allrules[i].alertText}else alert("jqv:custom rule not found - "+i)},
/**
		* Validate custom function outside of the engine scope
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_funcCall:function(e,a,t,r){var i=a[t+1],o;if(-1<i.indexOf(".")){for(var s=i.split("."),n=window;s.length;)n=n[s.shift()];o=n}else o=window[i]||r.customFunctions[i];if("function"==typeof o)return o(e,a,t,r)},
/**
		* Field match
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_equals:function(e,a,t,r){var i=a[t+1];if(e.val()!=k("#"+i).val())return r.allrules.equals.alertText},
/**
		* Check the maximum size (in characters)
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_maxSize:function(e,a,t,r){var i=a[t+1],o;if(i<e.val().length){var s=r.allrules.maxSize;return s.alertText+i+s.alertText2}},
/**
		* Check the minimum size (in characters)
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_minSize:function(e,a,t,r){var i=a[t+1],o;if(e.val().length<i){var s=r.allrules.minSize;return s.alertText+i+s.alertText2}},
/**
		* Check number minimum value
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_min:function(e,a,t,r){var i=parseFloat(a[t+1]),o;if(parseFloat(e.val())<i){var s=r.allrules.min;return s.alertText2?s.alertText+i+s.alertText2:s.alertText+i}},
/**
		* Check number maximum value
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_max:function(e,a,t,r){var i=parseFloat(a[t+1]),o;if(i<parseFloat(e.val())){var s=r.allrules.max;return s.alertText2?s.alertText+i+s.alertText2:s.alertText+i;
//orefalo: to review, also do the translations
}},
/**
		* Checks date is in the past
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_past:function(e,a,t,r,i){var o=t[r+1],s=k(e.find("input[name='"+o.replace(/^#+/,"")+"']")),n,l;if("now"==o.toLowerCase())n=new Date;else if(null!=s.val()){if(s.is(":disabled"))return;n=F._parseDate(s.val())}else n=F._parseDate(o);if(n<F._parseDate(a.val())){var d=i.allrules.past;return d.alertText2?d.alertText+F._dateToString(n)+d.alertText2:d.alertText+F._dateToString(n)}},
/**
		* Checks date is in the future
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_future:function(e,a,t,r,i){var o=t[r+1],s=k(e.find("input[name='"+o.replace(/^#+/,"")+"']")),n,l;if("now"==o.toLowerCase())n=new Date;else if(null!=s.val()){if(s.is(":disabled"))return;n=F._parseDate(s.val())}else n=F._parseDate(o);if(F._parseDate(a.val())<n){var d=i.allrules.future;return d.alertText2?d.alertText+F._dateToString(n)+d.alertText2:d.alertText+F._dateToString(n)}},
/**
		* Checks if valid date
		*
		* @param {string} date string
		* @return a bool based on determination of valid date
		*/
_isDate:function(e){var a;return new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/).test(e)},
/**
		* Checks if valid date time
		*
		* @param {string} date string
		* @return a bool based on determination of valid date time
		*/
_isDateTime:function(e){var a;return new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/).test(e)},
//Checks if the start date is before the end date
//returns true if end is later than start
_dateCompare:function(e,a){return new Date(e.toString())<new Date(a.toString())},
/**
		* Checks date range
		*
		* @param {jqObject} first field name
		* @param {jqObject} second field name
		* @return an error string if validation failed
		*/
_dateRange:function(e,a,t,r){
//are not both populated
return!r.firstOfGroup[0].value&&r.secondOfGroup[0].value||r.firstOfGroup[0].value&&!r.secondOfGroup[0].value?r.allrules[a[t]].alertText+r.allrules[a[t]].alertText2:
//are not both dates
F._isDate(r.firstOfGroup[0].value)&&F._isDate(r.secondOfGroup[0].value)&&F._dateCompare(r.firstOfGroup[0].value,r.secondOfGroup[0].value)?
//are both dates but range is off
void 0:r.allrules[a[t]].alertText+r.allrules[a[t]].alertText2},
/**
		* Checks date time range
		*
		* @param {jqObject} first field name
		* @param {jqObject} second field name
		* @return an error string if validation failed
		*/
_dateTimeRange:function(e,a,t,r){
//are not both populated
return!r.firstOfGroup[0].value&&r.secondOfGroup[0].value||r.firstOfGroup[0].value&&!r.secondOfGroup[0].value?r.allrules[a[t]].alertText+r.allrules[a[t]].alertText2:
//are not both dates
F._isDateTime(r.firstOfGroup[0].value)&&F._isDateTime(r.secondOfGroup[0].value)&&F._dateCompare(r.firstOfGroup[0].value,r.secondOfGroup[0].value)?
//are both dates but range is off
void 0:r.allrules[a[t]].alertText+r.allrules[a[t]].alertText2},
/**
		* Max number of checkbox selected
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_maxCheckbox:function(e,a,t,r,i){var o=t[r+1],s=a.attr("name"),n;if(o<e.find("input[name='"+s+"']:checked").size())return i.showArrow=!1,i.allrules.maxCheckbox.alertText2?i.allrules.maxCheckbox.alertText+" "+o+" "+i.allrules.maxCheckbox.alertText2:i.allrules.maxCheckbox.alertText},
/**
		* Min number of checkbox selected
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_minCheckbox:function(e,a,t,r,i){var o=t[r+1],s=a.attr("name"),n;if(e.find("input[name='"+s+"']:checked").size()<o)return i.showArrow=!1,i.allrules.minCheckbox.alertText+" "+o+" "+i.allrules.minCheckbox.alertText2},
/**
		* Checks that it is a valid credit card number according to the
		* Luhn checksum algorithm.
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return an error string if validation failed
		*/
_creditCard:function(e,a,t,r){
//spaces and dashes may be valid characters, but must be stripped to calculate the checksum.
var i=!1,o=e.val().replace(/ +/g,"").replace(/-+/g,""),s=o.length;if(14<=s&&s<=16&&0<parseInt(o)){for(var n=0,t=s-1,l=1,d,u=new String;d=parseInt(o.charAt(t)),u+=l++%2==0?2*d:d,0<=--t;);for(t=0;t<u.length;t++)n+=parseInt(u.charAt(t));i=n%10==0}if(!i)return r.allrules.creditCard.alertText},
/**
		* Ajax field validation
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		*            user options
		* @return nothing! the ajax validator handles the prompts itself
		*/
_ajax:function(s,e,a,n){var t=e[a+1],l=n.allrules[t],r=l.extraData,i=l.extraDataDynamic,o={fieldId:s.attr("id"),fieldValue:s.val()};if("object"==typeof r)k.extend(o,r);else if("string"==typeof r)for(var d=r.split("&"),a=0;a<d.length;a++){var u=d[a].split("=");u[0]&&u[0]&&(o[u[0]]=u[1])}if(i)for(var c=[],f=String(i).split(","),a=0;a<f.length;a++){var v=f[a];if(k(v).length){var p=s.closest("form, .validationEngineContainer").find(v).val(),m=v.replace("#","")+"="+escape(p);o[v.replace("#","")]=p}}
// If a field change event triggered this we want to clear the cache for this ID
// If there is an error or if the the field is already validated, do not re-execute AJAX
if("field"==n.eventTrigger&&delete n.ajaxValidCache[s.attr("id")],!n.isError&&!F._checkAjaxFieldStatus(s.attr("id"),n))return k.ajax({type:n.ajaxFormValidationMethod,url:l.url,cache:!1,dataType:"json",data:o,field:s,rule:l,methods:F,options:n,beforeSend:function(){},error:function(e,a){F._ajaxError(e,a)},success:function(e){
// asynchronously called on success, data is the json answer from the server
var a=e[0],t=k("#"+a).eq(0);
//var errorField = $($("#" + errorFieldId)[0]);
// make sure we found the element
if(1==t.length){var r=e[1],i=e[2];
// read the optional msg from the server
if(r){var o;
// resolves the msg prompt
if(n.ajaxValidCache[a]=!0,i){if(n.allrules[i])(o=n.allrules[i].alertTextOk)&&(i=o)}else i=l.alertTextOk;n.showPrompts&&(
// see if we should display a green prompt
i?F._showPrompt(t,i,"pass",!0,n):F._closePrompt(t)),
// If a submit form triggered this, we want to re-submit the form
"submit"==n.eventTrigger&&s.closest("form").submit()}else{var o;
// resolve the msg prompt
if(
// Houston we got a problem - display an red prompt
n.ajaxValidCache[a]=!1,n.isError=!0,i){if(n.allrules[i])(o=n.allrules[i].alertText)&&(i=o)}else i=l.alertText;n.showPrompts&&F._showPrompt(t,i,"",!0,n)}}t.trigger("jqv.field.result",[t,n.isError,i])}}),l.alertTextLoad},
/**
		* Common method to handle ajax errors
		*
		* @param {Object} data
		* @param {Object} transport
		*/
_ajaxError:function(e,a){0==e.status&&null==a?alert("The page is not served from a server! ajax call failed"):"undefined"!=typeof console&&console.log("Ajax error: "+e.status+" "+a)},
/**
		* date -> string
		*
		* @param {Object} date
		*/
_dateToString:function(e){return e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()},
/**
		* Parses an ISO date
		* @param {String} d
		*/
_parseDate:function(e){var a=e.split("-");return a==e&&(a=e.split("/")),a==e?(a=e.split("."),new Date(a[2],a[1]-1,a[0])):new Date(a[0],a[1]-1,a[2])},
/**
		* Builds or updates a prompt with the given information
		*
		* @param {jqObject} field
		* @param {String} promptText html text to display type
		* @param {String} type the type of bubble: 'pass' (green), 'load' (black) anything else (red)
		* @param {boolean} ajaxed - use to mark fields than being validated with ajax
		* @param {Map} options user options
		*/
_showPrompt:function(e,a,t,r,i,o){
//Check if we need to adjust what element to show the prompt on
e.data("jqv-prompt-at")instanceof jQuery?e=e.data("jqv-prompt-at"):e.data("jqv-prompt-at")&&(e=k(e.data("jqv-prompt-at")));var s=F._getPrompt(e);
// The ajax submit errors are not see has an error in the form,
// When the form errors are returned, the engine see 2 bubbles, but those are ebing closed by the engine at the same time
// Because no error was found befor submitting
o&&(s=!1),
// Check that there is indded text
k.trim(a)&&(s?F._updatePrompt(e,s,a,t,r,i):F._buildPrompt(e,a,t,r,i))},
/**
		* Builds and shades a prompt for the given field.
		*
		* @param {jqObject} field
		* @param {String} promptText html text to display type
		* @param {String} type the type of bubble: 'pass' (green), 'load' (black) anything else (red)
		* @param {boolean} ajaxed - use to mark fields than being validated with ajax
		* @param {Map} options user options
		*/
_buildPrompt:function(e,a,t,r,i){
// create the prompt
var o=k("<div>");switch(o.addClass(F._getClassName(e.attr("id"))+"formError"),
// add a class name to identify the parent form of the prompt
o.addClass("parentForm"+F._getClassName(e.closest("form, .validationEngineContainer").attr("id"))),o.addClass("formError"),t){case"pass":o.addClass("greenPopup");break;case"load":o.addClass("blackPopup");break;default:
/* it has error  */
//alert("unknown popup type:"+type);
}r&&o.addClass("ajaxed");
// create the prompt content
var s=k("<div>").addClass("formErrorContent").html(a).appendTo(o),n=e.data("promptPosition")||i.promptPosition;
// determine position type
// create the css arrow pointing at the field
// note that there is no triangle on max-checkbox and radio
if(i.showArrow){var l=k("<div>").addClass("formErrorArrow"),d;
//prompt positioning adjustment support. Usage: positionType:Xshift,Yshift (for ex.: bottomLeft:+20 or bottomLeft:-20,+10)
if("string"==typeof n)-1!=(d=n.indexOf(":"))&&(n=n.substring(0,d));switch(n){case"bottomLeft":case"bottomRight":o.find(".formErrorContent").before(l),l.addClass("formErrorArrowBottom").html('<div class="line1">\x3c!-- --\x3e</div><div class="line2">\x3c!-- --\x3e</div><div class="line3">\x3c!-- --\x3e</div><div class="line4">\x3c!-- --\x3e</div><div class="line5">\x3c!-- --\x3e</div><div class="line6">\x3c!-- --\x3e</div><div class="line7">\x3c!-- --\x3e</div><div class="line8">\x3c!-- --\x3e</div><div class="line9">\x3c!-- --\x3e</div><div class="line10">\x3c!-- --\x3e</div>');break;case"topLeft":case"topRight":l.html('<div class="line10">\x3c!-- --\x3e</div><div class="line9">\x3c!-- --\x3e</div><div class="line8">\x3c!-- --\x3e</div><div class="line7">\x3c!-- --\x3e</div><div class="line6">\x3c!-- --\x3e</div><div class="line5">\x3c!-- --\x3e</div><div class="line4">\x3c!-- --\x3e</div><div class="line3">\x3c!-- --\x3e</div><div class="line2">\x3c!-- --\x3e</div><div class="line1">\x3c!-- --\x3e</div>'),o.append(l);break}}
// Add custom prompt class
i.addPromptClass&&o.addClass(i.addPromptClass);
// Add custom prompt class defined in element
var u=e.attr("data-required-class");if(void 0!==u)o.addClass(u);else if(i.prettySelect&&k("#"+e.attr("id")).next().is("select")){var c=k("#"+e.attr("id").substr(i.usePrefix.length).substring(i.useSuffix.length)).attr("data-required-class");void 0!==c&&o.addClass(c)}o.css({opacity:0}),"inline"===n?(o.addClass("inline"),void 0!==e.attr("data-prompt-target")&&0<k("#"+e.attr("data-prompt-target")).length?o.appendTo(k("#"+e.attr("data-prompt-target"))):e.after(o)):e.before(o);var d=F._calculatePosition(e,o,i);return o.css({position:"inline"===n?"relative":"absolute",top:d.callerTopPosition,left:d.callerleftPosition,marginTop:d.marginTopSize,opacity:0}).data("callerField",e),i.autoHidePrompt&&setTimeout(function(){o.animate({opacity:0},function(){o.closest(".formErrorOuter").remove(),o.remove()})},i.autoHideDelay),o.animate({opacity:.87})},
/**
		* Updates the prompt text field - the field for which the prompt
		* @param {jqObject} field
		* @param {String} promptText html text to display type
		* @param {String} type the type of bubble: 'pass' (green), 'load' (black) anything else (red)
		* @param {boolean} ajaxed - use to mark fields than being validated with ajax
		* @param {Map} options user options
		*/
_updatePrompt:function(e,a,t,r,i,o,s){if(a){void 0!==r&&("pass"==r?a.addClass("greenPopup"):a.removeClass("greenPopup"),"load"==r?a.addClass("blackPopup"):a.removeClass("blackPopup")),i?a.addClass("ajaxed"):a.removeClass("ajaxed"),a.find(".formErrorContent").html(t);var n=F._calculatePosition(e,a,o),l={top:n.callerTopPosition,left:n.callerleftPosition,marginTop:n.marginTopSize};s?a.css(l):a.animate(l)}},
/**
		* Closes the prompt associated with the given field
		*
		* @param {jqObject}
		*            field
		*/
_closePrompt:function(e){var a=F._getPrompt(e);a&&a.fadeTo("fast",0,function(){a.parent(".formErrorOuter").remove(),a.remove()})},closePrompt:function(e){return F._closePrompt(e)},
/**
		* Returns the error prompt matching the field if any
		*
		* @param {jqObject}
		*            field
		* @return undefined or the error prompt (jqObject)
		*/
_getPrompt:function(e){var a=k(e).closest("form, .validationEngineContainer").attr("id"),t=F._getClassName(e.attr("id"))+"formError",r=k("."+F._escapeExpression(t)+".parentForm"+F._getClassName(a))[0];if(r)return k(r)},
/**
		  * Returns the escapade classname
		  *
		  * @param {selector}
		  *            className
		  */
_escapeExpression:function(e){return e.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g,"\\$1")},
/**
		 * returns true if we are in a RTLed document
		 *
		 * @param {jqObject} field
		 */
isRTL:function(e){var a=k(document),t=k("body"),r=e&&e.hasClass("rtl")||e&&"rtl"===(e.attr("dir")||"").toLowerCase()||a.hasClass("rtl")||"rtl"===(a.attr("dir")||"").toLowerCase()||t.hasClass("rtl")||"rtl"===(t.attr("dir")||"").toLowerCase();return Boolean(r)},
/**
		* Calculates prompt position
		*
		* @param {jqObject}
		*            field
		* @param {jqObject}
		*            the prompt
		* @param {Map}
		*            options
		* @return positions
		*/
_calculatePosition:function(e,a,t){var r,i,o,s=e.width(),n=e.position().left,l=e.position().top,d=e.height(),u;
// is the form contained in an overflown container?
r=i=0,
// compensation for the arrow
o=-a.height();
//prompt positioning adjustment support
//now you can adjust prompt position
//usage: positionType:Xshift,Yshift
//for example:
//   bottomLeft:+20 means bottomLeft position shifted by 20 pixels right horizontally
//   topRight:20, -15 means topRight position shifted by 20 pixels to right and 15 pixels to top
//You can use +pixels, - pixels. If no sign is provided than + is default.
var c=e.data("promptPosition")||t.promptPosition,f="",v="",p=0,m=0;switch("string"==typeof c&&-1!=c.indexOf(":")&&(f=c.substring(c.indexOf(":")+1),c=c.substring(0,c.indexOf(":")),
//if any advanced positioning will be needed (percents or something else) - parser should be added here
//for now we use simple parseInt()
//do we have second parameter?
-1!=f.indexOf(",")&&(v=f.substring(f.indexOf(",")+1),f=f.substring(0,f.indexOf(",")),m=parseInt(v),isNaN(m)&&(m=0)),p=parseInt(f),isNaN(f)&&(f=0)),c){default:case"topRight":i+=n+s-30,r+=l;break;case"topLeft":r+=l,i+=n;break;case"centerRight":r=l+4,o=0,i=n+e.outerWidth(!0)+5;break;case"centerLeft":i=n-(a.width()+2),r=l+4,o=0;break;case"bottomLeft":r=l+e.height()+5,o=0,i=n;break;case"bottomRight":i=n+s-30,r=l+e.height()+5,o=0;break;case"inline":o=r=i=0}return{callerTopPosition:(r+=m)+"px",callerleftPosition:(
//apply adjusments if any
i+=p)+"px",marginTopSize:o+"px"}},
/**
		* Saves the user options and variables in the form.data
		*
		* @param {jqObject}
		*            form - the form where the user option should be saved
		* @param {Map}
		*            options - the user options
		* @return the user options (extended from the defaults)
		*/
_saveOptions:function(e,a){
// is there a language localisation ?
if(k.validationEngineLanguage)var t=k.validationEngineLanguage.allRules;else k.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page");
// --- Internals DO NOT TOUCH or OVERLOAD ---
// validation rules and i18
k.validationEngine.defaults.allrules=t;var r=k.extend(!0,{},k.validationEngine.defaults,a);return e.data("jqv",r),r},
/**
		 * Removes forbidden characters from class name
		 * @param {String} className
		 */
_getClassName:function(e){if(e)return e.replace(/:/g,"_").replace(/\./g,"_")},
/**
		 * Escape special character for jQuery selector
		 * http://totaldev.com/content/escaping-characters-get-valid-jquery-id
		 * @param {String} selector
		 */
_jqSelector:function(e){return e.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g,"\\$1")},
/**
		* Conditionally required field
		*
		* @param {jqObject} field
		* @param {Array[String]} rules
		* @param {int} i rules index
		* @param {Map}
		* user options
		* @return an error string if validation failed
		*/
_condRequired:function(e,a,t,r){var i,o;for(i=t+1;i<a.length;i++)
/* Use _required for determining wether dependingField has a value.
				 * There is logic there for handling all field types, and default value; so we won't replicate that here
				 * Indicate this special use by setting the last parameter to true so we only validate the dependingField on chackboxes and radio buttons (#462)
				 */
if((o=jQuery("#"+a[i]).first()).length&&null==F._required(o,["required"],0,r,!0))
/* We now know any of the depending fields has a value,
					 * so we can validate this field as per normal required code
					 */
return F._required(e,["required"],0,r)},_submitButtonClick:function(e){var a=k(this),t;a.closest("form, .validationEngineContainer").data("jqv_submitButton",a.attr("id"))}};
/**
	 * Plugin entry point.
	 * You may pass an action as a parameter or a list of options.
	 * if none, the init and attach methods are being called.
	 * Remember: if you pass options, the attached method is NOT called automatically
	 *
	 * @param {String}
	 *            method (optional) action
	 */k.fn.validationEngine=function(e){var a=k(this);return a[0]?// stop here if the form does not exist
"string"==typeof e&&"_"!=e.charAt(0)&&F[e]?(
// make sure init is called once
"showPrompt"!=e&&"hide"!=e&&"hideAll"!=e&&F.init.apply(a),F[e].apply(a,Array.prototype.slice.call(arguments,1))):"object"!=typeof e&&e?void k.error("Method "+e+" does not exist in jQuery.validationEngine"):(
// default constructor with or without arguments
F.init.apply(a,arguments),F.attach.apply(a)):a},
// LEAK GLOBAL OPTIONS
k.validationEngine={fieldIdCounter:0,defaults:{
// Name of the event triggering field validation
validationEventTrigger:"blur",
// Automatically scroll viewport to the first error
scroll:!0,
// Focus on the first input
focusFirstField:!0,
// Show prompts, set to false to disable prompts
showPrompts:!0,
// Should we attempt to validate non-visible input fields contained in the form? (Useful in cases of tabbed containers, e.g. jQuery-UI tabs)
validateNonVisibleFields:!1,
// Opening box position, possible locations are: topLeft,
// topRight, bottomLeft, centerRight, bottomRight, inline
// inline gets inserted after the validated field or into an element specified in data-prompt-target
promptPosition:"topRight",bindMethod:"bind",
// internal, automatically set to true when it parse a _ajax rule
inlineAjax:!1,
// if set to true, the form data is sent asynchronously via ajax to the form.action url (get)
ajaxFormValidation:!1,
// The url to send the submit ajax validation (default to action)
ajaxFormValidationURL:!1,
// HTTP method used for ajax validation
ajaxFormValidationMethod:"get",
// Ajax form validation callback method: boolean onComplete(form, status, errors, options)
// retuns false if the form.submit event needs to be canceled.
onAjaxFormComplete:k.noop,
// called right before the ajax call, may return false to cancel
onBeforeAjaxFormValidation:k.noop,
// Stops form from submitting and execute function assiciated with it
onValidationComplete:!1,
// Used when you have a form fields too close and the errors messages are on top of other disturbing viewing messages
doNotShowAllErrosOnSubmit:!1,
// Object where you store custom messages to override the default error messages
custom_error_messages:{},
// true if you want to vind the input fields
binded:!0,
// set to true, when the prompt arrow needs to be displayed
showArrow:!0,
// did one of the validation fail ? kept global to stop further ajax validations
isError:!1,
// Limit how many displayed errors a field can have
maxErrorsPerField:!1,
// Caches field validation status, typically only bad status are created.
// the array is used during ajax form validation to detect issues early and prevent an expensive submit
ajaxValidCache:{},
// Auto update prompt position after window resize
autoPositionUpdate:!1,InvalidFields:[],onFieldSuccess:!1,onFieldFailure:!1,onSuccess:!1,onFailure:!1,validateAttribute:"class",addSuccessCssClassToField:"",addFailureCssClassToField:"",
// Auto-hide prompt
autoHidePrompt:!1,
// Delay before auto-hide
autoHideDelay:1e4,
// Fade out duration while hiding the validations
fadeDuration:.3,
// Use Prettify select library
prettySelect:!1,
// Add css class on prompt
addPromptClass:"",
// Custom ID uses prefix
usePrefix:"",
// Custom ID uses suffix
useSuffix:"",
// Only show one message per error prompt
showOneMessage:!1}},k(function(){k.validationEngine.defaults.promptPosition=F.isRTL()?"topLeft":"topRight"})}(jQuery);
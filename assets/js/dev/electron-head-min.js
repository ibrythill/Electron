!function(n){
/**
 * Prevent automatic scrolling of page to anchor by browser after loading of page.
 * Do not call this function in $(document).ready(...) or $(window).load(...),
 * it should be called earlier, as soon as possible.
 */
function o(){var o=function(){n(window).scrollTop(0)};window.location.hash&&
// handler is executed at most once
n(window).one("scroll",o),
// make sure to release scroll 1 second after document readiness
// to avoid negative UX
n(document).ready(function(){setTimeout(function(){n(window).off("scroll",o)},1e3)})}o()}(jQuery);
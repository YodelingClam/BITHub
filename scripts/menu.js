function centerAlignFull() {
    var menuCss = document.getElementById("menuCss");
    var LIs = menuCss.childNodes;
    var firstLI;
    var netWidth = 0;
    for (var i = 0, len = LIs.length; i < len; i++) {
        if (LIs[i].nodeName == "LI") {
            if (!firstLI) firstLI = LIs[i];
            netWidth += LIs[i].offsetWidth;
        }
    }
    if (firstLI) firstLI.style.marginLeft = (menuCss.offsetWidth - netWidth)/2 - 1 + "px";
}

var addToPageLoadEvent = function (el, eventName, eventHandler) {
    if (el.addEventListener)
        el.addEventListener(eventName, eventHandler, false);
    else if (el.attachEvent) //IE
        el.attachEvent('on' + eventName, eventHandler);
};

addToPageLoadEvent(window, "load", centerAlignFull);
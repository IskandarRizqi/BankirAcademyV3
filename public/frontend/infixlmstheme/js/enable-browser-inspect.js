/**
 * Keep browser inspection tools available.
 *
 * The minified theme bundle checks for `.app_debug` before registering
 * context-menu and keyboard shortcut blockers. This flag is created before the
 * bundle loads so those anti-inspect handlers are never attached.
 */
(function () {
    "use strict";

    var flagClass = "app_debug";
    var flagValue = "1";
    var existingFlag = document.querySelector("." + flagClass);

    if (existingFlag && "value" in existingFlag) {
        existingFlag.value = flagValue;

        return;
    }

    var flag = document.createElement("input");

    flag.type = "hidden";
    flag.className = flagClass;
    flag.value = flagValue;
    flag.setAttribute("aria-hidden", "true");

    if (existingFlag && existingFlag.parentNode) {
        existingFlag.parentNode.insertBefore(flag, existingFlag);

        return;
    }

    (document.body || document.documentElement).appendChild(flag);
})();

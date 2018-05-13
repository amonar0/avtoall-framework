/* global Node, HTMLElement */

namespace('alliance.dom', {
    isElement: function (value) {
        return typeof HTMLElement === "object" ? value instanceof HTMLElement : //DOM2
            value && typeof value === "object" && value !== null && value.nodeType === 1
            && typeof value.nodeName === "string";
    },
    isNode: function (value) {
        return typeof Node === "object" ? value instanceof Node :
            value && typeof value === "object" && typeof value.nodeType === "number"
            && typeof value.nodeName === "string";
    }
});

/* global alliance, _ */

function view(id, api) {
    namespace('alliance.view.' + id, (function () {
        var rootCached, settingsProviderCached;

        var context = {
            root: function (childElement) {
                if (!rootCached) {
                    rootCached = childElement.closest('.view-wrapper');
                }
                return rootCached;
            },
            settings: function (root) {
                if (!settingsProviderCached) {
                    settingsProviderCached = new alliance.view.SettingsProvider(context.root(root));
                }
                return settingsProviderCached;
            }
        };

        for (var i in api) {
            api[i] = api[i].bind(context);
        }
        return api;
    })());
}

/* global alliance */

namespace('alliance.view', {
    SettingsProvider: alliance.defineClass({
        constructor: function (root) {
            this.data = alliance.view.SettingsProvider.dataProvider(root);
        },
        uri: function (id) {
            if (!this.data.uriMap[id]) {
                throw 'Url with id "' + id + '" not found';
            }
            return this.data.uriMap[id];
        },
        commonData: function (id) {
            if (!this.data.commonDataMap[id]) {
                throw 'Data with id "' + id + '" not found';
            }
            return this.data.commonDataMap[id];
        }
    }, {
        dataProvider: function (root) {
            throw 'Method "dataProvider" must be implemented';
        }
    })
});
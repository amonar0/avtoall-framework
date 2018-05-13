/* global alliance */

alliance.extendClass(alliance.view.SettingsProvider,
    {}, {
        dataProvider: function (root) {
            var jsonData = root.querySelector('.settings-container').getAttribute('data-server-data');
            return JSON.parse(jsonData);
        }
    });
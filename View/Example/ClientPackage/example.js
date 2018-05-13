view('example', {
    test: function (element) {
        console.log(this, this.settings(element).uri('someAjax'), this.settings(element).commonData('data'));
    }
});

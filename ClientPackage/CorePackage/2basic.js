namespace('alliance', {
    defineClass: function (methods, staticMethods) {
        if (!methods.constructor) {
            throw 'Class must have constructor';
        }

        var Constructor = methods.constructor;
        delete methods.constructor;

        Object.assign(Constructor.prototype, methods);
        Object.assign(Constructor, staticMethods);

        return Constructor;
    },
    extendClass: function (aClass, methods, staticMethods) {
        Object.assign(aClass, staticMethods);
        return Object.create(aClass, methods);
    }
});

function namespace(namespace, value) {
    var separator = '.';

    var paths = namespace.split(separator);
    var lastPath = paths.pop();

    var currentObject = window;
    for (var i in paths) {
        var path = paths[i];

        if (!currentObject[path]) {
            currentObject[path] = {};
        } else {
            checkIsObject(currentObject, path, namespace);
        }

        currentObject = currentObject[path];
    }

    if (!currentObject[lastPath]) {
        currentObject[lastPath] = value;
    } else {
        checkIsObject(currentObject, lastPath, namespace);

        if (typeof value !== 'object') {
            throw 'Namespace "' + namespace + '" has object  "' + lastPath
            + '" already, so can be merged only with object, type "'
            + typeof value + '" given';
        }

        Object.assign(currentObject[lastPath], value);
    }

    function checkIsObject(currentObject, path, namespace) {
        if (typeof currentObject[path] !== 'object') {
            throw 'Namespace "' + namespace + '" is busy on path "' + path
            + '" by value "' + currentObject[path] + '"';
        }
    }
}

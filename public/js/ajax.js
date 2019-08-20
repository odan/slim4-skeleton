//
// Ajax and REST
//
let ajax = {};

/**
 * Ajax POST request
 *
 * @param {string} url
 * @param {object} data
 * @param {object=} options
 * @returns {*}
 */
ajax.post = function (url, data, options) {
    return $.ajax($.extend({
        url: url,
        type: 'POST',
        contentType: 'application/json; charset=utf-8',
        cache: false,
        dataType: 'json',
        processData: true,
        data: typeof data !== 'undefined' ? JSON.stringify(data) : null,
        headers: {
            'Accept': "application/+json; charset=utf-8"
        }
    }, options));
};

/**
 * Ajax GET request.
 *
 * @param {string} url
 * @param {object} options
 * @returns {*}
 */
ajax.get = function (url, options) {
    return $.ajax($.extend({
        url: url,
        type: 'GET',
        contentType: 'application/json; charset=utf-8',
        cache: false,
        dataType: 'json',
        processData: true
    }, options || {}));
};

/**
 * Check response object for error and show error message.
 *
 * @param {Object} xhr
 * @returns {Boolean}
 */
ajax.handleError = function (xhr) {
    // Handle only errors
    if (xhr.status == 422 || (xhr.status < 400 && xhr.status >= 599)) {
        return false;
    }

    let message = null;

    if (xhr.responseJSON) {
        if ('message' in xhr.responseJSON) {
            message = xhr.responseJSON.message;
        }
        if ('error' in xhr.responseJSON && 'message' in xhr.responseJSON.error) {
            message = xhr.responseJSON.error.message;
        }
    }

    message = message || __('Server error');

    Swal.hideLoading();
    Swal.fire({
        type: 'error',
        text: message
    });

    return true;
};
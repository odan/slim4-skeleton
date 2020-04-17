require('./spinner.css');

const showLoading = function () {
    hideLoading();
    const spinner = document.createElement('div');
    spinner.setAttribute('id', 'spinner');
    document.body.appendChild(spinner);
};

const hideLoading = function () {
    const spinner = document.getElementById("spinner");
    if (spinner) {
        spinner.remove();
    }
};

module.exports.showLoading = showLoading;
module.exports.hideLoading = hideLoading;

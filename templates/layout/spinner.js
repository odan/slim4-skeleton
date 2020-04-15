require('./spinner.css');

export function showLoading() {
    hideLoading();
    const spinner = document.createElement('div');
    spinner.setAttribute('id', 'spinner');
    document.body.appendChild(spinner);
};

export function hideLoading() {
    const spinner = document.getElementById("spinner");
    if (spinner) {
        spinner.remove();
    }
};

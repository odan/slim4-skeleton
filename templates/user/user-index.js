import './user-index.css';

const UserIndex = function () {
    const $this = this;

    this.init = function () {
        $('#data-table').DataTable();
    };

    this.init();
};

$(function () {
    new UserIndex();
});


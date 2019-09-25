require('./user-list.css');

const UserIndex = function () {
    const $this = this;

    this.init = function () {
        $('#data-table').DataTable();
    };

    this.demo = function () {
        return $('#myButton').html();
    }

    this.init();
};

$(function () {
    new UserIndex();
});

module.exports = UserIndex;

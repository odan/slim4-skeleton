const UserList = function () {
    const $this = this;

    this.init = function () {
        document.getElementById('add-button').addEventListener('click', $this.addButtonOnClick);
        document.getElementById('refresh-button').addEventListener('click', $this.refreshButtonOnClick);
    };

    this.addButtonOnClick = function () {
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        );
    };

    this.refreshButtonOnClick = function () {
        alert('Refresh clicked');
    };

    this.init();
};

document.addEventListener('DOMContentLoaded', function () {
    new UserList();
});

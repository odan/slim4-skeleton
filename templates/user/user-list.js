import './user-list.css';

class UserList {

    constructor() {
        $('#data-table').DataTable({
            'processing': true,
            'serverSide': true,
            'language': {
                //  'url': __('js/datatable-english.json')
            },
            'ajax': {
                'url': 'users/datatable',
                'type': 'POST'
            },
            'columns': [
                {'data': 'username'},
                {'data': 'email'},
                {'data': 'first_name'},
                {'data': 'last_name'},
                {'data': 'role'},
                {'data': 'enabled'},
                {
                    'orderable': false,
                    'searchable': false,
                    'data': null,
                    'render': function (data, type, row, meta) {
                        return '<button type="button" class="btn btn-info">Edit</button>';
                    }
                }
            ]
        });
    };
};

$(function () {
    new UserList();
});

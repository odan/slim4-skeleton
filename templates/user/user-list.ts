import './user-list.css';
import {Student, greeter} from './greeter';

export class UserList {

    public constructor() {
        //($('#data-table') as any).DataTable();

        ($('#data-table') as any).DataTable({
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
                    'render': function (data: any, type: any, row: any, meta: any) {
                        return '<button type="button" class="btn btn-info">Edit</button>';
                    }
                }
            ],
        });
    };

    public demo() {
        return $('#myButton').html();
    }
};

$(function () {

    let user = new Student("Jane", "M.", "User");

    greeter(user);

    new UserList();
});

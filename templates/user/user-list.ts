import './user-list.css';
import {Student} from './greeter';
import {greeter} from './greeter';

export class UserList {

    public constructor() {
        ($('#data-table') as any).DataTable();
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

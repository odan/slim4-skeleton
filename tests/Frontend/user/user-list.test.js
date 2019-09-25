const UserList = require('../../../templates/user/user-list').UserList;

test('user-list', () => {
    document.body.innerHTML = '<button id="myButton" type="button">My Button</button>';

    const user = new UserList();
    const actual = user.demo();

    expect(actual).toBe('My Button');
});




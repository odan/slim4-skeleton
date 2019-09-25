class Student {
    fullName: string;
    constructor(public firstName: string, public middleInitial: string, public lastName: string) {
        this.fullName = firstName + " " + middleInitial + " " + lastName;
    }
}

export { Student };

interface Person {
    firstName: string;
    lastName: string;
}

export { Person };

function greeter(person: Person) {
    return "Hello, " + person.firstName + " " + person.lastName;
}

export { greeter };



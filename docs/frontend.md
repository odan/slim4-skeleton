---
layout: default
title: Frontend
nav_order: 11
---

# Frontend

## Assets

### Updating packages

To update all packages like jQuery and Bootstrap run:

```bash
npm update
```

### Installing packages

To install a public package, on the command line, run:

```bash
npm install <package_name>
```

### Compiling Assets

To compile all assets for **development**, run:

```
npm run build:dev
```

To compile and minify all assets for **production**, run:

```
npm run build
```

To watch files and recompile whenever they change, run:

```
npm run watch
```

### Testing

To start frontend tests, run:

```
npm run test
```

To start frontend tests with code coverage, run:

```
npm run test:coverage
```

## Notifications

Showing a success message:

```js
notif({
    msg: "Good!",
    type: "success",
    position: "center"
});
```

Showing an error message:

```js
notif({
    msg: "Ooops!",
    type: "error",
    position: "center"
});
```

## Loading indicator

Show loading indicator:

```js
spinner.showLoading();
```

Hide loading indicator:

```js
spinner.hideLoading();
```

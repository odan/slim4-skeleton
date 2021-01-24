---
layout: default
title: Frontend
published: false
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

## Modal windows

Show a modal window:

```js
Swal.fire(
  'Good job!',
  'You clicked the button!',
  'success'
);
```

Read more: [SweetAlert2](https://sweetalert2.github.io/)

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

Read more: [notifIt!](https://github.com/naoxink/notifit-2)

## Loading indicator

Show loading indicator:

```js
spinner.showLoading();
```

Hide loading indicator:

```js
spinner.hideLoading();
```

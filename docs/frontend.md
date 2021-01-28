---
layout: default
title: Frontend
published: true
parent: Advanced
---

# Frontend

## Webpack

Webpack makes it relatively easy to compile and minify your application's 
CSS and JavaScript files. However, you are not required to use it 
while developing your application; 
you are free to use any asset pipeline tool you wish, or even none at all.

**Installation Instructions:** 

* [Slim 4 - Webpack](https://odan.github.io/2019/09/21/slim4-compiling-assets-with-webpack.html)
* [Webpack - Bootstrap Icons](https://odan.github.io/2021/01/07/webpack-bootstrap-icons.html)

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

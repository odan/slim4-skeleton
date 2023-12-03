---
layout: default
title: Directory Structure
parent: Getting Started
nav_order: 3
---

# Directory structure

The directory structure is based on the [Standard PHP package skeleton](https://github.com/php-pds/skeleton).

The `public` directory in your project contains 
the front-controller `index.php` and other web accessible files
such as images, CC and JavaScript files.

The `src` directory contains the core code for your application.

The `config` directory contains the application settings such as
the routes, service container, database connection and so on.

The `templates` directory contains the view templates 
for your application. You can use the Slim Framework's 
template engine, or you can use a third-party 
template engine such as Twig or Latte.

{% raw %}
```
.
├── build                   # Compiled files (artifacts)
├── config                  # Configuration files
├── docs                    # Documentation files
├── logs                    # Log files
├── public                  # Web server files
├── resources               # Other resource files
│   ├── migrations          # Database migration files
│   ├── seeds               # Data seeds
│   └── translations        # The .po message files for PoEdit
├── src                     # PHP source code (The App namespace)
│   ├── Action              # Controller actions (HTTP layer)
│   ├── Console             # Console commands
│   ├── Domain              # The core application
│   ├── Renderer            # Render and Url helper (HTTP layer)
│   ├── Middleware          # Middleware (HTTP layer)
│   └── Support             # Helper classes and functions
├── templates               # HTML templates
├── tests                   # Automated tests
├── tmp                     # Temporary files
├── vendor                  # Reserved for composer
├── build.xml               # Ant build tasks
├── composer.json           # Project dependencies
├── LICENSE                 # The license
└── README.md               # This file
```
{% endraw %}

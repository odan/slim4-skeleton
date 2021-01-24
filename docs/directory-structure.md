---
layout: default
title: Directory structure
nav_order: 5
---

# Directory structure

The directory structure based on the [Standard PHP package skeleton](https://github.com/php-pds/skeleton).

{% raw %}
```
.
├── bin                     # Excecutable files
│   └── console.php         # The command line tool
├── build                   # Compiled files (artifacts)
├── config                  # Configuration files
├── docs                    # Documentation files
├── logs                    # Log files
├── public                  # Web server files
├── resources               # Other resource files
│   ├── migrations          # Database migration files (Phinx)
│   ├── seeds               # Data seeds
│   └── translations        # The .po message files for PoEdit
├── src                     # PHP source code (The App namespace)
│   ├── Action              # Controller actions (application layer)
│   ├── Console             # Console commands for console.php
│   ├── Domain              # The business logic
│   ├── Factory             # Factories
│   ├── Responder           # Responder and Url helper (application layer)
│   ├── Middleware          # Middleware (application layer)
│   └── Support             # Helper classes and functions
├── templates               # Twig and Vue templates + JS and CSS
├── tests                   # Automated tests
├── tmp                     # Temporary files
│   ├── translations        # Locale cache
│   └── twig                # Internal twig cache
├── vendor                  # Reserved for composer
├── build.xml               # Ant build tasks
├── composer.json           # Project dependencies
├── LICENSE                 # The license
└── README.md               # This file
```
{% endraw %}

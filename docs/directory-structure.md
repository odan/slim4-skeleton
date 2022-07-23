---
layout: default
title: Directory Structure
parent: Getting Started
nav_order: 3
---

# Directory structure

The directory structure is based on the [Standard PHP package skeleton](https://github.com/php-pds/skeleton).

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
│   ├── Domain              # The business logic
│   ├── Factory             # Factories
│   ├── Renderer            # Render and Url helper (HTTP layer)
│   ├── Middleware          # Middleware (HTTP layer)
│   └── Support             # Helper classes and functions
├── templates               # Twig and Vue templates + JS and CSS
├── tests                   # Automated tests
├── tmp                     # Temporary files
├── vendor                  # Reserved for composer
├── build.xml               # Ant build tasks
├── composer.json           # Project dependencies
├── LICENSE                 # The license
└── README.md               # This file
```
{% endraw %}

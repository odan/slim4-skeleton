---
layout: default
title: Installation
parent: Getting Started
nav_order: 1
---

# Installation

The Slim Framework is a popular PHP micro-framework 
for building web applications. To set up this Slim Framework 
skeleton project, you will need to have PHP and Composer 
installed on your system.

**Step 1:** Create a new project:

Open a terminal and navigate to the directory where you 
want to create your new Slim Framework project.

Run the following Composer command to create a new project:

```shell
composer create-project odan/slim4-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired name for your project. 
This will create a new directory with the specified name 
and install the required dependencies.

**Step 2:** Set permissions *(Linux only)*

```bash
cd my-app

sudo chown -R www-data tmp/
sudo chown -R www-data logs/

sudo chmod -R g+w tmp/
sudo chmod -R g+w logs/
```

**Step 3:** Start the internal webserver

Once the installation is complete, navigate to the newly 
created directory and start the built-in PHP development 
server by running the following command:

```
composer start
```

This will start the development server on port 8080 of 
your local machine. You can now access your 
application by visiting <http://localhost:8080>
in your web browser.

**Note:** The PHP internal webserver is designed for
application development, testing or application demonstrations.
It is not intended to be a full-featured web server. 
It should not be used on a public network.

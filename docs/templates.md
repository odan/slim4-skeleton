---
layout: default
title: Templates
nav_order: 11
---

# Templates

Twig is the simple, yet powerful templating engine provided by Symfony. 

All Twig templates with the extension `*.twig` are stored in the directory: `templates/`

Twig templates will be converted to native PHP code and cached until the template changes. 
This means that Twig does not add much overhead to your application.

## VSCode Snippet

[Snippets in Visual Studio Code - Create your own snippets](https://code.visualstudio.com/docs/editor/userdefinedsnippets#_create-your-own-snippets).

Should be added to file `Code/User/snippets/html.json`.

For quick access start typing `extends` in new HTML file then pick snippet from dropdown.

```json
    "slim4 skeleton Twig template": {
        "prefix": "extends",
        "body": [
            "{% extends \"layout/${1|layout-empty,layout|}.twig\" %}",
            "",
            "{% block css %}",
            "    {% webpack_entry_css '${TM_DIRECTORY/^.+\\/(.*)$/$1/}/$TM_FILENAME_BASE' %}",
            "{% endblock %}",
            "",
            "{% block js %}",
            "    {% webpack_entry_js '${TM_DIRECTORY/^.+\\/(.*)$/$1/}/$TM_FILENAME_BASE' %}",
            "{% endblock %}",
            "",
            "{% block content %}",
            "",
            "    <div class=\"container\">",
            "        $0",
            "    </div>",
            "",
            "{% endblock %}",
            ""
        ],
        "description": "slim4 skeleton Twig template"
    },
```

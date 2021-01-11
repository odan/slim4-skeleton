---
layout: default
title: Responder
parent: Architecture
nav_order: 3
---

# Responder

According to [ADR](https://github.com/pmjones/adr) there should be a **responder** for each action.
In most cases a generic responder (see [Responder.php](https://github.com/odan/slim4-skeleton/blob/master/src/Responder/Responder.php))
is good enough. Of course, you can add special responder classes and move the complete presentation logic there.
An extra responder class would make sense when [building an transformation layer](https://fractal.thephpleague.com/)
for complex (json or xml) data output. This helps to separate the presentation logic from the domain logic.


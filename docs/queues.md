---
layout: default
title: Queues
parent: Advanced
---

# Queues

## Introduction

While building your web application, you may have some tasks, 
such as parsing and storing an uploaded CSV file, 
that take too long to perform during a typical web request. 
Thankfully, the `php-amqplib/php-amqplib` component allows you to
easily create queued jobs that may be processed in the background. 
By moving time intensive tasks to a queue, your application can 
respond to web requests with blazing speed and provide a better 
user experience to your customers.

**Read more**

* [Rabbit MQ](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [RabbitMQ Tutorial for PHP](https://www.rabbitmq.com/tutorials/tutorial-one-php.html)
* [The RabbitMQ website](https://www.rabbitmq.com/) (Website)

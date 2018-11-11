# Mail sender from RabbitMQ

This service allow work with queue RabbitMQ and send mail from 
queue by PhpMailer

In this service implemented DDD architecture and SOLID, KISS, YANGI specifications

For change enviroiment edit /www/app.pph and set constant ENVIRONMENT dev or prod

For configure rabbitMQ settings edit /www/config/env/dev or /www/config/env/prod

For add message to queue just execute command
```bash
cd www
composer cli /producer to=test@test.ru from=test@test.ru message=test subject=test
```

___

For fetch message from queue and send execute command
```bash
cd www
composer cli /consumer
```
___

For testing service execute command
```bash
cd www
composer test
```
Report will created in /www/logs/reports

___

For check code formating execute command
```bash
cd www
composer psr2
```
Report will created in /www/logs/reports

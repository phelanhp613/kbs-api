## About Laravel

Careermatket api

- Laravel 9.1
- Mysql 8
- Redis

RUN: 

```
composer install
```

Check syntax:

```
php artisan git:pre-commit
```

Register `.git/hooks/pre-commit` check syntax auto when commit
```
php artisan git:install-hook
```

Autoload file
```
composer dump-autoload
```

Run job: create sitemap, ...
```
php artisan queue:work
```

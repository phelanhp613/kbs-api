#!/usr/bin/env bash

#USER_ID=tinh.nguyen
#USER_PW=ffjx3lw3yzwnt4e4lxzgqltxayd4zkrqkrp5rrygx3443erbmr7a
#
#origin=$(git remote get-url origin)
#origin_with_pass=${origin/"//"/"//${USER_ID}:${USER_PW}@"}
#git pull ${origin_with_pass} master

#git pull origin master

#composer install
#
#composer dump-autoload
#
#php artisan migrate

cd /home/ubuntu/deploy/laradock

docker-compose restart

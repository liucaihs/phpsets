FROM registry-vpc.cn-shenzhen.aliyuncs.com/me2two/php71-apache:latest

RUN a2enmod rewrite \
  && mkdir -p /app \
  && rm -fr /var/www/html \
  && ln -s /app/public /var/www/html

WORKDIR /app

COPY ./composer.json ./
COPY ./composer.lock ./
RUN composer install  --no-autoloader --no-scripts

COPY . ./

RUN composer install \
  && chown -R www-data:www-data ./ \
  && chmod -R 0777 ./storage


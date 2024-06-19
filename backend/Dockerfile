# FROM php:8.3-fpm

# # Set working directory
# WORKDIR /var/www

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     libpng-dev \
#     libjpeg62-turbo-dev \
#     libfreetype6-dev \
#     locales \
#     zip \
#     jpegoptim optipng pngquant gifsicle \
#     vim \
#     unzip \
#     git \
#     curl

# # Clear cache
# # Set Environment Variables
# ENV DEBIAN_FRONTEND noninteractive

# #
# #--------------------------------------------------------------------------
# # Software's Installation
# #--------------------------------------------------------------------------
# #
# # Installing tools and PHP extentions using "apt", "docker-php", "pecl",
# #

# # Install "curl", "libmemcached-dev", "libpq-dev", "libjpeg-dev",
# #         "libpng-dev", "libfreetype6-dev", "libssl-dev", "libmcrypt-dev",
# RUN set -eux; \
#     apt-get update; \
#     apt-get upgrade -y; \
#     apt-get install -y --no-install-recommends \
#             curl \
#             libmemcached-dev \
#             libz-dev \
#             libpq-dev \
#             libjpeg-dev \
#             libpng-dev \
#             libfreetype6-dev \
#             libssl-dev \
#             libwebp-dev \
#             libxpm-dev \
#             libmcrypt-dev \
#             libonig-dev; \
#     rm -rf /var/lib/apt/lists/*

# RUN set -eux; \
#     # Install the PHP pdo_mysql extention
#     docker-php-ext-install pdo_mysql; \
#     # Install the PHP pdo_pgsql extention
#     docker-php-ext-install pdo_pgsql; \
#     # Install the PHP gd library
#     docker-php-ext-configure gd \
#             --prefix=/usr \
#             --with-jpeg \
#             --with-webp \
#             --with-xpm \
#             --with-freetype; \
#     docker-php-ext-install gd; \
#     php -r 'var_dump(gd_info());'
# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy existing application directory contents
# COPY src /var/www

# # Copy existing application directory permissions
# COPY --chown=www-data:www-data src /var/www

# # Expose port 9000 and start php-fpm server
# EXPOSE 9000
# CMD ["php-fpm"]

# 2022 update
FROM php:8.3-fpm

# setup user as root
USER root

WORKDIR /var/www

# setup node js source will be used later to install node js
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
RUN ["sh",  "./nodesource_setup.sh"]

# Install environment dependencies
RUN apt-get update \
	# gd
	&& apt-get install -y build-essential  openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev nodejs  \
	&& docker-php-ext-configure gd  \
	&& docker-php-ext-install gd \
	# gmp
	&& apt-get install -y --no-install-recommends libgmp-dev \
	&& docker-php-ext-install gmp \
	# pdo_mysql
	&& docker-php-ext-install pdo_mysql mbstring \
	# pdo
	&& docker-php-ext-install pdo \
	# opcache
	&& docker-php-ext-enable opcache \
	# exif
    && docker-php-ext-install exif \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
	# zip
	&& docker-php-ext-install zip \
	&& apt-get autoclean -y \
	&& rm -rf /var/lib/apt/lists/* \
	&& rm -rf /tmp/pear/

# Copy files
COPY src /var/www

# COPY ./deploy/local.ini /usr/local/etc/php/local.ini

COPY ./deploy/conf.d/nginx.conf /etc/nginx/nginx.conf

RUN chmod +rwx /var/www

RUN chmod -R 777 /var/www

# setup FE
RUN npm install

# RUN npm rebuild node-sass

# RUN npm run prod

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --working-dir="/var/www"

RUN composer dump-autoload --working-dir="/var/www"

RUN php artisan optimize

RUN php artisan route:clear

RUN php artisan route:cache

RUN php artisan config:clear

RUN php artisan config:cache

RUN php artisan view:clear

RUN php artisan view:cache

# remove this line if you do not want to run migrations on each build
EXPOSE 80

COPY post_deploy.sh /var/www/ 

# RUN ["chmod", "+x", "post_deploy.sh"]
RUN chmod +x /var/www/post_deploy.sh
CMD [ "sh", "/var/www/post_deploy.sh" ]
# CMD php artisan serve --host=127.0.0.1 --port=9000


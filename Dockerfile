# Use the specified base image
FROM webdevops/php-nginx-dev:8.2-alpine

# Set the working directory inside the container
WORKDIR /var/www

# Copy the web application files to the container
COPY ./webapp/ /var/www/public/

# Copy the custom Nginx configuration file
COPY ./docker/nginx.conf /opt/docker/etc/nginx/vhost.conf

# Expose port 80
EXPOSE 80

# The base image already contains a command to start PHP and Nginx, so no need to redefine CMD or ENTRYPOINT
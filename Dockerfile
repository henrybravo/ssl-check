# Use the specified base image
FROM webdevops/php-nginx-dev:8.2-alpine

LABEL org.opencontainers.image.title="ssl-checker-webapp" \
      org.opencontainers.image.description="webapp to check the ssl certificate of a web domain" \
      org.opencontainers.image.authors="Henry Bravo" \
      org.opencontainers.image.url="https://hub.docker.com/r/henrybravo/ssl-checker-webapp/" \
      org.opencontainers.image.documentation="https://github.com/henrybravo/ssl-check/README.md" \
      org.opencontainers.image.vendor="Henry Bravo" \
      org.opencontainers.image.licenses="MIT" \
      org.opencontainers.image.source="https://github.com/henrybravo/ssl-check.git"

# Set the working directory inside the container
WORKDIR /var/www

# Copy the web application files to the container
COPY ./webapp/ /var/www/public/

# Copy the custom Nginx configuration file
COPY ./docker/nginx.conf /opt/docker/etc/nginx/vhost.conf

# Expose port 80
EXPOSE 80

# The base image already contains a command to start PHP and Nginx, so no need to redefine CMD or ENTRYPOINT

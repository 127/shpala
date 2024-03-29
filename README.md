# Shpala MVC framework

## Requirements

- nginx/apache, whatever
- mysql 
- php 5.6.30 >

## Run local server

- Run server with ```bin/shpala server``` directory of the project.

## Production Ubuntu 

```sudo apt-get install nginx mysql-server php-fpm php-mysql```

and

```
server {
  listen 80;
  server_name site.com;
  root /var/www/site.com/current/public;
  access_log /var/www/site.com/current/log/nginx.access.log;
  error_log /var/www/site.com/current/log/nginx.error.log;
  index index.php;
  error_page 404 /404.html;
  error_page 500 /500.html; 
  #Specifies that Nginx is looking for .php files
  location ~ \.php$ { 
    #If a file isn’t found, 404
    try_files $uri =404; 
    #Include Nginx’s fastcgi configuration
    include /etc/nginx/fastcgi.conf;
    #Look for the FastCGI Process Manager at this location 
    fastcgi_pass unix:/run/php/php7.2-fpm.sock; 
  } 
}
```

![Logo](https://lzomedia.com/assets/logo.svg)


# Today Intel Application

## Installation and setup

Clone the GitHub repository on your local machine

```bash
cd <project directory>
cp .env.example .env
```

At the first step,
you need
to install composer dependencies
using a runtime container which will be cleanup after composer installation on the new build docker virtual machine.

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs 
```

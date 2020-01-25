# Techsample Backend
Backend for a simple user dashboard for player/developer

## Installation
Configuration for the app is set through the `.env` file and, so copy `.env.example`, edit accordingly and then run `docker-compose` and the corresponding artisan commands.

    cp .env.example .env
    docker-compose up -d --build
    # Run artisan commands
    docker-compose exec app bash
    # Inside the container
    php artisan key:generate
    php artisan migrate
    ...

    # Or run the script
    docker-compose exec app bash -c "./artisan-commands.sh"

This could also be done with the included `install.sh` script (using default configuration), so it'd boil down to running:

    ./install.sh
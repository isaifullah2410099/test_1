FROM mcr.microsoft.com/devcontainers/php:8.4-bookworm

# mysqli is needed because the class project uses new mysqli() in PHP.
RUN docker-php-ext-install mysqli

# MariaDB client is useful for checking the database from the terminal.
# Install database client and Git LFS
RUN apt-get update \
    && apt-get install -y mariadb-client git-lfs \
    && rm -rf /var/lib/apt/lists/*

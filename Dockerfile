# Use the official PHP image with CLI
FROM php:8.2-cli

# Install necessary PHP extensions and Git
RUN apt-get update && apt-get install -y \
    git \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /app

# Copy application files
COPY . .

# Remove the lock file if it exists
RUN rm -f composer.lock

# Set the default command to run the interactive PHP shell
CMD ["php", "-a"]

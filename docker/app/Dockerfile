FROM php:8.3-fpm

# Instala dependências necessárias do sistema
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    ca-certificates \
    zip \
    unzip \
    git \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    build-essential \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala o Node.js 24.x LTS
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Define o diretório de trabalho
WORKDIR /var/www

# Expor a porta (opcional, depende do uso)
EXPOSE 5173

# Comando padrão
CMD ["php-fpm"]


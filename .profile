# Run project
run() {
    symfony server:start -d
    docker compose up --build -d
}

# Stop project
stop() {
    symfony server:stop
    docker compose down
}

# php bin/console
console() {
    php bin/console "$@"
}

# Reload database
db() {
    php bin/console doctrine:database:drop --force
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate -n
    php bin/console doctrine:fixtures:load -n
}

# Reload whole project
reload() {
    composer install
    db
    yarn build
}

# Cache clear
cacl() {
    php bin/console cache:clear
}

# PHP quality check
phpstan() {
    vendor/bin/phpstan analyse
}

# JS quality check
eslint() {
    npx eslint assets/
}

# SCSS quality check
stylelint() {
    npx stylelint assets/styles/**/*.scss
}

# Global quality check
quality() {
    npx eslint assets/
    npx stylelint assets/styles/**/*.scss
    vendor/bin/php-cs-fixer fix --diff --allow-risky=yes
    vendor/bin/phpstan analyse
}

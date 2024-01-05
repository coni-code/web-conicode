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

# Reload whole project
reload() {
    run
    composer install
    php bin/console do:sch:dr -f --full-database
    php bin/console do:mi:mi -n
    php bin/console do:fi:lo -n
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
    vendor/bin/phpstan analyse
}

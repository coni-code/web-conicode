run() {
    symfony server:start -d
    docker compose up --build -d
}

stop() {
    symfony server:stop
    docker compose down
}

console() {
    php bin/console "$@"
}

reload() {
    run
    composer install
    php bin/console do:sch:dr -f --full-database
    php bin/console do:mi:mi -n
    php bin/console do:fi:lo -n
    yarn build
}

cacl() {
    php bin/console cache:clear
}

phpstan() {
    vendor/bin/phpstan analyse
}

eslint() {
    npx eslint assets/
}

stylelint() {
    npx stylelint assets/styles/**/*.scss
}

quality() {
    npx eslint assets/
    npx stylelint assets/styles/**/*.scss
    vendor/bin/phpstan analyse
}

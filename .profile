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
    php bin/console do:sch:dr -f --full-database
    php bin/console do:mi:mi -n
    php bin/console do:fi:lo -n
    yarn build
}

cacl() {
    php bin/console cache:clear
}

quality() {
    npx eslint assets/
    npx stylelint assets/styles/**/*.scss
    vendor/bin/phpstan analyse
}

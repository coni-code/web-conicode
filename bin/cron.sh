CRON_LOCK="./cron.lock"

if [ -f "$CRON_LOCK" ]; then
    echo 'Cron lock exist. Wait for the completion of running execution'

    exit 0
fi

touch $CRON_LOCK

php bin/console save:trello

rm $CRON_LOCK

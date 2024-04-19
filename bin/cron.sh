CRON_LOCK="./cron.lock"
LOG="./var/log/cron"

if [ -f "$CRON_LOCK" ]; then
    echo "$(date '+%Y-%m-%d %H:%M:%S') - Cron lock exists. Wait for the completion of running execution" >> $LOG
    exit 0
fi

touch $CRON_LOCK

echo "$(date '+%Y-%m-%d %H:%M:%S') - Starting execution" >> $LOG
php bin/console save:trello >> $LOG 2>&1

rm $CRON_LOCK
echo "$(date '+%Y-%m-%d %H:%M:%S') - Execution completed" >> $LOG

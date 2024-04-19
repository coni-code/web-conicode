<?php

declare(strict_types=1);

$CRON_LOCK = '../cron.lock';
$LOG_DIR = '../var/log';
$LOG = "$LOG_DIR/cron";

if (!is_dir($LOG_DIR)) {
    mkdir($LOG_DIR, 0755, true);
}

if (file_exists($CRON_LOCK)) {
    file_put_contents(
        $LOG,
        sprintf(
            '%s - %s',
            date('Y-m-d H:i:s'),
            "Cron lock exists. Wait for the completion of running execution\n",
        ),
        FILE_APPEND,
    );
    exit(0);
}

touch($CRON_LOCK);

file_put_contents($LOG, date('Y-m-d H:i:s') . " - Starting execution\n", FILE_APPEND);

exec('php ../bin/console save:trello 2>&1', $output);
file_put_contents($LOG, implode("\n", $output) . "\n", FILE_APPEND);

unlink($CRON_LOCK);

file_put_contents($LOG, date('Y-m-d H:i:s') . " - Execution completed\n", FILE_APPEND);

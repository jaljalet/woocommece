-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_actions WHERE status = 'complete' LIMIT 1000;

-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_actions WHERE status = 'failed' LIMIT 1000;

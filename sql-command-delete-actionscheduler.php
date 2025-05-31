-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_actions WHERE status = 'complete' LIMIT 1000;

-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_actions WHERE status = 'failed' LIMIT 1000;

-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_logs WHERE action_id NOT IN ( SELECT action_id FROM wp_actionscheduler_actions ) LIMIT 1000;

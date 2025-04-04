-- Delete 1000 logs at a time
DELETE l FROM wp_actionscheduler_logs l
JOIN wp_actionscheduler_actions a ON a.action_id = l.action_id
WHERE a.status IN ('complete', 'canceled')
LIMIT 1000;

-- Delete 1000 logs at a time
DELETE FROM wp_actionscheduler_actions
WHERE status IN ('complete', 'canceled')
LIMIT 1000;

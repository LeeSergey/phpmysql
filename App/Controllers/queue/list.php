<?php

use App\TasksQueue;

$tasks = TasksQueue::getTaskList();

$smarty->assign('queue_tasks', $tasks);
$smarty->display('queue/list.tpl');
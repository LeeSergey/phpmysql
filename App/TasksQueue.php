<?php


class TasksQueue
{
    public static function addTask(array $taskData)
    {
        echo "<pre>";var_dump($taskData);echo "</pre>";
        $task = $taskData['task'];
    }
}
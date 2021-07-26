<?php

namespace App\Queue;

use App\Renderer;
use App\Request;
use App\Response;
use App\TasksQueue;

class QueueController
{

    public function list()
    {
        $tasks = TasksQueue::getTaskList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('queue_tasks', $tasks);
        $smarty->display('queue/list.tpl');
    }

    public function run()
    {
        $id = Request::getIntFromGet('id');

        $result = TasksQueue::runById($id);

        Response::redirect('/queue/list');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id');

        $taskUploadedFilename = TasksQueue::deleteById($id);
        if (empty($taskUploadedFilename)){
            return false;
        }

        $filepath = APP_PUBLIC_DIR . '/upload/import/' . $taskUploadedFilename;

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        Response::redirect('/queue/list');
    }
}
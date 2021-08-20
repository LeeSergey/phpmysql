<?php

namespace App\Queue;

use App\Controller\AbstractController;
use App\Renderer;
use App\Request;
use App\Response;
use App\TasksQueue;

class QueueController extends AbstractController
{

//    public function __construct()
//    {
//    }

    public function list()
    {
        $tasks = TasksQueue::getTaskList();

//        $smarty = Renderer::getSmarty();
//        $smarty->assign('queue_tasks', $tasks);
//        $smarty->display('queue/list.tpl');

        return $this->render('queue/list.tpl',[
            'queue_tasks' => $tasks,
        ]);

    }

    public function run(Request $request, Response $response)
    {
        $id = $request->getIntFromGet('id');

        $result = TasksQueue::runById($id);

        $response->redirect('/queue/list');
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getIntFromPost('id');

        $taskUploadedFilename = TasksQueue::deleteById($id);
        if (empty($taskUploadedFilename)){
            return false;
        }

        $filepath = APP_PUBLIC_DIR . '/upload/import/' . $taskUploadedFilename;

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $response->redirect('/queue/list');
    }
}
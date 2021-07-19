<?php

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
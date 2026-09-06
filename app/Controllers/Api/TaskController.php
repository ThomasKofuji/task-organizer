<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\TaskModel;

class TaskController extends BaseController
{

    use ResponseTrait;

    protected TaskModel $taskModel;

    public function __construct(){
        $this->taskModel = new TaskModel();
    }

    public function findAll()
    {
        return $this->respond($this->taskModel->findAll());
    }

    public function findById($id = null)
    {
        $task = $this->taskModel->find($id);

        if(!$task){
            return $this->failNotFound('Tarefa não encontrada!');
        }

        return $this->respond($task);
    }

    public function create()
    {
        $rules = [
            'title' => ['required','max_length[255]'],
            'status' => ['required','in_list[pendente,em_andamento,concluida]']
        ];

        if(!$this->validate($rules)){
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'title'         => $this->request->getVar('title'),
            'description'   => $this->request->getVar('description'),
            'status'        => $this->request->getVar('status')
        ];

        $id = $this->taskModel->insert($data);

        return $this->respondCreated(['id' => $id] + $data);
    }

    public function update($id = null)
    {
        $task = $this->taskModel->find($id);

        if(!$task){
            return $this->failNotFound('Tarefa não Econtrada!');
        }

        $rules = [
            'title' => ['required','max_length[255]'],
            'status' => ['required','in_list[pendente,em_andamento,concluida]']
        ];

        if(!$this->validate($rules)){
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'title'         => $this->request->getVar('title'),
            'description'   => $this->request->getVar('description'),
            'status'        => $this->request->getVar('status')
        ];

        $this->taskModel->update($id, $data);

        return $this->respond(['id' => $id] + $data);
    
    }

    public function delete($id)
    {
        $task = $this->taskModel->find($id);

        if(!$task){
            return $task->failNotFound('Tarefa não Encontrada!');
        }

        $this->taskModel->delete($id);

        return $this->respondDeleted(['id' => $id]);
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TaskModel;

class TaskController extends BaseController
{

    public function index(): string
    {
        $taskModel = new TaskModel();
        
        $data['tasks'] = $taskModel->findAll();
        
        return view("tasks/index", $data);
    }

    public function create(): string
    {

        $data['validation_errors'] = session()->getFlashdata('errors');

        return view("tasks/create", $data);
    }

    public function submit()
    {
        
        $validation = $this->validate([
            'title' => [
                'label' => 'título',
                'rules' => ['required', 'max_length[255]'],
                'errors' => [
                    'required' => 'O campo {field} é obrigatório!',
                    'max_length' => 'O campo {field} deve ter no máximo {param} caracteres!'
                ]
            ],
            'status' => [
                'label' => 'status',
                'rules' => ['required', 'in_list[pendente,em_andamento,concluida]'],
                'errors' => [
                    'required' => 'O campo {field} é obrigatório!',
                    'in_list' => 'O campo {field} deve ser uma das opções: Pendente, Em Andamento, Concluída.'
                ]
            ]
        ]);

        if(!$validation){
            log_message('error', "Erro de Validação Ocorreu!");
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
        ];

        $taskModel = new TaskModel();
        $taskModel->insert($data);

        return redirect()->to('/')->with('success', 'Tarefa cadastrada com sucesso!');

    }

    public function edit($id)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($id);

        if (!$task) {
            return redirect()->to('/')->with('errors', ['Tarefa não encontrada.']);
        }

        $data['task'] = $task;
        $data['validation_errors'] = session()->getFlashdata('errors');

        return view("tasks/edit", $data);
    }

    public function update($id)
    {
        $validation = $this->validate([
            'title' => [
                'label' => 'título',
                'rules' => ['required', 'max_length[255]'],
                'errors' => [
                    'required' => 'O campo {field} é obrigatório!',
                    'max_length' => 'O campo {field} deve ter no máximo {param} caracteres!'
                ]
            ],
            'status' => [
                'label' => 'status',
                'rules' => ['required', 'in_list[pendente,em_andamento,concluida]'],
                'errors' => [
                    'required' => 'O campo {field} é obrigatório!',
                    'in_list' => 'O campo {field} deve ser uma das opções: Pendente, Em Andamento, Concluída.'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
        ];

        $taskModel = new TaskModel();
        $taskModel->update($id, $data);

        return redirect()->to('/')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function delete($id)
    {
        $taskModel = new TaskModel();
        $taskModel->delete($id);

        return redirect()->to('/')->with('success', 'Tarefa excluída com sucesso!');
    }

}
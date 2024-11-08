<?php

namespace App\Controllers;
use App\Models\TaskModel;

class TaskController extends BaseController
{
    protected $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }


    public function index()
    {
        return view('tasks/index');
    }


    public function getAll()
    {
        $tasks = $this->taskModel->findAll();
        return $this->response->setJSON($tasks);
    }


    public function add()
    {
        $judul = $this->request->getPost('judul');
        $status = 0; 

        $this->taskModel->save([
            'judul' => $judul,
            'status' => $status
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }


    public function get($id)
    {
        $task = $this->taskModel->find($id);

        if ($task) {
            return $this->response->setJSON(['status' => 'success', 'data' => $task]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Tugas tidak ditemukan']);
    }

    public function editForm($id)
{

    $task = $this->taskModel->find($id);
    if ($task) {
        return $this->response->setJSON(['status' => 'success', 'data' => $task]);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Tugas tidak ditemukan']);
    }
}

public function edit()
{
    $data = $this->request->getPost();
    if (!isset($data['id']) || !isset($data['judul']) || !isset($data['status'])) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

 
    $task = $this->taskModel->find($data['id']);
    if (!$task) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Tugas tidak ditemukan']);
    }


    $taskData = [
        'judul' => $data['judul'],
        'status' => $data['status'],
    ];


    $this->taskModel->update($data['id'], $taskData);

    return $this->response->setJSON(['status' => 'success']);
}


    public function delete()
    {
        $id = $this->request->getPost('id');

        if ($this->taskModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus tugas']);
    }
}

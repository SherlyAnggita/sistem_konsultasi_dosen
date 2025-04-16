<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_users' => $this->model->findAll()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $users = $this->model->find($id);

        if (!$users) {
            return $this->failNotFound('Data user tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'users_byid' => $users
        ], 200);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true); // true = convert ke array

        $rules = $this->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
        ]);

        return $this->respondCreated([
            'message' => 'Data user berhasil ditambahkan'
        ]);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $users = $this->model->find($id);

        if (!$users) {
            return $this->failNotFound('Data user tidak ditemukan');
        }

        $rules = $this->validate([
            'username' => 'required',
            'email'       => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'username' => $this->request->getVar('username'),
            'email'       => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'role' => $this->request->getVar('role'),
        ]);

        return $this->respond([
            'message' => 'Data user berhasil diperbarui'
        ], 200);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $users = $this->model->find($id);

        if (!$users) {
            return $this->failNotFound('Data user tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data user berhasil dihapus'
        ]);
    }
}

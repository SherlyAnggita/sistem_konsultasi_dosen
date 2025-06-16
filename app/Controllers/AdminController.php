<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends ResourceController
{
    protected $modelName = 'App\Models\AdminModel';
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
            'data_admin' => $this->model->findAll()
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
        $admin = $this->model->find($id);

        if (!$admin) {
            return $this->failNotFound('Data admin tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'admin_byid' => $admin
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
            'id_user' => 'required',
            'nama_admin' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert([
            'id_user' => $data['id_user'],
            'nama_admin' => $data['nama_admin'],
        ]);

        return $this->respondCreated([
            'message' => 'Data admin berhasil ditambahkan'
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
        $admin = $this->model->find($id);

        if (!$admin) {
            return $this->failNotFound('Data admin tidak ditemukan');
        }

        $rules = $this->validate([
            'id_user' => 'required',
            'nama_admin' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'id_user' => $this->request->getVar('id_user'),
            'nama_admin' => $this->request->getVar('nama_admin'),
        ]);

        return $this->respond([
            'message' => 'Data admin berhasil diperbarui'
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
        $admin = $this->model->find($id);

        if (!$admin) {
            return $this->failNotFound('Data admin tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data admin berhasil dihapus'
        ]);
    }
}

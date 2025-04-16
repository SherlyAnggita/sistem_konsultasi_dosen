<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DosenController extends ResourceController
{
    protected $modelName = 'App\Models\DosenModel';
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
            'data_dosen' => $this->model->findAll()
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
        $dosen = $this->model->find($id);

        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'dosen_byid' => $dosen
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
            'NIDN' => 'required',
            'nama_dosen' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert([
            'id_user' => $data['id_user'],
            'NIDN' => $data['NIDN'],
            'nama_dosen' => $data['nama_dosen'],
        ]);

        return $this->respondCreated([
            'message' => 'Data dosen berhasil ditambahkan'
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
        $dosen = $this->model->find($id);

        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $rules = $this->validate([
            'id_user' => 'required',
            'NIDN'       => 'required',
            'nama_dosen' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'id_user' => $this->request->getVar('id_user'),
            'NIDN'       => $this->request->getVar('NIDN'),
            'nama_dosen' => $this->request->getVar('nama_dosen'),
        ]);

        return $this->respond([
            'message' => 'Data dosen berhasil diperbarui'
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
        $dosen = $this->model->find($id);

        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data dosen berhasil dihapus'
        ]);
    }
}

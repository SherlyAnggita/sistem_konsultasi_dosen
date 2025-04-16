<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class KonsultasiController extends ResourceController
{
    protected $modelName = 'App\Models\KonsultasiModel';
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
            'data_konsultasi' => $this->model->findAll()
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
        $konsultasi = $this->model->find($id);

        if (!$konsultasi) {
            return $this->failNotFound('Data konsultasi tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'konsultasi_byid' => $konsultasi
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
            'id_mhs' => 'required',
            'id_dosen' => 'required',
            'nama_mhs' => 'required',
            'nama_dosen' => 'required',
            'tgl_konsultasi' => 'required',
            'topik' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert([
            'id_mhs' => $data['id_mhs'],
            'id_dosen' => $data['id_dosen'],
            'nama_mhs' => $data['nama_mhs'],
            'nama_dosen' => $data['nama_dosen'],
            'tgl_konsultasi' => $data['tgl_konsultasi'],
            'topik' => $data['topik'],
        ]);

        return $this->respondCreated([
            'message' => 'Data konsultasi berhasil ditambahkan'
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
        $konsultasi = $this->model->find($id);

        if (!$konsultasi) {
            return $this->failNotFound('Data konsultasi tidak ditemukan');
        }

        $rules = $this->validate([
            'id_mhs' => 'required',
            'id_dosen' => 'required',
            'nama_mhs' => 'required',
            'nama_dosen' => 'required',
            'tgl_konsultasi' => 'required',
            'topik' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'id_mhs' => $this->request->getVar('id_mhs'),
            'id_dosen'       => $this->request->getVar('id_dosen'),
            'nama_mhs' => $this->request->getVar('nama_mhs'),
            'nama_dosen' => $this->request->getVar('nama_dosen'),
            'tgl_konsultasi' => $this->request->getVar('tgl_konsultasi'),
            'topik' => $this->request->getVar('topik'),
        ]);

        return $this->respond([
            'message' => 'Data konsultasi berhasil diperbarui'
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
        $konsultasi = $this->model->find($id);

        if (!$konsultasi) {
            return $this->failNotFound('Data konsultasi tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data konsultasi berhasil dihapus'
        ]);
    }
}

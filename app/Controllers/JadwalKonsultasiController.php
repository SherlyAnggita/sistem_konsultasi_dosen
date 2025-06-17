<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class JadwalKonsultasiController extends ResourceController
{
    protected $modelName = 'App\Models\JadwalKonsultasiModel';
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
            'data_jadwal' => $this->model->findAll()
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
        $jadwal = $this->model->find($id);

        if (!$jadwal) {
            return $this->failNotFound('Data jadwal tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'jadwal_byid' => $jadwal
        ], 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true); // true = convert to array

        $rules = $this->validate([
            'id_dosen' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

       $this->model->insert([
            'id_dosen' => $data['id_dosen'],
            'tanggal' => $data['tanggal'],
            'jam_mulai' => $data['jam_selesai'],
            'jam_selesai' => $data['jam_selesai'],
            'ruang' => $data['ruang'],
        ]);

        return $this->respondCreated([
            'message' => 'Data jadwal konsultasi berhasil ditambahkan'
        ]);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $jadwal = $this->model->find($id);

        if (!$jadwal) {
            return $this->failNotFound('Data jadwal tidak ditemukan');
        }


        $rules = $this->validate([
            'id_dosen' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'id_dosen' => $this->request->getVar('id_dosen'),
            'tanggal' => $this->request->getVar('tanggal'),
            'jam_mulai' => $this->request->getVar('jam_mulai'),
            'jam_selesai' => $this->request->getVar('jam_selesai'),
            'ruang' => $this->request->getVar('ruang'),
        ]);

        return $this->respond([
            'message' => 'Data jadwal konsultasi berhasil diperbarui'
        ], 200);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $jadwal = $this->model->find($id);

        if (!$jadwal) {
            return $this->failNotFound('Data jadwal tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data jadwal konsultasi berhasil dihapus'
        ]);
    }
}

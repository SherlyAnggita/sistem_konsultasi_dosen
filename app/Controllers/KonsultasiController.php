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
        // 'status' tidak perlu divalidasi, karena kita akan set default-nya sendiri
    ]);

    if (!$rules) {
        return $this->failValidationErrors([
            'message' => $this->validator->getErrors()
        ]);
    }

    $data['status'] = 'menunggu'; // Set default status

    $this->model->insert($data);

    return $this->respondCreated([
        'message' => 'Data konsultasi berhasil ditambahkan',
        'data' => $data
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

    $data = $this->request->getJSON(true);

    // Debug log sementara
    log_message('debug', 'DATA MASUK: ' . json_encode($data));

    if (!isset($data['status']) || !in_array($data['status'], ['disetujui', 'ditolak'])) {
        return $this->failValidationErrors([
            'status' => '"disetujui" atau "ditolak"'
        ]);
    }

    $this->model->protect(false)->update($id, ['status' => $data['status']]);


    return $this->respond([
        'message' => 'Status konsultasi berhasil diperbarui',
        'status' => $data['status']
    ]);
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

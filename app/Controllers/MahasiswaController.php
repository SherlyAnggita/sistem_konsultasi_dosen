<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MahasiswaController extends ResourceController
{
    protected $modelName = 'App\Models\MahasiswaModel';
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
            'data_Mahasiswa' => $this->model->findAll()
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
        $Mahasiswa = $this->model->find($id);

        if (!$Mahasiswa) {
            return $this->failNotFound('Data Mahasiswa tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'Mahasiswa_byid' => $Mahasiswa
        ], 200);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true); // true = return as array

        $rules = $this->validate([
            'id_user' => 'required',
            'NPM' => 'required',
            'nama_mhs' => 'required',
            'kelas_mhs' => 'required',
            'prodi_mhs' => 'required',
            'jurusan_mhs' => 'required'
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert([
            'id_user' => $data['id_user'],
            'NPM' => $data['NPM'],
            'nama_mhs' => $data['nama_mhs'],
            'kelas_mhs' => $data['kelas_mhs'],
            'prodi_mhs' => $data['prodi_mhs'],
            'jurusan_mhs' => $data['jurusan_mhs']
        ]);

        return $this->respondCreated([
            'message' => 'Data Mahasiswa berhasil ditambahkan'
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
        $Mahasiswa = $this->model->find($id);

        if (!$Mahasiswa) {
            return $this->failNotFound('Data Mahasiswa tidak ditemukan');
        }

        $rules = $this->validate([
            'nama_mhs' => 'required',
            'id_user' => 'required',
            'NPM'       => 'required',
            'kelas_mhs'       => 'required',
            'prodi_mhs'       => 'required',
            'jurusan_mhs'       => 'required'
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, [
            'id_user' => $this->request->getVar('id_user'),
            'NPM'       => $this->request->getVar('NPM'),
            'nama_mhs' => $this->request->getVar('nama_mhs'),
            'kelas_mhs'       => $this->request->getVar('kelas_mhs'),
            'prodi_mhs'       => $this->request->getVar('prodi_mhs'),
            'jurusan_mhs'       => $this->request->getVar('jurusan_mhs')
        ]);

        return $this->respond([
            'message' => 'Data Mahasiswa berhasil diperbarui'
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
        $Mahasiswa = $this->model->find($id);

        if (!$Mahasiswa) {
            return $this->failNotFound('Data Mahasiswa tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Data Mahasiswa berhasil dihapus'
        ]);
    }
}

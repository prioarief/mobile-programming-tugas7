<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Controllers\RestfulController;
use Config\Services;

use Exception;

$validation = \Config\Services::validation();

class ProdukController extends RestfulController
{
  public function get()
  {
    try {
      $model = new ProdukModel();
      $listProduk = $model->findAll();

      return $this->responseHasil(200, true, $listProduk);
    } catch (Exception $error) {
      var_dump($error);
    }
  }

  public function detail($id = null)
  {
    try {
      $model = new ProdukModel();
      $detaillProduk = $model->where(['id' => $id])->first();
      if (!$detaillProduk) {
        return $this->responseHasil(404, false, 'produk not found');
      }

      return $this->responseHasil(200, true, $detaillProduk);
    } catch (Exception $error) {
      var_dump($error);
    }
  }

  public function delete($id = null)
  {
    try {
      $model = new ProdukModel();
      $detaillProduk = $model->where(['id' => $id])->first();
      if (!$detaillProduk) {
        return $this->responseHasil(404, false, 'produk not found');
      }

      $model->delete($id);

      return $this->responseHasil(200, true, 'Success Delete Data');
    } catch (Exception $error) {
      var_dump($error);
    }
  }

  public function update($id = null)
  {
    try {
      $model = new ProdukModel();
      $detaillProduk = $model->where(['id' => $id])->first();

      if (!$detaillProduk) {
        return $this->responseHasil(404, false, 'produk not found');
      }

      $data = [
        'nama' => $this->request->getVar('nama'),
        'harga' => $this->request->getVar('harga'),
        'stok' => $this->request->getVar('stok'),
      ];

      $validator = Services::validation();
      $validator->setRules([
        'nama' => 'required',
        'harga' => 'required|integer|greater_than[0]',
        'stok' => 'required|integer|greater_than[0]',
      ]);

      $validation = $validator->run($data);
      if (!$validation) {
        $error = $validator->getErrors();
        return $this->responseHasil(400, false, $error);
      }

      $model->update($id, $data);

      return $this->responseHasil(200, true, 'Success update data');
    } catch (Exception $error) {
      var_dump($error);
    }
  }

  public function create()
  {
    try {
      $data = [
        'nama' => $this->request->getVar('nama'),
        'harga' => $this->request->getVar('harga'),
        'stok' => $this->request->getVar('stok'),
      ];

      $validator = Services::validation();
      $validator->setRules([
        'nama' => 'required',
        'harga' => 'required|integer|greater_than[0]',
        'stok' => 'required|integer|greater_than[0]',
      ]);

      $validation = $validator->run($data);
      if (!$validation) {
        $error = $validator->getErrors();
        return $this->responseHasil(400, false, $error);
      }

      $model = new ProdukModel();
      $model->insert($data);

      return $this->responseHasil(200, true, 'Success Insert Data');
    } catch (Exception $error) {
      var_dump($error);
    }
  }
}

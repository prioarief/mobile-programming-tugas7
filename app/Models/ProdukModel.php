<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model {
  protected $table = 'produk';
  protected $allowedFields = ['nama', 'harga', 'stok'];
};

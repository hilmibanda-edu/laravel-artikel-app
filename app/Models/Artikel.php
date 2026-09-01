<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi melalui form
    protected $fillable = ['judul', 'isi', 'gambar'];
}
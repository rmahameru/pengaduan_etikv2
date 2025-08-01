<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    use HasFactory;

    protected $table = 'masyarakat';

    protected $primaryKey = 'nik';

    public $incrementing = false;

    protected $fillable = [
        'nik',
        'name',
        'username',
        'email',
        'telp',
        'jenis_kelamin',
        'password',
    ];

public function pengaduan()
{
    return $this->hasMany(Pengaduan::class, 'nik', 'nik');
}





}

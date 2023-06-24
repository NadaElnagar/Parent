<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProviderY extends Model
{
    use HasFactory;

    protected $table="data_provider_y";
    protected $fillable = [
        'balance',
        'currency',
        'email',
        'status',
        'created_at',
        'id'
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}

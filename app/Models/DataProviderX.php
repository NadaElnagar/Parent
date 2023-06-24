<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProviderX extends Model
{
    use HasFactory;

    protected $table = "data_provider_x";

    protected $primaryKey = 'id';
    protected $fillable = [
        'parentAmount',
        'currency',
        'parentEmail',
        'statusCode',
        'registerationDate',
        'parentIdentification',
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'parentEmail', 'email');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_name',
        'start_date',
        'end_date',
        'status',
        'description',
        'admin_id',
    ];

    public function adminId() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
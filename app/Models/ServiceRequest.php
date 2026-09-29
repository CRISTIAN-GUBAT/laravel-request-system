<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'requester_name',
        'requester_email',
        'item_name',
        'quantity',
        'purpose',
        'status',
    ];

    protected $guarded = [
        'id',
        'user_id',
        'is_admin',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
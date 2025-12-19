<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'postal_code',
        'phone_number',
        'screen_count',
        'start_date',
        'renewal_date',
        'email',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'renewal_date' => 'date',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable= [
        'name',
        'date_of_birth',
        'nationality',
        'phone',
        'email',
        'address',
        'created_by'
        ];
    protected $hidden = [
        'created_by','updated_by','deleted_by','is_deleted'
    ];
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}

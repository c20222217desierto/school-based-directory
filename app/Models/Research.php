<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'abstract',
        'published_date',
        'status',
        'department_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

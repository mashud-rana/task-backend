<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function assign_to()
    {
        return $this->belongsTo(User::class,'assign_to','id');
    }
}

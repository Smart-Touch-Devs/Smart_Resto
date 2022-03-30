<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeId',
        'dishId',
        'done'
    ];

    public function employeeId() {
        return $this->belongsTo(Employee::class, 'employeeId');
    }

    public function dishes() {
        return $this->belongsTo(Dish::class, 'dishId');
    }
}

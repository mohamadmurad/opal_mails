<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class files extends Model
{
    use HasFactory;
    protected $fillable  = [
        'name',
        'type',
        'size',
        'receipts_id',

    ];



    public function receipts(){

        return $this->belongsTo(receipts::class,'receipts_id','id');

    }

}

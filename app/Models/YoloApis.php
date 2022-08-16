<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoloApis extends Model
{
    use HasFactory;
    protected $table = 'yolo_apis';	
     protected $fillable=['api_type','api_url','request_body','response_data'];
}

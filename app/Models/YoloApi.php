<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YoloApi extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const API_TYPE_SELECT = [
        '1' => 'GET',
        '2' => 'POST',
    ];

    public $table = 'yolo_apis';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'enviroment_id',
        'api_type',
        'url',
        'endpoint',
        'cognito',
        'request_body',
        'response_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function enviroment()
    {
        return $this->belongsTo(Enviroment::class, 'enviroment_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

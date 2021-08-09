<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'name','description', 'creation_date', 'templateformation'
    ];

    protected $table = 'tb_companies';

    public $timestamps = false;

    public function scopeGetCompanyByClient($query) {

        $client = session("client");   

        $company = $query->where("id_creator", $client)->get();
        return $company;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'name','description', 'creation_date', 'templateformation', 'id_creator'
    ];

    protected $table = 'tb_companies';

    public $timestamps = false;

    public function scopeGetCompanyByClient($query) {

        $client = session("client");   
        // if(isset(session("permission")->limited)) {
        //     $company = $query
        //     ->where("id_creator", auth()->user()->id)
        //     ->get();
        // } else {
            if(auth()->user()->type < 2) {
                $company = $query->where("id_creator", $client)
                ->get();
            } else {
                $company = $query->where("id_creator", $client)
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        // }

        return $company;
    }


}

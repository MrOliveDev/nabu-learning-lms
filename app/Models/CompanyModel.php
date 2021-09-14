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
        if(auth()->user()->type != 0) {
            if(auth()->user()->type == 3) {
                $company = $query
                ->where("id_creator", auth()->user()->id)
                ->get();
                
            } else {
                $company = $query->where("id_creator", $client)
                ->orWhere("id_creator", auth()->user()->id)
                ->get();
            }
        } else {
            $company = $query->where("id_creator", $client)
            ->orWhere("id_creator", session("client"))
            ->get();
        }

        return $company;
    }


}

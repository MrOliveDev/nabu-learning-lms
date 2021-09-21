<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrainingsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'id_creator',
        'date_begin',
        'date_end',
        'status',
        'creation_date',
        'templateformation',
        'lesson_content',
        'type',
        'training_icon'
    ];

    protected $table = 'tb_trainings';
    public $timestamps = false;
    use HasFactory;
    public function scopeGetAllTrainings($query)
    {
        return $query->select(
            'tb_trainings.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_trainings.lang', '=', 'tb_languages.language_id')
            ->get();
    }

    public function scopeGetTrainingForTrainingpage($query, $id)
    {
        $result = $query->select(
            'tb_trainings.*',
            'tb_languages.language_iso as language_iso'
        )
            ->leftjoin('tb_languages', 'tb_trainings.lang', '=', 'tb_languages.language_id')
            ->where('tb_trainings.id', $id);
            if(session("user_type") != 0) {
                if(session("user_type") ==3) {
                    $result = $result->where("tb_trainings.id_creator", session("user_id"));
                } else {
                    $result = $result->where("tb_trainings.id_creator", session("client"))
                        ->orWhere("tb_trainings.id_creator", auth()->user()->id);
                }
            } else {
                $result = $result->where("tb_trainings.id_creator", session("client"));
            }
            $result = $result
            ->first();
        return $result;
    }

    // public function scopeGetActivedTrainingForTrainingpage($query, $id)
    // {
    //     $result = $query->select(
    //         'tb_trainings.*',
    //         'tb_languages.language_iso as language_iso'
    //     )
    //         ->leftjoin('tb_languages', 'tb_trainings.lang', '=', 'tb_languages.language_id')
    //         ->join('tb_lesson')
    //         ->whereNotNull(DB::raw("JSON_SEARCH(tb_trainings.contents, 'one', tb_lesson.id)"))
    //         ->where('tb_trainings.id', $id)
    //         ->first();
    //     return $result;
    // }

    public function scopeGetContentData($query, $content_data)
    {
        $groupData = array();
        $studentData = array();
        $teacherData = array();
        if (isset($content_data)) {
            $content = json_decode($content_data);
            $groupList = $content["s"];
            $studentList = $content["t"];
            $teacherList = $content["g"];
            if (count($groupList) != 0) {
                foreach ($groupList as $groupValue) {
                    $groupSubData = array();
                    $groupSubList = $groupValue['item'];
                    if (count($groupSubList) != 0) {
                        foreach ($groupSubList as $groupSubItemValue) {
                            $userItem = User::find($groupSubItemValue);
                            if(isset($userItem)){
                                if(session("user_type")==0 && $userItem->id_creator == session("client")) {
                                    array_push($groupSubItem, $userItem);
                                }  else if($userItem->id_creator == session("client") || $userItem->id_creator == session("user_id")){
                                    array_push($groupSubItem, $userItem);
                                }
                            }
                        }
                    }
                    array_push($groupData, array("value" => $query->find($groupValue['value']), "items"=>$groupSubData));
                }
            }
            if (count($studentList) != 0) {
                foreach ($groupList as $studentValue) {
                    $userItem = User::find($studentValue);
                    if(isset($userItem)){
                        if(session("user_type")==0 && $userItem->id_creator == session("client"))
                        {
                            array_push($studentData, $userItem);
                        } else if($userItem->id_creator == session("client") || $userItem->id_creator == session("user_id")){
                            array_push($studentData, $userItem);
                        }
                    }
                }
            }
            if (count($teacherList) != 0) {
                foreach ($groupList as $teacherValue) {
                    $userItem = User::find($teacherValue);
                    if(isset($userItem)){
                        if(session("user_type")==0 && $userItem->id_creator == session("client"))
                        {
                            array_push($teacherData, $userItem);
                        } else if($userItem->id_creator == session("client") || $userItem->id_creator == session("user_id")){
                            array_push($teacherData, $userItem);
                        }
                    }
                }
            }
        }
        return json_encode(array('group' => $groupData, 'student' => $studentData, 'teacher' => $teacherData));
    }

    public function scopeSetContentData($query, $data)
    {
        // $data = array("s" => array(), "t" => array(array("value"=>234, "item"=>array(123,24)), array("value"=>234, "item"=>array(123,24))));
        $ItemList = json_decode($data);
        $groupList = $ItemList['group'];
        $studentList = $ItemList['student'];
        $teacherList = $ItemList['teacher'];
        $result = json_encode(array("s" => $studentList, "t" => array(array("value"=>234, "item"=>array(123,24)), array("value"=>234, "item"=>array(123,24)))));
        return $result;
    }

    public function scopeGetTrainingByClient($query) {
        $client = session('client');
        if(isset(session("permission")->limited)) {
                $trainings = DB::table("tb_trainings")->leftjoin('tb_languages', "tb_languages.language_id", "=", "tb_trainings.lang")
                ->where("id_creator", auth()->user()->id)
                ->get();
        } else {
            if(auth()->user()->type < 2) {
                $trainings = DB::table("tb_trainings")->leftjoin('tb_languages', "tb_languages.language_id", "=", "tb_trainings.lang")
                ->whereIn("id_creator", User::get_members())
                ->get();
            } else {
                $trainings = DB::table("tb_trainings")->leftjoin('tb_languages', "tb_languages.language_id", "=", "tb_trainings.lang")
                ->where('tb_trainings.id_creator', $client)
                ->orWhere('id_creator', auth()->user()->id)
                ->get();
            }
        }
        return $trainings;
    }
}

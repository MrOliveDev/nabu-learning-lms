<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            ->where('tb_trainings.id', $id)
            ->first();
        return $result;
    }

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
                            array_push($groupSubItem, User::find($groupSubItemValue));
                        }
                    }
                    array_push($groupData, array("value" => $query->find($groupValue['value']), "items"=>$groupSubData));
                }
            }
            if (count($studentList) != 0) {
                foreach ($groupList as $studentValue) {
                    array_push($studentData, User::find($studentValue));
                }
            }
            if (count($teacherList) != 0) {
                foreach ($groupList as $teacherValue) {
                    array_push($teacherData, User::find($teacherValue));
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
        $trainings = $query->leftjoin("tb_users", 'tb_users.id', '=', 'tb_trainings.idCreator')->where('tb_trainings.idCreator', $client)->orWhere('tb_user.id_creator', $client)->get();
        return $trainings;
    }

    public function scopeGetTrainingByCreator($query, $id) {
        $trainings = $query->where('idCreator', $id)->get();
        return $trainings;
    }
}

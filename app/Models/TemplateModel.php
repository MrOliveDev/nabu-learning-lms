<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'alpha_id',
        'name',
        'code',
        'id_creator',
        'style',
        'published',
        'creation_date',
        'status',
        'description'
    ];

    protected $table = 'tb_template_html5_edit';

    public $timestamps = false;

    public function getParcoursCoursLang($datas)
    { // Fonction ajax pour recup le parcours dans lire un cours admin player
        $idFrabique = $datas['idfabrique'];
        $lang = $datas['lang'];
        $parcours = 0;
        $tmp_parcours = 9999999;
        $dir = '../../../export_fabrique/products/' . $idFrabique . '/courses/';
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                    $tab_file = explode('_', $file);
                    if (isset($tab_file[2]) && (strtolower($tab_file[2]) == strtolower($lang))) {
                        $intvalparcours = intval($tab_file[1]);
                        if ($intvalparcours < $tmp_parcours) {
                            $tmp_parcours = $intvalparcours;
                            $parcours = $tmp_parcours;
                        }
                    }
                }
                closedir($handle);
            }
        }
        return $parcours; //array('idparcours' => $parcours);
    }
    public function getDefaultTemplate()
    {
        $sql = "SELECT * FROM tb_templates WHERE id=1";
        $result = $this->getDatas($sql);
        if (count($result) > 0) {
            return $result;
        } else
            return FALSE;
    }
    public function getDefaultTemplate_html5edit($alpha_id = '')
    {
        $sql = 'SELECT * FROM tb_template_html5_edit WHERE alpha_id="' . $alpha_id . '"';
        $result = $this->getDatas($sql);
        if (count($result) > 0) {
            return $result;
        } else
            return FALSE;
    }
    public function getTemplatesList($datas = '')
    {
        $id_creator = $_SESSION['user_status'] <= 1 || $_SESSION['user_status'] == 3 ? $_SESSION['user_id'] : $_SESSION['user_creator_id'];

        $sql = "SELECT * FROM tb_templates WHERE id_creator = " . $id_creator;

        $result = $this->getDatas($sql);

        //mail('dorian.arod@gmail.com','test',print_r($result));
        if (count($result) > 0) {
            return $result;
        } else
            return FALSE;
    }
    public function insertTemplate($datas)
    {
        //mail('dorian.arod@gmail.com','test lms',print_r($datas,TRUE));
        $datas = $datas['formdatas'];
        $id_creator = $_SESSION['user_status'] <= 1 || $_SESSION['user_status'] == 3 ? $_SESSION['user_id'] : $_SESSION['user_creator_id'];
        $table = "tb_templates";
        $date = date("Y-m-d H:i:s");
        $alpha_id = md5(uniqid());

        // Creation tb_templates
        $colstr = "(name,description,status,id_creator,creation_date,alpha_id,published)";
        $valstr = '("' . $datas[0]['value'] . '","' . $datas[1]['value'] . '",1,' . $id_creator . ',"' . $date . '","' . $alpha_id . '",0)';
        $sql = " INSERT INTO $table $colstr VALUES $valstr";
        $stmt = $this->db->prepare($sql);
        $execute = $stmt->execute();
        $lastid = $execute;

        // Creation tb_templates_html5
        $table = "tb_template_html5";
        $colstr = "(alpha_id,name,code,id_creator,style)";
        $valstr = '("' . $alpha_id . '","' . $datas[0]['value'] . '","' . $datas[0]['value'] . '",' . $id_creator . ',"")';
        $sql = " INSERT INTO $table $colstr VALUES $valstr";
        $stmt = $this->db->prepare($sql);
        $execute = $stmt->execute();

        // Creation tb_templates_html5_edit
        $default_template = $this->getDefaultTemplate();
        $style = '';
        if ($default_template != FALSE) {
            $default_template_html5_edit = $this->getDefaultTemplate_html5edit($default_template[0]['alpha_id']);
            if ($default_template_html5_edit != FALSE)
                $style = $default_template_html5_edit[0]['style'];
        }
        $table = "tb_template_html5_edit";
        $colstr = "(alpha_id,name,code,id_creator,style,published)";
        $valstr = '("' . $alpha_id . '","' . $datas[0]['value'] . '","' . $datas[0]['value'] . '",' . $id_creator . ',"' . addslashes($style) . '",0)';
        $sql = " INSERT INTO $table $colstr VALUES $valstr";
        $stmt = $this->db->prepare($sql);
        $execute = $stmt->execute();

        return $this->returnResult($lastid, "Unable to update $table table");
    }
    public function deleteTemplate($datas)
    {
        // Empeche la suppression du template par defaut
        if ($datas['id'] == 1)
            return FALSE;

        $sql = "SELECT * FROM tb_templates WHERE id = " . addslashes($datas['id']);
        $res =  $this->getDatas($sql);
        //mail('dorian.arod@gmail.com','test lms',print_r($res,TRUE));
        if (isset($res[0]['alpha_id'])) {
            $alpha_id = $res[0]['alpha_id'];

            $sql = "DELETE FROM tb_templates WHERE alpha_id = '" . $alpha_id . "'";
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            $sql = "DELETE FROM tb_template_html5 WHERE alpha_id = '" . $alpha_id . "'";
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            $sql = "DELETE FROM tb_template_html5_edit WHERE alpha_id = '" . $alpha_id . "'";
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            return $execute;
        } else
            return FALSE;
    }
    public function duplicateTemplate($datas)
    {
        $id_creator = $_SESSION['user_status'] <= 1 || $_SESSION['user_status'] == 3 ? $_SESSION['user_id'] : $_SESSION['user_creator_id'];

        $date = date("Y-m-d H:i:s");
        $alpha_id = md5(uniqid());

        $sql = "SELECT * FROM tb_templates WHERE id = " . addslashes($datas['id']);
        $res = $this->getDatas($sql);
        if (isset($res[0]['alpha_id'])) {
            $sql = 'SELECT * FROM tb_template_html5 WHERE alpha_id = "' . addslashes($res[0]['alpha_id']) . '"';
            $res_html5 = $this->getDatas($sql);
            $sql = 'SELECT * FROM tb_template_html5_edit WHERE alpha_id = "' . addslashes($res[0]['alpha_id']) . '"';
            $res_html5_edit = $this->getDatas($sql);


            //mail('dorian.arod@gmail.com',"test lms",$sql);
            //mail('dorian.arod@gmail.com',"test lms",print_r($res,TRUE));
            //mail('dorian.arod@gmail.com',"test lms",print_r($res_html5,TRUE));
            //mail('dorian.arod@gmail.com',"test lms",print_r($res_html5_edit,TRUE));

            // Creation tb_templates
            $table = "tb_templates";
            $colstr = "(name,description,status,id_creator,creation_date,alpha_id,published)";
            $valstr = '("' . $datas['name'] . '","' . $res[0]['description'] . '",' . $res[0]['status'] . ',' . $id_creator . ',"' . $date . '","' . $alpha_id . '",' . $res[0]['published'] . ')';
            $sql = " INSERT INTO $table $colstr VALUES $valstr";
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            // Creation tb_templates_html5
            $table = "tb_template_html5";
            $colstr = "(alpha_id,name,code,id_creator,style)";
            $valstr = '("' . $alpha_id . '","' . $datas['name'] . '","' . $datas['name'] . '",' . $id_creator . ',"' . addslashes($res_html5[0]['style']) . '")';
            $sql = " INSERT INTO $table $colstr VALUES $valstr";
            //mail('dorian.arod@gmail.com',"test lms",$sql);
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            // Creation tb_templates_html5_edit
            $table = "tb_template_html5_edit";
            $colstr = "(alpha_id,name,code,id_creator,style,published)";
            $valstr = '("' . $alpha_id . '","' . $datas['name'] . '","' . $datas['name'] . '",' . $id_creator . ',"' . addslashes($res_html5_edit[0]['style']) . '",' . $res_html5_edit[0]['published'] . ')';
            $sql = " INSERT INTO $table $colstr VALUES $valstr";
            //mail('dorian.arod@gmail.com',"test lms",$sql);
            $stmt = $this->db->prepare($sql);
            $execute = $stmt->execute();

            return $this->returnResult($execute, "Unable to update $table table");
        } else
            return FALSE;
    }
    /******* DORIAN *******/
}

<?php

class fileSearch
{
    public $flvArray;
    public $mp4Array;

    public function __construct()
    {
        $this->flvArray = array();
        $this->mp4Array = array();
    }

    public function initialize()
    {
        $this->flvArray = array();
        $this->mp4Array = array();
    }

    public function listFolderFiles($dir){
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements

        //var_dump($dir);
        foreach($ffs as $ff){
            $path = $dir.'/'.$ff;
            if(!is_dir($path) )
            {
              $info = pathinfo($path);
              if(strtolower($info['extension']) == 'flv')
              {
                if(file_exists($dir.'/'.$info['filename'].'.mp4'))
                    $this->mp4Array[] = $dir.'/'.$info['filename'].'.mp4';  
                else if(file_exists($dir.'/'.$info['filename'].'.mP4'))
                    $this->mp4Array[] = $dir.'/'.$info['filename'].'.mP4';  
                else if(file_exists($dir.'/'.$info['filename'].'.Mp4'))
                    $this->mp4Array[] = $dir.'/'.$info['filename'].'.Mp4';  
                else if(file_exists($dir.'/'.$info['filename'].'.MP4'))
                    $this->mp4Array[] = $dir.'/'.$info['filename'].'.MP4';
                else
                    $this->flvArray[] = $dir.'/'.$ff;
              }
            } 
            else
             $this->listFolderFiles($path);
        }
    }
}

?>
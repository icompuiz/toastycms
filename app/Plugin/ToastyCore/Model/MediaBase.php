<?php

App::uses('ToastyCoreAppModel', "ToastyCore.Model");
App::uses('MediaDirectory', "ToastyCore.Model");
App::uses("Folder", "Utility");

class MediaBase extends ToastyCoreAppModel {

    public function getPathString($id) {
        $path = $this->getFullPath($id);
        $path = implode(DS, $path);
        $path = "Media" . DS . $path;

        $check = Folder::isSlashTerm($path);

        $path = $check ? $path : $path . DS;

        debug($path);

        return $path;
    }


    public function getParentDirectory($id = null) {

        $id = $this->checkId($id);

        $directory = $this->findById($id);

        $parent = $directory['ParentMediaDirectory'];

        return $parent;
    }

    public function getFullPath($id = null) {


        $dirs = $this->getDirectoryStack($id);

        if (!empty($dirs)) {

            $dir_names = array();
            foreach ($dirs as $dir) {
                $dir_names[] = $dir['name'];
            }

            return $dir_names;

        }

        return array();

    }

    public function getDirectoryStack($id = null) {

        if (!empty($id)) {

            App::uses('MediaDirectory', "ToastyCore.Model");

            $mediaDirectory =  new MediaDirectory();


            $data = $mediaDirectory->findById($id);  


            if (!empty($data)) {


                $dirs[] = $data['MediaDirectory'];


                $pid = $data['ParentMediaDirectory']['id'];


                if (null !== $pid) {

                    do {

                        
                        $data = $mediaDirectory->findById($pid);
                        $dirs[] = $data['MediaDirectory'];

                        $pid = $data['ParentMediaDirectory']['id'];


                    } while ( null !== $pid );

                    $dirs = array_reverse($dirs);


                }
                return $dirs;

            }

        }

        return array();



    }

}

?>
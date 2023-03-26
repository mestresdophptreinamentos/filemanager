<?php

namespace Controller;

/*
 *  [Componente: Gerenciador de Projetos] - Classe responsável por gerenciar uploads do projeto e clonagem de arquivos.
 *  Author: Jeferson Souza
 *  Company: Mestres do PHP Treinamentos
 *  Date: 19/03/2023 às 17:37
 *  Update: 25/03/2023 às 19:44
 *
 *  IDE: PHP STORM
 *  Version: 1.0
 *  PHP: 7.2 ou superior
 *
 *  License: Free (Gratuita) - Não é permitido modificar os dados acima
 *  Homepage: www.mestresdophp.com.br
 * */

use Controller\Files;

class Upload {

    public $counter;

     /**
     * Método público responsável por gerenciar a criação de pastas.
     * @param $dir
     * @return string
     */
    public function Folder($dir) {

        date_default_timezone_set("America/Sao_paulo");

        //Se há necessidade de criar uma pasta então é executado o restante do código abaixo.
        $folderDir = $dir . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if (!is_dir($folderDir) && !file_exists($folderDir)) {
            if (!is_dir($dir) && !file_exists($dir)) {
                mkdir($dir, '0755');
            }

            if (!is_dir($dir . '/' . date('Y')) && !file_exists($dir . '/' . date('Y'))) {
                mkdir($dir . '/' . date('Y'), '0755');
            }

            if (!is_dir($dir . '/' . date('Y') . '/' . date('m')) && !file_exists($dir . '/' . date('Y') . '/' . date('m'))) {
                mkdir($dir . '/' . date('Y') . '/' . date('m'), '0755');
            }

            if (!is_dir($dir . '/' . date('Y') . '/' . date('m') . '/' . date('d'))
                && !file_exists($dir . '/' . date('Y') . '/' . date('m') . '/' . date('d'))) {
                mkdir($dir . '/' . date('Y') . '/' . date('m') . '/' . date('d'), '0755');
            }
        }

        return $folderDir;

    }


    /**
     * Método privado responsável por gerenciar armazenamento de informações do upload de um único arquivo.
     * @param $input_name
     * @return mixed|string
     */
    private function VerifySimple($input_name) {
        $upload = $_FILES[$input_name];
        $fileName = $upload['name'];
        $fileSize = $upload['size'];
        /*$fileType = $upload['type'];
        $fileTemp = $upload['tmp_name'];
        $fileError = $upload['error'];*/
        $fileExt = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        //Verifica se o tamanho do arquivo não ultrapassa 5Mb
        if ($fileSize > 5242880) {
            $response = "Arquivo maior que 5Mb  não é permitido.";
            return $response;
        }

        //Verifica se a extensão do arquivo é do tipo documentos do pacote office, pdf, imagem, vídeo ou áudio.
        if ($fileExt == 'php' || $fileExt == 'js' || $fileExt == 'css' || $fileExt == 'jsp' || $fileExt == 'asp'
            || $fileExt == 'net' || $fileExt == 'exe' || $fileExt == 'bat' || $fileExt == 'msi' || $fileExt == 'cmd'
            || $fileExt == 'shell' || $fileExt == 'ini' || $fileExt == 'py' || $fileExt == 'sql' || $fileExt == 'oft'
            || $fileExt == 'eml' || $fileExt == 'tiff' || $fileExt == 'tif' || $fileExt == 'gif' || $fileExt == 'html'
            || $fileExt == 'htm' || $fileExt == 'xhtml' || $fileExt == 'src' || $fileExt == 'tmp' || $fileExt == 'cab'
            || $fileExt == 'dll' || $fileExt == 'sys' || $fileExt == 'ai' || $fileExt == 'psd' || $fileExt == 'crd'
            || $fileExt == 'raw' || $fileExt == 'jfif' || $fileExt == 'exif' || $fileExt == 'eps' || $fileExt == 'mkv') {

            $response = "Este tipo de arquivo não é permitido.";
            return $response;
        }

        return $upload;
    }

    /**
     * Método privado responsável por gerenciar armazenamento de informações do upload de vários arquivos.
     * @param bool $par
     * @param $count
     * @param $dir
     * @param $input_name
     * @return array|string|void
     */
    private function VerifyMultiple(bool $par = false, $count = '', $dir, $input_name) {
        date_default_timezone_set("America/Sao_paulo");

        if ($par) {
            $explode = '';
            for ($i = 0; $i < $count; $i++) {
                $upload = $_FILES[$input_name];
                $fileName = $upload['name'][$i];
                $fileSize = $upload['size'][$i];
                $fileType = $upload['type'][$i];
                $fileTemp = $upload['tmp_name'][$i];
                //$fileError[$i] = $upload['error'][$i];
                //$fileExt[$i] = mb_strtolower(pathinfo($fileName[$i], PATHINFO_EXTENSION));
                $separator = explode('.', $fileName);
                $fileExt = $separator[1];


                //Verifica se o tamanho do arquivo não ultrapassa 5Mb
                if ($fileSize > 5242880) {
                    $response = "Arquivo {$fileName} é maior que 5Mb  não é permitido.";
                    return $response;
                }

                //Extensões permitidas
                $Extension = ['image/png', 'image/jpeg', 'application/pdf', 'application/octet-stream', 'application/x-zip-compressed',
                   'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                   'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                   'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

                //Verifica se a extensão do arquivo é do tipo documentos do pacote office, pdf, png, jpg, jpeg, rar e zip.
                $verify = '';
                if(!in_array($fileType, $Extension)) {
                    $verify = "{$fileName} - Este tipo de arquivo não é permitido.";
                    echo $verify;
                }

                $newFileName = md5($fileName) . time() . '.' . $fileExt;
                $destination = $dir . $newFileName;

                if (!empty($fileName) && !$verify) {
                    move_uploaded_file($fileTemp, $destination);

                    $response = "count => {$count}, name => {$fileName}, encrypt => {$newFileName}, destination => {$destination}";
                }

                $explode[] = explode(", ", $response);
            }

            return $explode;


        }
    }


    /**
     * Método público responsável por realizar o upload de um único arquivo para seu projeto
     * @param $dir
     * @param $input_name
     * @return array
     */
    public function UploadFile($dir, $input_name, $newFolder = false) {
        ini_get('post_max_size');

       $folderDir = $dir .'/';

        //Se a pasta não existir
        if($newFolder == true || !is_dir($folderDir)){
            $folderDir = $this->Folder($dir);
        }
        
        $upload = $this->VerifySimple($input_name);

        $fileName = $upload['name'];
        $fileTemp = $upload['tmp_name'];
        $fileExt = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $newFileName = md5($fileName) . time() . '.' . $fileExt;
        $destination = $folderDir . $newFileName;

        move_uploaded_file($fileTemp, $destination);

        return['name' => $fileName, 'encrypt' => $newFileName, "destination" => $destination];

    }


    /**
     * Método público responsável por realizar o upload de vários arquivos para seu projeto
     * @param $dir
     * @param $input_name
     * @param $newFolder
     * @return array|string|void
     */
    public function UploadMultiplesFiles($dir, $input_name, $newFolder = false) {
        ini_get('post_max_size');

        $upload = $_FILES[$input_name];

        $count = count($upload['name']);

        //Se a pasta não existir
        if($newFolder === true || !is_dir($dir)) {
            $dir = $this->Folder($dir, $newFolder);
        } else {
            $dir = $dir . '/';
        }

        $uploads = $this->VerifyMultiple(true, $count, $dir, $input_name);

        return $uploads;
    }

    /**
     * Método público responsável por realizar clonagem de arquivos para seu projeto
     * @param array $file
     * @param $DirOrigin
     * @param $DirDest
     * @return bool
     */
    public function CloneFiles(array $file, $DirOrigin, $DirDest, $folder, $subFolder) {

        $Files = new Files();
        $Files -> CreateSubDir($folder, $subFolder);

        $Files = new Files();
        $counter = count($file);

        for ($a = 0; $a < $counter; $a++) {
            $Files->MoveFile([$file[$a]], $DirOrigin, $DirDest);

            $Origin = "{$DirDest}/{$file[$a]}";
            $Dest = "{$DirOrigin}/{$file[$a]}";

            copy($Origin, $Dest);
        }

        return true;

    }

    /**
     * Método público responsável por realizar clonagem de arquivos para seu projeto + remoção + criação de nova pasta
     * @param array $file
     * @param $DirOrigin
     * @param $DirDest
     * @param $folder
     * @param $subFolder
     * @return void
     */
    public function CloneFilesPlus(array $files, $DirOrigin, $DirDest, $folder, $subFolder) {

        $Files = new Files();
        $Files -> CreateSubDir($folder, $subFolder);
        $counter = count($files);

        for ($a = 0; $a < $counter; $a++) {
            $Files->MoveFile([$files[$a]], $DirOrigin, $DirDest);
        }

    }
}

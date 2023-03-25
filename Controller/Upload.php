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


    /**
     * Método público responsável por gerenciar a criação de pastas.
     * @param $dir
     * @return string
     */
    public function Folder($dir) {

        date_default_timezone_set("America/Sao_paulo");

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
     * @return array|string|void
     */
    private function VerifyMultiple(bool $par = false, $count = '', $dir) {
        date_default_timezone_set("America/Sao_paulo");

        if ($par) {
            for ($i = 0; $i < $count; $i++) {
                $upload = $_FILES['attach'];
                $fileName[$i] = $upload['name'][$i];
                $fileSize[$i] = $upload['size'][$i];
                //$fileType[$i] = $upload['type'][$i];
                $fileTemp[$i] = $upload['tmp_name'][$i];
                //$fileError[$i] = $upload['error'][$i];
                $fileExt[$i] = mb_strtolower(pathinfo($fileName[$i], PATHINFO_EXTENSION));

                //Verifica se o tamanho do arquivo não ultrapassa 5Mb
                if ($fileSize[$i] > 5242880) {
                    $response = "Arquivo {$fileName[$i]} é maior que 5Mb  não é permitido.";
                    return $response;
                }

                //Verifica se a extensão do arquivo é do tipo documentos do pacote office, pdf, imagem, vídeo ou áudio.
                if ($fileExt[$i] == 'php' || $fileExt[$i] == 'js' || $fileExt[$i] == 'css' || $fileExt[$i] == 'jsp' || $fileExt[$i] == 'asp'
                    || $fileExt[$i] == 'net' || $fileExt[$i] == 'exe' || $fileExt[$i] == 'bat' || $fileExt[$i] == 'msi' || $fileExt[$i] == 'cmd'
                    || $fileExt[$i] == 'shell' || $fileExt[$i] == 'ini' || $fileExt[$i] == 'py' || $fileExt[$i] == 'sql' || $fileExt[$i] == 'oft'
                    || $fileExt[$i] == 'eml' || $fileExt[$i] == 'tiff' || $fileExt[$i] == 'tif' || $fileExt[$i] == 'gif' || $fileExt[$i] == 'html'
                    || $fileExt[$i] == 'htm' || $fileExt[$i] == 'xhtml' || $fileExt[$i] == 'src' || $fileExt[$i] == 'tmp' || $fileExt[$i] == 'cab'
                    || $fileExt[$i] == 'dll' || $fileExt[$i] == 'sys' || $fileExt[$i] == 'ai' || $fileExt[$i] == 'psd' || $fileExt[$i] == 'crd'
                    || $fileExt[$i] == 'raw' || $fileExt[$i] == 'jfif' || $fileExt[$i] == 'exif' || $fileExt[$i] == 'eps' || $fileExt[$i] == 'mkv') {

                    $response = "{$fileName[$i]} - Este tipo de arquivo não é permitido.";
                    return $response;
                }

                $newFileName[$i] = md5($fileName[$i]) . time() . '.' . $fileExt[$i];

                $folderDir = $dir . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

                $destination[$i] = $folderDir . $newFileName[$i];

                if (!empty($fileName[$i])) {
                    move_uploaded_file($fileTemp[$i], $destination[$i]);

                    $response[] = ['count' => $count, 'name' => $fileName[$i], 'encrypt' => $newFileName[$i], "destination" => $destination[$i]];
                }
            }
            return $response;
        }
    }


    /**
     * Método público responsável por realizar o upload de um único arquivo para seu projeto
     * @param $dir
     * @param $input_name
     * @return array
     */
    public function UploadFile($dir, $input_name) {
        ini_get('post_max_size');

        $folderDir = $this->Folder($dir);
        $upload = $this->VerifySimple($input_name);

        $fileName = $upload['name'];
        $fileTemp = $upload['tmp_name'];
        $fileExt = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $newFileName = md5($fileName).time(). '.' .$fileExt;
        $destination = $folderDir . $newFileName;

        move_uploaded_file($fileTemp, $destination);

        return['name' => $fileName, 'encrypt' => $newFileName, "destination" => $destination];

    }


    /**
     * Método público responsável por realizar o upload de vários arquivos para seu projeto
     * @param $dir
     * @param $input_name
     * @return array|string|void
     */
    public function UploadMultiplesFiles($dir, $input_name) {
        ini_get('post_max_size');

        $upload = $_FILES[$input_name];

        if ($upload != '') {
            $count = count($upload['name']);
        }

        $this->Folder($dir);
        $upload = $this->VerifyMultiple(true, $count, $dir);

        return $upload;
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

        for ($a = 0; $a < count($files); $a++) {
            $Files->MoveFile([$files[$a]], $DirOrigin, $DirDest);
        }

    }
}
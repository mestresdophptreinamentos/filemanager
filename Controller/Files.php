<?php

namespace Controller;

/*
 *  [Componente: Gerenciador de Projetos] - Classe responsável por gerenciar arquivos, pastas e subpastas do projeto.
 *  Author: Jeferson Souza
 *  Company: Mestres do PHP Treinamentos
 *  Date: 19/03/2023 às 17:37
 *  Update: 19/03/2023 às 18:22
 *
 *  IDE: PHP STORM
 *  Version: 1.0
 *  PHP: 7.2 ou superior
 *
 *  License: Free (Gratuita) - Não é permitido modificar os dados acima
 *  Homepage: www.mestresdophp.com.br
 * */

use Controller\Upload;

class Files
{

    public $folder;

    /**
     * Método privado responsável por gerenciar escrita de um arquivo específico.
     * @param $dir
     * @param $file
     * @param $text
     * @return void
     */
    private function mountFileWrite($dir, $file, $text, $newFolder = false) {
        $Upload = new Upload();

        if (is_dir($dir)) {
            $folder = $Upload->Folder($dir, $newFolder);
        }

        //Se o arquivo não existir, cria o mesmo.
        $fopen = fopen($folder . $file, 'w');
        fwrite($fopen, $text);
        fclose($fopen);
    }

    /**
     * Método privado responsável por gerenciar leitura e escrita de um arquivo específico.
     * @param $dir
     * @param $file
     * @param $text
     * @return void
     */
    private function mountFileReadWrite($dir, $text, $newFolder = false) {
        $Upload = new Upload();
        $Upload ->Folder($dir, $newFolder);

        //Se o arquivo não existir, cria o mesmo.
        $fopen = fopen($dir, 'a+');
        fwrite($fopen, PHP_EOL . $text . PHP_EOL);
        fclose($fopen);
    }

    /**
     * Método privado responsável por gerenciar sobreescrita do texto de um arquivo específico.
     * @param $file
     * @param $text
     * @return void
     */
    private function mountFileRewrite($file, $text) {

        //Se o arquivo não existir, cria o mesmo.
        $fopen = fopen($file, 'w');
        fwrite($fopen, PHP_EOL . $text . PHP_EOL);
        fclose($fopen);

        return $fopen;
    }

    /**
     * Método privado responsável por gerenciar leitura em tela de um arquivo específico.
     * @param $dir
     * @param $file
     * @return void
     */
    private function mountFileReadData($dir, $newFolder = false) {
        $Upload = new Upload();
        $Upload ->Folder($dir, $newFolder);

        //Após escrever, abre o arquivo para leitura
        $fread = fopen($dir, 'r');

        //Apresenta em tela o conteúdo do arquivo.
        while ($showData = fgets($fread)) {
            echo "{$showData}<br>";
        }

        fclose($fread);
    }

    /**
     * Método privado responsável por gerenciar criação de múltiplos arquivos.
     * @param $folder
     * @param $dir
     * @param $files
     * @param $count
     * @param $contents
     * @return false|void
     */
    private function FileMultiple($folder, $dir, $files, $count, $contents, $newFolder = false) {
        $Upload = new Upload();
        $Upload ->Folder($folder, $newFolder);

        //Verifica se os arquivos já existem, se sim, retorna false.
        foreach ($files as $file) {
            if (file_exists($dir . '/' . $file)) {
                return false;
            }
        }

        //Cria através do for os arquivos na pasta indicada
        for ($i = 0; $i < $count; $i++) {
            $fopen = fopen($dir . '/' . $files[$i], 'w');
            fwrite($fopen, $contents[$i]);
            fclose($fopen);
        }
    }

    /**
     * Método privado responsável por gerenciar a montagem das pastas do diretório
     * @param $dir
     * @return array
     */
    private function ListFolders($dir) {
        $folder = '';
        $mount = '';

        //Separa as pastas dos arquivos
        $folders = glob("{$dir}/*", GLOB_ONLYDIR);

        //Cálcula o número de pastas
        $calc = count($folders) + 1;

        //Mostra só as pastas da pasta raiz
        foreach ($folders as $arquivos) {
            $folder[] = $arquivos;
            $mount[] = "<b>Pasta do Diretório - '{$dir}':</b><br>&nbsp;&nbsp;&nbsp; <i>* {$arquivos}</i> <br><br>";
        }

        return ['folders' => $folder, 'calc' => $calc, 'mount' => $mount];

    }

    /**
     * Método privado responsável por gerenciar a montagem dos arquivos do diretório
     * @param $dir
     * @return void
     */
    private function ListFiles($dir) {
        //Mostra arquivos da pasta raiz
        foreach (glob("{$dir}/*.*") as $arquivo) {
            echo "<b>Arquivos do Diretório - '{$dir}':</b><br>&nbsp;&nbsp;&nbsp; <i>- {$arquivo}</i><br><br>";
        }
    }

    /**
     * Método público responsável por criar um novo diretório dentro do seu projeto.
     * @param $dir
     * @return bool
     */
    public function CreateDir($dir) {

        //Faz a limpeza da string, se necessário.
        $dirVerify = str_replace("\\", "/", $dir);

        //Verifica se o diretório e se o arquivo não existem no projeto, se não existir cria a pasta.
        if (!is_dir($dirVerify) && !file_exists($dirVerify)) {
            mkdir($dirVerify, "0755");
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método público responsável por criar nova subpasta no seu projeto
     * @param $dir
     * @param $folder
     * @return bool
     */
    public function CreateSubDir($dir, $folder) {

        //Faz a limpeza da string, se necessário.
        $dirVerify = str_replace("\\", "/", $dir);

        //Verifica se o diretório e se o arquivo não existem no projeto, se não existir cria a subpasta.
        if (!is_dir($dirVerify . '/' . $folder) && !file_exists($dirVerify . '/' . $folder)) {
            mkdir($dirVerify . '/' . $folder, "0755");
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método público responsável por criar novo arquivo no projeto.
     * @param $dir
     * @param $file
     * @param $text
     * @return bool
     */
    public function CreateFile($dir, $file = "", $text = "", $newFolder = false) {

        //Verifica se o arquivo existe
        if (file_exists($dir . '/' . $file)) {
            return false;
        }

        $this->mountFileWrite($dir, $file, $text, $newFolder);
        return true;
    }

    /**
     * Método público responsável por criar vários ou múltiplos arquivos no projeto.
     * @param $dir
     * @param array $files
     * @param array $contents
     * @return bool|string
     */
    public function CreateFileMultiple($folder, $dir, array $files, array $contents, $newFolder = false) {

        //Faz a contagem dos arrays dos parâmetros enviados pela aplicação
        $countFiles = count($files);
        $countContents = count($contents);

        //Verifica se os arrays dos parâmetros $files e $contents possuem a mesma quantidade de valores.
        if ($countContents != $countFiles) {
            return '<p> Número de arrays: files e contents não são iguais.</p>';
        }

        $this->FileMultiple($folder, $dir, $files, $countFiles, $contents, $newFolder);
        return true;
    }


    /**
     * Método público responsável por fazer a leitura de um arquivo.
     * @param $file
     * @return false|void
     */
    public function FileRead($file) {

        if (!file_exists($file)) {
            return false;
        }

        $fopen = fopen($file, 'r');

        //Apresenta em tela o conteúdo do arquivo.
        while ($showData = fgets($fopen)) {
            echo "{$showData}<br>";
        }

        fclose($fopen);
    }


    /**
     * Método público responsável pela sobrescrita de novo conteúdo em um arquivo já existente.
     * @param $file
     * @param $text
     * @return void
     */
    public function FileWrite($file, $text, $newFolder = false) {

        $return = $this->mountFileRewrite($file, $text, $newFolder);
        return $return;
    }

    /**
     * Método público responsável por acrescentar nova escrita de novo conteúdo em um arquivo já existente, sem sobreescrevê-lo.
     * @param $dir
     * @param $file
     * @param $text
     * @return void
     */
    public function FileReadWrite($dir, $text, $newFolder = false) {

        $this->mountFileReadWrite($dir, $text, $newFolder);
        $this->mountFileReadData($dir, $newFolder);

    }

    /**
     * Método público responsável por deletar um diretório.
     * @param $dir
     * @return bool
     */
    public function RemoveDir($dir) {

        //Faz a limpeza da string, se necessário.
        $dirVerify = str_replace("\\", "/", $dir);

        //Lista os arquivos e pastas existentes no diretorio alvo e retira da lista o array (. e ..)
        $files = array_diff(scandir($dirVerify), array('.', '..'));

        //Verifica se diretório informado existe e se é um diretório.
        if (is_dir($dirVerify) && file_exists($dirVerify)) {

            //Desmembra os arquivos para ser processado individualmente
            foreach ($files as $file) {
                //Se não existe nenhum arquivo, deleta a pasta
                if (is_dir($dirVerify . "/" . $file)) {
                    delTree($dirVerify . "/" . $file);
                } else {
                    //Se existir arquivo na pasta, faça a exclusão do mesmo, até limpar a pasta.
                    unlink($dirVerify . "/" . $file);
                }
            }

            //Remove o diretório informado.
            rmdir($dir);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método público responsável por excluir um arquivo específico da pasta
     * @param $dir
     * @return bool
     */
    public function RemoveFile($dir) {

        //Faz a limpeza da string, se necessário.
        $dirVerify = str_replace("\\", "/", $dir);

        if (file_exists($dirVerify)) {
            unlink($dirVerify);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método público para deletar determinados os arquivos de uma pasta.
     * @param $dir
     * @param array $files
     * @return bool
     */
    public function RemoveMultipleFiles($dir, array $files) {

        //Faz a limpeza da string, se necessário.
        $dirVerify = str_replace("\\", "/", $dir);

        //Verifica se diretório informado existe.
        if (is_dir($dirVerify) && file_exists($dirVerify)) {
            $counter = count($files);

            //Processa cada um dos arquivos mencionados no parâmetro $files
            for ($a = 0; $a < $counter; $a++) {

                //Se existir o diretório, mas não existir o arquivo, retorna false.
                if (is_dir($dirVerify . "/" . $files[$a]) && !file_exists($dirVerify . "/" . $files[$a])) {
                    return false;
                } else {
                    //Verifica se o arquivo existe, se sim, faz a exclusão.
                    if (file_exists($dirVerify . "/" . $files[$a])) {
                        unlink($dirVerify . "/" . $files[$a]);
                    } else {
                        echo "Esse Arquivo Não Existe: {$files[$a]}<br>";

                    }
                }
            }
        }
        return true;
    }

    /**
     * Método público responsável por mover arquivos entre pastas.
     * @param array $file
     * @param $DirOrigin
     * @param $DirDest
     * @return bool
     */
    public function MoveFile(array $file, $DirOrigin, $DirDest) {

        //Verifica se diretório e o arquivo informado existem.
        if (is_dir($DirOrigin) && file_exists($DirOrigin)) {

            $counter = count($file);
            //Desmembra os arquivos que devem ser movidos de pastas
            for ($a = 0; $a < $counter; $a++) {

                //Atribui-lhes o caminho de origem e de destino.
                $Origin = "{$DirOrigin}/{$file[$a]}";
                $Dest = "{$DirDest}/{$file[$a]}";

                //Arquivos existindo, faz a cópia (copy) do mesmo para a pasta de destino e logo em seguida remove (unlink)
                if (file_exists($Origin)) {
                    copy($Origin, $Dest);
                    unlink($Origin);
                } else {
                    echo "Estes arquivos não existem na pasta de origem: {$file[$a]}<br>";
                }
            }
            return true;

        } else {
            return false;
        }
    }

    /**
     * Método público responsável por renomear a pasta
     * @param $dir
     * @param $rename
     * @return bool
     */
    public function RenameDir($dir, $rename) {

        //Verifica se o diretório e a pasta existe
        if (is_dir($dir) && file_exists($dir)) {

            //Renomeia o diretório (nome atual: $dir) para o (novo nome: $rename).
            rename($dir, $rename);
            return true;

        } else {
            return false;
        }
    }

    /**
     * Método público responsável por renomear arquivo.
     * @param $file
     * @param $rename
     * @return bool
     */
    public function RenameFile($file, $rename) {

        //Verifica se o diretório e a pasta existe
        if (file_exists($file)) {

            //Renomeia o arquivo (nome atual: $file) para o (novo nome: $rename).
            rename($file, $rename);
            return true;

        } else {
            return false;
        }
    }

    /**
     * Método público para listar as pastas, arquivos e primeiras subpastas do diretório selecionado
     * @param $dir
     * @return void
     */
    public function ListDir($dir) {

        $return = $this->ListFolders($dir);
        $folder = $return['folders'];
        $calc   = $return['calc'];

        //Desmembra as pastas do diretório
        for ($a = 0; $a < $calc; $a++) {
            echo $return['mount'][$a];
        }

        $this->ListFiles($dir);

        //Mostra as subpastas e seus arquivos
        for ($i = 0; $i < $calc; $i++) {
            foreach (glob("{$folder[$i]}/*.*") as $arquivo) {

                //Faço o desmembramento dos valores através do explode
                $explode = explode('/', $arquivo);

                //Separo e capturo somente os valores que forem válidos e pertencentes a pasta/subpasta/arquivos
                if ($arquivo == $explode[0] . '/' . $explode[1] . '/' . $explode[2]) {

                    //Monto a apresentação.
                    $mount = $explode[0] . '/' . $explode[1] . '/' . $explode[2];
                    echo "<b>Arquivos da Subpasta - '{$dir}':</b><br>&nbsp;&nbsp;&nbsp;<i>+ {$mount}</i><br><br>";
                }

            }
        }

    }

}

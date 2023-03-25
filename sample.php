<?php

/*
 *  [Componente: Gerenciador de Projetos] - Classe responsável por gerenciar arquivos, pastas e subpastas do projeto.
 *  Author: Jeferson Souza
 *  Company: Mestres do PHP Treinamentos
 *  Date: 19/03/2023 às 18:02
 *  Update: 19/03/2023 às 23:12
 *
 *  IDE: PHP STORM
 *  Version: 1.0
 *  PHP: 7.2 ou superior
 *
 *  License: Free (Gratuito) - Não é permitido modificar os dados acima
 *
 *
 *
 *  ---------------
 *  Instruções em Português:
 *  1. Faça a declaração da classe na página ou utilize o Autoload.php próprio ou se desejar pode utilizar da pasta vendor ( via composer)
 *  2. Crie o objeto  $Files = new Controller\Files(); ou $Upload = new Controller\Upload();
 *  3. Depois só instanciar os métodos, conforme as instruções abaixo:
 *
 *  Instructions in English:
 *  1. Make the class declaration on the page or use the Autoload.php or Autoload.php from the vendor folder (composer)
 *  2. Create the object $Files = new Controller\Files(); or $Upload = new Controller\Upload();
 *  3. Then just instantiate the methods, according to the instructions below:
 *  ---------------
 *
 *  ---------------
 *  Chamando Métodos/Instanciando (Calling Methods/Instantiating)
 *  ---------------
 *
 *  ---------------
 *  Criar novo arquivo (Create New File)
 *  Call (Chamada):  $Files->CreateFile("Documents/Reads/", "read1.txt", "teste3");
 *  ---------------
 *
 *  ---------------
 *  Criar nova pasta (Create New Folder)
 *  Call (Chamada):  $Files -> CreateDir("Documents");
 *  ---------------
 *
 *  ---------------
 *  Criar nova subpasta (Create New SubFolder)
 *  Call (Chamada):  $Files -> CreateSubDir("Documents", "Sample");
 *  ---------------
 *
 *  ---------------
 *  Criar multiplos arquivos (Create Multiples Files)
 *  Variables (Variáveis):
 *  $text1 = "texto 1";
 *  $text2 = "texto 2";
 *  $text3 = "texto 3";
 *
 *  Call (Chamada):  $Files -> CreateFileMultiple("Documents/", "Documents/2023/", ["read1.txt", "read2.txt", "read3.txt"], [$text1, $text2, $text3]);
 *  ---------------
 *
 *  ---------------
 *  Leitura de Arquivo (Read File)
 *  Call (Chamada):  $Files->FileRead("Documents/read.txt");
 *  ---------------
 *
 *  ---------------
 *  Escrita de Arquivo (Write File)
 *  Call (Chamada):  $Files ->FileWrite("Documents/read.txt", "Estou programando em PHP OO nessa série 1");
 *  ---------------
 *
 *  ---------------
 *  Leitura/Escrita de Arquivo (Read/Write File)
 *  Call (Chamada):  $Files ->FileReadWrite("Documents/read.txt", "Estou programando em PHP OO nessa série 2");
 *  ---------------
 *
 *  ---------------
 *  Remover Pasta (Remove Folder)
 *  Call (Chamada):  $Files->RemoveDir("Documents/Excluir/Subpasta");
 *  ---------------
 *
 *  ---------------
 *  Remover Pasta (Remove Folder)
 *  Call (Chamada):  $Files->RemoveDir("Documents/Excluir/Subpasta");
 *  ---------------
 *
 *  ---------------
 *  Remover Diretório (Remove Directory)
 *  Call (Chamada):
 *  $Files->RemoveDir("Documents/Excluir/Subpasta3");
 *  $Files->RemoveDir("Documents/Excluir/Subpasta2");
 *  $Files->RemoveDir("Documents/Excluir/Subpasta1");
 *  $Files->RemoveDir("Documents/Excluir");
 *  ---------------
 *
 *  ---------------
 *  Remover Arquivo (Remove File)
 *  Call (Chamada):  $Files->RemoveFile("Documents/Excluir/read1.txt");
 *  ---------------
 *
 *  ---------------
 *  Remover Múltiplos Arquivos (Remove Multiples Files)
 *  Call (Chamada):  $Files->RemoveMultipleFiles("Documents/Excluir", ['read2.txt', 'read3.txt', 'read4.txt']);
 *  ---------------
 *
 *  ---------------
 *  Mover Arquivos (Move Files)
 *  Call (Chamada):  $Files->MoveFile(["read1.txt", "read2.txt"], "Documents/Excluir", "Documents"));
 *  ---------------
 *
 *  ---------------
 *  Renomear Pasta (Rename Folder)
 *  Call (Chamada):  $Files->RenameDir("Documents/Teste", "Documents/Teste2");
 *  ---------------
 *
 *  ---------------
 *  Renomear Pasta (Rename Folder)
 *  Call (Chamada):  $Files->RenameFile("Documents/Teste2/NovoRead.txt", "Documents/Teste2/Read2.txt");
 *  ---------------
 *
 *  ---------------
 *  Listar Diretório (List: Directory)
 *  Call (Chamada):  $Files->ListDir('Documents');
 *  ---------------
 *
 *  ---------------
 *  Upload de Um Único Arquivo (List: Directory)
 *  Call (Chamada):  $Upload->UploadFile('Folder', 'attach');
 *  Parameter (Parâmetros): 1º Folder name (Nome da pasta), 2ª input name attribute (atributo name do input)
 *
 *  Note (Observação):
 *  - Put the method call inside an if(isset($_POST['btn_sender']))
 *  - Coloque a chamada do método dentro de um if(isset($_POST['btn_sender']))
 *
 *  Return (Retorno)
 *  - The method returns an array with the file name, the encrypted name and the destination path of the image.
 *  - É retornado do método um array com nome do arquivo, com o nome encriptado e com o caminho de destino da imagem.
 *  ---------------
 *
 * ---------------
 *  Upload de Múltiplos Arquivos (List: Directory)
 *  Call (Chamada):  $Upload->UploadMultiplesFiles('Folder', 'attach');
 *  Parameter (Parâmetros): 1º Folder name (Nome da pasta), 2ª input name attribute (atributo name do input)
 *
 *  Note (Observação):
 *  - Put the method call inside an if(isset($_POST['btn_sender']))
 *  - Coloque a chamada do método dentro de um if(isset($_POST['btn_sender']))
 *
 *  Return (Retorno)
 *  - The method returns an array with the files numbers, file name, the encrypted name and the destination path of the image.
 *  - É retornado do método um array com o número de arquivos, nome do arquivo, com o nome encriptado e com o caminho de destino da imagem.
 *
 *  Instructions (Instruções)
 *  - Create a variable to count the number of files and then use for to display the results.
 *  - Crie uma variável para contar o número de arquivos e depois utilize o for para mostrar os resultados.
 *
 *  Example (Exemplo):
 * if(isset($_POST['send'])) {
   $Return = $Upload->UploadMultiplesFiles('Uploads', 'attach');

   $counter = count($Return);

   for($i = 0; $i < $counter; $i++){
       $name = $Return[$i]['name'];
       $encrypt = $Return[$i]['encrypt'];
       $destination = $Return[$i]['destination']."<br><br>";
       var_dump($name, $encrypt, $destination);
   }
}
 *  ---------------
 *
 * ---------------
 *  Clonar Arquivos Sem Removê-los (List: Clone Files - No remove files)
 *  Call (Chamada):  $Upload->CloneFiles(["image1.png", "image2.png"], 'Uploads/2023/03/19', "Uploads/2023/March", "Uploads/2023", "March")
 *
 *  Parameter (Parâmetros): 1º Files you want to clone (Arquivos que deseja clonar),
 *      2ª source folder, from where you will clone the files (pasta de origem, de onde você vai clonar os arquivos)
 *      3ª destination folder, where to clone the files (pasta de destino, para onde vai clonar os arquivos)
 *      4º diretório onde deseja criar uma pasta (directory where you want to create a folder)
 *      5º nome da pasta que deseja criar a pasta (name of the folder you want to create the folder)
 *
 *  Note (Observação):
 *  - As soon as possible, we will improve this method.
 *  - Assim que possível, iremos melhorar esse método.
 *  ---------------
 *
 *  ---------------
 *  Clonar Arquivos com Exclusão dos Arquivos (List: Clone Files - With remove files)
 *  Call (Chamada):  $Upload->CloneFilesPlus(["image1.png", "image2.png"], 'Uploads/2023/03/19', "Uploads/2023/March", "Uploads/2023", "March")
 *
 *  Parameter (Parâmetros): 1º Files you want to clone (Arquivos que deseja clonar),
 *      2ª source folder, from where you will clone the files (pasta de origem, de onde você vai clonar os arquivos)
 *      3ª destination folder, where to clone the files (pasta de destino, para onde vai clonar os arquivos)
 *      4º diretório onde deseja criar uma pasta (directory where you want to create a folder)
 *      5º nome da pasta que deseja criar a pasta (name of the folder you want to create the folder)
 *
 *  Note (Observação):
 *  - As soon as possible, we will improve this method.
 *  - Assim que possível, iremos melhorar esse método.
 *  ---------------
 * */

# **filemanager**
Gerenciador de arquivos desenvolvido em PHP 7 - É um conjunto de métodos responsáveis por gerenciar pastas, arquivos e diretórios. Estamos na primeira versão dessa aplicação.

File manager developed in PHP 7 - It is a set of methods responsible for managing folders, files and directories. We are in the first version of this application.


## **Instalação (Installation)**

FileManager está disponível via composer:

FileManager is available via Composer:

`
"mestresdophp/filemanager": "1.0.*"
`

or run

`
composer require mestresdophp/filemanager
`


## **Documentação (Documentation)**

Para maiores detalhes de como utilizar a aplicação, criamos um arquivo chamado sample.php que contém todas as formas de chamar os métodos, bem como seus parâmetros que devem ser utilizados.

For more details on how to use the application, we created a file called sample.php that contains all the ways to call the methods, as well as their parameters that must be used.

Exemplo 1: Chamada de Método de Criação de Arquivo: 

Example 1: File Creation Method Call:

`
$Files = new Controller\Files();

$Files->CreateFile("Documents/Reads/", "read1.txt", "teste3");
`

Parametros ("Caminho para a pasta", "Nome do Arquivo", "Conteúdo que será escrito no arquivo");

Parameters ("Path to the folder", "File name", "Content that will be written in the file");

Exemplo 2: Chamada de Método de Upload de Único Arquivo:

Example 2: Single File Upload Method Call:

`$Upload = new Controller\Upload();
 $Upload->UploadFile('Uploads', 'attach');`
 
 Parametros: ('Nome da Pasta ', 'o atributo Name do input files');
 
 Parameters: ('Folder Name ', 'the Name attribute of the input files');
 
 Observação: É importante que se coloque a chamada do Upload dentro da instrução abaixo para evitar que o método seja executado sem submeter o formulário:
 
 Note: It is important to place the Upload call within the statement below to prevent the method from being executed without submitting the form:
 
 `if(isset($_POST['send'])) {
 
    $Upload->UploadFile('Uploads', 'attach');
    
 }`


## **Suporte (Support)**

Se você encontrar algum problema de segurança, erro, bug ou qualquer outra coisa que comprometa o funcionamento, por favor, nos encaminhe um e-mail para [contato@mestresdophp.com.br](contato@mestresdophp.com.br) .

If you find any security problem, error, bug or anything else that compromises the operation, please send us an email to [contato@mestresdophp.com.br](contato@mestresdophp.com.br)  .


## **Créditos (Credits)**

Jeferson Souza (Developer)

Mestres do PHP Treinamentos (Team)


## **Licença (License)**

The MIT License (MIT).

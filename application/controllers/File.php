<?php
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
class File extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('File_model');
    }
    public function index(){
        $this->load->view('/file/fileIns');
    }
    public function fileIns(){
        if($_FILES != []){
            $fileName = md5($_FILES['file']['name'] . time());						//назначение уникального имени
            $endNameFile = explode('.', $_FILES['file']['name']);				//получение расширения
            $structure = 'img/' . $fileName[0] . '/';									//подготовка директории для записи файла
            if(!file_exists($structure)){												//проверить наличие папки, если нету - создать
                mkdir($structure, 0777, true);							//создание папки
            }
            $uploadfile = $structure . $fileName . '.' . end($endNameFile);		//получение полного адреса (с именем и расширением)
            if($_FILES["file"]["error"] == 0){											//если файл получен без ошибок
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {		//записать по указанному адресу
                                                                                        //вставка файла
                    $rez = $this -> File_model -> insertFile($uploadfile, $_FILES['file']['name'], $_FILES['file']['size']);
                    if($rez){                                                           //если успешно ...
                        echo '<p>Файл успешно загружен</p><p><a href="/regAuth/page2">Ссылка на 2-ю страницу</a></p>';
                    }
                }
            }
            else {
                echo '<p>Файл не загружен. Ошибка ' . $_FILES["file"]["error"] . '</p>';//если возникла ошибка, вывести код ошибки
                echo '<p><a href="/regAuth/page2">Ссылка на 2-ю страницу</a></p>';
            }
        }
    }
    public function fileList(){
        $rez = $this -> File_model -> showFile();
//        echo '<pre>';
//        print_r($rez);
        $this->load->view('/file/fileList', $rez);
    }
    public function fileDel($userID, $fileID){
        if(!empty($userID) && !empty($fileID)){
            $del = $this->File_model->delFile($userID, $fileID);
            if($del == true){
                $this->fileList();
            }
            else{
                $this->fileList();
            }
        }
        else{
//            $this->fileList();
        }
    }
}
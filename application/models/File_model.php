<?php
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
class File_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        session_start();
    }
    public function insertFile($adres,$name,$size){
        $data = array(
            'adres' => $adres,
            'name' => $name,
            'size' => $size,
            'userID' => $_SESSION['id']
        );
        return $this->db->insert('file', $data);
    }
    public function showFile(){
        $this->db->where('id', $_SESSION['id']);                //получение данных пользователя
        $this->db->select('login');
        $query = $this->db->get('users');
        $rez['login'] = $query->result_array()[0]['login'];
        $this->db->select('file.*,users.login');
        $this->db->from('file');
        $this->db->join('users', 'users.id = file.userID');
        $query = $this->db->get();
        $mas = [];
        foreach ($query->result() as $row)                      //подготовка списка файлов к выводу
        {
            $mas[] = $row;
        }
        $rez['file'] = $mas;
        return $rez;
    }
    public function delFile($userID, $fileID)
    {
        if ($userID == $_SESSION['id']) {                       //проверка пользователя
            $this->db->where('id', $fileID);                    //получение задачи пользователя
            $query = $this->db->get('file');
            $mas = $query->result_array();
            if (!empty($mas[0])) {                              //проверка: получена ли задача?
                if ($mas[0]['userID'] == $userID) {             //проверка: получена задача данного пользователя?
                    $this->db->where('id', $fileID);
                    $query = $this->db->delete('file');         //запрос на удаление
                    if ($query == 1) {                          //проверка: выполнено ли удаление?
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
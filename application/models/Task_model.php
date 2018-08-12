<?php
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
class Task_model extends CI_Model
{
    protected $result;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        session_start();
    }

    public function showTask()
    {
        if (!empty($_SESSION['id'])) {
            $this->db->where('id', $_SESSION['id']);                //получение данных пользователя
            $this->db->select('login');
            $query = $this->db->get('users');
            $rez['login'] = $query->result_array()[0]['login'];
            $this->db->where('userID', $_SESSION['id']);            //получение списка задач пользователя
            $query = $this->db->get('task');
            $mas = [];
            foreach ($query->result() as $row)                      //подготовка списка задач к выводу
            {
                $mas[] = $row;
            }
            $rez['task'] = $mas;
//            echo '<pre>';
//            print_r($rez);
//            exit();
            return $rez;
        }
    }

    public function delTask($userID, $taskID)
    {
        $this->db->where('id', $taskID);                    //получение задачи пользователя
        $query = $this->db->get('task');
        $mas = $query->result_array();
        if (empty($mas[0])) {                              //проверка: получена ли задача?
			return false;
		}
        if ($mas[0]['userID'] != $userID) {             //проверка: получена задача данного пользователя?
			return false;
		}
        $this->db->where('id', $taskID);
        $query = $this->db->delete('task');         //запрос на удаление
        if ($query == 1) {                          //проверка: выполнено ли удаление?
            return true;
        } else {
            return false;
        }
    }

    public function insertTask($headTask,$textTask,$deadLine){
        $data = array(
            'headTask' => $headTask,
            'textTask' => $textTask,
            'deadLine' => $deadLine,
            'userID' => $_SESSION['id']
        );
        return $this->db->insert('task', $data);
    }

    public function selTask($taskID){
        $this->db->where('id', $taskID);                    //получение задачи пользователя
        $query = $this->db->get('task');
        $mas = $query->result_array();
        if (!empty($mas[0])) {                              //проверка: получена ли задача?
            return $mas[0];
        }
        else{
            $mas = array(
                'headTask' => '',
                'textTask' => '',
                'deadLine' => ''
            );
            return $mas;
        }
    }

    public function updateTask($taskID, $userID, $headTask, $textTask, $deadLine){
        if ($userID == $_SESSION['id']) {                       //проверка пользователя
            $this->db->where('id', $taskID);                    //получение задачи пользователя
            $query = $this->db->get('task');
            $mas = $query->result_array();
            if (!empty($mas[0])) {                              //проверка: получена ли задача?
                if ($mas[0]['userID'] == $userID) {             //проверка: получена задача данного пользователя?
                    $this->db->where('id', $taskID);
                    $data = array(
						'headTask' => $headTask,
						'textTask' => $textTask,
						'deadLine' => $deadLine
                    );
                    $rez = $this->db->update('task', $data);
                    return $rez;
                }
            }
        }
        return 0;
    }
}
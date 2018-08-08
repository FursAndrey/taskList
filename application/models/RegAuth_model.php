<?php
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
class RegAuth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        session_start();
    }
    public function LI(){
        $auth = 0;
        if(!empty($_SESSION['id'])){
            $auth = 1;
            $this->db->where('id', $_SESSION['id']);
            $query = $this->db->get('users');
        }
        $logIn = [
            'auth' => $auth
        ];
        if($auth){
            $login = $query -> result_array()[0]['login'];
            $logIn['login'] = $login;
        }
        return $logIn;
    }
    public function logOut()
    {
        if(!empty($_SESSION['id'])){
            session_destroy();
            return true;
        }
    }
    public function ra($a = 'e')                                        //процесс авторизации и регистрации
    {
        if ($a == 'auth') {                                             //авторизация
            if ($this->input->post('login') != NULL && $this->input->post('pass') != NULL) {    //если введены логин и пароль
                $this->db->where('login', $this->input->post('login')); //подготовка запроса в базу
                $query = $this->db->get('users');                       //поиск в базе введенного логина
                if (!empty($query->result_array()[0])) {                //если логин существует в базе
                    $pass = md5($_POST['pass']);                        //хеш пароля
                                                                        //если пароль пользователя совпадает с паролем из базы - авторизация
                    if ($query->result_array()[0]['login'] == $this->input->post('login') && $query->result_array()[0]['password'] == $pass) {
                        $_SESSION['id'] = $query->result_array()[0]['id'];
                        return true;
                    }                                                   //если нет - ошибка
                    if ($query->result_array()[0]['login'] != $_POST['login'] || $query->result_array()[0]['password'] != $pass) {
                        return false;
                    }
                } else {                                                //если логин в базе не найден - ошибка
                    return false;
                }
            }
        }
        else if ($a == 'reg') {                                        //регистрация
            if ($this->input->post('login') != NULL && $this->input->post('pass') != NULL) {        //логин и пароль введены
                $this->db->where('login', $this->input->post('login'));
                $query = $this->db->get('users');
                if (!empty($query->result_array()[0])) {                    //если в базе есть такой логин - ошибка
                    return false;
                } else {                                                    //если логина в базе нет - продолжить регистрацию
                    $pass = md5($this->input->post('pass'));                //хеш пароля
                    $mas = [
                        'login' => $this->input->post('login'),
                        'password' => $pass
                        ];
                    $query = $this->db->insert('users', $mas);              //запрос на добавление данных в базу
                    if(!empty($query)) {
                        if($query == 1) {                                   //если данные добавлены
                            if (!empty($this->db->insert_id())) {           //сохранить ИД пользователя и авториовать
                                $_SESSION['id'] = $this->db->insert_id();
                                return true;
                            }
                        }
                    }
                }
            }
        }
    }
}
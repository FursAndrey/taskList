<?
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
class Task extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Task_model');
    }
    public function index(){
        
    }
    public function taskList(){
        $rez = $this -> Task_model -> showTask();
        $this->load->view('/task/taskList', $rez);
    }
    public function taskDel($userID, $taskID){
        if(!empty($userID) && !empty($taskID)){
            $del = $this->Task_model->delTask($userID, $taskID);
            if($del == true){
                $this->taskList();
            }
            else{
//                $this->taskList();
            }
        }
        else{
//            $this->taskList();
        }
    }

    public function taskInsert(){
        $this->load->view('/task/taskIns');
    }
	private function defData(){
		if ($this->input->post('head') != ''){$headTask = $this->input->post('head');}
		else{$headTask = 'Пустой заголовок';}
		if ($this->input->post('text') != ''){$textTask = $this->input->post('text');}
		else{$textTask = 'Пустой текст';}
		if ($this->input->post('deadLine') != ''){$deadLine = strtotime($this->input->post('deadLine'));}
		else{$deadLine = 0;}
		$rez = [];
		$rez['head']=$headTask;
		$rez['text']=$textTask;
		$rez['deadLine']=$deadLine;
		return $rez;
	}
    public function taskIns(){
		$mas = $this->defData();
		$headTask = $mas['head'];
		$textTask = $mas['text'];
		$deadLine = $mas['deadLine'];
        $rez = $this -> Task_model -> insertTask($headTask,$textTask,$deadLine);
    //    $rez = $this -> Task_model -> insertTask($mas);
        if($rez == 1){
            $this->taskList();
        }
        else{

        }
    }
	
	public function taskUpdate($userID, $taskID){
		if($this->input->method(TRUE) == 'GET'){
			$rez = $this -> Task_model -> selTask($taskID);
			$data = [
				'taskID' => $taskID,
				'userID' => $userID,
				'rez' => $rez
				];
			$this->load->view('/task/taskUpdate', $data);
		}
		else if($this->input->method(TRUE) == 'POST'){
			$mas = $this->defData();
			$headTask = $mas['head'];
			$textTask = $mas['text'];
			$deadLine = $mas['deadLine'];
			$rez = $this -> Task_model -> updateTask($taskID, $userID, $headTask, $textTask, $deadLine);
		//	$rez = $this -> Task_model -> updateTask($taskID, $userID, $mas);
			if($rez == 1){
				$this->taskList();
			}
			else{

			}
		}
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 /**
     * author: Joney Sousa 
     * email: joneysousa@yahoo.com.br
     * 
     */
	 
	public function __construct() {
        parent::__construct();
        $this->load->model('redua','',TRUE);
        
    }
	 
	public function index()
	{
		$this->load->view('home');
	}
	
	public function login()
	{
		$this->load->view('login');
	}
	
	public function about()
	{
		$this->load->view('about');
	}
	
	public function services()
	{
		$this->load->view('services');
	}
	
	public function contact()
	{
		$this->load->view('contact');
	}
	
	public function verificarLogin(){
        
        header('Access-Control-Allow-Origin: '.base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','E-mail','valid_email|required|trim');
        $this->form_validation->set_rules('senha','Senha','required|trim');
        if ($this->form_validation->run() == false) {
            $json = array('result' => false, 'message' => validation_errors());
            echo json_encode($json);
        }
        else {
            $email = $this->input->post('email');
            $password = $this->input->post('senha');
            $this->load->model('Mapos_model');
            $user = $this->Mapos_model->check_credentials($email);

            if($user){
                if(password_verify($password, $user->senha)){
                    $session_data = array('nome' => $user->nome, 'email' => $user->email, 'id' => $user->idUsuarios,'permissao' => $user->permissoes_id , 'logado' => TRUE);
                    $this->session->set_userdata($session_data);
                    $json = array('result' => true);
                    echo json_encode($json);
                }
                else{
                    $json = array('result' => false, 'message' => 'Os dados de acesso estão incorretos.');
                    echo json_encode($json);
                }
            }
            else{
                $json = array('result' => false, 'message' => 'Usuário não encontrado, verifique se suas credenciais estão corretass.');
                echo json_encode($json);
            }
        }
        die();
    }
	
	public function sair(){
        $this->session->sess_destroy();
        redirect('mapos/login');
    }
}
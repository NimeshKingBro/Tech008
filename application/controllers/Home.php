<?php
class Home extends Tech008_Controller{

    public function index(){
        // $data['hello'] =$this->session->userdata('test');
        // $this->load->view('templates/header');
        // $this->load->view('homePage',$data);
        // $this->load->view('templates/footer');
        // Load the model for questions

        $this->load->model('QuestionModel');
        // Fetch all questions from the database
        $data['questions'] = $this->QuestionModel->getAllQuestions();

        $this->load->view('templates/header');
        $this->load->view('homePage', $data);
        $this->load->view('templates/footer');

    }
}
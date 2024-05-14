<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answers extends Tech008_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AnswerModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    public function add_answer() {
        $this->output->set_content_type('application/json');

        $userId = $this->session->userdata('userId');
        if (!$userId) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
                return;
            } else {
                redirect('login');
            }
        }
        $answer_data = array(
            'body' => $this->input->post('body', TRUE),
            'question_id' => $this->input->post('question_id', TRUE),
            'user_id' => $userId,
            'Date_answered' => date('Y-m-d H:i:s')
        );

        $this->AnswerModel->apply_answer($answer_data);

        try {
            $response = ['status' => 'success', 'message' => "Successfully Posted"];
            echo json_encode($response);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Server error']);
        }
        return;
    }

    public function change_vote_answer($answer_id, $type) {
        if (!$this->session->userdata('isUserLoggedIn')) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        if ($type == 'up') {
            $this->AnswerModel->increase_answer_votes($answer_id);
        } elseif ($type == 'down') {
            $this->AnswerModel->decrease_answer_votes($answer_id);
        }
    
        echo json_encode(['status' => 'success', 'message' => 'Vote updated']);
    }
    





}

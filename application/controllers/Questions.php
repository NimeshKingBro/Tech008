<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends Tech008_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper(array('form', 'url'));
    }

    public function create()
    {
        $this->load->view('templates/header');
        $this->load->view('askQuestionPage');
        $this->load->view('templates/footer');
    }


    public function question_info($question_id) {
        $this->QuestionModel->increment_views($question_id);
        $this->load->model('AnswerModel');
        
        $data['question'] = $this->QuestionModel->get_question_by_id($question_id);
        
        $data['answers'] = $this->AnswerModel->get_answers_by_question_id($question_id);
        
        $this->load->view('templates/header');
        $this->load->view('questionDetails', $data);
        $this->load->view('templates/footer');
    }

    public function search_questions() {
        $search_term = $this->input->get('search', TRUE);
        $data['searchedFor'] = $search_term;

        $data['results'] = $this->QuestionModel->search_questions($search_term);

        $this->load->view('templates/header');
        $this->load->view('search_results', $data);
        $this->load->view('templates/footer');
    }


    
    
    public function add_question_test(){

        $userId = $this->session->userdata('userId');
        if (!$userId) {
            $responseData = array(
                'success' => true,
                'condition' => 'D', 
                'message' => 'Error'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
            return;

        }

        $title = $this->input->post('title');
        $body = $this->input->post('body');
        $tags = $this->input->post('tags');

        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; 

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $imagePath = 'uploads/' . $uploadData['file_name'];
            } 
            else {
 
                $responseData = array(
                    'success' => true,
                    'condition' => 'C', 
                    'message' => 'Error',
                    'error' => $this->upload->display_errors()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
                return; 
            }
        }

            $questionData = array(
                'title' => $title,
                'body' => $body,
                'tags' => $tags,
                'votes' => 0, 
                'views' => 0,  
                'answered' => FALSE, 
                'Date_posted' => date('Y-m-d H:i:s'),
                'image' => $imagePath,
                'user_id' => $userId
                
            );

            if ($this->QuestionModel->insert_question($questionData)) {
                $responseData = array(
                    'success' => true,
                    'condition' => 'A',
                    'message' => 'Error'
                );
                
            } else {
                $responseData = array(
                    'success' => false,
                    'condition' => 'B', 
                    'message' => 'Error'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));

           
        }

      
    public function get_filtered_questions() {
            $filter = $this->input->get('filter', TRUE);
        
            $this->load->model('QuestionModel');
        
            switch ($filter) {
                case 'top':
                    $questions = $this->QuestionModel->get_top_questions();
                    break;
                case 'latest':
                    $questions = $this->QuestionModel->get_latest_questions();
                    break;
                case 'unanswered':
                    $questions = $this->QuestionModel->get_unanswered_questions();
                    break;
                default:
                    $questions = $this->QuestionModel->get_questions();
                    break;
            }
        
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($questions));
    }

    public function change_vote_question($question_id, $type) {
        if (!$this->session->userdata('isUserLoggedIn')) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        if ($type == 'up') {
            $this->QuestionModel->increment_question_votes($question_id);
        } elseif ($type == 'down') {
            $this->QuestionModel->decrement_question_votes($question_id);
        }
    
        echo json_encode(['status' => 'success', 'message' => 'Vote updated']);
    }

}
    

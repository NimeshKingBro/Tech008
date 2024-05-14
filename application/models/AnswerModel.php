<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all answers for a specific question with user details
    public function get_answers_by_question_id($question_id) {
        $this->db->select('answers.*, users.fName, users.LName');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'left');
        $this->db->where('answers.question_id', $question_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Insert a new answer into the database
    public function apply_answer($data) {
        return $this->db->insert('answers', $data);
    }


    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING
    
    public function increase_answer_votes($answer_id) {
        $this->db->set('votes', 'votes + 1', FALSE);
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');
    }

    public function decrease_answer_votes($answer_id) {
        $this->db->set('votes', 'votes - 1', FALSE);
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');
    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Profile Page

    public function get_answers_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_answer($answer_id) {
        $this->db->where('answer_id', $answer_id);
        $this->db->delete('answers');
    }


}

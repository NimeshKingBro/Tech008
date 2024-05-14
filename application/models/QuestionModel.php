<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function search_questions($search_term) {
        // Search for questions based on the term in title or body
        $this->db->like('title', $search_term);
        $this->db->or_like('body', $search_term);
        $query = $this->db->get('questions');
        return $query->result_array();
    }

    public function insert_question($data) {
        return $this->db->insert('questions', $data);
    }
    public function getAllQuestions() {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.fName, users.LName');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_latest_questions() {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.fName, users.LName');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->order_by('Date_posted', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_top_questions() {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.fName, users.LName');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->order_by('votes', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_unanswered_questions() {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.fName, users.LName');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->where('answered', FALSE);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_question_by_id($question_id) {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.fName, users.LName');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->where('questions.question_id', $question_id);
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function increment_views($question_id) {
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING

    public function increment_question_votes($question_id) {
        $this->db->set('votes', 'votes + 1', FALSE);
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }

    public function decrement_question_votes($question_id) {
        $this->db->set('votes', 'votes - 1', FALSE);
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Profile Page
    public function get_questions_by_user($user_id) {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count');
        $this->db->from('questions');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->where('questions.user_id', $user_id);
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_question($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->delete('questions');
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //
}

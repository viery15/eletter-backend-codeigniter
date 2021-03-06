<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_format extends CI_Model
{
    private $_table = "eletter.letter_format";

    public function getAll(){
      $this->db->order_by('id','DESC');
      $this->db->where('parent', '0');
      return $this->db->get($this->_table)->result_array();
    }

    public function getAllFormat(){
      $this->db->order_by('id','DESC');
      return $this->db->get($this->_table)->result_array();
    }

    public function getLetterName($id){
      // $this->db->select('name');
      $this->db->where('parent', '0');
      $this->db->where('id', $id);
      return $this->db->get($this->_table)->row();
    }

    public function getById($id) {
      $this->db->where('id', $id);
      return $this->db->get($this->_table)->row();
    }

    public function getLetterNameAll(){
      // $this->db->select('name');
      $this->db->where('parent', '0');
      return $this->db->get($this->_table)->result_array();
    }

    public function getLastIndex($id){
      $this->db->select_max('index');
      // $this->db->order_by('id', 'desc');
      $this->db->
      group_start()
         ->where('id', $id)
         ->or_where('parent', $id)
     ->group_end();
     return $this->db->get($this->_table)->row();
    }

    public function getName($id){
      $this->db->select('name');
      $this->db->where('id', $id);
      return $this->db->get($this->_table)->row();
    }

    public function getTemplate($id){
      $this->db->select('output_template');
      // $this->db->order_by('id', 'desc');
      $this->db->
      group_start()
         ->where('id', $id)
         ->or_where('parent', $id)
     ->group_end();
     $this->db->order_by('index', 'ASC');
     return $this->db->get($this->_table)->result_array();
    }

    public function getParents(){
      $this->db->where('parent', '0');
      return $this->db->get($this->_table)->result_array();
    }

    public function save($input){
      $this->db->insert($this->_table, $input);
      $insert_id = $this->db->insert_id();

      return $insert_id;
    }

    public function delete($id) {
      $this->db->delete($this->_table, array('id' => $id));

      return 'success';
    }

    public function update($id, $input) {
      // $post = $this->input->post();

      $this->db->update($this->_table, $input, array('id' => $id));
    }

}

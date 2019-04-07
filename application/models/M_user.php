<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model
{
    private $_table = "eletter.users";

    public function getAll(){
      $this->db->order_by('id','DESC');
      return $this->db->get($this->_table)->result_array();
    }

    public function getLetterName(){
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
      $this->db->insert_id();
    }

    public function delete($id) {
      $this->db->delete($this->_table, array('id' => $id));
    }

    public function update($id, $input) {
      // $post = $this->input->post();

      $this->db->update($this->_table, $input, array('id' => $id));
    }

}

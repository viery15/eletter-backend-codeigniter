<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_data_format extends CI_Model
{
    private $_table = "eletter.data_format_line";

    public function getAll($id){
      $this->db->select('*');
      $this->db->from('eletter.data_format_line a');
      $this->db->join('eletter.letter_format b', 'b.id=a.letter_format_id', 'left');
      $this->db->join('eletter.component c', 'c.id=a.component_id', 'left');
      $this->db->where('a.letter_format_id', $id);
      return $this->db->get()->result_array();
    }

    

    public function save($input){
      $this->db->insert($this->_table, $input);
    }

    public function deleteByLetterId($id) {
      $this->db->delete($this->_table, array('letter_format_id' => $id));
    }

    public function update($id, $input) {
      // $post = $this->input->post();

      $this->db->update($this->_table, $input, array('id' => $id));
    }

}

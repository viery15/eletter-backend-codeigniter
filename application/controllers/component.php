<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class component extends CI_Controller
{
    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();

        $this->load->model("M_component");
    }

    public function index()
    {
      $data = $this->M_component->getAll();

      echo json_encode($data);
    }

    public function allConfigVariable(){
      // $data = DATA_NIK;
      $data = array_keys(DATA_NIK[0]);

      echo json_encode($data);
    }

    public function config(){
      $variable_name = $this->M_component->getVariableName();
      $config = DATA_NIK[0];
      $i = 0;
      foreach ($config as $key => $value) {
        if ($key != 'nik') {
          $data[$i] = $key;
          $i++;
        }
      }

      // for ($i=0; $i < count($data); $i++) {
      //   foreach ($variable_name as $key => $value) {
      //     if ($data[$i] == $value['variable_name']) {
      //       // echo $data[$i];
      //       unset($data[$i]);
      //       $data = array_values($data);
      //     }
      //   }
      // }

      echo json_encode($data);
    }

    public function variableName(){
      $variable_name = $this->M_component->getVariableName();
      $i = 0;
      foreach ($variable_name as $key) {
        $variable[$i] = $key['variable_name'];
        $i++;
      }

      echo json_encode($variable);

    }

    public function index2()
    {
      $data = $this->M_component->getAll();
      for ($i=0; $i < count($data); $i++) {
        $new_data[$i]['html_basic'] = '';
        foreach ($data[$i] as $key => $value) {
          if ($key == 'html_basic') {
            $attribut = json_decode($data[$i]['html_basic'], true);

            $count_attribut = count($attribut);
            foreach ($attribut as $attribut => $value) {

              if ($attribut != 'name' && $attribut != 'variable_name' && $attribut != 'option') {
                if ($attribut == 'type') {
                  if ($value == 'text' || $value == 'number') {
                    $new_data[$i]['html_basic'] = '<input type="text" class="form-control" ';
                  }
                  elseif ($value == 'textarea') {
                    $new_data[$i]['html_basic'] = '<textarea class="form-control" ';
                  }
                  elseif ($value == 'date') {
                    $new_data[$i]['html_basic'] = '<input type="date" class="form-control" ';
                  }
                }
                if($attribut != 'type' && $attribut != 'option') {
                  $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . $attribut . '="' . $value . '" ';

                }

                $new_data[$i]['attribut'][$attribut] = $value;
              }
              elseif ($attribut == 'option') {
                $new_data[$i]['option'] = $value;
                if ($new_data[$i]['attribut']['type'] == 'radio') {
                  for ($o=0; $o < count($new_data[$i]['option']); $o++) {
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<div class="form-check-inline">';
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<label class="form-check-label">';
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<input type="radio" name="' . $data[$i]['variable_name'] . '" value="' . $new_data[$i]['option'][$o] . '"/>&nbsp; ' . $new_data[$i]['option'][$o];
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '</label></div>';
                  }
                }

                elseif ($new_data[$i]['attribut']['type'] == 'dropdown') {
                  $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<select class="form-control">';
                  for ($o=0; $o < count($new_data[$i]['option']); $o++) {
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<option value="' . $new_data[$i]['option'][$o] . '">' . $new_data[$i]['option'][$o] . '</option>';
                  }
                }

                elseif ($new_data[$i]['attribut']['type'] == 'checkbox') {
                  for ($o=0; $o < count($new_data[$i]['option']); $o++) {
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<div class="form-check-inline">';
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<label class="form-check-label">';
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '<input type="checkbox" name="' . $data[$i]['variable_name'] . '" value="' . $new_data[$i]['option'][$o] . '"/>' . $new_data[$i]['option'][$o];
                    $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '</label></div>';
                  }
                }
              }
            }
          }
          else {
            $new_data[$i][$key] = $data[$i][$key];
          }
        }
        if ($new_data[$i]['attribut']['type'] == 'text' || $new_data[$i]['attribut']['type'] == 'number' || $new_data[$i]['attribut']['type'] == 'date') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '>';
        }
        elseif ($new_data[$i]['attribut']['type'] == 'textarea') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '></textarea>';
        }
        elseif ($new_data[$i]['attribut']['type'] == 'dropdown') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '</select>';
        }
      }

      if (isset($new_data)) {
        echo json_encode($new_data);
      }

    }

    public function delete($id)
    {
      $return = $this->M_component->delete($id);

      if ($return == 'success') {
        $response = [
          'msg' => 'Data '. $id . ' deleted successful'
        ];
      }

      echo json_encode($response);
    }

    public function list_input(){
      include APPPATH.'views/data.php';

      echo json_encode($data_type_input);
    }

    public function create(){
      $post = $this->input->post();

      $input['variable_name'] = $this->input->post('variable_name');
      $input['name'] = $this->input->post('name');
      $input['html_basic'] = json_encode($post);

      echo json_encode($post);

      $status = $this->M_component->save($input);

    }

    public function update($id){
      $post = $this->input->post();
      // print_r($post);
      // print_r($id);

      $input['variable_name'] = $this->input->post('variable_name');
      $input['name'] = $this->input->post('name');
      $input['html_basic'] = json_encode($post);
      //
      print_r($input);
      //
      $status = $this->M_component->update($id,$input);

    }

    //radio button
    public function input_radio(){

      include APPPATH.'views/data.php';
      $post = $this->input->post();
      $type = $this->input->post('type');
      $variable_name = $this->input->post('variable_name');
      $keys = array_keys($data_type_input);

      $option = $this->input->post('option');

      for ($i=0; $i < count($option); $i++) {
        $html[$i] = '<div class="form-check-inline">';
        $html[$i] = $html[$i] . '<label class="form-check-label">';
        $html[$i] = $html[$i] . '<input type="radio" name="' . $variable_name . '" value="' . $option[$i] . '"/>' . $option[$i];
        $html[$i] = $html[$i] . '</label></div>';
      }

      $fix_html = '';

      for ($i=0; $i < count($html); $i++) {
        $fix_html = $fix_html . $html[$i];
      }

      return $fix_html;

    }

    //text, number, password, date
    public function input_text(){

      include APPPATH.'views/data.php';
      $post = $this->input->post();
      $type = $this->input->post('type');
      $variable_name = $this->input->post('variable_name');
      $keys = array_keys($data_type_input);
      $post_keys = array_keys($post);

      for ($i=0; $i < count($keys); $i++) {
        if ($keys[$i] == $type) {
          foreach ($data_type_input[$keys[$i]] as $attribut => $value) {
            for ($j=0; $j < count($post_keys); $j++) {
              if ($attribut == $post_keys[$j]) {
                $list_attribut[$attribut] = $post[$post_keys[$j]];
              }
            }
          }
        }
      }

      if ($type == 'text' || $type == 'number' || $type == 'password' || $type == 'date') {
        $html = '<input type="' . $type . '" ' . 'class="form-control" ';
      }
      elseif ($type == 'textarea') {
        $html = '<textarea class="form-control" ';
      }

      if (isset($list_attribut)) {
        foreach ($list_attribut as $attribut => $value) {
          if ($value != 'false') {
            $html = $html . $attribut . '="' . $value . '" ';
          }
        }
      }

      $html = $html . 'name= "' . $variable_name . '" ';
      $html = $html . '>';

      if ($type == 'textarea') {
        $html = $html . '</textarea>';
      }

      return $html;

    }

    public function input_text2(){
      $post = $this->input->post();
      $type = $this->input->post('type');
      $name = $this->input->post('name');
      $variable_name = $this->input->post('variable_name');
      $post_keys = array_keys($post);

      print_r($post);
    }
}

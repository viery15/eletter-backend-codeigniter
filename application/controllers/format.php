<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class format extends CI_Controller
{
    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();

        $this->load->model("M_component");
        $this->load->model("M_format");
        $this->load->model("M_data_format");
    }

    public function index()
    {
      $data = $this->M_format->getAll();

      echo json_encode($data);
    }

    public function letterFormat(){
      $format = $this->M_format->getLetterName();

      // $i = 0;
      // foreach ($format as $key) {
      //   $format_name[$i] = $key['name'];
      //   $i++;
      // }

      echo json_encode($format);
    }

    public function parent(){
      $parents = $this->M_format->getParents();

      echo json_encode($parents);
    }

    public function formInput($id){
      $data = $this->M_data_format->getAll($id);

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
                    $new_data[$i]['html_basic'] = '<input type="text" class="form-control" id="'.$data[$i]['variable_name'].'"';
                  }
                  elseif ($value == 'textarea') {
                    $new_data[$i]['html_basic'] = '<textarea class="form-control" id="'.$data[$i]['variable_name'].'"';
                  }
                  elseif ($value == 'date') {
                    $new_data[$i]['html_basic'] = '<input type="date" class="form-control" id="'.$data[$i]['variable_name'].'"';
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
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . 'name="'.$new_data[$i]['variable_name'].'">';
        }
        elseif ($new_data[$i]['attribut']['type'] == 'textarea') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . 'name="' . $new_data[$i]['variable_name'] . '"></textarea>';
        }
        elseif ($new_data[$i]['attribut']['type'] == 'dropdown') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '</select>';
        }
      }
      if ($new_data[0]['data_source'] == 'config') {
        $new_data['config']['nik'] = DATA_NIK;
      }

      echo json_encode($new_data);
      // print_r(DATA_NIK);
    }

    public function delete($id){
      $this->M_data_format->deleteByLetterId($id);
      $this->M_format->delete($id);
    }

    public function create(){
      $post = $this->input->post();
      // print_r($post);
      $extract = explode("@",$post['html_output']);

      for ($i=0; $i < count($extract); $i++) {
        $extract[$i] = '@'.$extract[$i];
        $extract[$i] = str_replace("&nbsp;"," ",$extract[$i]);
        $extract[$i] = $this->get_string_between($extract[$i], '@', ' ');
      }


      $input['output_template'] = $post['html_output'];
      if ($post['data_source'] == 'true') {
          $input['data_source'] = 'config';
      }
      if ($post['parent'] == 'true') {
          $input['parent'] = 0;
          $input['index'] = 0;
          $input['name'] = $post['letter_name'];
      }
      elseif ($post['parent'] == 'false') {
        $input['parent'] = $post['parent_id'];
        $index = $this->M_format->getLastIndex($input['parent']);
        $name = $this->M_format->getName($input['parent']);
        $input['index'] = $index->index + 1;
        $input['name'] = $name->name .' '. $input['index'];

      }
      // print_r($index);
      $letter_id = $this->M_format->save($input);
      if ($post['parent'] == 'false') {
        $letter_id = $post['parent_id'];
        $component_exist = $this->M_data_format->getAll($post['parent_id']);
      }
      $input2['letter_format_id'] = $letter_id;

      $variable_name = array_unique($extract);
      $variable_name = array_values($variable_name);
      // print_r($component_exist);

      if ($post['parent'] == 'false') {
        for ($i=1; $i < count($variable_name); $i++) {
          $same = 0;
          for ($j=0; $j < count($component_exist); $j++) {
            if ($variable_name[$i] == $component_exist[$j]['variable_name']) {
              $same++;
              // break;
            }
          }
          if ($same == 0) {
            $id = $this->M_component->getId($variable_name[$i]);
            $input2['component_id'] = $id->id;

            $this->M_data_format->save($input2);
          }

        }
      }

      if ($post['parent'] == 'true') {
        for ($i=1; $i < count($variable_name); $i++) {
            $id = $this->M_component->getId($variable_name[$i]);
            $input2['component_id'] = $id->id;

            $this->M_data_format->save($input2);
        }
      }
    }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function submit(){
      $post = $this->input->post();
      $output_template = $this->M_format->getTemplate($post['letter_id']);

      $pattern = "/\d{4}\-\d{2}\-\d{2}/";

      foreach ($post as $key => $value) {
        if (preg_match($pattern, $post[$key], $matches)) {
           $post[$key] = date('Y-m-d', strtotime($matches[0]));
           if ($post['Indonesian_date'] == 'true') {
             $post[$key] = $this->tgl_indo($post[$key]);
           }
           else {
             $post[$key] = date('d F Y', strtotime($post[$key]));
           }
        }
      }

      // print_r($post);
      extract($post);
      for ($i=0; $i < count($output_template); $i++) {
        $output_template[$i]['output_template'] = str_replace("@","$",$output_template[$i]['output_template']);
        $output_template[$i]['output_template'] = str_replace("\"","'",$output_template[$i]['output_template']);
        $output[$i] = $output_template[$i]['output_template'];
        eval("\$output[$i] = \"$output[$i]\";");
      }
      // print_r($output);
      echo json_encode($output);

    }

    public function tgl_indo($tanggal){
    	$bulan = array (
    		1 =>   'Januari',
    		'Februari',
    		'Maret',
    		'April',
    		'Mei',
    		'Juni',
    		'Juli',
    		'Agustus',
    		'September',
    		'Oktober',
    		'November',
    		'Desember'
    	);
    	$pecahkan = explode('-', $tanggal);
    	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function update($id) {
      $post = $this->input->post();

      print_r($post);
    }


}

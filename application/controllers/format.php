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
        $this->load->model("M_user");
    }

    public function index()
    {
      $data = $this->M_format->getAll();

      echo json_encode($data);
    }

    public function getFormat(){
      $data = $this->M_format->getAll();

      echo json_encode($data);
    }

    public function letterFormat($nik){
      $access = $this->M_user->getAccess($nik);
      if ($access->access != 'all') {
        $access = json_decode($access->access);

        for ($i=0; $i < count($access); $i++) {
          $access[$i] = $this->M_format->getLetterName($access[$i]);
        }
      }
      else {
        $access = $this->M_format->getLetterNameAll();
      }


      echo json_encode($access);
    }

    public function parent(){
      $parents = $this->M_format->getParents();

      echo json_encode($parents);
    }

    public function changenik($dept){
      $temp_nik = DATA_NIK;
      for ($i=0; $i < count($temp_nik); $i++) {
        $temp_nik[$i]['label'] = $temp_nik[$i]['nik'] . ' - ' . $temp_nik[$i]['nama'];
      }

      if ($dept != 'all') {
        $i = 0;
        foreach ($temp_nik as $key) {
          if ($key['department'] == $dept) {
            $response[$i] = $key;
            $i++;
          }
        }
        echo json_encode($response);
      }
      else {
        echo json_encode($temp_nik);
      }
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
                    if ($new_data[0]['data_source'] == 'multiple') {
                      $new_data[$i]['html_basic'] = '<input type="text" class="form-control" id="'.$data[$i]['variable_name'].'" ' . 'name="' . $data[$i]['variable_name'] . '[]"';
                    }
                    else {
                      $new_data[$i]['html_basic'] = '<input type="text" class="form-control" id="'.$data[$i]['variable_name'].'" ';
                    }

                  }
                  elseif ($value == 'textarea') {
                    $new_data[$i]['html_basic'] = '<textarea class="form-control" id="'.$data[$i]['variable_name'].'"';
                  }
                  elseif ($value == 'date') {
                    if ($new_data[0]['data_source'] == 'multiple') {
                      $new_data['date'] = 'true';
                      $new_data[$i]['html_basic'] = '<input type="date" class="form-control" id="'.$data[$i]['variable_name'].'" value="' . date('Y-m-d') . '" ' . 'name="' . $data[$i]['variable_name'] . '[]"';
                    }
                    else {
                      $new_data['date'] = 'true';
                      $new_data[$i]['html_basic'] = '<input type="date" class="form-control" id="'.$data[$i]['variable_name'].'" value="' . date('Y-m-d') . '"';
                    }

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
          $cek = '';
          if (isset($new_data[$i]['attribut']['value'])) {
            $cek = $new_data[$i]['attribut']['value'];
          }

          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . 'name="' . $new_data[$i]['variable_name'] . '">'.$cek.'</textarea>';
        }
        elseif ($new_data[$i]['attribut']['type'] == 'dropdown') {
          $new_data[$i]['html_basic'] = $new_data[$i]['html_basic'] . '</select>';
        }
      }
      if ($new_data[0]['data_source'] == 'single' || $new_data[0]['data_source'] == 'multiple') {
        $new_data['config']['nik'] = DATA_NIK;
        for ($d=0; $d < count($new_data['config']['nik']); $d++) {
          $new_data['config']['nik'][$d]['label'] = $new_data['config']['nik'][$d]['nik'] . ' - ' . $new_data['config']['nik'][$d]['nama'];
        }
        $new_data['data_source'] = $new_data[0]['data_source'];
      }

      $output = str_replace("\"","'",$new_data[0]['output_template']);
      $split = $this->split_output($output);
      $k = 0;
      for ($i=0; $i < count($split); $i++) {
        if (count($split[$i]) == 1) {
          for ($j=0; $j < count($split[$i]); $j++) {
            $split[$i][$j] = str_replace("&nbsp;"," ",$split[$i][$j]);
            $single_component[0] = $this->get_string_between($split[$i][$j], '@', ' ');
            $temp_output = $this->str_replace_first("@","$",$split[$i][$j]);
            while ($single_component[$k] != '') {
              if ($single_component[$k] != '') {
                $k++;
                $single_component[$k] = $this->get_string_between($temp_output, '@', ' ');
                $temp_output = $this->str_replace_first("@","$",$temp_output);
              }
            }
          }
        }
        if (count($split[$i]) > 1) {
          $split[$i][1] = str_replace("&nbsp;"," ",$split[$i][1]);
          $single_component[$k] = $this->get_string_between($split[$i][1], '@', ' ');
          $temp_output = $this->str_replace_first("@","$",$split[$i][1]);
          while ($single_component[$k] != '') {
            if ($single_component[$k] != '') {
              $k++;
              $single_component[$k] = $this->get_string_between($temp_output, '@', ' ');
              $temp_output = $this->str_replace_first("@","$",$temp_output);
            }
          }
        }
      }
      unset($single_component[count($single_component)-1]);

      for ($i=0; $i < count($new_data) - 3; $i++) {
        for ($j=0; $j < count($single_component); $j++) {
          if ($new_data[$i]['variable_name'] == $single_component[$j]) {
            $new_data[$i]['for'] = 'single';
          }
        }
      }
      // print_r($split);
      // print_r($single_component);
      echo json_encode($new_data);
    }

    function str_replace_first($from, $to, $content){

        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
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
      if ($post['data_source'] != '') {
          $input['data_source'] = $post['data_source'];
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

      if ($post['parent'] == 'false') {
        for ($i=1; $i < count($variable_name); $i++) {
          $same = 0;
          for ($j=0; $j < count($component_exist); $j++) {
            if ($variable_name[$i] == $component_exist[$j]['variable_name']) {
              $same++;
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
          if ($variable_name[$i] != 'nik') {
            $id = $this->M_component->getId($variable_name[$i]);
            $input2['component_id'] = $id->id;

            $this->M_data_format->save($input2);
          }
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

    public function month_romawi($month){
      $rom = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
      return $rom[$month-1];
    }

    public function generate_code($code) {
      $dictionary = [
        'year' => date('Y'),
        'm_rom' => $this->month_romawi(date('n')),
        'today' => $this->tgl_indo(date('Y-m-d')),
        'indonesian_day' => 'Senin',
      ];

      for ($i=0; $i < count($code); $i++) {
        foreach ($dictionary as $key => $value) {
          if ($code[$i] == $key) {
            $code[$i] = $value;
          }
        }
      }

      return $code;
    }

    public function submit(){
      $post = $this->input->post();
      if ($post['data_source'] == 'single') {
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

        extract($post);
        for ($i=0; $i < count($output_template); $i++) {
          $output_template[$i]['output_template'] = str_replace("@","$",$output_template[$i]['output_template']);
          $output_template[$i]['output_template'] = str_replace("\"","'",$output_template[$i]['output_template']);
          $output[$i] = $output_template[$i]['output_template'];
          eval("\$output[$i] = \"$output[$i]\";");
        }

        for ($i=0; $i < count($output); $i++) {
          $code = explode("#", $output[$i]);
          $final = $this->generate_code($code);
          $output[$i] = '';
          for ($j=0; $j < count($final); $j++) {
            $output[$i] = $output[$i] . $final[$j];
          }
        }

        // $code = explode("#", $output[0]);
        // $final = $this->generate_code($code);
        //
        // $return[0] = '';
        // for ($i=0; $i < count($final); $i++) {
        //   $return[0] = $return[0] . $final[$i];
        // }
        echo json_encode($output);
        // print_r($final);
      }

      if ($post['data_source'] == 'multiple') {

        $output_template = $this->M_format->getTemplate($post['letter_id']);

        $pattern = "/\d{4}\-\d{2}\-\d{2}/";

        foreach ($post as $key => $value) {
          for ($i=0; $i < count($post[$key]); $i++) {
            if (preg_match($pattern, $post[$key][$i], $matches)) {
               $post[$key][$i] = date('Y-m-d', strtotime($matches[0]));
               if ($post['Indonesian_date'] == 'true') {
                 $post[$key][$i] = $this->tgl_indo($post[$key][$i]);
               }
               else {
                 $post[$key][$i] = date('d F Y', strtotime($post[$key][$i]));
               }
            }
          }

        }

        extract($post);
        foreach ($post as $key => $value1) {
          if (is_array($value1)) {
            $source[$key] = $value1;
          }
        }

        for ($i=0; $i < count($output_template); $i++) {
          $output_template[$i]['output_template'] = str_replace("\"","'",$output_template[$i]['output_template']);
          $output[$i] = $output_template[$i]['output_template'];
        }

        $split = $this->split_output($output[0]);
        for ($i=0; $i < count($split); $i++) {
          if (count($split[$i]) > 1) {
            $split[$i][0] = $this->inject_loop($split[$i][0], $post);

            $temp = str_replace("@","$",$split[$i][1]);
            foreach ($source as $key => $value) {
              if (isset($value[$i])) {
                ${$key} = $value[$i];
              }

            }

            eval("\$temp = \"$temp\";");
            $split[$i][1] = $temp;
          }
          if(count($split[$i]) == 1) {

            $temp = str_replace("@","$",$split[$i][0]);
            foreach ($source as $key => $value) {
              if (isset($value[$i])) {
                ${$key} = $value[$i];
              }
            }

            eval("\$temp = \"$temp\";");
            $split[$i][0] = $temp;

          }
        }

        $response[0] = '';
        for ($i=0; $i < count($split); $i++) {
          for ($j=0; $j < count($split[$i]); $j++) {
            $response[0] = $response[0] . $split[$i][$j];
          }
        }
        // print_r($post);
        echo json_encode($response);
      }
    }

    public function split_output($data){
      $split = explode("<input type='hidden' class='loop' value=''>", $data);
      for ($i=0; $i < count($split); $i++) {
        $split[$i] = explode("<input type='hidden' class='endloop' value=''>", $split[$i]);
      }

      return $split;
    }

    public function inject_loop($for_loop, $post){
      foreach ($post as $key => $value1) {
        if (is_array($value1)) {
          $source[$key] = $value1;
        }
      }

      $response = '';
      $keys = array_keys($source);
      $idx = 1;
      for($i=0; $i < count($post['nik']); $i++) {

        $for_loop = str_replace("@","$",$for_loop);

        $for_loop = str_replace("#idx#",'$idx',$for_loop);
        foreach ($source as $key => $value) {

          if (isset($value[$i])) {
            ${$key} = $value[$i];
          }
        }

        $response = $response . $for_loop;
        eval("\$response = \"$response\";");
        $idx++;
      }

      return $response;
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

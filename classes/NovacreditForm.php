<?php

//  Sample code to connect Novacredit form service.
//
//     try {
//       // Inicialize form class
//       $form = new NovacreditForm(NC_ID);
//       // add form fiels
//       if (!empty($_POST)) {
//         foreach ($_POST as $field_id => $field_value) {
//           $form->addField($field_id, $field_value);
//         }
//       }
//       // send form
//       $form->sendForm();
//     }
//     catch (NovacreditFormException $e) {
//       // get form response
//       $form_response = json_decode($e->getMessage());
//       print '<pre>';
//       print_r($form_response);
//       print '</pre>';
//     }

class NovacreditForm {

  // Novacredit endpoint URL
  const BASE_URL = 'http://www.novacredit.cz/loan_calculator/external_form_json';

  // Site NC id
  private $ncId;

  // Form fields
  private $fields = array();

  // Initialize Novacredit form service
  public function __construct($ncId, $form_type = 1) {
    $this->setNcId($ncId);
    $this->form_type = $form_type;
  }

  // Sets NC id and check well-formedness
  public function setNcId($ncId) {
    if (preg_match('(^[0-9abcdef]{32}$)', $ncId)) {
      $this->ncId = $ncId;
    }
    else {
      throw new NovacreditFormException('NC id ' . $ncId . ' is invalid.');
    }
  }

  // Add form filds to form
  public function addField($field_id, $field_value) {
    $this->fields[$field_id] = $field_value;
  }

  // Creates HTTP request and returns response body
  private function sendRequest($url, $use_ssl = true) {
    $parsed = parse_url($url);

    if ($use_ssl) {
      $fp = fsockopen('ssl://' .$parsed['host'], 443, $errno, $errstr, 5);
    }
    else {
      $fp = fsockopen($parsed['host'], 80, $errno, $errstr, 5);
    }

    if (!$fp) {
      throw new NovacreditFormException($errstr . ' (' . $errno . ')');
    }
    else {
      $return = '';
      $out =  "GET " . $parsed['path'] . "?" . $parsed['query'] . " HTTP/1.1\r\n" .
              "Host: " . $parsed['host'] . "\r\n" .
              "Content-type: application/x-www-form-urlencoded\r\n" .
              "Connection: Close\r\n\r\n";
      fputs($fp, $out);
      while (!feof($fp)) {
          $return .= fgets($fp, 4096);
      }
      fclose($fp);

      $returnParsed = explode("\r\n\r\n", $return);
      return empty($returnParsed[2]) ? '' : trim($returnParsed[2]);
    }
  }

  // Returns domain
  private function getUrl() {
    return self::BASE_URL;
  }

  // Sends request to Novacredit form service and get response
  public function sendForm() {
    // create URL
    $url = $this->getUrl() . '?ncId=' . $this->ncId . '&action=send-form&form_type=' . $this->form_type;

    // add static form fields
    $this->addField('payment_method', 'BT');
    $this->addField('remote_addr', $_SERVER['REMOTE_ADDR']);

    foreach ($this->fields as $field_id => $field_value) {
      $url .= '&fields['.$field_id.']=' . urlencode($field_value);
    }

    // send request and check response
    $contents = $this->sendRequest($url);
    if ($contents == FALSE) {
      throw new NovacreditFormException('Unable to create HTTP request to Novacredit form service');
    }
    else {
      throw new NovacreditFormException($contents);
    }
  }

  // Sends request to Novacredit service and returns array of form filds
  public function getFormFields() {
    // create URL
    $url = $this->getUrl() . '?ncId=' . $this->ncId . '&action=get-form-fields&form_type=' . $this->form_type;

    // send request and check for valid response
    $contents = $this->sendRequest($url);
    if ($contents == FALSE) {
        return FALSE;
    } else {
        return json_decode($contents);
    }
  }

  // Sends request to Novacredit service and returns array of form filds
  public function getFormData() {
    // create URL
    $url = $this->getUrl() . '?ncId=' . $this->ncId . '&action=get-form-data&form_type=' . $this->form_type;

    // send request and check for valid response
    $contents = $this->sendRequest($url);

    if ($contents == FALSE) {
        return FALSE;
    } else {
        return json_decode($contents);
    }
  }

  // Check if form filds if reguired
  public function checFieldIsRequired($field_id) {
    $formFields = $this->getFormFields();
    if (!empty($formFields)) {
      if ($formFields->status == 'return_filds_ok') {
        return ($formFields->data->{$field_id}->required == 1 ? true : false);
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }

  // Sends request to Novacredit service and returns array of client leads data
  public function getLeadsData($count = 100, $order_by = 'DESC', $date_from = null, $date_to = null) {
    // create URL
    $url = $this->getUrl() . '?ncId=' . $this->ncId . '&count=' . $count . '&order_by=' . $order_by . '&date_from=' . $date_from . '&date_to=' . $date_to . '&action=get-leads-data';

    // send request and check for valid response
    $contents = $this->sendRequest($url);
    if ($contents == FALSE) {
        return FALSE;
    } else {
        return json_decode($contents);
    }
  }
}

// Thrown when an service returns an exception
class NovacreditFormException extends Exception {};
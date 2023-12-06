<?php

require_once __DIR__ . '/../classes/NovacreditForm.php';

try {
  // Use your own API key here. And keep it secret!
  $apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
  $form = new NovacreditForm($apiKey);

  // Add form items
  if (!empty($_POST)) {
    foreach ($_POST as $field_id => $field_value) {
      $form->addField($field_id, $field_value);
    }
  }

  // And finally send form to our service.
  $form->sendForm();

  // if it's go this point everything go well
} catch (NovacreditFormException $e) {
  // Something unexpected happened.
  // We can print the message for debug purposes only,
  // DO NOT ever do that on your production environment.
  var_dump($e->getMessage());
}
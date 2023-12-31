Novacredit.cz PHP API
===================================

['Novacredit.cz'](https://www.novacredit.cz/) Lead service API client implementation for PHP.

Examples
--------

You can check working examples in the folder `examples` of this repository.

Usage
-----

Initialize class `NovacreditForm` using
['your API key'](mailto:martin.tuma@bestfornet.cz) (you need to send an email with request for final API key), for testing purposes, you can use these credentials:

- **API key (only for testing):** `64a5a3ed70feb41dcd5889edf1e3db6d`

```php
require_once __DIR__ . '/classes/NovacreditForm.php';

$form = new NovacreditForm('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
```

**Keep in mind that your API key is only yours and it is supposed to be a secret.** Never post your API key to anyone,
never put it into JavaScript or anywhere else. It should live on your server only.

Get the fields to form (type, title, required), price configurator data by loan_amount:

```php
$form->getFormData();
```

Set the fields to form (installments type):

```php
$form->addField('loan_amount', '15000,- Kč');
$form->addField('loan_cost', '11508,- Kč');
$form->addField('number_installments', 6);
$form->addField('loan_total', '26508,- Kč');
$form->addField('loan_return', '06.06.2024');
$form->addField('name', 'Pepa');
$form->addField('last_name', 'Novák');
$form->addField('pin', '30145694');
$form->addField('dni', '30145698');
$form->addField('idn', '30145694');
$form->addField('street', 'Na kopečku 66/3');
$form->addField('city', 'Brno');
$form->addField('zip_code', '23578');
$form->addField('contact_street', 'Dolní 637/6');
$form->addField('contact_city', 'Plzeň 6');
$form->addField('contact_zip_code', '32174');
$form->addField('email', 'vas.email@seznam.cz');
$form->addField('mobile', '777666555');
$form->addField('property_owner', 1);
$form->addField('property_owner_description', 'WV Passat 2015');
$form->addField('motor_vehicle_owner', 0);
$form->addField('motor_vehicle_owner_description', '');
$form->addField('account_number', '77741162/0100');
```

Data payload fields (Installments type)
-------------------

To be able to send form, you have to provide all the required information in the form.
Supported fields are following:

|              Field              |  Type  | Required |                         Notes                        |
|:-------------------------------:|:------:|:--------:|:----------------------------------------------------:|
| apiKey                          | string | yes      | you can obtain this on support email                 |
| loan_amount                     | string | yes      | the value of the loan chosen by the customer         |
| loan_cost                       | string | yes      | the cost of the loan is generated by the system.     |
| number_installments             | int    | yes      | number installments                                  |
| loan_total                      | string | yes      | sum of loan_amount and loan_cost                     |
| loan_return                     | string | yes      | day of loan return in format dd.mm.yyyy              |
| name                            | string | yes      | Customer name                                        |
| last_name                       | string | yes      | Customer last name                                   |
| pin                             | string | yes      | ​personal identification number                       |
| dni                             | string | yes      | company identification number                        |
| idn                             | string | yes      | Identity card number                                 |
| street                          | string | yes      | Customer street                                      |
| city                            | string | yes      | Customer city                                        |
| zip_code                        | string | yes      | Customer zip code                                    |
| contact_street                  | string | no       | Customer contact street                              |
| contact_city                    | string | no       | Customer contact city                                |
| contact_zip                     | string | no       | Customer contact zip code                            |
| email                           | string | yes      | Customer e-mail                                      |
| mobile                          | string | yes      | Customer phone number                                |
| property_owner                  | int    | yes      | 0 / 1 if not or yes                                  |
| property_owner_description      | string | yes      | if property_owner 1 must be filed                    |
| motor_vehicle_owner             | int    | yes      | 0 / 1 if not or yes                                  |
| motor_vehicle_owner_description | string | yes      | if motor_vehicle_owner 1 must be filed               |
| account_number                  | string | yes      | account number with bank code                        |

Set the fields to form (credotax type):

```php
$form->addField('loan_amount', '3000,- Kč');
$form->addField('loan_cost', '750,- Kč');
$form->addField('loan_total', '3750,- Kč');
$form->addField('loan_return', '06.01.2024');
$form->addField('name', 'Pepa');
$form->addField('last_name', 'Novák');
$form->addField('pin', '30145694');
$form->addField('dni', '30145698');
$form->addField('idn', '30145694');
$form->addField('street', 'Na kopečku 66/3');
$form->addField('city', 'Brno');
$form->addField('zip_code', '23578');
$form->addField('contact_street', 'Dolní 637/6');
$form->addField('contact_city', 'Plzeň 6');
$form->addField('contact_zip_code', '32174');
$form->addField('email', 'vas.email@seznam.cz');
$form->addField('mobile', '777666555');
$form->addField('property_owner', 1);
$form->addField('property_owner_description', 'WV Passat 2015');
$form->addField('motor_vehicle_owner', 0);
$form->addField('motor_vehicle_owner_description', '');
$form->addField('account_number', '77741162/0100');
$form->addField('employer', 'Firma s.r.o.');
$form->addField('profession', 'Pozice');
$form->addField('employer_telephone', '147852369');
$form->addField('monthly_net_income', '100');
$form->addField('monthly_expenses', '50');
```

Data payload fields (Credotax type)
-------------------

To be able to send form, you have to provide all the required information in the form.
Supported fields are following:

|              Field              |  Type  | Required |                         Notes                        |
|:-------------------------------:|:------:|:--------:|:----------------------------------------------------:|
| apiKey                          | string | yes      | you can obtain this on support email                 |
| loan_amount                     | string | yes      | the value of the loan chosen by the customer         |
| loan_cost                       | string | yes      | the cost of the loan is generated by the system.     |
| loan_total                      | string | yes      | sum of loan_amount and loan_cost                     |
| loan_return                     | string | yes      | day of loan return in format dd.mm.yyyy              |
| name                            | string | yes      | Customer name                                        |
| last_name                       | string | yes      | Customer last name                                   |
| pin                             | string | yes      | ​personal identification number                       |
| dni                             | string | yes      | company identification number                        |
| idn                             | string | yes      | Identity card number                                 |
| street                          | string | yes      | Customer street                                      |
| city                            | string | yes      | Customer city                                        |
| zip_code                        | string | yes      | Customer zip code                                    |
| contact_street                  | string | no       | Customer contact street                              |
| contact_city                    | string | no       | Customer contact city                                |
| contact_zip                     | string | no       | Customer contact zip code                            |
| email                           | string | yes      | Customer e-mail                                      |
| mobile                          | string | yes      | Customer phone number                                |
| property_owner                  | int    | yes      | 0 / 1 if not or yes                                  |
| property_owner_description      | string | yes      | if property_owner 1 must be filed                    |
| motor_vehicle_owner             | int    | yes      | 0 / 1 if not or yes                                  |
| motor_vehicle_owner_description | string | yes      | if motor_vehicle_owner 1 must be filed               |
| account_number                  | string | yes      | Account number with bank code                        |
| employer                        | string | yes      | Employer company name                                |
| profession                      | string | yes      | profession name                                      |
| employer_telephone              | string | yes      | Employer phone                                       |
| monthly_net_income              | int    | yes      | Net monthly income                                   |
| monthly_expenses                | int    | yes      | Net monthly income                                   |

And finally send request send form data:

```php
$form->sendForm();
```

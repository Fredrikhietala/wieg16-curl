<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.milletech.se/invoicing/export/customers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"name\"\r\n\r\nFredrik\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\nfredrik.hietala@hawco.se\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"age\"\r\n\r\n31\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"occupation\"\r\n\r\nStudent\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        "postman-token: 221cdf1c-c26f-bd08-24a9-54b559694e14"
    ),
));

$response = json_decode(curl_exec($curl), true);
$err = curl_error($curl);

curl_close($curl);

/*if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}*/

$username = "root";
$password = "root";
$db = "customer_info";
$server = "localhost";

$conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($response as $customer) {

    $customer_stm = $conn->prepare("INSERT INTO `customer`(`id`, `email`, `firstname`, `lastname`, `gender`, `customer_activated`, `group_id`, `customer_company`, `default_billing`, `default_shipping`, `is_active`, `created_at`, `updated_at`, `customer_invoice_email`, `customer_extra_text`, `customer_due_date_period`) 
      VALUES (:id, :email, :firstname, :lastname, :gender, :customer_activated, :group_id, :customer_company, :default_billing, :default_shipping, :is_active, :created_at, :updated_at, :customer_invoice_email, :customer_extra_text, :customer_due_date_period)");

    $address_stm = $conn->prepare("INSERT INTO `customer_address`(`id`, `customer_id`, `customer_address_id`, `email`, `firstname`, `lastname`, `postcode`, `street`, `city`, `telephone`, `country_id`, `address_type`, `company`, `country`) 
      VALUES (:id, :customer_id, :customer_address_id, :email, :firstname, :lastname, :postcode, :street, :city, :telephone, :country_id, :address_type, :company, :country)");

    $customer_stm->execute([
        ':id' => $customer['id'],
        ':email' => $customer['email'],
        ':firstname' => $customer['firstname'],
        ':lastname' => $customer['lastname'],
        ':gender' => $customer['gender'],
        ':customer_activated' => $customer['customer_activated'],
        ':group_id' => $customer['group_id'],
        ':customer_company' => $customer['customer_company'],
        ':default_billing' => $customer['default_billing'],
        ':default_shipping' => $customer['default_shipping'],
        ':is_active' => $customer['is_active'],
        ':created_at' => $customer['created_at'],
        ':updated_at' => $customer['updated_at'],
        ':customer_invoice_email' => $customer['customer_invoice_email'],
        ':customer_extra_text' => $customer['customer_extra_text'],
        ':customer_due_date_period' => $customer['customer_due_date_period']
    ]);

    $address_stm->execute([
        ':id' => $customer['address'] ['id'],
        ':customer_id' => $customer['address'] ['customer_id'],
        ':customer_address_id' => $customer['address'] ['customer_address_id'],
        ':email' => $customer['address'] ['email'],
        ':firstname' => $customer['address'] ['firstname'],
        ':lastname' => $customer['address'] ['lastname'],
        ':postcode' => $customer['address'] ['postcode'],
        ':street' => $customer['address'] ['street'],
        ':city' => $customer['address'] ['city'],
        ':telephone' => $customer['address'] ['telephone'],
        ':country_id' => $customer['address'] ['country_id'],
        ':address_type' => $customer['address'] ['address_type'],
        ':company' => $customer['address'] ['company'],
        ':country' => $customer['address'] ['country']
    ]);
}


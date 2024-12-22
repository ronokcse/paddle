<?php
// Paddle API endpoint for generating payment links
session_start();
$apiUrl = "https://sandbox-vendors.paddle.com/api/2.0/product/generate_pay_link";

// Paddle Vendor Details and Dynamic Product Information
$data = [
    "vendor_id" => 5746, // Your Paddle Vendor ID
    "vendor_auth_code" => "f87134e253253e311a22a47f82bfa3761e8a3384005cab0983", // Your Paddle Auth Code
    "title" => "Dynamic Product", // Title of the product
    "prices" => ["USD:18.00"], 
    "webhook_url" => "https/localhost/paddle/paddle_webhook.php", // Webhook URL for transaction fulfillment
    "return_url" => "https:/localhost/paddle", // Redirect URL after successful payment
    "customer_email" => "ronok@gmail.com", // Pre-filled customer email
];
// Convert the data array to query string format
$postFields = http_build_query($data);

// Initialize cURL
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/x-www-form-urlencoded",
    ],
]);

// Execute cURL request
$response = curl_exec($curl);

// Check for cURL errors
$err = curl_error($curl);

// Close the cURL session
curl_close($curl);

// Handle the response
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Decode the JSON response
    $result = json_decode($response, true);
    // echo "<pre>";
    // print_r($result);
    if (isset($result['success']) && $result['success']) {
        header("Location: {$result['response']['url']}");
    } else {
        // Handle API error
        echo "Error: " . $result['error']['message'];
    }
}

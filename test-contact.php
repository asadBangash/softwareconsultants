<?php
/**
 * Simple test to verify contact handler is working
 * Access: https://softwaresconsultants.com/test-contact.php
 */

// Prevent errors from showing
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Set JSON header
header('Content-Type: application/json');

$test_results = [];

// Test 1: Check if PHP is working
$test_results['php_working'] = [
    'status' => 'OK',
    'message' => 'PHP is executing correctly',
    'php_version' => phpversion()
];

// Test 2: Check if mail function exists
$test_results['mail_function'] = [
    'status' => function_exists('mail') ? 'OK' : 'FAILED',
    'message' => function_exists('mail') ? 'PHP mail() function is available' : 'PHP mail() function is NOT available',
    'present' => function_exists('mail')
];

// Test 3: Check if POST data can be received
$test_results['post_capable'] = [
    'status' => 'OK',
    'message' => 'Server can receive POST requests',
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'N/A'
];

// Test 4: Check if file exists
$test_results['contact_handler'] = [
    'status' => file_exists(__DIR__ . '/contact-handler.php') ? 'OK' : 'FAILED',
    'message' => file_exists(__DIR__ . '/contact-handler.php') ? 'contact-handler.php file exists' : 'contact-handler.php NOT found',
    'path' => __DIR__ . '/contact-handler.php'
];

// Test 5: Check php.ini settings for mail
$test_results['mail_config'] = [
    'sendmail_path' => ini_get('sendmail_path'),
    'smtp' => ini_get('SMTP'),
    'smtp_port' => ini_get('smtp_port'),
    'default_charset' => ini_get('default_charset')
];

// Test 6: Try to simulate form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_results['form_data'] = [
        'received' => true,
        'keys' => array_keys($_POST),
        'sample_data' => [
            'firstName' => isset($_POST['firstName']) ? 'OK' : 'MISSING',
            'email' => isset($_POST['email']) ? 'OK' : 'MISSING'
        ]
    ];
} else {
    $test_results['form_data'] = [
        'received' => false,
        'info' => 'Send POST data to test form processing'
    ];
}

// Output results
echo json_encode($test_results, JSON_PRETTY_PRINT);
?>

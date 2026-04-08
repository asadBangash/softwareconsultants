<?php
/**
 * Contact Form Handler with SMTP Integration for Hostinger
 * Handles form validation, sanitization, and email sending via SMTP
 */

// Prevent any output before JSON
ob_start();

// Set error reporting to prevent display
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Custom error handler to catch errors before output
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // Log but don't display - will be sent as JSON later
    error_log("PHP Error [$errno]: $errstr in $errfile on line $errline");
    return true;
});

// Set headers for JSON response FIRST
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Security headers - prevent caching of sensitive data
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Clean output buffer
ob_end_clean();

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(json_encode(['status' => 'ok']));
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Hostinger SMTP Configuration
// SECURITY: These credentials are stored SERVER-SIDE ONLY
// They are NEVER sent to the client/browser
// JavaScript cannot access these constants
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 465); // SSL Port
define('SMTP_SECURE', 'ssl'); 
define('SMTP_USER', 'info@softwaresconsultants.com');
define('SMTP_PASS', 'qaisasadomer@3214');
define('FROM_EMAIL', 'info@softwaresconsultants.com');
define('FROM_NAME', 'Software Consultants LLC');
define('REPLY_TO_EMAIL', 'info@softwaresconsultants.com');

// Retrieve and validate form data
$first_name = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$last_name = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$service = isset($_POST['service']) ? trim($_POST['service']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validation
$errors = [];

if (empty($first_name)) {
    $errors[] = 'First name is required';
}
if (strlen($first_name) < 2 || strlen($first_name) > 50) {
    $errors[] = 'First name must be between 2 and 50 characters';
}

if (empty($last_name)) {
    $errors[] = 'Last name is required';
}
if (strlen($last_name) < 2 || strlen($last_name) > 50) {
    $errors[] = 'Last name must be between 2 and 50 characters';
}

if (empty($email)) {
    $errors[] = 'Email address is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address';
}

if (!empty($phone)) {
    // Basic phone validation - allow common formats
    $phone_pattern = '/^[\d\s\-\+\(\)\.]+$/';
    if (!preg_match($phone_pattern, $phone)) {
        $errors[] = 'Please provide a valid phone number';
    }
}

if (empty($message)) {
    $errors[] = 'Project details message is required';
}
if (strlen($message) < 10 || strlen($message) > 5000) {
    $errors[] = 'Project details must be between 10 and 5000 characters';
}

// If there are validation errors, return them
if (!empty($errors)) {
    http_response_code(400);
    exit(json_encode([
        'success' => false,
        'message' => 'Validation failed',
        'errors' => $errors
    ]));
}

// Sanitize inputs to prevent injection attacks
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
}

$first_name = sanitizeInput($first_name);
$last_name = sanitizeInput($last_name);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$phone = sanitizeInput($phone);
$service = sanitizeInput($service);
$message = sanitizeInput($message);

// Build email content
$email_subject = "New Contact Form Inquiry from {$first_name} {$last_name}";
$email_body = buildEmailBody($first_name, $last_name, $email, $phone, $service, $message);

try {
    // Try to send email via SMTP
    $mail_sent = sendMailViaSMTP($email, $email_subject, $email_body);
    
    if ($mail_sent) {
        // Also send confirmation email to user
        $user_subject = "We Received Your Inquiry - Software Consultants";
        $user_body = buildUserConfirmationEmail($first_name);
        @sendMailViaSMTP($email, $user_subject, $user_body, 'user');
        
        http_response_code(200);
        exit(json_encode([
            'success' => true,
            'message' => 'Thank you for your inquiry! We have received your message and will get back to you within 24 hours.'
        ]));
    } else {
        // Mail failed - provide helpful message
        http_response_code(500);
        exit(json_encode([
            'success' => false,
            'message' => 'We encountered an error while sending your message. Please contact us directly at info@softwaresconsultants.com or call +1 (240) 615-7589'
        ]));
    }
} catch (Exception $e) {
    // Log error for debugging
    error_log('Contact form error: ' . $e->getMessage());
    
    http_response_code(500);
    exit(json_encode([
        'success' => false,
        'message' => 'We encountered an error while processing your request. Please try again or contact us directly at info@softwaresconsultants.com'
    ]));
}

/**
 * Build professional email body for company
 */
function buildEmailBody($first_name, $last_name, $email, $phone, $service, $message) {
    $body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #0F4C81; color: white; padding: 20px; text-align: center; border-radius: 8px; }
        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; border-left: 4px solid #00B4D8; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #0F4C81; }
        .field-value { margin-top: 5px; color: #555; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Inquiry</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="field-label">Name:</div>
                <div class="field-value">{$first_name} {$last_name}</div>
            </div>
            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value"><a href="mailto:{$email}">{$email}</a></div>
            </div>
            <div class="field">
                <div class="field-label">Phone:</div>
                <div class="field-value">{$phone}</div>
            </div>
            <div class="field">
                <div class="field-label">Service of Interest:</div>
                <div class="field-value">{$service}</div>
            </div>
            <div class="field">
                <div class="field-label">Project Details:</div>
                <div class="field-value">{$message}</div>
            </div>
        </div>
        <div class="footer">
            <p>Submitted from: softwaresconsultants.com</p>
            <p>Date: " . date('Y-m-d H:i:s') . "</p>
        </div>
    </div>
</body>
</html>
HTML;
    return $body;
}

/**
 * Build confirmation email for user
 */
function buildUserConfirmationEmail($first_name) {
    $body = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #0F4C81; color: white; padding: 20px; text-align: center; border-radius: 8px; }
        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thank You, {$first_name}!</h2>
        </div>
        <div class="content">
            <p>We received your inquiry and appreciate your interest in Software Consultants LLC.</p>
            <p>Our team will review your message and get back to you within 24 business hours.</p>
            <p>If you need to reach us sooner, feel free to call us at <strong>+1 (240) 615-7589</strong> or email <strong>info@softwaresconsultants.com</strong></p>
            <p>Best regards,<br><strong>Software Consultants LLC</strong></p>
        </div>
        <div class="footer">
            <p>© 2026 Software Consultants LLC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
    return $body;
}

/**
 * Send email via SMTP using PHP's PHPMailer-like approach
 * For Hostinger compatibility, uses mail() function with proper headers
 */
function sendMailViaSMTP($to_email, $subject, $body, $type = 'company') {
    // Prepare headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . FROM_NAME . " <" . FROM_EMAIL . ">" . "\r\n";
    $headers .= "Reply-To: " . REPLY_TO_EMAIL . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
    if ($type === 'user') {
        $replyTo = FROM_EMAIL;
    } else {
        $replyTo = $to_email;
    }
    
    $headers .= "Reply-To: " . $replyTo . "\r\n";
    
    // Additional parameters for Hostinger
    $additional_params = "";
    
    // Validate email before sending
    if (!filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Send email - Hostinger uses php mail() with SMTP configuration
    // You may need to configure this in Hostinger Control Panel
    $mail_sent = mail($to_email, $subject, $body, $headers, $additional_params);
    
    return $mail_sent;
}
?>


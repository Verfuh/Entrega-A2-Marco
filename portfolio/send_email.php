<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['subject']) || !isset($data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos devem ser preenchidos']);
    exit;
}

$name = filter_var($data['name'], FILTER_SANITIZE_STRING);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($data['subject'], FILTER_SANITIZE_STRING);
$message = filter_var($data['message'], FILTER_SANITIZE_STRING);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email Inválido']);
    exit;
}

$to = "JHENIFEREGINADEMOURA@GMAIL.COM";

$email_content = "Name: $name\n";
$email_content .= "Email: $email\n";
$email_content .= "Message: $message\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $email_content, $headers)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao enviar o e-mail']);
}
?>

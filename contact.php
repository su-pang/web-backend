<?php
header("Content-Type: application/json"); // JSON 응답을 반환하도록 설정

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}

$name = htmlspecialchars($_POST['name'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

// 입력값 검증
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email format."
    ]);
    exit;
}

$to = "sa2840@naver.com"; // 받는 사람의 이메일
$subject = "New Message from $name";
$headers = "From: $email\r\n" .
           "Reply-To: $email\r\n" .
           "X-Mailer: PHP/" . phpversion();

// 메일 전송
if (mail($to, $subject, $message, $headers)) {
    echo json_encode([
        "success" => true,
        "message" => "Email sent successfully!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to send email."
    ]);
}

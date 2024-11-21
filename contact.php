<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 입력 데이터 검증 및 보안 처리
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // 이메일 형식 유효성 검사
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // 메일 설정
    $to = "sa2840@naver.com"; // 받는 사람의 이메일
    $subject = "New Message from " . $name;
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // 이메일 전송
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}
?>

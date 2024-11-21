<?php
// 에러를 화면에 출력하지 않도록 설정
error_reporting(0);

// 1. 폼 데이터 수집
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $agree = isset($_POST['agree']); // 체크박스는 값이 없으므로 확인만 필요
    
    // 2. 폼 데이터 유효성 검증
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message content is required.";
    }
    if (!$agree) {
        $errors[] = "You must agree to the Privacy Policy.";
    }
    
    // 3. 에러가 없을 경우 처리
    if (empty($errors)) {
        // 예제: 이메일 전송
        $to = "your_email@example.com"; // 실제 수신 이메일 주소
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email";
        
        if (mail($to, $subject, $body, $headers)) {
            echo json_encode(["success" => true, "message" => "Thank you for reaching out!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error sending email. Please try again."]);
        }
    } else {
        // 에러 반환
        echo json_encode(["success" => false, "errors" => $errors]);
    }
} else {
    // GET 요청 처리
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>

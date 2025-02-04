<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require"db/db.php"; // Установи PHPMailer через Composer: composer require phpmailer/phpmailer

// Подключение к базе данных
$host = "localhost";
$dbname = "user_db";
$username = "root"; // Замени на свой логин MySQL
$password = "";     // Замени на свой пароль MySQL

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // SQL-запрос для сохранения данных
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $phone, $email, $message);
    
    if ($stmt->execute()) {
        echo "Данные успешно сохранены!";

        // Отправка письма на Gmail
        $mail = new PHPMailer(true);

        try {
            // Настройки SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Укажи свой Gmail
            $mail->Password = 'your-app-password';  // Используй пароль приложения Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Отправитель и получатель
            $mail->setFrom('your-email@gmail.com', 'Website');
            $mail->addAddress('your-email@gmail.com'); // Получатель

            // Тема и тело письма
            $mail->Subject = 'Новая заявка с сайта';
            $mail->Body = "Имя: $first_name\nФамилия: $last_name\nТелефон: $phone\nEmail: $email\nСообщение: $message";

            // Отправка письма
            $mail->send();
            echo "Письмо отправлено!";
        } catch (Exception $e) {
            echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
        }
    } else {
        echo "Ошибка при сохранении: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

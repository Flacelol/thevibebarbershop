<?php
// Перевірка, чи форма була відправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $master = isset($_POST['master']) ? $_POST['master'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    
    // Перетворення значень послуг та майстрів у читабельний формат
    $serviceNames = [
        'haircut-women' => 'Жіноча стрижка',
        'haircut-men' => 'Чоловіча стрижка',
        'beard' => 'Моделювання бороди',
        'manicure' => 'Манікюр',
        'pedicure' => 'Педикюр',
        'makeup' => 'Макіяж',
        'brows' => 'Корекція брів'
    ];
    
    $masterNames = [
        'any' => 'Будь-який майстер',
        'olena' => 'Олена (стрижки, зачіски)',
        'maria' => 'Марія (манікюр, педикюр)',
        'andrii' => 'Андрій (чоловічі стрижки, борода)',
        'natalia' => 'Наталія (макіяж, брови)'
    ];
    
    $serviceName = isset($serviceNames[$service]) ? $serviceNames[$service] : $service;
    $masterName = isset($masterNames[$master]) ? $masterNames[$master] : $master;
    
    // Форматування дати у більш читабельний формат
    $formattedDate = date('d.m.Y', strtotime($date));
    
    // Адреса, на яку відправляти повідомлення
    $to = 'flace4961@gmail.com'; // Замініть на реальну адресу власника салону
    
    // Тема повідомлення
    $subject = 'Новий запис на прийом - HAIRSTYLE';
    
    // Тіло повідомлення
    $message = "<html><body>";
    $message .= "<h2>Новий запис на прийом</h2>";
    $message .= "<p><strong>Послуга:</strong> $serviceName</p>";
    $message .= "<p><strong>Майстер:</strong> $masterName</p>";
    $message .= "<p><strong>Дата:</strong> $formattedDate</p>";
    $message .= "<p><strong>Час:</strong> $time</p>";
    $message .= "<p><strong>Ім'я клієнта:</strong> $name</p>";
    $message .= "<p><strong>Телефон:</strong> $phone</p>";
    
    if (!empty($email)) {
        $message .= "<p><strong>Email:</strong> $email</p>";
    }
    
    if (!empty($comment)) {
        $message .= "<p><strong>Коментар:</strong> $comment</p>";
    }
    
    $message .= "</body></html>";
    
    // Заголовки для відправки HTML-листа
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: HAIRSTYLE <noreply@hairstyle.ua>\r\n";
    
    // Відправка листа
    $mailSent = mail($to, $subject, $message, $headers);
    
    // Відповідь у форматі JSON
    header('Content-Type: application/json');
    
    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Запис успішно створено!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Виникла помилка при створенні запису. Будь ласка, спробуйте пізніше або зв\'яжіться з нами за телефоном.']);
    }
    
    exit;
}

// Якщо запит не POST, перенаправляємо на сторінку бронювання
header('Location: booking.html');
exit;
?>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru','phpmailer/language');
    $mail->IsHTML(true);

    // От кого письмо
    $mail->setForm('info@fls.guru', 'Фрилансер по жизни');
    // Кому отправишь
    $mail->addAddress('vlad.kudrych231@gmail.com');
    // Тема письма
    $mail->Subject = 'Привет! Ето Фрилансер по жизни';

    //Рука
    $hand = "правая";
    if($_POST['hand'] == "left"){
        $hand = "левая"
    }

    // Тело письма
    $body = '<h1>Встречайте супер письмо!</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['hand']))){
        $body.='<p><strong>рука:</strong> '.$hand.'</p>';
    }
    if(trim(!empty($_POST['age']))){
        $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
    }

    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Сщщбщение:</strong> '.$_POST['message'].'</p>';
    }

    //Прикрепить файл
    if(!empty($_FILES['image']['tmp_name'])) {
        //Пути загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //грузим файл
        if(copy($_FILES['image']['tmp_name'], $filePath)){
            $fileAttach = $filePath;
            $body.='<p><strong>Фото в приложении</strong>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    // Отправляем
    if (!$mail->send()) {
        $message = 'Ошибка';
    } else {
        $message = 'Данние отправлени!';
    }

    $response = ['masseage' => $message];

    header('Content-type: application/json');
    esho json_encode($response);
?>
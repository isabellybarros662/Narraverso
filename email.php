<?php 
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function mandarEmail($nomeDestinatario, $To, $Subject, $novaSenha) {

    $email = new PHPMailer(true);
    $email->CharSet = 'UTF-8'; // ← Esta linha corrige os acentos

    try {
        // Configurações do servidor SMTP
        $email->isSMTP();                               
        $email->Host = 'smtp.gmail.com';                       
        $email->SMTPAuth = true;                               
        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
        $email->Port = 587;                                    
        
        // Credenciais de acesso ao SMTP
        $email->Username = 'isabellysistema@gmail.com';       
        $email->Password = 'exvv sbgc bpdl kzni';    

        $email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Configuração do remetente
        $email->setFrom('isabellysistema@gmail.com', 'Equipe do Narraverso');

        // Definir destinatário
        if (is_array($To)) {
            foreach ($To as $address) {
                $email->addAddress($address); 
            }
        } else {
            $email->addAddress($To);
        }

        // Definição do e-mail como HTML
        $email->isHTML(true);     
        $email->ContentType = 'text/html; charset=UTF-8';                           
        $email->Subject = $Subject;

        // Corpo do e-mail com formatação HTML
        $email->Body = "
        <html lang='pt-br'>
        <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                }
                .container {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    box-shadow: 2px 2px 10px rgba(145, 9, 16, 0.1);
                }
                h2 {
                    color: #910910;
                }
                p {
                    font-size: 16px;
                    line-height: 1.5;
               }
                .password-box {
                    background-color: #f8f9fa;
                    border-left: 4px solid #910910;
                    padding: 10px;
                    font-weight: bold;
                    font-size: 18px;
                    margin-top: 10px;
                } 
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Olá, $nomeDestinatario!</h2>
                <p>Você solicitou a recuperação de senha.</p>
                <div class='password-box'>$novaSenha</div>
                <p>Recomendamos que você altere essa senha assim que possível para garantir a segurança da sua conta.</p>
                <p>Se você não solicitou essa mudança, entre em contato com o suporte imediatamente.</p>
                <p>Atenciosamente,<br>Equipe do Narraverso</p>
            </div>
        </body>
        </html>";

        // Alternativa para e-mails sem HTML
        $email->AltBody = "Olá, $nomeDestinatario! Sua nova senha é: $novaSenha. Recomendamos que você a altere assim que possível.";

        // Teste de conexão SMTP
        if (!$email->smtpConnect()) {
            die('Erro ao conectar ao servidor SMTP: ' . $email->ErrorInfo);
        }

        // Envia o e-mail
        $email->send();
        $_SESSION['sucessoEmail'] = true; // ← Flag para exibir modal
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        header("Location: index.php?erro=1");
        return false;
    }
}
?>

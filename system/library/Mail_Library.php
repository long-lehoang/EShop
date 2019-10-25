<?php 
    if ( ! defined('PATH_SYSTEM')) die ('Bad requested!');
    include PATH_SYSTEM."/PHPMailer-master/src/PHPMailer.php";
    include PATH_SYSTEM."/PHPMailer-master/src/Exception.php";
    include PATH_SYSTEM."/PHPMailer-master/src/OAuth.php";
    include PATH_SYSTEM."/PHPMailer-master/src/POP3.php";
    include PATH_SYSTEM."/PHPMailer-master/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mail_Library 
    {
        public function __construct()
        {
        }
        
        public function sendMail($title, $content, $nTo, $mTo,$diachicc='')
        {
            $nFrom = 'EShop';
            $mFrom = 'long.bk.khmt@gmail.com';  //dia chi email cua ban 
            $mPass = 'hoanglongle2402';       //mat khau email cua ban
            $mail             = new PHPMailer();
            $body             = $content;
            $mail->IsSMTP(); 
            $mail->CharSet   = "utf-8";
            $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = true;                    // enable SMTP authentication
            $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
            $mail->Host       = "smtp.gmail.com";        
            $mail->Port       = 465;
            $mail->Username   = $mFrom;  // GMAIL username
            $mail->Password   = $mPass;               // GMAIL password
            $mail->SetFrom($mFrom, $nFrom);
            //chuyen chuoi thanh mang
            $ccmail = explode(',', $diachicc);
            $ccmail = array_filter($ccmail);
            if(!empty($ccmail)){
                foreach ($ccmail as $k => $v) {
                    $mail->AddCC($v);
                }
            }
            $mail->Subject    = $title;
            $mail->MsgHTML($body);
            $address = $mTo;
            $mail->AddAddress($address, $nTo);
            $mail->AddReplyTo('long.bk.khmt@gmail.com', 'EShop');
            if(!$mail->Send()) {
                return 0;
            } else {
                return 1;
            }
        }
    }

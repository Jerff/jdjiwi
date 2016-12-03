<?php

namespace Jdjiwi\Mail\Phpmailer;

use Jdjiwi\Loader,
    \Jdjiwi\Cache;

//Loader::library('vendor/phpmailer/phpmailer/class.phpmailer');

class Phpmailer {

    private $charset = 'utf-8';
    private $login = null;
    private $password = null;
    private $host = null;
    private $secure = null;
    private $port = null;
    private $attachment = array();

    public function __construct() {
        $this->loadConfig();
    }

    // настройка почтового адреса
    // читает из базы, но можно передавать через массив
    public function loadConfig($config = null) {
        if (!$config) {
            $config = \cDB::sql()->placeholder("SELECT login, secure, password, host, port FROM ?t WHERE id='1'", cDB::table('mail.config'))
                    ->fetchAssoc();
        }
        foreach (array('login', 'password', 'secure', 'host', 'port') as $k) {
            if (isset($config[$k])) {
                $this->$k = $config[$k];
            }
        }
    }

    // почтовые переменные
    static public function getMailVar($name = null) {
        $arValues = Cache::run(array(__CLASS__, __FUNCTION__), function() {
                    return \cDB::sql()->placeholder("SELECT var, value FROM ?t", cDB::table('mail.var'))
                                    ->fetchRowAll(0, 1);
                });
        return $name ? get($arValues, $name) : $arValues;
    }

    // работа c вложениями
    public function initAttachment(&$mail) {
        foreach ($this->attachment as $path => $name) {
            if ($path === $name) {
                $mail->AddAttachment($path);
            } else {
                $mail->AddAttachment($path, $name);
            }
        }
    }

    public function addAttachment($path, $name) {
        $this->attachment[$path] = $name;
    }

    public function &init() {
        $mail = new \PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPAuth = true;                  // enable SMTP authentication
        $mail->SMTPSecure = $this->secure;                 // sets the prefix to the servier
        $mail->Host = $this->host;      // sets GMAIL as the SMTP server
        $mail->Port = $this->port;                   // set the SMTP port for the GMAIL server

        $mail->CharSet = $this->charset;

        $mail->Username = $this->login;  // GMAIL username
        $mail->Password = $this->password;            // GMAIL password

        $mail->From = self::getMailVar('proectSupport');
        $mail->FromName = "";

        $mail->WordWrap = 200;
        return $mail;
    }

    public function send($to, $subject, $message, $html = null) {
        if (!cFilter::isEmail($to))
            return;

        //return;
        $mail = $this->init();

        $mail->Subject = $subject;
        $mail->AddAddress($to, "");

        $is = preg_replace('`\s`', '', strip_tags(html_entity_decode($html)));
        if (empty($is)) {
            $mail->Body = $message;
            $mail->IsHTML(false);
        } else {
            $mail->AltBody = $message;
            $this->searchAttachment($html);
            $mail->MsgHTML($html);
        }
        $this->initAttachment($mail);
        $mail->Send();
    }

    public function sendHTML($to, $subject, $message) {
        if (!\Jdjiwi\Str::isEmail($to))
            return;

        $mail = $this->init();
        $mail->Subject = $subject;
        $mail->AddAddress($to, "");

        $mail->AltBody = strip_tags($message);
        $this->searchAttachment($message);
        $this->initAttachment($mail);
        $mail->MsgHTML($message);
        $mail->Send();
    }

    private function searchAttachment(&$message) {
        preg_match_all('~(<img[^>]*src="([^"]+)"[^>]*>)~S', $message, $tmp);
        if (isset($tmp[2])) {
            foreach ($tmp[2] as $img) {
                $file = preg_replace('~^(.*\/)([^\/]+)$~S', '$2', $img);
                $message = str_replace($img, $file, $message);
                $this->AddAttachment(realpath(cWWWPath . $img), $file);
            }
        }
    }

    // отправка шаблона письма по адресу
    public function sendTemplates($name, $data, $email) {
        list($header, $content, $html) = \cDB::sql()->placeholder("SELECT header, content, html FROM ?t WHERE name=?", cDB::table('mail.templates'), $name)
                ->fetchRow();
        if (!$header)
            $header = $name;

        $data['proectUrl'] = cBaseAppUrl;
        foreach (array_merge($data, self::getMailVar()) as $k => $v) {
            $header = str_replace('{' . $k . '}', $v, $header);
            $content = str_replace('{' . $k . '}', $v, $content);
            $html = str_replace('{' . $k . '}', $v, $html);
        }
        $content = str_replace("\r", '', $content);
        $this->send($email, $header, $content, $html);
    }

    // отправка шаблона письма по адресам указанным в админке
    public function sendType($type, $name, $data) {
        $arEmails = Cache::run(array(__CLASS__, __FUNCTION__), function() {
                    $arEmail = \cDB::sql()->placeholder("SELECT email FROM ?t WHERE `?s`='yes'", cDB::table('mail.list'), $type)
                            ->fetchRowAll(0);
                });
        foreach ($arEmails as $email) {
            $this->sendTemplates($name, $data, $email);
        }
    }

}

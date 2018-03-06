<?php 

namespace Hcode;

use Rain\Tpl;

class Mailer{

	const USERNAME = "mapedine3@gmail.com";
	const PASSWORD = "NICKdiasneto1010@";
	const NAME_FROM = "Mapedine";

	private $mail;

	public function __construct($toAdress, $toName, $subject, $tplName, $data = array()){

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false // set to false to improve the speed
	   );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		$this->mail = new \PHPMailer;

		$this->mail->SMTPOptions = array(
		    'ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => true
			)
		);

		$this->mail->isSMTP();
		$this->mail->SMTPDebug = 0;
		$this->mail->Host = 'smtp.gmail.com';
		$this->mail->Port = 587;
		$this->mail->SMTPSecure = 'tls';
		$this->mail->SMTPAuth = true;
		$this->mail->Debugoutput = 'html';
		$this->mail->Username = Mailer::USERNAME;
		$this->mail->Password = Mailer::PASSWORD;
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
		$this->mail->addAddress($toAdress, $toName);
		$this->mail->Subject = $subject;
		$this->mail->msgHTML($html);
		$this->mail->AltBody = 'This is a plain-text message body';

	}

	public function send(){

		return $this->mail->send();

	}
}

 ?>
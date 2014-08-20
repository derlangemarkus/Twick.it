<?php
class TwickitMailer extends PHPMailer {

    // ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
    private $title;
    private $htmlMessage;
    private $plainText;


    // ---------------------------------------------------------------------
	// ----- Konstruktor ---------------------------------------------------
	// ---------------------------------------------------------------------
    public function __construct() {
        $this->CharSet = 'utf-8';
		$this->From = USER_MAIL_SENDER;
		$this->FromName = "Twick.it";
        $this->isHTML(true);
    }


    // ---------------------------------------------------------------------
	// ----- Setter --------------------------------------------------------
	// ---------------------------------------------------------------------
    public function setPlainMessage($inMessage) {
        $this->plainText = $inMessage;
    }


    public function setTitle($inTitle) {
        $this->title = $inTitle;
    }


    public function setHtmlMessage($inMessage) {
        $this->htmlMessage = $inMessage;
    }


    // ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public function Send() {
        $this->Body = $this->_buildHtml();
        $this->AltBody = $this->plainText . "\n\n-- \n". _loc('email.footer') . "\n";
        return parent::Send();
    }


    // ---------------------------------------------------------------------
    // ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
    private function _buildHtml() {
        $title = $this->title ? $this->title : $this->Subject;
        $message = $this->htmlMessage ? $this->htmlMessage : nl2br(insertAutoLinks(htmlspecialchars($this->plainText)));

        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional //EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Twick.it</title>
        <style type="text/css">
            a:hover{text-decoration:none;}
        </style>
    </head>
    <body style="margin:0;padding:0;" dir="ltr">
        <table width="98%" border="0" cellspacing="0" cellpadding="20">
            <tr>
                <td bgcolor="#EEEEEE" width="100%" style="font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;">
                    <table cellpadding="0" cellspacing="0" border="0" width="580">
                        <tr>
                            <td style="background:#FFFFFF;padding:7px 10px 3px 0px" align="right">
                                <a href="http://twick.it"><img src="http://twick.it/html/img/logo_klein.jpg" alt="Twick.it" border="0"/></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="background:#638301; color:#FFFFFF; font-weight: bold; font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica; padding: 4px 16px; vertical-align: middle; font-size: 17px;">
                                <font color="#FFFFFF">' . $title . '</font>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color:#FFFFFF; border: 1px solid #638301;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica; padding: 15px;" valign="top">
                                <div style="margin-bottom: 8px; font-size: 13px;">
                                    ' . $message . '
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#999999; padding: 15px 10px 10px 0px; font-size: 12px; font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;">
                                ' . nl2br(str_replace("<a ", "<a style='color:#999999;' ", insertAutoLinks(_loc('email.footer')))) . '
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
    }
}
?>

<?php

App::uses('Component', 'Controller', 'CakeEmail', 'Network/Email');

class NotificationComponent extends Component 
{

	function sendsms($message=null, $type)
	{
        $this->User = ClassRegistry::init('User');
        $users = $this->User->find('all');

        $thedetails = [];
        $torecive   = [];
        $numbers    = "";

        foreach ($users as $user)
        {
            if ( $user['User']['suppressed'] != 1) 
            {
                if ( in_array($type, unserialize($user['User']['permissions'])) )
                {
                    $thedetails['cellnumber'] = $user['User']['cellnumber'];
                    $torecive[] = $thedetails;
                    $thedetails = [];
                }
            }
        }

        foreach ($torecive as $reciever) 
        {
            if (strlen($reciever['cellnumber']) == 11) 
            {
                $numbers .= $reciever['cellnumber'] . ',';
            }
        }

        $numbers .= '27817549884';
        $smsText = urlencode($message);

        //$url = "http://78.46.17.110/app/smsapi/index.php?key=5bd18d48532d6&type=text&title=&contacts={$numbers}&groupid=&senderid=MAFFINS&msg={$smsText}&time=&time_zone=";
        $url = "http://148.251.196.36/app/smsapi/index.php?key=5c6d72f0f094d&type=text&contacts={$numbers}&senderid=Matjabheng&msg={$smsText}&time=";

        $mystring = $this->get_data($url);
	}

	function sendemail($message=null, $subject=null, $type)
    { 
        $Email = new CakeEmail();

        $this->User = ClassRegistry::init('User');
        $users = $this->User->find('all');

        foreach ($users as $user) 
        {
            if ( $user['User']['suppressed'] != 1) 
            {            
                if (in_array($type, unserialize($user['User']['permissions']))) 
                {
                    $Email->from(array('no-reply@matjhabeng.co.za' => 'Matjhabeng Local Municipality Document Management System'))
                            ->template('newmeetingposted', 'default')
                            ->domain('www.trustconetest.co.za')
                            ->emailFormat('html')
                            ->viewVars(array('meeting' => $message))
                            ->to(trim($user['User']['email'])) //
                            //->to('mapaepae@gmail.com')
                            ->bcc('maffins@gmail.com')
                            ->subject($subject)
                            ->send();
                }
            }
        }

    }

    public function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

?>
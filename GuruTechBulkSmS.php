<?php

/**
 * GuruTechBulkSmS Class 
 * 
 * @author Giceha(gicehajunior76@gmail.com)
 * @version v1.0
 * */
class GuruTechBulkSmS {

    private $sender_id; 
    private $userid; 
    private $password; 
    private $contacts;
    private $message;
    private $sendMethod;
    private $msgType;
    private $duplicatecheck;
    private $output;

    private $gurutech_messaging_endpoint;
    private $gurutech_apikey_create_endpoint;
    private $gurutech_read_apikey_endpoint;

    /**
     * GuruTechBulkSmS class constructor
     */
    public function __construct($sender_id, $userid, $password, $apikey = "", $sendMethod = "quick")
    {
        $this->sender_id = $sender_id;
        $this->userid = $userid;
        $this->password = $password;
        $this->sendMethod = $sendMethod;
        $this->msgType = "text";
        $this->duplicatecheck = "true";
        $this->output = "json";
        $this->gurutech_messaging_endpoint = "https://portal.gurutechsms.co.ke/SMSApi/send";
        $this->gurutech_apikey_create_endpoint = "https://portal.gurutechsms.co.ke/SMSApi/apikey/create?userid=" . $this->userid . "&password=" . $this->password . "&output=" . $this->output . "";
        $this->gurutech_read_apikey_endpoint = "https://portal.gurutechsms.co.ke/SMSApi/apikey/read?userid=" . $this->userid . "&password=" . $this->password . "&output=" . $this->output . "";
    }

    /**
     * Takes care of generating api key via gurutech sms api
     * 
     * @author - Giceha(gicehajunior76@gmail.com) 
     * @return array
     */
    public function generate_apikey() {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->gurutech_apikey_create_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array (
                'Content-Type: application/x-www-form-urlencoded',
                'Access-Control-Allow-Origin: *',
                'Accept-Language: *',  
                "Cache-Control: no-cache", 
            ),
        ));
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $response = curl_error($curl);
        }
    
        curl_close($curl);

        $response_obj = array();

        foreach (json_decode($response) as $key => $obj_val) { 
            $response_obj[$key] = $obj_val;
        }

        return $response_obj;
    }

    /**
     * Takes care of reading the list of api keys generated
     * via gurutech sms api
     * 
     * @author - Giceha(gicehajunior76@gmail.com) 
     * @return array
     */
    public function read_apikey() { 
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->gurutech_read_apikey_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array (
                'Content-Type: application/x-www-form-urlencoded',
                'Access-Control-Allow-Origin: *',
                'Accept-Language: *',  
                "Cache-Control: no-cache", 
            ),
        ));
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $response = curl_error($curl);
        }
    
        curl_close($curl);
        
        $response_obj = array();

        foreach (json_decode($response) as $key => $obj_val) { 
            $response_obj[$key] = $obj_val; 
        } 

        $finalResponse = array();
        foreach ($response_obj as $obj) { 
           $finalResponse['status'] = $obj->status;
           $finalResponse['msg'] = $obj->msg;
           $finalResponse['code'] = $obj->code; 
           $finalResponse['apikey'] = $obj->apikeyList->apikey;

        }
        
        return $finalResponse;
    }

    /**
     * Takes care of sending an sms via gurutech sms api
     * 
     * @author - Giceha(gicehajunior76@gmail.com)
     * @param  :  
     *         -  message - Actual text message that gets sent to recipient.
     * 
     *         -  contacts - Selected array of numbers to send the message to.
     * @return array
     */
    public function send($message, $contacts = []) {
        $this->message = $message;
        $this->contacts = implode(",", $contacts); 
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->gurutech_messaging_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userid=" . $this->userid . "&password= " . $this->password . " &mobile= " . $this->contacts . "&msg=" . $this->message . "&senderid=" . $this->sender_id . "&msgType=" . $this->msgType . "&duplicatecheck=" . $this->duplicatecheck . "&output=" . $this->output . "&sendMethod=" . $this->sendMethod . "",
            CURLOPT_HTTPHEADER => array (
                'Content-Type: application/x-www-form-urlencoded',
                'Access-Control-Allow-Origin: *',
                'Accept-Language: *', 
                "apikey: somerandomuniquekey",
                "Cache-Control: no-cache", 
            ),
        ));
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $response = curl_error($curl);
        }
    
        curl_close($curl);

        $response_obj = array();

        foreach (json_decode($response) as $key => $obj_val) { 
            $response_obj[$key] = $obj_val;
        }
    
        return $response_obj;
    }
    

}


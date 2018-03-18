<?php
namespace Famephp\api;

class GraphRequest {
    
    /**
     * Curl handle
     *
     * @var object
     */
    private $ch;

    /**
     * Whether or not to return a response from requests
     *
     * @var boolean
     */
    private $returnResponse = true;

    /**
     * Request headers
     *
     * @var array
     */
    private $headers = array(
        "Content-Type" => "application/json"
    );

    /**
     * Which facebook API section to send to
     *
     * @var string
     */
    private $graphSection = 'messages';

    /**
     * Page access token
     *
     * @var string
     */
    private $pageAccessToken;

    /**
     * Constructor
     *
     * @param string $token page access token
     */
    public function __construct($token) 
    {
        $this->pageAccessToken = $token;
    }

    /**
     * Open a new curl session
     *
     * @return void
     */
    public function OpenSession() 
    {
        $this->ch = curl_init();
    }

    /**
     * Close current curl session
     *
     * @return void
     */
    public function CloseSession() {
        if (!isset($this->ch)) {
            exit('Failed to close session: no curl session started yet!');
        }

        curl_close($this->ch);
    }

    public function SetReturnResponseTo($bool) 
    {
        if (!is_bool($bool)) {
            throw new \InvalidArgumentException('SetReturnResponseTo() only accepts a boolean as parameter!');
        }
        $this->returnResponse = $bool;
    }

    public function SetContentType($contentType) 
    {
        $this->headers['Content-Type'] = $contentType;
    }

    public function SetGraphSection($section) 
    {
        $this->graphSection = $section;
    }

    /**
     * Convert array of headers to correct format
     *
     * @param array $headers PHP array
     * @return void
     */
    private function BuildHeaders($headers) 
    {
        $newHeaders = [];
        foreach ($headers as $key => $value) {
            $newHeaders[] = "$key: $value";
        }
        return $newHeaders;
    }

    /**
     * Send message data to facebook's graph API
     * Supports both Attachment Upload API & Send API
     * 
     * @param array|string $payload post data array or json encoded string
     * @return string|null response data or null
     */
    public function Post($payload)
    {
        if (!isset($this->ch)) {
            exit('Failed to post data: No curl session started yet!');
        }

        curl_setopt_array($this->ch, [
            CURLOPT_URL => "https://graph.facebook.com/v2.6/me/$this->graphSection?access_token=$this->pageAccessToken",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $this->BuildHeaders($this->headers)
        ]);
        
        if ($this->returnResponse == true) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        }
        
        return curl_exec($this->ch);
    }

    /**
     * Send GET request to URL
     *
     * @param string $url
     * @return boolean
     */
    public function Get($url) 
    {
        if (!isset($this->ch)) {
            exit('Failed to get data: No curl session started yet!');
        }

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($this->ch);
    }
}
?>
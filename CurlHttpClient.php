<?php
class CurlHttpClient {
    /**
     * Used HTTP request methods
     */
    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';

    /**
     * cURL handler
     * @var resource
     */
    private $handler;

    /**
     * Store the POST fields
     */
    private $postParams = array();

    /**
     * Initiate a cURL session
     * @param string $url
     */
    public function __construct($uri) {
        $this->handler = curl_init($uri);
        $this->_setOptions();
    }

    protected function _setOptions() {
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handler, CURLOPT_FOLLOWLOCATION, true);
    }

    /**
     * Set the URI
     * @param $uri
     */
    public function setUri($uri) {
        $this->handler = curl_init($uri);
        $this->_setOptions();
    }

    /**
     * Receive the response with full headers
     * @param boolean $value
     */
    public function setHeaders($value = true) {
        curl_setopt($this->handler, CURLOPT_HEADER, $value);
    }

    /**
     * Set the HTTP request method
     * @param string $method
     */
    public function setMethod($method = self::GET) {
        switch ($method) {
            case self::GET :
                curl_setopt($this->handler, CURLOPT_HTTPGET, true);
                break;
            case self::POST :
                curl_setopt($this->handler, CURLOPT_POST, true);
                break;
            case self::DELETE :
                curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, self::DELETE);
                break;
            default:
                throw new CurlHttpClientException('Method not supported');
        }
    }

    /**
     * Add a new post param to the set
     * @param string $name
     * @param mixed $value
     */
    public function setPostParam($name, $value) {
        $this->postParams[$name] = $value;
        curl_setopt($this->handler, CURLOPT_POSTFIELDS, $this->postParams);
    }

    /**
     * Get the response
     * @return string
     */
    public function getResponse() {
        $response = curl_exec($this->handler);
        curl_close($this->handler);

        return $response;
    }
}

class CurlHttpClientException extends Exception {}

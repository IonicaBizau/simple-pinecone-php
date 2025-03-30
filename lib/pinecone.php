<?php

class Pinecone {
    private $apiKey;
    private $hostUrl;
    private $apiVersion;

    /**
     * Pinecone
     * Constructor to initialize the Pinecone API client.
     *
     * @function
     * @name Pinecone
     * @param {String} $apiKey The API key for authentication.
     * @param {String} $hostUrl The base URL of the Pinecone API.
     * @param {String} $apiVersion The API version, default is `'2025-01'`.
     */
    public function __construct($apiKey, $hostUrl, $apiVersion = '2025-01') {
        $this->apiKey = $apiKey;
        $this->hostUrl = rtrim($hostUrl, '/');
        $this->apiVersion = $apiVersion;
    }

    /**
     * pinecone.request
     * Makes an HTTP request to the Pinecone API.
     *
     * @function
     * @name pinecone.request
     * @param {String} $method HTTP method (GET or POST).
     * @param {String} $pathname The API endpoint path.
     * @param {Array} $data The data to send with the request.
     * @return {Array} The API response as an associative array.
     */
    private function request($method, $pathname, $data = []) {
        $url = strpos($pathname, 'https://') === 0 ? $pathname : $this->hostUrl . '/' . ltrim($pathname, '/');

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        $ch = curl_init($url);

        $headers = [
            "Content-Type: application/json",
            "Api-Key: {$this->apiKey}",
            "X-Pinecone-API-Version: {$this->apiVersion}"
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }

        $response = json_decode($response, true);
	return $response;
    }

    /**
     * pinecone.getRequest
     * Sends a GET request to the Pinecone API.
     *
     * @name pinecone.getRequest
     * @function
     * @param {String} $pathname The API endpoint path.
     * @param {Array} $queryStringParamsAsArray Query parameters as an associative array.
     * @return {Array} The API response as an associative array.
     */
    public function getRequest($pathname, $queryStringParamsAsArray = []) {
        return $this->request('GET', $pathname, $queryStringParamsAsArray);
    }

    /**
     * pinecone.postRequest
     * Sends a POST request to the Pinecone API.
     *
     * @name pinecone.postRequest
     * @function
     * @param {String} $pathname The API endpoint path.
     * @param {Array} $bodyAsArray The request body as an associative array.
     * @return {Array} The API response as an associative array.
     */
    public function postRequest($pathname, $bodyAsArray = []) {
        return $this->request('POST', $pathname, $bodyAsArray);
    }
}

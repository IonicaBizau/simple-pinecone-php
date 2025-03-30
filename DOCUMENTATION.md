## Documentation

You can see below the API reference of this module.

### `Pinecone($apiKey, $hostUrl, $apiVersion)`
Constructor to initialize the Pinecone API client.

#### Params

- **String** `$apiKey`: The API key for authentication.
- **String** `$hostUrl`: The base URL of the Pinecone API.
- **String** `$apiVersion`: The API version, default is `'2025-01'`.

### `pinecone.request($method, $pathname, $data)`
Makes an HTTP request to the Pinecone API.

#### Params

- **String** `$method`: HTTP method (GET or POST).
- **String** `$pathname`: The API endpoint path.
- **Array** `$data`: The data to send with the request.

#### Return
- **Array** The API response as an associative array.

### `pinecone.getRequest($pathname, $queryStringParamsAsArray)`
Sends a GET request to the Pinecone API.

#### Params

- **String** `$pathname`: The API endpoint path.
- **Array** `$queryStringParamsAsArray`: Query parameters as an associative array.

#### Return
- **Array** The API response as an associative array.

### `pinecone.postRequest($pathname, $bodyAsArray)`
Sends a POST request to the Pinecone API.

#### Params

- **String** `$pathname`: The API endpoint path.
- **Array** `$bodyAsArray`: The request body as an associative array.

#### Return
- **Array** The API response as an associative array.


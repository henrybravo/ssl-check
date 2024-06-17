<?php
/**
 * This script is used to check the SSL certificate of a given domain.
 * It expects a POST request with a 'domain' parameter.
 * If the domain is valid, it retrieves the SSL information and returns it as JSON.
 * If the domain is invalid or the SSL information cannot be retrieved, it returns an error message.
 */

$domainPattern = '/^([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["domain"])) {
    $domain = filter_var($_POST['domain'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if (preg_match($domainPattern, $domain)) {
        $ssl_info = get_ssl_info($domain);
        if ($ssl_info !== false) {
            header('Content-Type: application/json');
            echo json_encode(['message' => "SSL certificate is valid for {$domain}", 'data' => $ssl_info], JSON_PRETTY_PRINT);
            exit;
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'SSL information could not be retrieved.']);
            exit;
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['message' => "Invalid domain format."]);
        exit;
    }
}

/**
 * Retrieves SSL information for a given domain.
 *
 * @param string $domain The domain for which to retrieve SSL information.
 * @return array|false Returns an array containing the SSL certificate information if successful, or false on failure.
 */
function get_ssl_info($domain) {
    $url = "https://".$domain;
    $original_parse = parse_url($url, PHP_URL_HOST);
    $get = stream_context_create(["ssl" => ["capture_peer_cert" => TRUE]]);
    $read = @stream_socket_client("ssl://".$original_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
    if ($read) {
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        return $certinfo; // Return the certificate info as an array
    } else {
        return false; // Return false on failure
    }
}
?>

<?php

/**
 * This module contains the plain non-curl HTTP fetcher
 * implementation.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: See the COPYING file included in this distribution.
 *
 * @package Yadis
 * @author JanRain, Inc. <openid@janrain.com>
 * @copyright 2005 Janrain, Inc.
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */

/**
 * Interface import
 */

$base_path = './inc/openid/';

require_once $base_path .  "Services/Yadis/HTTPFetcher.php";

/**
 * This class implements a plain, hand-built socket-based fetcher
 * which will be used in the event that CURL is unavailable.
 *
 * @package Yadis
 */
class Services_Yadis_PlainHTTPFetcher extends Services_Yadis_HTTPFetcher {
    function get($url, $extra_headers = null)
    {
        if (!$this->allowedURL($url)) {
            trigger_error("Bad URL scheme in url: " . $url,
                          E_USER_WARNING);
            return null;
        }

        $redir = true;

        $stop = time() + $this->timeout;
        $off = $this->timeout;

        while ($redir && ($off > 0)) {

            $parts = parse_url($url);

            $specify_port = true;

            // Set a default port.
            if (!array_key_exists('port', $parts)) {
                $specify_port = false;
                if ($parts['scheme'] == 'http') {
                    $parts['port'] = 80;
                } elseif ($parts['scheme'] == 'https') {
                    $parts['port'] = 443;
                } else {
                    trigger_error("fetcher post method doesn't support " .
                                  " scheme '" . $parts['scheme'] .
                                  "', no default port available",
                                  E_USER_WARNING);
                    return null;
                }
            }

            $host = $parts['host'];

            if ($parts['scheme'] == 'https') {
                $host = 'ssl://' . $host;
            }

            $user_agent = "PHP Yadis Library Fetcher";

            $headers = [
                             "GET ".$parts['path'].
                             (array_key_exists('query', $parts) ?
                              "?".$parts['query'] : "").
                                 " HTTP/1.0",
                             "User-Agent: $user_agent",
                             "Host: ".$parts['host'].
                                ($specify_port ? ":".$parts['port'] : ""),
                             "Port: ".$parts['port']
			];

            $errno = 0;
            $errstr = '';

            if ($extra_headers) {
                foreach ($extra_headers as $h) {
                    $headers[] = $h;
                }
            }

            @$sock = fsockopen($host, $parts['port'], $errno, $errstr,
                               $this->timeout);
            if ($sock === false) {
                return false;
            }

            stream_set_timeout($sock, $this->timeout);

            fputs($sock, implode("\r\n", $headers) . "\r\n\r\n");

            $data = "";
            while (!feof($sock)) {
                $data .= fgets($sock, 1024);
            }

            fclose($sock);

            // Split response into header and body sections
            list($headers, $body) = explode("\r\n\r\n", $data, 2);
            $headers = explode("\r\n", $headers);

            $http_code = explode(" ", $headers[0]);
            $code = $http_code[1];

            if (in_array($code, ['301', '302'])) {
                $url = $this->_findRedirect($headers);
                $redir = true;
            } else {
                $redir = false;
            }

            $off = $stop - time();
        }

        $new_headers = [];

        foreach ($headers as $header) {
            if (preg_match("/:/", $header)) {
                list($name, $value) = explode(": ", $header, 2);
                $new_headers[$name] = $value;
            }

        }

        return new Services_Yadis_HTTPResponse($url, $code, $new_headers, $body);
    }

    function post($url, $body, $extra_headers = null)
    {
        if (!$this->allowedURL($url)) {
            trigger_error("Bad URL scheme in url: " . $url,
                          E_USER_WARNING);
            return null;
        }

        $parts = parse_url($url);

        $headers = [];

        $post_path = $parts['path'];
        if (isset($parts['query'])) {
            $post_path .= '?' . $parts['query'];
        }

        $headers[] = "POST ".$post_path." HTTP/1.0";
        $headers[] = "Host: " . $parts['host'];
        $headers[] = "Content-type: application/x-www-form-urlencoded";
        $headers[] = "Content-length: " . strval(strlen($body));

        if ($extra_headers &&
            is_array($extra_headers)) {
            $headers = array_merge($headers, $extra_headers);
        }

        // Join all headers together.
        $all_headers = implode("\r\n", $headers);

        // Add headers, two newlines, and request body.
        $request = $all_headers . "\r\n\r\n" . $body;

        // Set a default port.
        if (!array_key_exists('port', $parts)) {
            if ($parts['scheme'] == 'http') {
                $parts['port'] = 80;
            } elseif ($parts['scheme'] == 'https') {
                $parts['port'] = 443;
            } else {
                trigger_error("fetcher post method doesn't support scheme '" .
                              $parts['scheme'] .
                              "', no default port available",
                              E_USER_WARNING);
                return null;
            }
        }

        if ($parts['scheme'] == 'https') {
            $parts['host'] = sprintf("ssl://%s", $parts['host']);
        }

        // Connect to the remote server.
        $errno = 0;
        $errstr = '';

        $sock = fsockopen($parts['host'], $parts['port'], $errno, $errstr,
                          $this->timeout);

        if ($sock === false) {
            trigger_error("Could not connect to " . $parts['host'] .
                          " port " . $parts['port'],
                          E_USER_WARNING);
            return null;
        }

        stream_set_timeout($sock, $this->timeout);

        // Write the POST request.
        fputs($sock, $request);

        // Get the response from the server.
        $response = "";
        while (!feof($sock)) {
            if ($data = fgets($sock, 128)) {
                $response .= $data;
            } else {
                break;
            }
        }

        // Split the request into headers and body.
        list($headers, $response_body) = explode("\r\n\r\n", $response, 2);

        $headers = explode("\r\n", $headers);

        // Expect the first line of the headers data to be something
        // like HTTP/1.1 200 OK.  Split the line on spaces and take
        // the second token, which should be the return code.
        $http_code = explode(" ", $headers[0]);
        $code = $http_code[1];

        $new_headers = [];

        foreach ($headers as $header) {
            if (preg_match("/:/", $header)) {
                list($name, $value) = explode(": ", $header, 2);
                $new_headers[$name] = $value;
            }

        }

        return new Services_Yadis_HTTPResponse($url, $code,
                                               $headers, $response_body);
    }
}

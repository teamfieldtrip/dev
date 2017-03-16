<?php

use Curl\Curl;

const DEF_DATE = '2017-01-01T12:00:00.00+0100';

require_once __DIR__ . '/vendor/autoload.php';

$curl = new Curl;
$curl->get('https://circleci.com/api/v1.1/project/github/teamfieldtrip/spirithunt/tree/develop', [
    'filter' => 'failed',
    'limit' => 1
]);

if (!$curl->error) {
    $json = json_decode($curl->response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        if (is_array($json)) {
            $entry = array_shift($json);
            $lastError = \DateTime::createFromFormat(
                'Y-m-d\TH:i:s.uO',
                $entry['stop_time'] ?? DEF_DATE
            );
        }
    }
}

$lastError = $lastError instanceof \DateTime ? $lastError : new \DateTime;

header('Content-Type: text/plain; charset=utf-8');

echo json_encode([
    'date' => $lastError->format('Y-m-d\TH:i:s')
]);

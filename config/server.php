<?php
return [

'mailgun' => [
    'domain' => '',
    'secret' => '',
],

'mandrill' => [
    'secret' => getenv('MAIL_PASSWORD'),
]

];
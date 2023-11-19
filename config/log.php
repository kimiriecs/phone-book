<?php declare(strict_types=1);

return [
    'date_format' => "Y n j, g:i a",
    'output' => "%datetime% > %channel% > %level_name% > \n\nMessage: '%message%'\nTrace: %context% %extra%\n\n",
    'output_simple' => "%datetime% > %channel% > %level_name% > %message% %context% %extra%\n\n",
];
<?php

$header = <<<EOF
This file is part of the Nexylan CloudFlare package.

(c) Nexylan SAS <contact@nexylan.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = \PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
;

return \PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'linebreak_after_opening_tag' => true,
        'ordered_imports' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'modernize_types_casting' => true,
        'header_comment' => [
            'header' => $header,
        ]
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;

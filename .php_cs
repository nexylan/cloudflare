<?php

$header = <<<EOF
This file is part of the Nexylan CloudFlare package.

(c) Nexylan SAS <contact@nexylan.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'header_comment',
        '-unalign_double_arrow',
        '-unalign_equals',
        'align_double_arrow',
        'newline_after_open_tag',
        'ordered_use',
        'short_array_syntax',
        'strict',
        'strict_param',
    ))
    ->setUsingCache(true)
    ->finder($finder)
;
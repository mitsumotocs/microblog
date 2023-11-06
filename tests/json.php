<?php

declare(strict_types=1);

$text = <<<'EOT'
PHPちゃん、"髪　の　毛"、切ったのかな😜⁉️❓\SLASHES/
    （￣ー￣?）似合いすぎだよ😃✋😃♥
        ﾎﾞｸ、本当に女優さんかと思っちゃっタヨ(^o^)😆😘
            #おじさん文章ジェネレーター
EOT;

$jsonEncoded = json_encode(['text' => $text]);
var_dump($jsonEncoded);
$jsonDecoded = json_decode($jsonEncoded);
var_dump($jsonDecoded);

echo sprintf('Is decoded text equal to the original? %s', sha1($text) === sha1($jsonDecoded->text) ? 'YES' : 'NO'), PHP_EOL;

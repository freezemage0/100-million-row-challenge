<?php

namespace App;

final class Parser
{
    public function parse(string $inputPath, string $outputPath): void
    {
        $result = [];

        $file = \fopen($inputPath, 'rb');
        while ($line = \fgetcsv($file, escape: '"')) {
            $result[\parse_url($line[0], \PHP_URL_PATH)][] = \substr($line[1], 0, 10);
        }

        foreach ($result as &$visits) {
            $visits = \array_count_values($visits);
            \ksort($visits);
        }

        \file_put_contents($outputPath, \json_encode($result, \JSON_PRETTY_PRINT));
    }
}

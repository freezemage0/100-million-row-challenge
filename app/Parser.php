<?php

namespace App;

final class Parser
{
    public function parse(string $inputPath, string $outputPath): void
    {
        $result = [];

        $file = \fopen($inputPath, 'rb');
        while ($line = \fgetcsv($file, escape: '"')) {
            $date = \substr($line[1], 0, 10);

            $path = \parse_url($line[0], \PHP_URL_PATH);

            $result[$path] ??= [];
            $result[$path][] = $date;
        }
        \fclose($file);

        foreach ($result as &$visits) {
            \sort($visits);
            $visits = \array_count_values($visits);
        }
        unset($visits);

        \file_put_contents($outputPath, \json_encode($result, \JSON_PRETTY_PRINT));
    }
}

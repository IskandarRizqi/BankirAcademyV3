<?php

declare(strict_types=1);

require dirname(__DIR__, 2).'/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$source = __DIR__.'/index.html';
$output = __DIR__.'/dokumentasi-skema-calon-bankir.pdf';

$options = new Options;
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', false);

$dompdf = new Dompdf($options);
$dompdf->loadHtml((string) file_get_contents($source), 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

file_put_contents($output, $dompdf->output());

fwrite(STDOUT, "Generated: {$output}\n");

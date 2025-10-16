<?php

namespace App\Services\FileScanner;

use Symfony\Component\Process\Process;

class ClamAvScanner {
    public function scan(string $absolutePath): bool {
        $process = new Process(['clamscan','--no-summary',$absolutePath]);
        $process->run();
        return $process->isSuccessful();
    }
}

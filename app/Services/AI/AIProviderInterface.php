<?php

namespace App\Services\AI;

use App\Models\Contract;

interface AIProviderInterface {
    /** @return array{engine:string, engine_version:?string, raw:array, normalized:array} */
    public function extract(Contract $contract): array;
}

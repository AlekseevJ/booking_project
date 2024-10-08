<?php

namespace App\Services;

class RequestParserService
{
    public function parseParams(array $criteria): array
    {
        $params = [];

        foreach ($criteria as $key => $value) {
            if (is_array($value)) {
                $params[] = [$key, $value[0], $value[1]];
            } else {
                $params[] = [$key, $value];
            }
        }

        return $params;
    }

    public function parseParamFacilities(array $facilities): array
    {
        $facilities = implode(', ', $facilities);
        
        return [$facilities];
    }
}
<?php

declare(strict_types=1);

namespace App\Services;

use Mews\Purifier\Facades\Purifier;

class DataSanitizer
{
    public function sanitize(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = Purifier::clean($value, [
                    'HTML.Allowed' => '',
                    'HTML.TidyLevel' => 'none',
                    'CSS.AllowedProperties' => '',
                    'AutoFormat.AutoParagraph' => false,
                    'AutoFormat.RemoveEmpty' => true,
                    'HTML.Doctype' => 'HTML 4.01 Strict',
                ]);
            }
        }

        return $data;
    }
}

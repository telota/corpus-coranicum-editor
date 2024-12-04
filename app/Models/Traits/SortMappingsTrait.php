<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 06.03.18
 * Time: 16:01
 */

namespace App\Models\Traits;

/**
 * Trait SortMappingsTrait
 * @package App\Models\Traits
 */
trait SortMappingsTrait
{

    /**
     * Get sorted manuscript mappings
     * @return mixed
     */
    public function getMappingsSortedAttribute()
    {
        $mappings = $this->mappings;

        return $mappings->sort(function ($mappingA, $mappingB) {
            if ($mappingA->sure_start < $mappingB->sure_start) {
                return -1;
            }
            if ($mappingA->sure_start == $mappingB->sure_start) {
                if ($mappingA->vers_start < $mappingB->vers_start) {
                    return -1;
                }

                if ($mappingA->vers_start == $mappingB->vers_start) {
                    if ($mappingA->wort_start < $mappingB->wort_start) {
                        return -1;
                    }

                    if ($mappingA->wort_start == $mappingB->wort_start) {
                        return 0;
                    }
                }
            }
            return 1;
        });
    }
}

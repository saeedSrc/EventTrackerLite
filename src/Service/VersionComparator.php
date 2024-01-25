<?php

namespace App\Service;

class VersionComparator
{
    public static function isVersionAfterReference(string $version, string $referenceVersion): bool
    {
        list($versionNumber, $offset) = explode('+', $version);
        list($referenceVersionNumber, $referenceOffset) = explode('+', $referenceVersion);

        // Compare version numbers
        if (version_compare($versionNumber, $referenceVersionNumber) > 0) {
            return true;
        }

        // If version numbers are equal, compare offsets
        if ($versionNumber === $referenceVersionNumber) {
            return (int) $offset > (int) $referenceOffset;
        }

        return false;
    }
}

<?php
class Cleaner {
    public static function int($dannye): int {
        return (int) $dannye;
    }

    public static function uint($dannye): int {
        return abs(self::int($dannye));
    }

    public static function str($dannye): string {
        return trim(strip_tags((string) $dannye));
    }

    public static function str2db($dannye, PDO $bd): string {
        return $bd->quote(self::str($dannye));
    }

    public static function str2quote($dannye, PDO $bd): string {
        return $bd->quote((string) $dannye);
    }
}

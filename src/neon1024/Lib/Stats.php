<?php
declare(strict_types=1);
/**
 * Stats.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Lib;

class Stats
{
    /**
     * List of junctionable Character stats in the ingame order
     *
     * @var array JUNCTIONS
     */
    private const JUNCTIONS = [
        'HP-J',
        'Str-J',
        'Vit-J',
        'Mag-J',
        'Spr-J',
        'Spd-J',
        'Eva-J',
        'Hit-J',
        'Luck-J',
    ];

    private const AUTO_JUNCTION_PRIORITY = [
        'Spd-J',
        'HP-J',
        'Str-J',
        'Vit-J',
        'Spr-J',
        'Mag-J',
        'Luck-J',
        'Eva-J',
    ];

    /**
     * Get a list of the all the possible Character junctionable stats
     *
     * @return array
     */
    public static function list()
    {
        return self::JUNCTIONS;
    }

    /**
     * Get a list of all the possible Character junctionable stats in the preferred order of junctioning
     *
     * @return array
     */
    public static function autoJunctionList()
    {
        return self::AUTO_JUNCTION_PRIORITY;
    }
}

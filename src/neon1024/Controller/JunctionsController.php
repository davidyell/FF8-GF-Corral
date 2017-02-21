<?php
declare(strict_types=1);

/**
 * JunctionsController
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Controller;

use neon1024\Lib\Junctioner;
use neon1024\Repository\Garden;
use neon1024\Repository\Corral;
use neon1024\Repository\Party;
use neon1024\Entity\Character\Character;

class JunctionsController
{
    
    /**
     * List of all junctionable stats
     *
     * @var array
     */
    public $junctions = [
        'HP',
        'Str',
        'Vit',
        'Mag',
        'Spr',
        'Spd',
        'Eva',
        'Hit',
        'Luck'
    ];
    
    /**
     * Array of variables for the view
     *
     * @var array
     */
    public $viewVars = [];
    
    /**
     * Default data file locations
     *
     * @var array
     */
    private $defaults = [
        'characters' => '../../src/neon1024/Entity/Character/Characters.xml',
        'gfs' => '../../src/neon1024/Entity/GuardianForce/GFs.xml'
    ];
    
    /**
     * User data file locations
     *
     * @var array
     */
    private $userData = [
        'characters' => '../../config/Characters.xml',
        'gfs' => '../../config/GFs.xml'
    ];
    
    /**
     * Index action
     *
     * @return string
     */
    public function index()
    {
        $file = $this->defaults['gfs'];
        if (file_exists($this->userData['gfs'])) {
            $file = $this->userData['gfs'];
        }
        $corral = new Corral();
        $corral->loadFromXmlFile($file);
        
        $file = $this->defaults['characters'];
        if (file_exists($this->userData['characters'])) {
            $file = $this->userData['characters'];
        }
        $garden = new Garden();
        $garden->loadFromXmlFile($file);
        
        $this->viewVars = [
            'chars' => $garden,
            'gfs' => $corral
        ];
        
        return require('../../src/neon1024/Views/index.php');
    }
    
    /**
     * Automatically junction gfs to characters
     *
     * @return string
     */
    public function autoJunction()
    {
        $file = $this->defaults['gfs'];
        if (file_exists($this->userData['gfs'])) {
            $file = $this->userData['gfs'];
        }
        $corral = new Corral();
        $corral->loadFromXmlFile($file);
        
        if (file_exists($this->userData['characters'])) {
            $characterDataFile = file_get_contents($this->userData['characters']);
            $characterData = simplexml_load_string($characterDataFile);
        } else {
            $characterDataFile = file_get_contents($this->defaults['characters']);
            $characterData = simplexml_load_string($characterDataFile);
        }
        
        $one = new Character($characterData->Character[0]);
        $two = new Character($characterData->Character[1]);
        $three = new Character($characterData->Character[2]);
        
        $party = new Party($one, $two, $three);

        $junctioner = new Junctioner();
        $junctionResult = $junctioner->party($party, $corral);
        
        $this->viewVars = [
            'party' => $junctionResult['party'],
            'corral' => $junctionResult['corral'],
        ];
        
        return require('../../src/neon1024/Views/junction.php');
    }
}

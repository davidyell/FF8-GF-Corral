<?php
declare(strict_types=1);

/**
 * JunctionsController
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\FF8Corral\Controller;

use neon1024\FF8Corral\Lib\Junctioner;
use neon1024\FF8Corral\Lib\Stats;
use neon1024\FF8Corral\Repository\Garden;
use neon1024\FF8Corral\Repository\Corral;
use neon1024\FF8Corral\Repository\Party;
use neon1024\FF8Corral\Entity\Character\Character;
use Zend\Diactoros\Response;

class JunctionsController
{

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
     * @return \Zend\Diactoros\Response
     */
    public function index(): Response
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
            'junctions' => Stats::list(),
            'chars' => $garden,
            'gfs' => $corral,
        ];

        $response = new Response();
        $response->getBody()->write(require('../../src/neon1024/Views/index.php'));

        return $response;
    }
    
    /**
     * Automatically junction gfs to characters
     *
     * @return \Zend\Diactoros\Response
     */
    public function autoJunction(): Response
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

        $junctioner = new Junctioner($party, $corral);
        $junctioner->autojunction(true);
        $junctioner->autojunction(false);

        $this->viewVars = [
            'party' => $junctioner->party,
            'corral' => $junctioner->corral,
        ];

        $response = new Response();
        $response->getBody()->write(require('../../src/neon1024/Views/junction.php'));

        return $response;
    }
}

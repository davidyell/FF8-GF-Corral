<?php
/**
 * GuardianForce
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\GuardianForces;

class GuardianForce {
	
	private $name;
	private $element;
	private $junctions = [];
	
	public function __construct($data) {
		$this->setName((string)$data->name);
		$this->setElement((string)$data->element);
		$this->setJunctions((array)$data->Junctions->junction);
	}
	
	protected function setName($name) {
		$this->name = $name;
	}
	
	public function getname() {
		return $this->name;
	}
	
	protected function setElement($element) {
		$this->element = $element;
	}
	
	public function getElement() {
		return $this->element;
	}
	
	protected function setJunctions($junctions) {
		$this->junctions = $junctions;
	}
	
	public function addJunction($junction) {
		$this->junctions = array_merge($this->junctions, [$junction]);
	}
	
	public function hasJunction($junction) {
		if (in_array($junction . '-J', $this->junctions)) {
			return true;
		}
		
		return false;
	}
	
	public function getJunctions() {
		return $this->junctions;
	}
	
}
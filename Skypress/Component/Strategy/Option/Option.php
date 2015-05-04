<?php

namespace Skypress\Component\Strategy\Option;

/**
 *
 * @version 1.0
 * @since 1.0
 *
 * @author Thomas DENEULIN <contact@skypress.fr>
 *
 */
class Option
{

	private $options = array();

	public function __construct($options, OptionSaveInterface $saveOption = null){
		$this->options = $options;
		$this->optionSave = ($saveOption === null) ? new OptionSaveFunction() : $saveOption;
	}

	public function getOption($key){

		if(array_key_exists($key, $this->options)):
			return $this->options[$key];
		endif;

		return null;
	}

	public function setOptions($options){

		$this->options = $options;
		return $this;
	}

	public function setOption($key, $value){
		$this->options[$key] = $value;
		return $this;
	}

	public function setOptionSave(OptionSaveInterface $saveOption){
		$this->optionSave = $saveOption;
		return $this;
	}

	public function getOptionSave(){
		return $this->optionSave;
	}
}

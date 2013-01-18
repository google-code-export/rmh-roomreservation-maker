<?php
class FormHelper{
	
	private $formAttribs = array();
	
	private $fields = array();
	
	private $buttons = array();
	
	private $defaultData;
	private $dataErrors;
	
	function __construct($defaultData, $dataErrors){
		$this->defaultData = $defaultData;
		$this->dataErrors = $dataErrors;
	}
	
	/**
	 * @param array $options array of div attributes to set
	 * 				example: array('class'=>array('generic'),
	 * 								'name'=>'formname')
	 */
	public function create($options){
		//merge with default options
		$options = array_merge(array('class'=>'generic',
							'name'=>'genericForm',
							'method'=>'post',
						),$options);
		
		
		$this->formAttribs = $options;
	}
	
	public function input($options=array()){
		$options = array_merge(array('class'=>'formRow',
										'label'=>array(
													'value'=>'Input Field'
												),
										'input'=>array(
													'id'=>'inputField',
													'type'=>'text',
													'value'=>''
												)
									),
								$options);
		array_push($this->fields, $options);
	}
	
	public function button($options=array()){
		$options = array_merge(array('class'=>'formRow',
									'multi'=>false,
									'button'=> array(
											'type'=>'submit',
											'value'=>'Submit',
											'name'=>'submit',
											'class'=>'btn'
									)
		),
				$options);
		array_push($this->buttons, $options);
	}
	
	public function generate(){
		echo "<form";
		foreach($this->formAttribs as $attribName=>$attrib){
			$val = is_array($attrib) ? implode(" ", $attrib) : $attrib;
			echo " ".$attribName.'="'.$val.'"';
		}
		echo ">";
		
		echo generateTokenField();
		
		foreach($this->fields as $field){
			$val = is_array($field['class']) ? implode(" ",$field['class']) : $field['class'];
			if(!isset($field['label']['for'])){
				$field['label']['for'] = $field['input']['id'];
			}
			echo '<div class='.$val.">";
				echo $this->createLabel($field['label']);
				echo $this->createInput($field['input']);
			echo '</div>';
		}
		
		foreach($this->buttons as $button){
			$val = is_array($button['class']) ? implode(" ",$button['class']) : $button['class'];
			echo '<div class='.$val.">";
				if(!$button['multi']){
					echo $this->createButton($button['button']);
				}else{
					for($i=0;$i<count($button['button']); $i++){
						echo $this->createButton($button['button'][$i]);
					}
				}
				
			echo '</div>';
		}
		
		echo "</form>";
	}
	
	private function createLabel($attribs){
		$value = $attribs['value'];
		unset($attribs['value']);
		$labelField = '<label';
		foreach($attribs as $attribName=>$attrib){
			$val = is_array($attrib) ? implode(" ",$attrib) : $attrib;
			$labelField .= ' '.$attribName.'="'.$val.'"';
		}
		$labelField .= '>'.$value.'</label>';

		return $labelField;
	}
	
	private function createInput($attribs){
		$returnField = "";
		$id = $attribs['id'];
		//TODO check if id field is set! it is important to do so
		
		$type = isset($attribs['type']) ? $attribs['type'] : '';
		if(!isset($attribs['name'])){
			$attribs['name'] = $id;
		}
		
		$default = false; //has default data set or not?
		if(isset($this->defaultData[$attribs['id']]) && $this->defaultData[$attribs['id']] != ''){
			$default = true;
		}
		switch($type){
			case 'text':
				if($default)
					$attribs['value'] = $this->desanitize($this->defaultData[$id]);
				$returnField = $this->textField($attribs);
				break;
			case 'select':
				if($default)
					$attribs['selected'] = $this->defaultData[$id];
				$returnField = $this->select($attribs);
				break;
			case 'radio':
				if($default)
					$attribs['selected'] = $this->defaultData[$id];
				$returnField = $this->radio($attribs);
				break;
			default:
				//everything else goes here, like email, tel etc
				if($default)
					$attribs['value'] = $this->desanitize($this->defaultData[$id]);
				$returnField = $this->textField($attribs);
				break;
		}
		if(isset($this->dataErrors[$attribs['id']]) && $this->dataErrors[$attribs['id']] != ''){
			$returnField .= '<span class="error">'.$this->dataErrors[$attribs['id']].'</span>';
		}
		
		return $returnField;
	}
	
	private function createButton($button){
		$retField = "";
	
		switch($button['type']){
			case 'submit':
				$retField = '<input';
				foreach($button as $attribName=>$attrib){
					$val = is_array($attrib) ? implode(" ",$attrib) : $attrib;
					$retField .= ' '.$attribName.'="'.$val.'"';
				}
				$retField .= ' />';
				break;
	
			default:
				break;
		}
	
		return $retField;
	}
	
	private function textField($attribs){
		$retField = '<input';
		foreach($attribs as $attribName=>$attrib){
			$val = is_array($attrib) ? implode(" ",$attrib) : $attrib;
			$retField .= ' '.$attribName.'="'.$val.'"';
		}
		$retField .= ' />';
		
		return $retField;
	}
	
	private function select($attribs){
		$options = $attribs['options'];
		$selected = isset($attribs['selected']) ? $attribs['selected'] : '';
		unset($attribs['options']);
		
		$retField = '<select';
		foreach($attribs as $attribName=>$attrib){
			$val = is_array($attrib) ? implode(" ",$attrib) : $attrib;
			$retField .= ' '.$attribName.'="'.$val.'"';
		}
		$retField .= '>';
		
		foreach($options as $value=>$display){
			$retField .= '<option value="'.$value.'"';
			$retField .= ($selected == $value) ? ' selected="selected"' : '';
			$retField .= '>'.$display.'</option>';
		}
		
		$retField .= '</select>';
		
		return $retField;
	}
	
	private function radio($attribs){
		$selected = isset($attribs['selected']) ? $attribs['selected'] : '';
		$innerDiv = isset($attribs['innerDiv']) ? $attribs['innerDiv'] : 'rightGrid';
		$name = isset($attribs['name']) ? $attribs['name'] : $attribs['id'];
		$options = $attribs['options'];
		unset($attribs['options']);
		
		$retField = '<div class="'.$innerDiv.'">';
		foreach($options as $value=>$display){
			$retField .= '<input type="radio" id="'.$attribs['id'].'_'.$value.'" name="'.$name.'" value="'.$value.'"';
			$retField .= ($selected == $value) ? ' checked="true"' : '';
			$retField .= '/>';
			$retField .= $this->createLabel(array('for'=>$attribs['id'].'_'.$value, 'value'=>$display));
		}
		$retField .= '</div>';
		
		return $retField;
	}
	/**
	 * should ONLY be used for output generation! Harmful to use before data storage!
	 */
	private function desanitize($value){
		return htmlspecialchars_decode(stripslashes($value));
	}
	
}

?>
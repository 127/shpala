<?
/*
Kata v.0.1.13 beta от 20.04.2008
last modified

Пример:
		$form->formMethods(false, 'post', false, ' onsubmit="return false;"');
		$form->createField('string','<span class="openHidden">Открыть системные настройки</span>');
		$form->createField('hidden', 'action', $action);
		$form->createField('text', 'url', false, 'URL<sup>*</sup>: ');
		$form->createField('select', 'parent', $list, 'Вложить в<sup>*</sup>: ',0, false, false, 10,true);
		$form->createField('date', 'goal', $r->row['date'], 'Срок исполнения: ');
		$form->createField('radio', 'hide', $hideit, 'Отключить страницу: ',0);
		$form->setFieldSet('Добавить всписок',0,4);
		$form->createField('submit', 'submit', 'Добавить');
		$form->createField('button', 'submit', 'Добавить');
		$form->display();
*/

class Kata {
	//массив созданных полей
	protected $field = array(); 
	//выхлоп формы в конце
	protected $form; 
	// определяем параметры тэга <form>
	protected $formTag; 
	//выхлоп массива полей формы
	protected $formParts = array(); 
	 //можно заменить на br
	protected $separator = false;
	 
  	public function __construct($populate=false) {

  	}
	
 
	//создаем произвольное поле
	function createField(
		$type, 
		$name, 
		$value 	  = false, 
		$label 	  = false, 
		$selected = false, 
		$help	  = false, 
		$max	  = false, 
		$size	  = false, 
		$multiple = false, 
		$class    = false
	){
        $id = count($this->field);   		
        $this->field[$id] = array(
			'type'  => $type,
            'label' => $label,
            'help'  => $help,
            'value' => $value,
            'maxlength' => $max,
            'size'  => $size,
            'name'  => $name,
			'selected' => $selected,
			'multiple' => $multiple,
			'class' => $class			);
        return $this->genField($id);
    }
	
	//сборка аттрибутов в строку
	function implodeAttr($attr){
		$attr = implode('', $attr);
		return $attr;
	}

	
	//расставляем legends и fieldsets
	function setFieldSet($legend=false, $start, $end=false, $id=false, $class=false){
		if ($id) $id = " id=\"$id\"";
		if ($class) $class = " class=\"$class\"";
		if ($end==false) $end = $start;
		if ($legend) $legend = "\n<legend>$legend</legend>";
		$this->formParts[$start] = "<fieldset$id$class>$legend\n".$this->formParts[$start];
		$this->formParts[$end] .= "\n</fieldset>\n\n";
	}

	//возврат формы
	function returnForm(){	
		$this->form = implode('',$this->formParts);
		$this->form = preg_replace('/{form}/', $this->form, $this->formTag);
		return $this->form;
	}
	
	//вывод формы
	function display(){		
		if ($this->form==false) $this->returnForm();
		echo $this->form;
	}

	//определяем источник отправки формы и метод
	function formMethods($action, $method='POST', $id=false, $add=false, $class=false){
		if (!$action) $action = $_SERVER['REQUEST_URI'];
		
		if ($id) 	  $id = ' id="'.$id.'"';
		if ($class)   $id = ' class="'.$id.'"';

		$this->formTag = '<form action="'.$action.'" method="'.$method."\"".$id.$class.$add.">\n{form}</form>";
	}

	//собственно построение отдельных элементов формы
	function genField($id){			
		global $addons, $vars;
		$uid = $this->field[$id]['name'].$id.'i';
        $attrList['id']   = ' id="'.$uid.'"';
		if ($this->field[$id]['name']) $attrList['name'] = ' name="'.$this->field[$id]['name'].'"';
		if ($this->field[$id]['maxlength'])  $attrList['maxlength'] = ' maxlength="'.$this->field[$id]['maxlength'].'"';
		if ($this->field[$id]['size'])  $attrList['size'] = ' size="'.$this->field[$id]['size'].'"';
		if ($this->field[$id]['multiple'])  $attrList['multiple'] = ' multiple="multiple"';

		if ($this->field[$id]['help'])  $attrSecondary['help'] = '<span class="help">'.$this->field[$id]['help'].'</span>';
		if ($this->field[$id]['label']) $attrSecondary['label'] = '<label for="'. $uid.'">'.$this->field[$id]['label'].'</label>';
		if ($this->field[$id]['class']) $attrList['class'] = ' class="'.$this->field[$id]['class'].'"';

		switch ($this->field[$id]["type"]){	
			case 'file':
				$attrSecondary['label'] = preg_replace('/[\[\]]/','',$attrSecondary['label']);
				$attrList['id'] = preg_replace('/[\[\]]/','',$attrList['id']);
			case 'text':
				$element .= $attrSecondary['label'];
				$element = $element.$attrSecondary['help']; //нахуй??
			case 'submit':
			case 'button':
			case 'hidden':	
				if($this->field[$id]["type"] == 'submit') $attrList['id'] = ' id="submit"';
				//if($this->field[$id]["type"] == 'submit')$attrList['id']=false; //$attrList['id'] = ' id="submit'.$id.'"';
				if ($this->field[$id]['value'])  $attrUnique['value'] = ' value="'.$this->field[$id]['value'].'"';				
				$element .= '<input type="'.$this->field[$id]['type'].'"'. $this->implodeAttr($attrList).$attrUnique['value']." />".$this->separator."\n";
				break;
			case 'image':
				$attrList['id'] = ' id="submit"';
				$element .= '<input type="'.$this->field[$id]['type'].'"'. $this->implodeAttr($attrList).' src="'.$this->field[$id]['value']."\" />".$this->separator."\n";
				break;
			case 'textarea':
				////!!!!!!!!!!////
				if ($attrList['maxlength']) {					
					$attrList['cols'] = ' cols="'.$this->field[$id]['maxlength'].'"';
					unset($attrList['maxlength']);					
				}
				if ($attrList['size']){
					$attrList['rows'] = ' rows="'.$this->field[$id]['size'].'"';
					unset($attrList['size']);
				}
				///!!!!!!!!!!////
				 $element .= $attrSecondary['label'];
				 $element .= '<textarea'.$this->implodeAttr($attrList).">".$this->field[$id]['value']."</textarea>".$this->separator."\n";
				break;
			case 'select':			
				$attrSecondary['label'] = preg_replace('/[\[\]]/','',$attrSecondary['label']);
				$attrList['id'] = preg_replace('/[\[\]]/','',$attrList['id']);
				$element .= $attrSecondary['label'];
                $element .= '<select'.$this->implodeAttr($attrList).'>';
                foreach ($this->field[$id]['value'] as $k => $v){					
					$element .= '<option value="'.$k.'"';
					if ($this->field[$id]['selected'] == $k) $element .= ' selected="selected"';
					$element .= '>'.htmlspecialchars($v)."</option>\n";
				}
				$element .= '</select>'.$this->separator;				
				break;
			case 'radio':
            case 'checkbox':   				
				if ($attrSecondary['label']) $element .= '<span>'.strip_tags($attrSecondary['label']).'</span>'.$this->separator;
				// если передан массив значений
				if (is_array($this->field[$id]['value'])){
					foreach ($this->field[$id]['value'] as $k => $v){					
						if ($this->field[$id]["type"]=='checkbox') $attrList['name'] = ' name="'.$this->field[$id]['name'].'['.$k.']"';
						$uid = $this->field[$id]['name'].$id.$k.'i';
						$attrList['id']   = ' id="'.$uid.'"';					
						$attrSecondary['label'] = '<label for="'.$uid.'">'.$v.'</label>';					
						$element .= '<input type="'.$this->field[$id]['type'].'" class="small"';
						if(is_array($this->field[$id]['selected'])){
							if (in_array($k,$this->field[$id]['selected'])) $element .= ' checked="checked"';	
						}
						else{
							if ($this->field[$id]['selected'] == $k) $element .= ' checked="checked"';		
						}	
						$element .= $this->implodeAttr($attrList)." />\n";
						$element .= $attrSecondary['label'];
						$element .= $this->separator."\n";
						
					}	
				}
				else{
					//если единичный чекбокс
					if ($this->field[$id]["type"]=='checkbox') $attrList['name'] = ' name="'.$this->field[$id]['name'].'"';
					$uid = $this->field[$id]['name'].$id.'i';
					$attrList['id']   = ' id="'.$uid.'"';
					
					$attrSecondary['label'] = '<label for="'.$uid.'">'.$this->field[$id]['value'].'</label>';

					$element .= '<input type="'.$this->field[$id]['type'].'" class="small"';

					if ($this->field[$id]['selected'] == 1) $element .= ' checked="checked"';	

					$element .= $this->implodeAttr($attrList).' value="'.$this->field[$id]['value']."\" />\n";
					$element .= $attrSecondary['label'];
					$element .= $this->separator."\n";
				}
				
				break;
			case 'string':
				$element .= $this->field[$id]['name'];
				break;
			case 'date':
				$element .= '<span>'.strip_tags($attrSecondary['label']).'</span>'.$this->separator;
				$darray = explode(' ', $this->field[$id]['value']);
				$dyear = explode('-', $darray[0]);

				$cyear = date("Y");
				$lyear = $cyear+1; // :-))))))))))))))))
				$lday = 31;

				$element.= '<select name='.$this->field[$id]['name'].'[year]>';
				for($cyear; $cyear<$lyear; $cyear++){
						if($cyear==$dyear[0]) $selected = ' selected="selected"';
						else $selected = false;
						$element.='<option value="'.$cyear.'"'.$selected.'>'.$cyear.'</option>';					
				}
				$element.= '</select>';
				
				$element.= '<select name='.$this->field[$id]['name'].'[month]>';
				foreach($addons->month[$vars['lc']['lang']] as $k=>$v){
					if ($v!=false) {
						if (strlen($k)==1) $k = "0$k";
						if($k==$dyear[1]) $selected = ' selected="selected"';
						else $selected = false;
						$element.='<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
					}
				}
				$element.= '</select>';

				$element.= '<select name='.$this->field[$id]['name'].'[day]>';
				for($i=0; $i<=$lday; $i++){	
						$z=$i;
						if (strlen($z)==1) $z = "0$z";
						if($z==$dyear[2]) $selected = ' selected="selected"';
						else $selected = false;
						if ($i!=0) $element.='<option value="'.$z.'"'.$selected.'>'.$i.'</option>';					
				}
				$element.= '</select>'.$this->separator;
				
				break;
		}		
		$this->formParts[$id] = $element;
		return $this->formParts[$id];
	}
}
?>

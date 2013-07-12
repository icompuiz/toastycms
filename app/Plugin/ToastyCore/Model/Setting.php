<?php
App::uses("ToastyCoreAppModel", "ToastyCore.Model");
class Setting extends ToastyCoreAppModel {

	public $name = "Setting";


	public $validate = array(

		'name' => array(
			'notEmpty' => array(
				'rule' =>'notEmpty',
				'message' => 'Please provide a name for this setting'
			),
			'isUnique' => array(
				'rule' =>array('isUniqueCheck', false),
				'on' => 'create',
				'message' => 'A setting with that name already exists. Any non alphanumeric character is replaced with an underscore and the value is all lowercase'
			),
			'isUniquedit' => array(
				'rule' =>array('isUniqueCheck', true),
				'on' => 'update',
				'message' => 'A setting with that name already exists. Any non alphanumeric character is replaced with an underscore and the value is all lowercase'
			)
		)

	);

	public function findByName($name) {

		$options = array(
			'conditions' => array(

				'Setting.name' => $name
			)

		);

		$setting = $this->find('first', $options);

		return $setting;

	}

	public function isUniqueCheck($name, $edit) {

		$name = $name['name'];
		
		$name = preg_replace("~\W~", "_", $name);

		$name = Inflector::underscore($name);

		$options = array(
			'conditions' => array(

				'Setting.name' => $name
			)

		);

		$setting = $this->find('first', $options);

		if ($edit) {

			if (!empty($setting)) {
				if ($name == $setting['Setting']['name']) {

					return true;

				}
			}

		}

		return empty($setting);

	}

	public function isRoot($id) {

		$setting = $this->findById($id);

		$is_root = $setting['Setting']['type'] === 'root';

		return $is_root;

	}

	public function beforeSave($options = array()) {

		parent::beforeSave($options);

		$data = $this->data;

		$name = $data['Setting']['name'];

		$name = preg_replace("~\W~", "_", $name);

		$name = Inflector::underscore($name);

		$this->data['Setting']['name'] = $name;

		if ( isset($data['Setting']['id'])) {
			$id = $data['Setting']['id'];
			
			$is_root = $this->isRoot($id);
			if ($is_root) {
				unset($this->data['Setting']['name']);
			}
		}

		return true;

	}

}

?>
<?php

	function implode_associative($pieces) {
		$output = "";

		if (null !== $pieces ) {
			foreach ($pieces as $key => $value) {
				$output .= "$key=\"$value\" ";
			}
		}

		return trim($output);

	}

	if (isset($id)) {

		$links = isset($links) ? $links : true;

		$link_attributes = isset($link_attributes) ? $link_attributes : null;
		$list_attributes = isset($list_attributes) ? $list_attributes : null;
		$item_attributes = isset($item_attributes) ? $item_attributes : null;

		$link_attributes = implode_associative($link_attributes);
		$item_attributes = implode_associative($item_attributes);
			
		$item_template = isset($item_template) ? $item_template : null;

		$content = $this->getContent($id);

		if (!empty($content)) {

			$children = isset($content['ChildContent']) ? $content['ChildContent'] : array();

			$item_format = "<li%s>%s</li>";
			$list_format = "<ul%s>%s</ul>";
			$list_output = "";
			foreach ($children as $item) {

				if ($links) {
					$item_link = $this->Html->link($item['name'], array('controller' => 'contents', 'action' => 'view', $item['id']), $link_attributes);
					$item_output = sprintf($item_format, $item_attributes, $item_link);
				} else {
					$item_output = sprintf($item_format, $item_attributes, $item['name']);
				}

				$list_output .= $item_output;
			}

			echo sprintf($list_format, $list_attributes, $list_output);

		} else {

			echo "<!--No content with id: $id-->";

		}



	}

?>
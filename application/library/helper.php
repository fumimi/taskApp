<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Helper {
	
	function selector($name, $option, $item = '', $attribute = '') {
		
		$string = '';
		if (is_array($option) && count($option) > 0) {
			foreach ($option as $key => $value) {
				if ($key == $item) {
					$selected = ' selected="selected"';
				} else {
					$selected = '';
				}
				$string .= sprintf('<option value="%s"%s>%s</option>', $key, $selected, $value);
			}
		}
		$selector = sprintf('<select id="%s" name="%s"%s>%s</select>', $name, $name, $attribute, $string);
		return $selector;
		
	}
	
	function option($begin, $end, $item = '') {
		
		$option = '';
		for ($i = $begin; $i <= $end; $i++) {
			$value = $i;
			if ($value == $item && strlen($item) > 0) {
				$selected = ' selected="selected"';
			} else {
				$selected = '';
			}
			$option .= sprintf('<option value="%d"%s>%d</option>', $value, $selected, $value);
		}
		return $option;
		
	}
	
	function checkbox($name, $value, $item, $label, $caption, $attribute = '') {
		
		if ($value == $item) {
			$checked = ' checked="checked"';
		} else {
			$checked = '';
		}
		$checkbox = '<input type="checkbox" name="%s" id="%s" value="%s"%s%s /><label for="%s">%s</label>';
		$checkbox = sprintf($checkbox, $name, $label, $value, $checked, $attribute, $label, $caption);
		return $checkbox;
	
	}
	
	function radio($name, $value, $item, $label, $caption, $attribute = '') {
		
		if ($value == $item) {
			$checked = ' checked="checked"';
		} else {
			$checked = '';
		}
		$radio = '<input type="radio" name="%s" id="%s" value="%s"%s%s /><label for="%s">%s</label>';
		$radio = sprintf($radio, $name, $label, $value, $checked, $attribute, $label, $caption);
		return $radio;
	
	}
	
	function attribute($attribute, $value, $string) {
	
		if ($value == $string) {
			$attribute = ' '.$attribute.'="'.$attribute.'"';
		} else {
			$attribute = '';
		}
		return $attribute;
	
	}

	function resizeImage($image, $maxwidth = 200, $maxheight = 150) {
		
		$tag = '';
		$size = @getimagesize($image);
		if ($size[0] > $maxwidth && $size[1] > $maxheight) {
			if ($size[1]/$size[0] < $maxheight/$maxwidth) {
				$tag = 'width:'.$maxwidth.'px;';
			} else {
				$tag = 'height:'.$maxheight.'px;';
			}
		} elseif ($size[0] > $maxwidth) {
			$tag = 'width:'.$maxwidth.'px;';
		} elseif ($size[1] > $maxheight) {
			$tag = 'height:'.$maxheight.'px;';
		}
		if (strlen($tag) > 0) {
			$tag = ' style="'.$tag.'"';
		}
		return $tag;
	
	}
	
	function multisort($data, $sortkey, $desc = '') {
		
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $key => $row) {
				$array[$key] = $row[$sortkey];
			}
			if ($desc == 'desc') {
				$desc = SORT_DESC;
			} else {
				$desc = SORT_ASC;
			}
			array_multisort($array, $desc, $data);
		}
		return $data;
		
	}

}
?>
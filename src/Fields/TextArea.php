<?php

namespace marcusvbda\vstack\Fields;

class TextArea extends Field
{
	public $options = [];
	public $view = "";
	public function __construct($op = [])
	{
		$this->options = $op;
		$this->options["type"] = "textarea";
		parent::processFieldOptions();
	}

	public function getView($type = "input")
	{
		if (@$this->options["hide"]) {
			return $this->view = "";
		}

		if ($type == "view") {
			return $this->getViewOnlyValue();
		}
		$label          = $this->options["label"];
		$field          = $this->options["field"];
		$type           = $this->options["type"];
		$placeholder    = $this->options["placeholder"];
		$description    = @$this->options["description"];
		$disabled       = @$this->options["disabled"] ? "true" : "false";
		$rows           = @$this->options["rows"] ? $this->options["rows"] : 3;
		$maxlength      = $this->options["maxlength"] ?  $this->options["maxlength"] : $this->getDefaultMaxlength(9999999999);
		$eval = " " . (@$this->options["eval"] ? trim($this->options["eval"]) : "") . " ";
		$show_value_length = (@$this->options["show_value_length"] !== null) ? $this->options["show_value_length"] : false;
		$show_value_length = $show_value_length ? 'true' : 'false';

		return $this->view = view("vStack::resources.field.textarea", compact(
			"disabled",
			"label",
			"type",
			"rows",
			"placeholder",
			"description",
			"field",
			"maxlength",
			"eval",
			"show_value_length"
		))->render();
	}
}

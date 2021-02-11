<?php

namespace marcusvbda\vstack\Fields;

class HtmlEditor extends Field
{
	public $options = [];
	public $view = "";
	public function __construct($op = [])
	{
		$this->options = $op;
		$this->options["type"] = "html_editor";
		parent::processFieldOptions();
	}

	public function getView()
	{
		if (@$this->options["hide"]) return $this->view = "";

		$field     = $this->options["field"];
		$label = $this->options["label"];
		$uploadroute = @$this->options["uploadroute"];
		$mode = @$this->options["mode"] ? $this->options["mode"] : 'webpage';
		$field = $this->options["field"];
		return $this->view = view("vStack::resources.field.html_editor", compact(
			"label",
			"field",
			"uploadroute",
			"mode"
		))->render();
	}
}
<?php
/**
 * Shows a widget with viewing blog entries
 * by months or years.
 *
 * @package blog
 */
class LatestBlogEntries extends Widget {

	static $db = array(
		'NumberOfItems' => 'Int',
		'Header' => 'Varchar(30)',
		'OnlyFromThisPage' => 'Boolean'
	);

	static $defaults = array(
		'NumberOfItems' => 7
	);

	static $title = 'Latest Blog Entries';

	static $cmsTitle = 'Latest Blog Entries';

	static $description = 'Show a list of latest blog entries.';

	function getCMSFields() {
		return new FieldSet(
			new NumericField("NumberOfItems","Number Of Items Shown"),
			new CheckboxField("OnlyFromThisPage","Only from This Page")
		);
	}

	private $data = null;

	function Links() {
		Requirements::themedCSS("widgets_latestblogentries");
		if($this->OnlyFromThisPage && $data = $this->getData()) {
			return $data->Entries($this->NumberOfItems);
		}
		else {
			return DataObject::get("BlogEntry", null, "\"Created\" DESC", null, $this->NumberOfItems);
		}
	}

	function Title(){
		if($this->Header) {
			return $this->Header;
		}
		elseif($this->OnlyFromThisPage && $data = $this->getData()) {
			return $data->Title." News";
		}
		else {
			return parent::Title();
		}
	}

	protected function getData(){
		$controller = Controller::curr();
		if($controller) {
			if($data = $controller->data()) {
				return $data;
			}
		}
	}

}

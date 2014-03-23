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

	function Links() {
		Requirements::themedCSS("widgets_latestblogentries");
		if($this->OnlyFromThisPage) {
			$controller = Controller::curr();
			if($controller) {
				if($data = $controller->data()) {
					return $data->Entries($this->NumberOfItems);
				}
			}
		}
		else {
			return DataObject::get("BlogEntry", null, "\"Created\" DESC", null, $this->NumberOfItems);
		}
	}

}

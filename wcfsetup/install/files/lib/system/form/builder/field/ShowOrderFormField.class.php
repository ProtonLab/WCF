<?php
namespace wcf\system\form\builder\field;
use wcf\system\form\builder\IFormNode;
use wcf\system\WCF;

/**
 * Implementation of a form field for an object's `showOrder` property which determines
 * the order in which the objects are shown.
 * 
 * The show order field provides a list of siblings and the object will be positioned
 * *after* the selected sibling. To insert objects at the very beginning, the `options()`
 * method prepends an additional option for that case.
 *
 * This field uses the `wcf.form.field.showOrder` language item as the default form
 * field label uses `showOrder` as the default node id.
 * 
 * @author	Matthias Schmidt
 * @copyright	2001-2018 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	WoltLabSuite\Core\System\Form\Builder\Field
 * @since	3.2
 */
class ShowOrderFormField extends SingleSelectionFormField {
	/**
	 * Creates a new instance of `ShowOrderFormField`.
	 */
	public function __construct() {
		$this->label('wcf.form.field.showOrder');
	}
	
	/**
	 * @inheritDoc
	 */
	public function getSaveValue() {
		if ($this->__value) {
			$index = array_search($this->__value, array_keys($this->getOptions()));
			
			if ($index !== false) {
				return $index + 1;
			}
			
			return null;
		}
		
		return $this->__value;
	}
	
	/**
	 * @inheritDoc
	 * @return	static
	 * 
	 * There is an additional element prepended to the options with key `0`
	 * and using the language item `wcf.form.field.showOrder.firstPosition`
	 * as value to mark adding it at the first position.
	 */
	public function options($options): ISelectionFormField {
		parent::options($options);
		
		$this->__options = array_merge(
			[0 => WCF::getLanguage()->get('wcf.form.field.showOrder.firstPosition')],
			$this->__options
		);
		
		return $this;
	}
	
	/**
	 * @inheritDoc
	 */
	public function value($value): IFormField {
		$keys = array_keys($this->getOptions());
		
		if (count($keys) < $value) {
			throw new \InvalidArgumentException("Unknown value '{$value}' as only " . count($keys) . " values are available.");
		}
		
		return parent::value($keys[$value]);
	}
	
	/**
	 * @inheritDoc
	 * @return	static
	 */
	public static function create(string $id = 'showOrder'): IFormNode {
		return parent::create($id);
	}
}
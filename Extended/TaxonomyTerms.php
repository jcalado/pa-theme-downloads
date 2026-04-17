<?php

namespace Extended;

use Extended\ACF\Fields\Field;
use Extended\ACF\Fields\Settings\ConditionalLogic;
use Extended\ACF\Fields\Settings\Instructions;
use Extended\ACF\Fields\Settings\Wrapper;

/**
 * Register Taxonomy Terms field
 */
class TaxonomyTerms extends Field {

  use ConditionalLogic;
  use Instructions;
  use Wrapper;

  protected null|string $type = 'acfe_taxonomy_terms';

	/**
	 * taxonomies Allowed terms
	 *
	 * @param  array $value Terms limit
	 * @return self
	 */
	public function allowTerms(array $value): self {
    $this->withSettings(array('allow_terms' => $value));

    return $this;
  }

  /**
	 * taxonomies Allowed taxonomies
	 *
	 * @param  array $value Taxonomies limit
	 * @return self
	 */
	public function taxonomies(array $value): self {
    $this->withSettings(array('taxonomy' => $value));

    return $this;
  }

  /**
	 * fieldType Field display type
	 *
	 * @param  string $value Type key
	 * @return self
	 */
	public function fieldType(string $value): self {
    if(!in_array($value, ['checkbox', 'radio', 'select']))
      throw new \InvalidArgumentException("Invalid argument return format [$value].");

    $this->withSettings(array('field_type' => $value));

    return $this;
  }

  /**
   * stylisedUi Improved field interface
   *
   * @return self
   */
  public function stylisedUi(): self {
    $this->withSettings(array('ui' => true));

    return $this;
  }

  /**
   * saveTerms Connects selected terms to the post object
   *
   * @param  mixed $saveTerms True to connect
   * @return self
   */
  public function saveTerms(bool $saveTerms = true): self {
    $this->withSettings(array('save_terms' => $saveTerms));

    return $this;
  }

  /**
   * loadTerms Loads selected terms from the post object
   *
   * @param  mixed $loadTerms True to connect
   * @return self
   */
  public function loadTerms(bool $loadTerms = true): self {
    $this->withSettings(array('load_terms' => $loadTerms));

    return $this;
  }

  /**
   * useAjax Add AJAX option
   *
   * @return self
   */
  public function useAjax(): self {
    $this->withSettings(array('ajax' => true));

    return $this;
  }

  /**
   * multiple Select multiple values
   *
   * @return self
   */
  public function multiple(): self {
    $this->withSettings(array('multiple' => true));

    return $this;
  }

  /**
   * placeholder Set placeholder
   *
   * @return self
   */
  public function placeholder(string $value): self {
    $this->withSettings(array('placeholder' => $value));

    return $this;
  }

  /**
   * @param string $format array, id, label, object, url or value
   * @throws \InvalidArgumentException
   * @return static
   */
  public function returnFormat(string $format): self {
      if(!in_array($format, ['object', 'name', 'id']))
        throw new \InvalidArgumentException("Invalid argument return format [$format].");

      $this->withSettings(array('return_format' => $format));

      return $this;
  }

}

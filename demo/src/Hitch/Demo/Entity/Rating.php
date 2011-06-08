<?php

/**
 * This file is part of the Hitch Demo package
 *
 * (c) Marc Roulias <marc@lampjunkie.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hitch\Demo\Entity;

/**
 * @xml:XmlElement
 */
class Rating
{
  /**
   * @xml:XmlAttribute
   */
  protected $type;

  /**
   * @xml:XmlValue
   */
  protected $value;

  public function setType($type)
  {
    $this->type = $type;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }

  public function getValue()
  {
    return $this->value;
  }

}

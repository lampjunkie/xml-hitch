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
 *
 */
class Comment
{
  /**
   * @xml:XmlAttribute
   */
  protected $user;

  /**
   * @xml:XmlValue
   */
  protected $value;

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function getUser()
  {
    return $this->user;
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

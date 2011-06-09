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
 * @xml:XmlObject
 *
 */
class Meta
{
  /**
   * @xml:XmlElement(name="version")
   */
  protected $version;

  /**
   * @xml:XmlElement(name="category")
   */
  protected $category;

  /**
   * @xml:XmlElement(name="response_time")
   */
  protected $responseTime;

  public function setVersion($version)
  {
    $this->version = $version;
  }

  public function getVersion()
  {
    return $this->version;
  }

  public function setCategory($category)
  {
    $this->category = $category;
  }

  public function getCategory()
  {
    return $this->category;
  }

  public function getResponseTime()
  {
    return $this->responseTime;
  }

  public function setResponseTime($responseTime)
  {
    $this->responseTime = $responseTime;
  }
}

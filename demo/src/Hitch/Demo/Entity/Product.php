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
class Product
{
  /**
   * @xml:XmlAttribute
   */
  protected $id;

  /**
   * @xml:XmlAttribute(name="name")
   */
  protected $name;

  /**
   * @xml:XmlAttribute(name="price")
   */
  protected $price;

  /**
   * @xml:XmlAttribute(name="url")
   */
  protected $url;

  /**
   * @xml:XmlList(name="comment", wrapper="comments", type="Hitch\Demo\Entity\Comment")
   */
  protected $comments;

  /**
   * @xml:XmlList(name="rating", type="Hitch\Demo\Entity\Rating")
   */
  protected $ratings;

  /**
   * @xml:XmlElement
   */
  protected $description;

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function setUrl($url)
  {
    $this->url = $url;
  }

  public function getUrl()
  {
    return $this->url;
  }

  public function setComments($comments)
  {
    $this->comments = $comments;
  }

  public function getComments()
  {
    return $this->comments;
  }

  public function setRatings($ratings)
  {
    $this->ratings = $ratings;
  }

  public function getRatings()
  {
    return $this->ratings;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getDescription()
  {
    return $this->description;
  }
}

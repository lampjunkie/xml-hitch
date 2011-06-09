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

use Hitch\Demo\Entity\Meta;

/**
 * @xml:XmlObject
 *
 */
class Catalog
{
  /**
   * @xml:XmlAttribute
   */
  protected $name;

  /**
   * @xml:XmlElement(type="Hitch\Demo\Entity\Meta")
   */
  protected $meta;

  /**
   * @xml:XmlList(name="product", wrapper="products", type="Hitch\Demo\Entity\Product")
   */
  protected $products;

  /**
   * @xml:XmlAttribute(name="num", node="products")
   */
  protected $numProducts;

  /**
   * @xml:XmlAttribute(name="total", node="products")
   */
  protected $totalProducts;

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setMeta(Meta $meta)
  {
    $this->meta = $meta;
  }

  public function getMeta()
  {
    return $this->meta;
  }

  public function setProducts($products)
  {
    $this->products = $products;
  }

  public function getProducts()
  {
    return $this->products;
  }

  public function getNumProducts()
  {
    return $this->numProducts;
  }

  public function setNumProducts($numProducts)
  {
    $this->numProducts = $numProducts;
  }

  public function getTotalProducts()
  {
    return $this->totalProducts;
  }

  public function setTotalProducts($totalProducts)
  {
    $this->totalProducts = $totalProducts;
  }
}

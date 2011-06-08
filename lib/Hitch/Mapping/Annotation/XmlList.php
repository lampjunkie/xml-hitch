<?php

/**
 * This file is part of the Hitch package
 *
 * (c) Marc Roulias <marc@lampjunkie.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hitch\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * XmlList maps a property to a collection of XML nodes
 * 
 * @author marc
 */
class XmlList extends Annotation
{
	public $name;
	public $type;
	public $wrapper;
}

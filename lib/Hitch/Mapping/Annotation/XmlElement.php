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
 * XmlElement maps a entity property or class to an XML node
 * 
 * @author marc
 */
class XmlElement extends Annotation
{
	public $name;
	public $type;
}

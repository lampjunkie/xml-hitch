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
 * XmlObject maps a class to XML by letting Hitch know that the annotated
 * class should be parsed for additional annotations
 * 
 * @author marc
 */
class XmlObject extends Annotation
{
}

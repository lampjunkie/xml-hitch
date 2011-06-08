<?php

/**
 * This file is part of the Hitch package
 *
 * (c) Marc Roulias <marc@lampjunkie.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hitch\Mapping\Loader;

use Doctrine\Common\Annotations\AnnotationReader;

use Hitch\Mapping\Annotation\XmlAttribute;
use Hitch\Mapping\Annotation\XmlElement;
use Hitch\Mapping\Annotation\XmlList;
use Hitch\Mapping\Annotation\XmlValue;
use Hitch\Mapping\ClassMetadata;

/**
 * AnnotationLoader loads all of the annotations from an entity class and sets
 * them to a ClassMetadata object
 *
 */
class AnnotationLoader
{
  /**
   * @var AnnotationReader
   */
  protected $reader;

  /**
   * Build the AnnotationLoader with an AnnotationReader
   *
   * @param AnnotationReader $reader
   */
  public function __construct(AnnotationReader $reader)
  {
    $this->reader = $reader;
    $this->reader->setAutoloadAnnotations(true);
    $this->reader->setAnnotationNamespaceAlias('Hitch\\Mapping\\Annotation\\', 'xml');
  }

  /**
   * Parse all of the annotations for a given ClassMetadata object
   *
   * @param ClassMetadata $metadata
   */
  public function loadClassMetadata(ClassMetadata $metadata)
  {
    $reflClass = $metadata->getReflectionClass();
    $className = $reflClass->getName();

    foreach ($this->reader->getClassAnnotations($reflClass) as $annotation) {
      if ($annotation instanceof XmlElement) {
        $this->loadClassAttributes($metadata);
        $this->loadClassElements($metadata);
        $this->loadClassLists($metadata);
        $this->loadClassValue($metadata);
      }
    }
  }

  /**
   * Load all of the @XmlAttribute annotations
   * 
   * @param ClassMetadata $metadata
   */
  protected function loadClassAttributes(ClassMetadata $metadata)
  {
    $reflClass = $metadata->getReflectionClass();
     
    foreach ($reflClass->getProperties() as $property) {
      foreach($this->reader->getPropertyAnnotations($property) as $annotation){
        if($annotation instanceof XmlAttribute){
          $attributeName = !is_null($annotation->name) ? $annotation->name : $property->getName();
          $nodeName = $annotation->node;
          $metadata->addAttribute($attributeName, $property->getName(), $nodeName);
        }
      }
    }
  }

  /**
   * Load all of the @XmlElement annotations
   * 
   * @param ClassMetadata $metadata
   */
  protected function loadClassElements(ClassMetadata $metadata)
  {
    $reflClass = $metadata->getReflectionClass();
     
    foreach ($reflClass->getProperties() as $property) {

      foreach($this->reader->getPropertyAnnotations($property) as $annotation){
        if($annotation instanceof XmlElement){
          $nodeName = !is_null($annotation->name) ? $annotation->name : $property->getName();
          if(is_null($annotation->type)){
            $metadata->addElement($nodeName, $property->getName());
          } else {
            $embeddedMetadata = new ClassMetadata($annotation->type);
            $this->loadClassMetadata($embeddedMetadata);
            $metadata->addEmbed($nodeName, $property->getName(),$embeddedMetadata);
          }
        }
      }
    }
  }

  /**
   * Load all of the @XmlList annotations
   * 
   * @param ClassMetadata $metadata
   */
  protected function loadClassLists(ClassMetadata $metadata)
  {
    $reflClass = $metadata->getReflectionClass();
     
    foreach ($reflClass->getProperties() as $property) {

      foreach($this->reader->getPropertyAnnotations($property) as $annotation){
        if($annotation instanceof XmlList){
          $nodeName = !is_null($annotation->name) ? $annotation->name : $property->getName();

          if(!is_null($annotation->type)){
            $embeddedMetadata = new ClassMetadata($annotation->type);
            $this->loadClassMetadata($embeddedMetadata);
          } else {
            $embeddedMetadata = null;
          }
           
          $metadata->addList($property->getName(), $nodeName, $annotation->wrapper,$embeddedMetadata);
           
        }
      }
    }
  }

  /**
   * Load all of the @XmlValue annotations
   * 
   * @param ClassMetadata $metadata
   */
  protected function loadClassValue(ClassMetadata $metadata)
  {
    $reflClass = $metadata->getReflectionClass();
     
    foreach ($reflClass->getProperties() as $property) {

      foreach($this->reader->getPropertyAnnotations($property) as $annotation){
        if($annotation instanceof XmlValue){
          $metadata->setValue($property->getName());
        }
      }
    }
  }
}

<?php

/**
 * This file is part of the Hitch package
 *
 * (c) Marc Roulias <marc@lampjunkie.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hitch\Mapping;

use Doctrine\Common\Cache\AbstractCache;

use Hitch\Mapping\ClassMetadata;
use Hitch\Mapping\Loader\AnnotationLoader;

/**
 * The ClassMetadataFactory is used to create ClassMetadata objects that contain all the
 * metadata mapping informations of a class which describes how a class should be mapped
 * to an XML document.
 *
 * @author marc
 */
class ClassMetadataFactory
{
  /**
   * The loader for loading the class metadata
   * @var LoaderInterface
   */
  protected $loader;

  /**
   * The cache for caching class metadata
   * @var AbstractCache
   */
  protected $cache;

  /**
   * Already loaded classes
   *
   * @var array
   */
  protected $loadedClasses = array();

  /**
   * Required dependencies
   *
   * @param LoaderInterface $loader
   * @param AbstractCache $cache
   */
  public function __construct(AnnotationLoader $loader, AbstractCache $cache = null)
  {
    $this->loader = $loader;
    $this->cache = $cache;
  }

  /**
   * Returns the class metadata associated to the given class name
   *
   * @param string $class
   */
  public function getClassMetadata($class)
  {
    $class = ltrim($class, '\\');

    if (! isset($this->loadedClasses[$class])) {

      $cache = $this->getCache();

      if ($cache !== null && $cache->contains($class)) {
        $this->loadedClasses[$class] = $cache->fetch($class);
      } else {
        $metadata = $this->createClassMetaData($class);
        $this->getLoader()->loadClassMetadata($metadata);

        $this->loadedClasses[$class] = $metadata;

        if ($cache !== null) {
          $cache->save($class, $metadata);
        }
      }
    }

    return $this->loadedClasses[$class];
  }

  /**
   * Create the ClassMetadata for a class name
   * 
   * @param string $class
   * @return ClassMetadata
   */
  public function createClassMetadata($class)
  {
    return new ClassMetadata($class);
  }

  /**
   * @return the $loader
   */
  public function getLoader()
  {
    return $this->loader;
  }

  /**
   * @param LoaderInterface $loader
   */
  public function setLoader($loader)
  {
    $this->loader = $loader;
  }

  /**
   * @return the $cache
   */
  public function getCache()
  {
    return $this->cache;
  }

  /**
   * @param AbstractCache $cache
   */
  public function setCache($cache)
  {
    $this->cache = $cache;
  }

  /**
   * @return the $loadedClasses
   */
  public function getLoadedClasses()
  {
    return $this->loadedClasses;
  }

  /**
   * @param array $loadedClasses
   */
  public function setLoadedClasses($loadedClasses)
  {
    $this->loadedClasses = $loadedClasses;
  }
}
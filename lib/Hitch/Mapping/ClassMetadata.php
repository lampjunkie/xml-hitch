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

/**
 * A ClassMetadata instance holds all of the XML mapping information for an entity
 * 
 * @author marc
 */
class ClassMetadata
{
    /**
     * @var ReflectionClass
     */
    protected $reflClass;

    /**
     * The class name
     *
     * @var string
     */
    protected $className;

    /**
     * Array of xml attributes
     * 
     * @var array
     */
    protected $attributes = array();

    /**
     * Array of child xml elements
     * 
     * @var array
     */
    protected $elements = array();

    /**
     * Array of embedded ClassMetadata objects
     * 
     * @var array
     */
    protected $embeds = array();

    /**
     * Array of xml lists
     * 
     * @var array
     */
    protected $lists = array();

    /**
     * The value node info
     * 
     * @var string
     */
    protected $value;

    /**
     * Constructs a metadata for the given class
     *
     * @param string $class
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the fully qualified name of the class
     *
     * @return string  The fully qualified class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns a ReflectionClass instance for this class.
     *
     * @return ReflectionClass
     */
    public function getReflectionClass()
    {
        if (! $this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getClassName());
        }

        return $this->reflClass;
    }

    /**
     * Add info for an XML attribute
     * 
     * @param string $name
     * @param string $property
     * @param string $nodeName
     */
	public function addAttribute($name, $property, $nodeName)
	{
		$this->attributes[$name] = array($property, $nodeName);
	}

	/**
	 * Get all of the attributes
	 * 
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * Add info for an XML element
	 * 
	 * @param string $name
	 * @param string $property
	 */
	public function addElement($name, $property)
	{
		$this->elements[$name] = $property;
	}

	/**
	 * Get all of the XML elements
	 * 
	 * @return array
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * Add an embedded ClassMetadata
	 * 
	 * @param string $nodeName
	 * @param string $property
	 * @param ClassMetadata $metadata
	 */
	public function addEmbed($nodeName, $property, ClassMetadata $metadata)
	{
		$this->embeds[$nodeName] = array($property, $metadata);
	}

	/**
	 * Get all of the embedded ClassMetadata(s)
	 * 
	 * @return array
	 */
	public function getEmbeds()
	{
		return $this->embeds;
	}

	/**
	 * Add info for an XML list
	 * 
	 * @param string $property
	 * @param string $nodeName
	 * @param string $wrapperNode
	 * @param ClassMetadata $metadata
	 */
	public function addList($property, $nodeName, $wrapperNode = null, ClassMetadata $metadata = null)
	{
		$this->lists[$nodeName] = array($property, $wrapperNode, $metadata);
	}

	/**
	 * Get all of the XML lists
	 * 
	 * @return array
	 */
	public function getLists()
	{
		return $this->lists;
	}

	/**
	 * Set the node name which holds the value
	 * 
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * Get the value node name
	 * 
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
}

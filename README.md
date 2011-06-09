# Hitch

Hitch is a PHP 5.3 library which makes it extremely easy to map an XML document to an object graph. You
simply create plain old PHP objects and map them to XML nodes and attributes using annotations in your
docblock comments. Annotation parsing is achieved through the doctrine-common library.

Hitch is loosely based on JAXB within the Java language.

Currently Hitch is focused on parsing XML into objects. But future versions will use the 
mappings to allow you to produce XML strings from object graphs.

## Overview

Consider the following XML document structure:

        <catalog>
            <products>
              <product>
                <comments>
                  <comment />
                </comments>
              </product>
            </products>
        </catalog>

This would be mapped to the following object hierarchy:

        Catalog
          -> Product
               -> Comment

Hitch's only requirement is that your objects will need to have standard getters and setters for
the properties that you map to an XML document.

Look in the demo/ directory to see a full working example of all the features of Hitch.

## Annotations

The mapping of classes and their properties to XML nodes and attributes is achieved through the
use of annotations within your docblock comments. The following sections explain all of the available
annotations that you can use.

### @XmlObject

Any class that needs to be mapped to an XML document will need this annotation defined on the class level.

Example:

        /**
         * @xml:XmlObject
         */
        class Catalog
        {
        }

### @XmlElement

This annotation will map a class property to a node within the XML document. An element can be either a
simple value node or a child node which maps to a child object.

Node name:

By default Hitch will assume that the property name is the same as the XML node name. You can override
the node name which a property gets mapped to by including a name="" parameter in the annotation.

Mapping Embedded object:

You can map child nodes to an embedded objects by specifying a type="" parameter in the annotation. The
value just needs to be the fully qualified name of your embedded class.

Example XML:

        <product>
          <description>This is a description</description>
          <price>$100</price>
          <product_rating>4</product_rating>
          <manufacturer>
            <id>1</id>
            <name>Acme Corp</name>
          </manufacturer/>
        </product>

Example Annotations:

        /**
         * @xml:XmlObject
         */
        class Product
        {
          /**
           * @xml:XmlElement
           */
          protected $description;

          /**
           * @xml:XmlElement
           */
          protected $price;

          /**
           * @xml:XmlElement(name="product_rating")
           */
          protected $rating;

          /**
           * @xml:XmlElement(name="manufacturer", type="My\Namespace\Manufacturer")
           */
          protected $manufacturer;

          // ... getters and setters

        }

        /**
         * @xml:XmlObject
         */
        class Manufacturer
        {
          /**
           * @xml:XmlElement
           */
          protected $id;

          /**
           * @xml:XmlElement
           */
          protected $name;

          // ... getters and setters
        }

### @XmlAttribute

This annotation will map a class property to an attribute within an XML node.

Example XML:

        <product id="1" name="Product 1" price="$100" />

Example Annotations:

        /**
         * @xml:XmlObject
         */
        class Product
        {
          /**
           * @xml:XmlAttribute
           */
          protected $id;

          /**
           * @xml:XmlAttribute
           */
          protected $name;

          /**
           * @xml:XmlAttribute(name="price")
           */
          protected $myPrice;

          // ... getters and setters

        }

### @XmlValue

This annotation will map the value of an XML node to a class property when the node is mapped to a class.

Example XML:

        <product id="1" name="Product 1" price="$100">This is a product description</product>

Example Annotations:

        /**
         * @xml:XmlObject
         */
        class Product
        {
          /**
           * @xml:XmlAttribute
           */
          protected $id;

          /**
           * @xml:XmlAttribute
           */
          protected $name;

          /**
           * @xml:XmlAttribute(name="price")
           */
          protected $myPrice;

          /**
           * @xml:XmlValue
           */
          protected $description;

          // ... getters and setters

        }

### @XmlList

This annotation allows you to map collections of XML nodes to arrays of objects.

You are required to add a name="" parameter in order for Hitch to know which child nodes
to look for.

If you need to map a collection of nodes that are within a wrapper element, 
simply add the wrapper="" parameter to the annotation.

#### No Wrapper Node

Example XML:

        <catalog>
          <product />
          <product />
          <product />
        </catalog>

Example Annotations:

        /**
         * @xml:XmlObject
         */
        class Catalog
        {
          /**
           * @xml:XmlList(name="product", type="My\Namespace\Product")
           */
          protected $products;
        }

#### Wrapper Node

Example XML:

        <catalog>
          <products>
            <product />
            <product />
            <product />
          </products>
        </catalog>

Example Annotations:

        /**
         * @xml:XmlObject
         */
        class Catalog
        {
          /**
           * @xml:XmlList(name="product", wrapper="products", type="My\Namespace\Product")
           */
          protected $products;
        }

## Using Hitch to Unmarshall XML to an Object Graph

You will use the Hitch\HitchManager class to perform all basic operations. In order for Hitch to work, you
will need to make sure that the doctrine-common library is autoloaded in your application.

To get startet, instantiate a HitchManager object and inject some required objects:

        // create our new HitchManager
        $hitch = new HitchManager();  
        $hitch->setClassMetaDataFactory(new ClassMetadataFactory(
                                            new AnnotationLoader(new AnnotationReader()), 
                                            new ArrayCache()));

Now you can unmarshall an XML string into an object graph in one simple call:

        // get xml from somewhere
        $xml = file_get_contents('myxml.xml');

        // unmarshall xml to a Catalog object
        $catalog = $hitch->unmarshall($xml, "My\Namespace\Catalog");

        // do something with the object
        foreach($catalog->getProducts() as $product){
          echo $product->getName();
        }

## Prebuild Hitch Class Meta Data cache

In real life situations, you will probably want to prebuild the meta data cache for your annotations so
that they don't need to be parsed every single time.

You will just need to register each of the class which are the root of your object hierarchy and tell hitch to
build the cache.

Example:

        // create our new HitchManager
        $hitch = new HitchManager();  
        $hitch->setClassMetaDataFactory(new ClassMetadataFactory(
                                            new AnnotationLoader(new AnnotationReader()), 
                                            new XcacheCache()));
                                            
        // pre-build the class meta data cache
        $hitch->registerRootClass('My\Namespace\Catalog');
        $hitch->registerRootClass('My\Namespace\SomeOtherClass');
        $hitch->buildClassMetaDatas();


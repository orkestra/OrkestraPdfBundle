OrkestraPdfBundle
=================

[![Build Status](https://travis-ci.org/orkestra/OrkestraPdfBundle.png?branch=develop)](https://travis-ci.org/orkestra/OrkestraPdfBundle)

Abstracts different PDF generation libraries. Currently supports TCPDF, Zend PDF and wkhtmltopdf.

This bundle is under active development and is prone to backwards compatibility breaks.


Installation
------------

Using composer, in your project's root directory:

```
composer require "orkestra/pdf-bundle 1.0.x-dev"
```

```
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Orkestra\Bundle\PdfBundle\OrkestraPdfBundle(),
        // ...
    );
}
```
Configuration
-------------

Configuration defaults reference:

```yml
# config.yml
orkestra_pdf:
  cache_dir:  %kernel.cache_dir%/orkestra_pdf                  # Cache directory
  tcpdf:
    root_dir:   %kernel.root_dir%/../vendor/tecnick.com/tcpdf  # Path to the tcpdf installation
    fonts_dir:  %orkestra.pdf.tcpdf.root_dir%/fonts            # Path to tcpdf fonts
    image_dir:  %orkestra.pdf.tcpdf.root_dir%/images           # Path to tcpdf images
  wkhtmltopdf:
    binary_path:  wkhtmltopdf                                  # Path to the wkhtmltopdf binary
```


Usage
-----

This bundle's aim is to provide a uniform API for generating PDFs using different generation tools.

Currently supported: TCPDF, Zend PDF, and wkhtmltopdf.


### Generators

The basis of this bundle revolves around services called "Generators". Generators know how to take
some input, such as entities and other data, and return a PDF ready to be used. Generators encapsulate
library-specific logic, returning a subtype of `Orkestra\Bundle\PdfBundle\Pdf\PdfInterface` which can
then be used to send the generated PDF to the browser, save it to the filesystem, etc.

All Generators should implement `PdfGeneratorInterface`. Additionally, a base class called
`AbstractPdfGenerator` is included. This document details how to extend `AbstractPdfGenerator`


#### Creating an Invoice Generator

The two main methods to implement are: `doGenerate` and `setDefaultParameters`.

##### Implementing the  `doGenerate` method

This method actually performs the PDF generation. It takes two parameters, `$parameters` and
`$options`.

* `$parameters` is an array of data to be sent to the templating engine.
* `$options` is an array of options to pass to the underlying PDF library.

##### Implementing the `setDefaultParameters` method

This method configures an `OptionsResolver` and allows specification of required and available
parameters that the Generator supports.

NOTE: There's also a `setDefaultOptions` method available. Parameters are intended to be passed
to the templating engine, things like entities and collections. Options are intended to allow
configuration of the generator at runtime.

##### Example implementation: InvoiceGenerator

In this example, we use the WkPdf adapter and the built in templating engine to render a PDF.

```php
<?php

namespace MyBundle\PdfGenerator;

use Orkestra\Bundle\PdfBundle\Generator\AbstractPdfGenerator;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceGenerator extends AbstractPdfGenerator
{
    /**
     * Performs the PDF generation
     *
     * @param array $parameters An array of parameters to be used to render the PDF
     * @param array $options    An array of options to be passed to the underlying PdfFactory
     *
     * @return \Orkestra\Bundle\PdfBundle\Pdf\PdfInterface
     */
    protected function doGenerate(array $parameters, array $options)
    {
        // Use the createPdf method to create the desired type of PDF
        $pdf = $this->createPdf('wkpdf', $options);

        // Call any native methods on the underlying library object
        $builder = $pdf->getNativeObject();
        $builder->useTemporaryFile();
        $builder->setInput($this->render('MyBundle:Pdf\Invoice:template.html.twig', $parameters));

        // Return the original PDF, calling getContents to retrieve the rendered content
        return $pdf;
    }

    /**
     * Configure the parameters OptionsResolver.
     *
     * Use this method to specify default and required options
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    protected function setDefaultParameters(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'invoice',
        ));
        $resolver->setAllowedTypes(array(
            'invoice' => 'MyBundle\Entity\Invoice',
        ));
    }
}
```

##### Useful methods

`AbstractPdfGenerator->createPdf($type, $options)` wraps the PDF factory registry. As the first
parameter, pass the type of PDF and options to configure it. Available PDF types: `tcpdf`, `wkpdf`,
and `zendpdf`.

`AbstractPdfGenerator->render($template, array $parameters = array())` uses the application's templating
engine to render templates for use in generating the content for the PDF.


##### Registering your generator

In services.yml:

```yml
my_bundle.invoice_pdf_generator:
  class: MyBundle\PdfGenerator\InvoiceGenerator
  arguments: [ @orkestra.pdf.factory_registry, @templating ]
```

`AbstractPdfGenerator` by default, takes a PDF factory registry and the templating service. You may
need to add more dependencies, depending on your implementation.


#### Using your service

From within one of your controllers:

```php
class MyController extends Controller
{
    // ...
    public function someAction()
    {
        // Fetch the invoice from somewhere
        $invoice = $this->getInvoice();

        $generator = $this->get('my_bundle.invoice_pdf_generator');

        $pdf = $generator->generate(array('invoice' => $invoice));

        // Write the PDF to a file
        file_put_contents('/some/path/to.pdf', $pdf->getContents());

        // Output the PDF to the browser
        return new Response($pdf->getContents(), 200, array('Content-type' => 'application/pdf'));
    }
}
```

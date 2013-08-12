OrkestraPdfBundle
=================

Abstracts different PDF generation libraries. Currently supports TCPDF, Zend PDF and wkhtmltopdf.

This bundle is under active development and is prone to backwards compatibility breaks.


Installation
------------

Using composer, in your project's root directory:

```
composer require "orkestra/pdf-bundle 1.0.x-dev"
```


Usage
-----

This bundle's aim is to provide a uniform API for generating PDFs using different generation tools.

Currently supported: TCPDF, Zend PDF, and wkhtmltopdf.


## Generators

The basis of this bundle revolves around services called "Generators". Generators know how to take
some input, such as entities and other data, and return a PDF ready to be used. Generators encapsulate
library-specific logic, returning a subtype of `Orkestra\Bundle\PdfBundle\Pdf\PdfInterface` which can
then be used to send the generated PDF to the browser, save it to the filesystem, etc.

All Generators should implement `PdfGeneratorInterface`. Additionally, a base class called
`AbstractPdfGenerator` is included. This document details how to extend `AbstractPdfGenerator`


### Creating an Invoice Generator

The two main methods to implement are: `doGenerate` and `setDefaultParameters`.

#### doGenerate

This method actually performs the PDF generator. The method takes two parameters, `$parameters` and
`$options`.

* `$parameters`: An array of data to be sent to the templating engine.
* `$options`: An array of options to pass to the underlying PDF library.

#### setDefaultParameters

This method configures an `OptionsResolver` and allows specification of required and available
parameters that the Generator supports.

NOTE: There's also a `setDefaultOptions` method available.

#### Example InvoiceGenerator implementation

```php
<?php

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
        /** @var \Orkestra\Bundle\PdfBundle\Pdf\WkPdfBuilder $builder */
        $builder = $this->createPdf('wkpdf', $options);
        $builder->useTemporaryFile();
        $builder->setInput($this->render('MyBundle:Pdf\Invoice:template.html.twig', $parameters));

        return $builder->getPdf();
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

#### `AbstractPdfGenerator->createPdf($type, $options)`

This method wraps the PDF factory registry. As the first parameter, pass the type of PDF and
options to configure it.

Available PDF types to be used with `AbstractPdfGenerator->createPdf($type, $options)`:

* TCPDF:       `tcpdf`
* wkhtmltopdf: `wkpdf`
* Zend PDF:    `zendpdf`


## Registering your generator

In services.yml:

```yml
my_bundle.invoice_pdf_generator:
  class: MyBundle\PdfGenerator\InvoiceGenerator
  arguments: [ @orkestra.pdf.factory_registry, @templating ]
```

`AbstractPdfGenerator`, by default, takes a PDF factory registry and the templating service.

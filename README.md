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
some input, such as entities and other data, and return a PDF ready to be used.

All Generators should implement `PdfGeneratorInterface`. Additionally, an base class called
`AbstractPdfGenerator` is included. This document details how to extend `AbstractPdfGenerator`


### Creating an Invoice Generator

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
        $builder = $this->factory->create($options);
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
    public function setDefaultParameters(OptionsResolverInterface $resolver)
    {
        $resolver->setAllowedTypes(array(
            'invoice' => 'MyBundle\Entity\Invoice',
        ));
    }
}
```


## Registering your generator

In services.yml:

```yml
my_bundle.invoice_pdf_generator:
  class: MyBundle\PdfGenerator\InvoiceGenerator
  arguments: [ @orkestra.pdf.wkpdf_factory, @templating ]
```

`AbstractPdfGenerator`, by default, takes an appropriate PDF factory and the templating service.

Available factories:

* TCPDF Factory:       `orkestra.pdf.tcpdf_factory`
* wkhtmltopdf Factory: `orkestra.pdf.wkpdf_factory`
* Zend PDF Factory:    `orkestra.pdf.zendpdf_factory`

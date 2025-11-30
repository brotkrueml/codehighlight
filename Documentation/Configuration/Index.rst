.. include:: /Includes.rst.txt


.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**

.. contents::
   :local:

.. _site-configuration:

Site configuration
==================

Some site-wide configurations can be made in the
:ref:`site configuration <t3coreapi:sitehandling>`. Select a site under
:guilabel:`Site Management` > :guilabel:`Sites` and switch to the tab
:guilabel:`Code Highlight`.

.. figure:: /Images/Configuration/site-configuration.png
   :alt: Site configuration

   Site configuration


.. _configuration-theme:

CSS file for theme
------------------

In the value picker you have the choice between several themes for using on a
website. As the extension uses `PrismJS <https://prismjs.com/>`_ for the code
highlighting you can have a look at their website to see the differences
between the themes.

When selecting a theme, the path to the according CSS file is stored in the site
configuration. You can also use an own theme to customise the look of the
code snippets.

As the theme is assigned to a site, different sites can have different themes.

.. tip::

   If you don't like the shipped themes you find many more in a separate
   `GitHub repository <https://github.com/PrismJS/prism-themes>`_. Just
   download the desired theme, save it to your site package extension and
   type the path to the file into the site configuration field.

.. _configuration-url-hash:

Usage of a URL hash
-------------------

If the option is enabled, the usage of a URL hash (like ``#codesnippet8.5-6``)
for highlighting code and as anchor is available. You can find more information
in the :ref:`chapter for editors <editor-url-hash>`.


.. _configuration-command-line-default-host:

Command line: default host
--------------------------

Defines the default host for the command line, if none is given in the options
of the content element. If a value is neither in the configuration nor in the
content element given, ``localhost`` is used as last fallback.


.. _configuration-command-line-default-user:

Command line: default user
--------------------------

Defines the default user for the command line, if none is given in the options
of the content element. If a value is neither in the configuration nor in the
content element given, ``user`` is used as last fallback.


.. _configuration-toolbar-copy:

Toolbar: display button "Copy to clipboard"
-------------------------------------------

If the option is enabled, a :guilabel:`Copy` button is displayed in the upper
right corner when the user moves the mouse pointer over a code snippet.


.. _site-sets:

Site sets (TYPO3 v13+)
======================

This extension provides support for :ref:`site sets <t3coreapi:site-sets>`.

Add :yaml:`brotkrueml/codehighlight` as dependency to the configuration of
your site package:

.. code-block:: yaml
   :caption: EXT:your_sitepackage/Configuration/Sets/<your-set>/config.yaml
   :emphasize-lines: 7

   name: your-vendor/your-sitepackage
   label: Sitepackage

   dependencies:
     # ... some other dependencies

     - brotkrueml/codehighlight

Settings
--------

If you want to change the layout or template of the content element or add a
partial you can make a copy of them and adjust the Fluid root paths.

Path to template root
~~~~~~~~~~~~~~~~~~~~~

Define the additional template root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Templates/Codehighlight/`.

.. code-block:: yaml
   :caption: EXT:your_sitepackage/Configuration/Sets/<your-set>/settings.yaml
   :emphasize-lines: 3-5

   # ... some other settings

   tt_content:
      tx_codehighlight_codesnippet:
         templateRootPath: 'EXT:your_sitepackage/Resources/Private/Extensions/Codehighlight/Templates/'

Path to template partials
~~~~~~~~~~~~~~~~~~~~~~~~~

Define the additional partial root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Partials/Codehighlight/`.

.. code-block:: yaml
   :caption: EXT:your_sitepackage/Configuration/Sets/<your-set>/settings.yaml
   :emphasize-lines: 3-5

   # ... some other settings

   tt_content:
      tx_codehighlight_codesnippet:
         partialRootPath: 'EXT:your_sitepackage/Resources/Private/Extensions/Codehighlight/Partials/'

Path to template layouts
~~~~~~~~~~~~~~~~~~~~~~~~

Define the additional layout root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Layouts/Codehighlight/`.

.. code-block:: yaml
   :caption: EXT:your_sitepackage/Configuration/Sets/<your-set>/settings.yaml
   :emphasize-lines: 3-5

   # ... some other settings

   tt_content:
      tx_codehighlight_codesnippet:
         layoutRootPath: 'EXT:your_sitepackage/Resources/Private/Extensions/Codehighlight/Layouts/'

CSS file
~~~~~~~~

The extension comes with a default CSS file. If you don't want to include it or
want to use an own CSS file you can empty the field or change the path.

.. code-block:: yaml
   :caption: EXT:your_sitepackage/Configuration/Sets/<your-set>/settings.yaml
   :emphasize-lines: 3-5

   # ... some other settings

   tt_content:
      tx_codehighlight_codesnippet:
         cssFile: 'EXT:your_sitepackage/Resources/Public/Css/codehighlight.css'


.. _constant-editor:

Constant editor (without site sets)
===================================

Some constants can be defined in the
:ref:`constant editor <t3tsref:typoscript-syntax-constant-editor>`. It is
recommended to use :ref:`site sets <site-sets>` instead.

Select the category :guilabel:`Codehighlight` and make your adjustments.

.. figure:: /Images/Configuration/constant-editor.png
   :alt: Constant Editor

   Constant editor


Files
-----

If you want to change the layout or template of the content element or add a
partial you can make a copy of them and adjust the Fluid root paths.

Path to template root (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional template root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Templates/Codehighlight/`.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.templateRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Templates/Codehighlight/
   }

Path to template partials (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional partial root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Partials/Codehighlight/`.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.partialRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Partials/Codehighlight/
   }

Path to template layouts (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional layout root path, for example,
:file:`EXT:your_sitepackage/Resources/Private/Layouts/Codehighlight/`.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.layoutRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Layouts/Codehighlight/
   }

CSS file
~~~~~~~~

The extension comes with a default CSS file. If you don't want to include it
or want to use an own CSS file you can empty the field or change the path.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.cssFile {
      settings.cssFile = EXT:your_sitepackage/Resources/Public/Css/codehighlight.css
   }

.. note::

   Do not mix up this CSS file with the CSS file for the design. This CSS file
   is responsible for the representation outside the code section. Currently
   there are styles for displaying the filename of a snippet.


.. _assets-embedding:

Assets embedding
================

The required CSS and JavaScript files from the PrismJS library and the extension's
CSS file are embedded with the :php:`PageRenderer` methods :php:`addCssFile()`
and :php:`addJsFooterFile()`. This means, that they adhere to the configuration
setting :php:`$GLOBALS['TYPO3_CONF_VARS']['FE']['versionNumberInFilename']`
and the TypoScript settings
:ref:`config.concatenateJs <t3tsref:setup-config-concatenatejs>` and
:ref:`config.concatenateCss <t3tsref:setup-config-concatenatecss>` (only
available in TYPO3 v13). One exception from concatenation is the PrismJS
autoloader JavaScript which is used to load the necessary language files.

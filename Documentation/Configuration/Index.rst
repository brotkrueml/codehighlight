.. include:: ../Includes.txt


.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**


.. _site-configuration:

Site configuration
==================

A theme can be selected for a web site in the site configuration. Select a site under *Site Management* > *Sites*
and switch to the tab "Code Highlight":

.. figure:: ../Images/Configuration/site-configuration.png
   :class: with-shadow
   :alt: Selecting a theme in the Site Configuration

   Selecting a theme in the Site Configuration

In the value picker you have the choice between several themes. As the extension uses `Prism <https://prismjs.com/>`__ for the code
highlighting you can have a look at there website to see the differences between the themes.

When selecting a theme, the path to the according CSS file is stored in the site configuration. So you can also
use an own theme to customise the look of the code snippets.

As the theme is assigned to a site, different sites can have different themes.


.. _constant-editor:

Constant Editor
===============

Some constants can be defined in the :ref:`Constant Editor <t3tsref:typoscript-syntax-constant-editor>`.

Select the category "Codehighlight" and make the adjustments.

.. figure:: ../Images/Configuration/constant-editor.png
   :class: with-shadow
   :alt: Constant Editor

   Constant Editor

Options
-------

If you regularly use the :ref:`command line options <editors-content-element-options-command-line>`, you may want to
globally set the user and host for the command prompt. These are taken when no user or host is set in the options of
the content element.

Default user for the command line
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Defines the default user for the command line, if none is given in the options of the content element. If neither in
the constant nor in the content element a user is given, ``user`` is used as last fallback.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet {
      settings.commandLine.defaultServerUser = chris
   }


Default host for the command line
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Defines the default host for the command line, if none is given in the options of the content element. If neither in
the constant nor in the content element a host is given, ``localhost`` is used as last fallback.

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet {
      settings.commandLine.defaultServerHost = earth
   }


Files
-----

If you want to change the layout or template of the content element or add a partial you can make a copy of then and
adjust the Fluid root paths.

Path to template root (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional template root path, e.g. :file:`EXT:your_sitepackage/Resources/Private/Templates/Codehighlight/`

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.templateRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Templates/Codehighlight/
   }

Path to template partials (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional partial root path, e.g. :file:`EXT:your_sitepackage/Resources/Private/Partials/Codehighlight/`

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.partialRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Partials/Codehighlight/
   }

Path to template layouts (FE)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Enter the additional layout root path, e.g. :file:`EXT:your_sitepackage/Resources/Private/Layouts/Codehighlight/`

Alternatively you can change the setting directly in the TypoScript setup:

.. code-block:: typoscript

   tt_content.tx_codehighlight_codesnippet.layoutRootPaths {
      10 = EXT:your_sitepackage/Resources/Private/Layouts/Codehighlight/
   }


.. _assets-embedding:

Assets embedding
================

The required CSS and JavaScript files from the Prism library are embedded with the :php:`PageRenderer` methods
:php:`addCssFile()` and :php:`addJsFooterFile()`. This means, that they adhere to the configuration setting
:php:`$GLOBALS['TYPO3_CONF_VARS']['FE']['versionNumberInFilename']` and the TypoScript setting
:ref:`config.concatenateJs <t3tsref:setup-config-concatenatejs>`.

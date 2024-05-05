.. include:: /Includes.rst.txt

.. _installation:

============
Installation
============

Target group: **Administrators**

.. note::
   The extension in version |version| supports TYPO3 v12 LTS and TYPO3 v13.
   Use version 3.x for support of TYPO3 v11.
   Use version 2.x for support of TYPO3 v9 LTS and TYPO3 v10 LTS.


Some basic configuration is available which is explained in the
:ref:`Configuration <configuration>` section.

.. tip::
   Install the TYPO3 system extension "t3editor" on TYPO3 v12 to use the
   features of this editor in the backend content element. In TYPO3 v13 the
   code editor is always available.


.. _installation-composer:

Installation via Composer
=========================

The recommended way to install this extension is by using Composer. In your
Composer-based TYPO3 project root, just type:

.. code-block:: shell

   composer req brotkrueml/codehighlight

and the recent stable version will be installed.

.. _installation-extension-manager:

Installation in extension manager
=================================

You can also install the extension from the `TYPO3 Extension Repository (TER) <https://extensions.typo3.org/extension/codehighlight>`_.
See :ref:`t3start:extensions_legacy_management` for a manual how to install an
extension.


.. _include-static-typoscript:

Preparation: Include static TypoScript
======================================

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the :guilabel:`Template module` and select :guilabel:`Info/Modify`.

#. Press the link :guilabel:`Edit the whole template record` and switch to the
   tab :guilabel:`Includes`.

#. Select :guilabel:`Code Highlight (codehighlight)` from the available items
   at the field :guilabel:`Include static (from extensions):`

.. figure:: /Images/Installation/include-static-template.png
   :alt: Include static TypoScript

   Include static TypoScript

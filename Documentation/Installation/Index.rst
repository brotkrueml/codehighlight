.. include:: /Includes.rst.txt

.. _installation:

============
Installation
============

Target group: **Administrators**

.. note::
   The extension in version |version| supports TYPO3 v13 LTS.


Some basic configuration is available which is explained in the
:ref:`Configuration <configuration>` section.


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

In a legacy installation, you can also install the extension from the
`TYPO3 Extension Repository (TER) <https://extensions.typo3.org/extension/codehighlight>`_.


.. _include-static-typoscript:

Preparation: Include static TypoScript
======================================

The extension ships some TypoScript code which needs to be included.

.. note::
   This needs only to be done, if **not** using TYPO3 v13 with
   :ref:`site sets <site-sets>`.

#. Switch to the root page of your site.

#. Switch to the :guilabel:`Template module` and select :guilabel:`Info/Modify`.

#. Press the link :guilabel:`Edit the whole template record` and switch to the
   tab :guilabel:`Includes`.

#. Select :guilabel:`Code Highlight (codehighlight)` from the available items
   at the field :guilabel:`Include static (from extensions):`

.. figure:: /Images/Installation/include-static-template.png
   :alt: Include static TypoScript

   Include static TypoScript

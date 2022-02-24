.. include:: /Includes.rst.txt

.. highlight:: shell

.. _maintenance:

===========
Maintenance
===========

Target group: **Contributors, Developers**


.. _maintenance-translations:

Translations
============

The translation to other languages is done within the
`Crowdin <https://crowdin.com/>`__ service. It is appreciated to add missing or
incomplete languages. Please navigate to the
`project home <https://crowdin.com/project/typo3-extension-codehighlight>`__.
If the language is not available please drop me a :ref:`note <start>` and I will
create it.

.. note::

   For now, the language files are integrated into a release of the extension.
   When the new
   `translation structure <https://github.com/TYPO3-Initiatives/crowdin>`__
   (based on the translations within Crowdin) is in place, the language files
   (other than English) will be removed in favour of the new infrastructure.


.. _maintenance-prism:

Prism Library
=============

For syntax highlighting `Prism <https://prismjs.com/>`__ is used. The JavaScript
library and its dependencies are managed with :file:`yarn` and build with
:file:`gulp`:

::

   cd Build
   yarn install
   yarn build

The :file:`yarn build` command runs the according gulp task and copies the Prism
components (aka languages), plugins and themes to the
:file:`Resources/Public/Vendor/PrismJs/` folder. Also a PHP file
:file:`Resources/Private/PHP/AvailableProgrammingLanguages.php` is generated
with the available languages. It will be used for the select box of programming
languages in the backend form. The option values are "translated" via the
:file:`Resources/Private/Language/ProgrammingLanguages.xlf` file.


.. _maintenance-prism-update:

Update
------

To update the library to the recent version just call on the console:

::

   cd Build
   yarn upgrade prismjs
   yarn build

The copied artifacts can now be committed (along with the :file:`package.json`
file to the repository. Don't forget to add new files to the commit and add
these to the translation file
:file:`Resources/Private/Language/ProgrammingLanguages.xlf`.

.. note::

   Due to the variants JavaScript files can be integrated into the page (like
   last modification timestamp is embedded into the filename), the script
   :file:`Build/node_modules/prismjs/plugins/autoloader/prism-autoloader.js`
   was patched: The variable :js:`autoloaderFile` regex has to be set to
   adjusted to consider a possibly available timestamp in the filename.
   When updating the Prism library, the patch under
   :file:`Build/patches/prismjs+1.xx.x.patch` has to be adjusted eventually.
   The package `patch-package <https://github.com/ds300/patch-package#readme>`__
   is used for that.


.. _maintenance-packaging-extension:

Packaging of extension for TER
==============================

Set the new version in the files

- :file:`ext_emconf.php`
- :file:`Documentation/Settings.cfg`,

adjust the :file:`CHANGELOG.md` and tag the release. The packaging of the
extension for the TYPO3 Extension Repository (TER) can be done with:

::

   make zip

This creates/replaces a file :file:`../zip/codehighlight_x.y.z.zip` which is
ready for upload to TER. :file:`x.y.z` holds the recent version number.

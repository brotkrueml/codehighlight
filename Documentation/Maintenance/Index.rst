.. include:: ../Includes.txt


.. _maintenance:

===========
Maintenance
===========

This chapter is for developers who want to contribute and maintain the extension.


.. _update-prism:

Prism Library
=============

For syntax highlighting `Prism <https://prismjs.com/>`__ is used. The JavaScript library and its dependencies are
managed with :file:`yarn` and build with :file:`gulp`:

.. code-block:: shell

   cd Build
   yarn install
   yarn build

The :file:`yarn build` command runs the according gulp task and copies the Prism components (aka languages), plugins
and themes to the :file:`Resources/Public/Vendor/PrismJs/` folder. Also a PHP file
:file:`Resources/Private/PHP/AvailableProgrammingLanguages.php` is generated with the available languages. It will
be used for the select box of programming languages in the backend form. The option values are "translated" via the
:file:`Resources/Private/Language/ProgrammingLanguages.xlf` file.

Update
------

To update the library to the recent version just call on the console:

.. code-block:: shell

   cd Build
   yarn upgrade prismjs
   yarn build

The copied artifacts can now be committed (along with the :file:`package.json` file to the repository. Don't forget to
add new files to the commit and add these to the translation file :file:`Resources/Private/Language/ProgrammingLanguages.xlf`.

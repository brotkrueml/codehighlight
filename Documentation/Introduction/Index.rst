.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _what-it-does:

What does it do?
================

In technical articles it is sometimes necessary to embed code snippets into the
text of a page. To improve the readability of the snippets, the syntax
highlighting of code is appreciated - as in modern IDEs.

The extension provides a new content element to achieve this goal. You can
choose between several themes.

.. _screenshots:

Screenshots
===========

PHP code snippet
----------------

Example output using the Coy theme for a PHP code snippet with line numbers and
line highlighting:

.. figure:: /Images/Introduction/example-php.png
   :class: with-shadow
   :alt: PHP code snippet with line numbers and line highlighting


Shell command
-------------

Example output using the Coy theme for a shell command with prompt:

.. figure:: /Images/Introduction/example-shell.png
   :class: with-shadow
   :alt: Shell command with prompt


CSS inline colours
------------------

Example output using the Coy theme for a CSS snippet with activated
inline colours (the coloured square before the colour definition):

.. figure:: /Images/Introduction/example-css-inline-colours.png
   :class: with-shadow
   :alt: CSS snippet with inline colours

Treeview
--------

Example for a treeview to highlight file system tree structures:

.. figure:: /Images/Introduction/example-treeview.png
   :class: with-shadow
   :alt: Treeview


.. _release-management:

Release Management
==================

This extension uses `semantic versioning <https://semver.org/>`_ which
basically means for you, that

- Bugfix updates (e.g. 1.0.0 => 1.0.1) just includes small bug fixes or security
  relevant stuff without breaking changes.
- Minor updates (e.g. 1.0.0 => 1.1.0) includes new features and smaller tasks
  without breaking changes.
- Major updates (e.g. 1.0.0 => 2.0.0) breaking changes which can be
  refactorings, features or bug fixes.

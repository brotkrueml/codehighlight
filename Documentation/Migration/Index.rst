.. include:: /Includes.rst.txt

.. _migration:

=========
Migration
=========

Target group: **Integrators,Developers**


From version 1.1 to 2.0
=======================

The TypoScript settings

* :ts:`tt_content.tx_codehighlight_codesnippet.settings.commandLine.defaultServerHost` and
* :ts:`tt_content.tx_codehighlight_codesnippet.settings.commandLine.defaultServerUser`

respectively the Constant Editor settings for defining a default host and
default user on the command line are moved into the
:ref:`site configuration <site-configuration>`. Please remove the mentioned
settings and adjust your site configuration accordingly.

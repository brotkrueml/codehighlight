.. include:: ../Includes.txt

.. _installation:

============
Installation
============

Target group: **Administrators**

.. note::

   The extension works with TYPO3 v9 and v10.

The extension needs to be installed as any other extension of TYPO3 CMS:

#. **Use composer**: The preferred way is to use the composer dependency manager:
   ``composer req brotkrueml/codehighlight``.

#. **Get it from the Extension Manager:** Press the "Retrieve/Update" button in the Extension Manager backend
   module, search for the extension key *codehighlight* and import the extension from the repository.

#. **Get it from typo3.org:** You can always get the current version from
   `https://extensions.typo3.org/extension/codehighlight/ <https://extensions.typo3.org/extension/codehighlight/>`_
   by downloading either the :file:`t3x` or :file:`zip` version. Upload the file afterwards in the Extension Manager.

Some basic configuration is available which is explained in the :ref:`Configuration <configuration>` section.

.. tip::

   Install the TYPO3 system extension "t3editor" to use the features of this editor in the backend content element.


.. _include-static-typoscript:

Preparation: Include static TypoScript
======================================

The extension ships some TypoScript code which needs to be included.

#. Switch to the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Code Highlight (codehighlight)** from the available items at the field *Include static (from extensions):*

.. figure:: ../Images/Installation/include-static-template.png
   :class: with-shadow
   :alt: Include static TypoScript

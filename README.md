# TYPO3 content element for highlighting code

[![TYPO3](https://img.shields.io/badge/TYPO3-9%20LTS-orange.svg)](https://typo3.org/)
[![Build Status](https://travis-ci.org/brotkrueml/codehighlight.svg?branch=master)](https://travis-ci.org/brotkrueml/codehighlight)

## Requirements

The extension works with TYPO3 9 LTS and TYPO3 10.0.

For now, it's work in progress.

## Update of JavaScript libraries

For syntax highlighting [Prism](https://prismjs.com/) is used.
This dependency is managed via yarn:

    cd Build
    yarn install

With

    yarn build

the Prism components (aka languages), plugins and themes are copied
to the `Resources/Public/Vendor/PrismJs/` folder. Also a PHP file
`AvailableProgrammingLanguages.php` is generated with the available
languages. It will be used for the select box of programming languages
in the backend form. The options are "translated" via the
`ProgrammingLanguages.xlf` file.

More details can be found in the `gulpfile.js`.

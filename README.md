# TYPO3 content element for highlighting code

## Requirements

The extension works with TYPO3 9 LTS and TYPO3 10.0.

For now, it's work in progress.

## Update of JavaScript libraries

For syntax highlighting the [Prism](https://prismjs.com/) is used.
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

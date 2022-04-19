# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.11.0] - 2022-04-19

### Added
- Compatibility with typo3/cms-composer-installers v4 (#33)

### Changed
- The PrismJS autoloader JavaScript can't be concatenated anymore with other JavaScript files (#33)

### Updated
- PrismJS to version [1.28.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1280-2022-04-17)

## [2.10.0] - 2022-02-19

### Updated
- PrismJS to version [1.27.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1270-2022-02-17)

## [2.9.0] - 2022-01-07

### Updated
- PrismJS to version [1.26.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1260-2022-01-06)

## [2.8.0] - 2021-11-01

### Added
- Button "Copy" to copy a code snippet to the clipboard (#27)

### Fixed
- Move content element to group "special" in type select box (TYPO3 v10+)

## [2.7.0] - 2021-09-19

### Security
- Update PrismJS to version [1.25.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1250-2021-09-16)

## [2.6.1] - 2021-07-04

### Updated
- PrismJS to version [1.24.1](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1241-2021-07-03)

## [2.6.0] - 2021-06-28

### Updated
- PrismJS to version [1.24.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1240-2021-06-27)

## [2.5.0] - 2021-01-06

### Security
- Update PrismJS to version [1.23.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1230-2020-12-31)

## [2.4.0] - 2020-12-27

### Added
- Plugin "Inline colour" to show colour preview in CSS snippets
- Compatibility with TYPO3 v11

## [2.3.0] - 2020-10-12

### Updated
- PrismJS to version [1.22.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1220-2020-10-10)

### Fixed
- Show content element in wizard in TYPO3 v10

## [2.2.0] - 2020-08-08

### Updated
- PrismJS to version [1.21.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1210-2020-08-06)

## [2.1.0] - 2020-04-01

### Updated
- PrismJS to version [1.19.0](https://github.com/PrismJS/prism/blob/master/CHANGELOG.md#1190-2020-01-13)

## [2.0.1] - 2019-12-20

### Added
- Add t3 pseudo language (#13)

### Fixed
- Fixed an error when editing translated content (#14)

## [2.0.0] - 2019-11-07

### Added
- Possibility to display filename for snippet (#10)

### Changed
- Move asset handling and HTML code generation from template to view helper (#8)
- Move command line TypoScript settings to site configuration (#9)
- Separate shell and bash, bnf and rbnf in the list of available languages

## [1.1.1] - 2019-10-13

### Fixed
- Use reference to lib.contentElement instead of assigning FLUIDTEMPLATE (#5)

## [1.1.0] - 2019-10-11

### Added
- Setting for default user and host in command line (#2)
- Activate heading and appearance tab in content element (#3)
- Using URL hash to highlight lines and jump to them (#4)

## [1.0.1] - 2019-10-03

### Added
- German translations

## [1.0.0] - 2019-10-01

### Added
- Content element "Code Snippet"
- Syntax highlighting with PrismJS


[Unreleased]: https://github.com/brotkrueml/codehighlight/compare/v2.11.0...HEAD
[2.11.0]: https://github.com/brotkrueml/codehighlight/compare/v2.10.0...v2.11.0
[2.10.0]: https://github.com/brotkrueml/codehighlight/compare/v2.9.0...v2.10.0
[2.9.0]: https://github.com/brotkrueml/codehighlight/compare/v2.8.0...v2.9.0
[2.8.0]: https://github.com/brotkrueml/codehighlight/compare/v2.7.0...v2.8.0
[2.7.0]: https://github.com/brotkrueml/codehighlight/compare/v2.6.1...v2.7.0
[2.6.1]: https://github.com/brotkrueml/codehighlight/compare/v2.6.0...v2.6.1
[2.6.0]: https://github.com/brotkrueml/codehighlight/compare/v2.5.0...v2.6.0
[2.5.0]: https://github.com/brotkrueml/codehighlight/compare/v2.4.0...v2.5.0
[2.4.0]: https://github.com/brotkrueml/codehighlight/compare/v2.3.0...v2.4.0
[2.3.0]: https://github.com/brotkrueml/codehighlight/compare/v2.2.0...v2.3.0
[2.2.0]: https://github.com/brotkrueml/codehighlight/compare/v2.1.0...v2.2.0
[2.1.0]: https://github.com/brotkrueml/codehighlight/compare/v2.0.1...v2.1.0
[2.0.1]: https://github.com/brotkrueml/codehighlight/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/brotkrueml/codehighlight/compare/v1.1.1...v2.0.0
[1.1.1]: https://github.com/brotkrueml/codehighlight/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/brotkrueml/codehighlight/compare/v1.0.1...v1.1.0
[1.0.1]: https://github.com/brotkrueml/codehighlight/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/brotkrueml/codehighlight/releases/tag/v1.0.0

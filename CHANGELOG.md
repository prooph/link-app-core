# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]

## [0.3.3] - 2015-05-12
### Fixed
- riot tags not working correctly after upgrading to riot v2.0.15

## [0.3.2] - 2015-05-10
### Fixed
- wrong version definition in composer.json

## [0.3.1] - 2015-05-10
### Fixed
- missing dependency codeliner/array-reader

## [0.3.0] - 2015-05-10
### Added
- Support for prooph/proophessor
- Support for prooph/processing v0.4
- `AbstractRestController::location` provides an easy way to return a 201 response
- New interface `ApplicationDbAware` and corresponding `ApplicationDbProvider`

### Changed
- Rename protected `AbstractRestController::getApiProblemResponse` to `apiProblem` and use it internally


## [0.2.0] - 2015-04-03
### Added
- Publish a TickOccurred event triggered by the UI
- Make JS-Ticker configurable via UI
- Move assertion and handling of ConfigLocation to SystemCommand
- Enable/Disable workflow processor message queue
- Add change log

## [0.1.1] - 2015-03-20
### Changed
- Align versions of dependant repos in composer.json

## [0.1.0] - 2015-03-20
### Added
- First development version of the module
- Runs already in production!

[unreleased]: https://github.com/prooph/link-app-core/compare/v0.3.3...HEAD
[0.3.3]: https://github.com/prooph/link-app-core/compare/v0.3.2...v0.3.3
[0.3.2]: https://github.com/prooph/link-app-core/compare/v0.3.1...v0.3.2
[0.3.1]: https://github.com/prooph/link-app-core/compare/v0.3.0...v0.3.1
[0.3.0]: https://github.com/prooph/link-app-core/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/prooph/link-app-core/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/prooph/link-app-core/compare/v0.1...v0.1.1

# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Added
- EventStoreTransaction Plugin for prooph/service-bus
  - Start transaction when a `TransactionCommand` is dispatched
  - Rollback transaction on error
  - Commit transaction on finalize
- RecordedEventsDispatcher listens on EventStore `commit.post` event and pushes recorded events on the PSB event bus
- `AbstractRestController::location` provides an easy way to return a 201 response

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

[unreleased]: https://github.com/prooph/link-app-core/compare/v0.2.0...HEAD
[0.2.0]: https://github.com/prooph/link-app-core/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/prooph/link-app-core/compare/v0.1...v0.1.1
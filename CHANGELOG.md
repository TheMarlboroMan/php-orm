# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog] and this project attempts to adhere to [Semantic Versioning].

Changes will be documented under Added, Changed, Deprecated, Removed, Fixed or Security headers.

## Unreleased
### Pending

- on_create, on_update, on_delete...
- test on_default builder
- order should not use field name, but property name and be mapped somewhere.
- readme documentation
- cover edge cases (boolean testing for non-boolean transformations)

## [v0.0.2]: 2021-12-05
### Added
- fetch one and fetch_by_id to entity manager

### Changed
- changes return type of entity manager create, update and delete

### Fixed
- fixes entity inflator not working properly with default datetimes.
- fixes entity inflator not assigning null to nullable datetime values.

## [v0.0.1]: 2021-12-03
### Added
- bare minimals
- added mapping from property name to storage name for queries.
- added inflators so arrays and maps can be turned into entities.
- added data transformers from and to storage
- quick documentation on each class and method

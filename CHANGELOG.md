# Changelog

## 2.2.1 - 2019-12-19

- The `pluck()` method didn't work as expected ([#4](https://github.com/jeromegamez/typed-collection/issues/4))
- The `keys()` method didn't work as expected

## 2.2.0 - 2019-11-19

- Added support for arrayable items ([#3](https://github.com/jeromegamez/typed-collection/issues/3))

## 2.1.0 - 2019-11-10

- Added `LazyTypedCollection`
- Ensured support for Laravel/Illuminate `^5.4|^6.0`

## 2.0 - 2017-10-17

- Added method `untype()` to return an untyped collection
- Removed override of `map()` to support working with an untyped collection (use `untype()` instead)

## 1.0

Initial release

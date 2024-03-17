# Changelog

## Unreleased

- Added support for Laravel 11 ([#21](https://github.com/jeromegamez/typed-collection/issues/21))

## 6.1.0 - 2023-02-17

- Added support for Laravel 10

## 6.0.0 - 2023-01-02

- The `TypedCollection` and `LazyTypedCollection` classes are now abstract to make clear that they shouldn't
  be instantiated directly ([#13](https://github.com/jeromegamez/typed-collection/issues/13))

## 5.2.0 - 2022-05-20

- Collections now includes the same template typings as the upstream Illuminate collections 

## 5.1.0 - 2022-04-25

- Collections are now untyped when using the `map()` method.

## 5.0.0 - 2020-02-09

- Add support for Laravel ^9.0
- Drop support for Laravel <9.0

## 4.0.0 - 2020-12-10

- This library is now based on [`illuminate/collections`](https://github.com/illuminate/collections)
  and tested with PHP 7.4 and 8.0

## 3.0.1 - 2020-07-02

- Fixed `TypedCollection::push()` ([#7](https://github.com/jeromegamez/typed-collection/issues/7))

## 3.0.0 - 2020-04-28

- Add support for Laravel ^7.0
- Drop support for Laravel <7.0
- Replace forced installation of tightenco/collect with information on how to integrate

## 2.3.0 - 2020-04-28

- Declare incompatibility with Laravel >=7.0

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

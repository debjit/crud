# CRUD

This package while is based on the Krafthaus/Bauhaus package, greatly differs on some key points. First of all It will include an Auth & Role based permission management solution, and some more ideas as project comes along :smile:

[![Travis](https://img.shields.io/travis/BlackfyreStudio/crud.svg?style=flat-square)](https://travis-ci.org/BlackfyreStudio/crud) [![Packagist](https://img.shields.io/packagist/dt/blackfyrestudio/crud.svg?style=flat-square)](https://packagist.org/packages/blackfyrestudio/crud)
[![Code Climate](https://codeclimate.com/github/BlackfyreStudio/crud/badges/gpa.svg)](https://codeclimate.com/github/BlackfyreStudio/crud)
[![Test Coverage](https://codeclimate.com/github/BlackfyreStudio/crud/badges/coverage.svg)](https://codeclimate.com/github/BlackfyreStudio/crud/coverage)
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/BlackfyreStudio/crud?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

Contributions are welcome! Either as ideas or (preferably) pull requests :smile:

## Work in progress

* IDE Support (with laravel-ide-helper, main angle on PHPStorm)
* Field types
  * Text
  * Email
  * File (DropzoneJS)
  * Image
  * Select
  * Belongs to
  * Numbers
  * Markdown
  * CKEditor


## Tasklist


* Index view
  * Bulk delete
  * Bulk actions
  * Boolean field actions per row
* Auth management
  * Roles
* Field Types
  * Image Crop


## Done

* Laravel 5.1 LTS support
* Working Scaffold command
* Index view
* Create view
* Edit view

## Installation

To install the bleeding edge package just follow these steps
```
$ composer require blackfyrestudio/crud:dev-master
```
Add the package to the providers list in `config/app.php`
```
BlackfyreStudio\CRUD\CRUDProvider::class
```
To publish the package files
```
$ php artisan vendor:publish --provider="BlackfyreStudio\CRUD\CRUDProvider"
```

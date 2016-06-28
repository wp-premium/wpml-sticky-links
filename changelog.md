# 1.3.19

## Fixes
* [wpmlcore-3030] Class auto loading is not compatible with version of PHP older than 5.3

# 1.3.18

##Fixes
* [wpmlst-695] Fix performance issue when checking fo sticky links plugin

##Performances
* [wpmlcore-2988] Removed unneeded dependencies checks in admin pages: this now runs only once and later only when activating/deactivating plugins

# 1.3.17

##Fixes
* Removed dead code for handling auto loaded classes: is not used yet

# 1.3.16

##Fixes
* Added backward compatibility for `__DIR__` magic constant not being supported before PHP 5.3.

# 1.3.15

## New
* [wpmlga-96] WordPress 4.4 compatibility: pulled all html headings by one (e.g. h2 -> h1, he -> h2, etc.)

# 1.3.14

## New
* Updated dependency versions

# 1.3.13

## New
* Updated dependency check module

# 1.3.12

## New
* Updated dependency check module

# 1.3.11

## New
* Updated dependency check module

# 1.3.6

## Improvements
* Added warning when activating plugin without WPML Core

# 1.3.5

## Improvements
* Compatibility with WPML Core

# 1.3.4

## Improvements
* New way to define plugin url is now tolerant for different server settings

## Fix
* Fixed sticky links in widgets
* Fixed possible SQL injections

# 1.3.3

## Fix
* Handled dependency to icl_js_escape() function
* Added support for converting links to Custom Post Types with translated slugs
* mysql_* functions doesn't show deprecated notice when PHP >= 5.5
* Several fixes to achieve compatibility with WordPress 3.9
* Updated links to wpml.org
* Handled case where ICL_PLUGIN_PATH constant is not defined (i.e. when plugin is activated before WPML core)
* Fixed problem with Sticky Links and Custom Taxonomies
* Fixed problem with additional language code in Sticky Links
* Fixed Korean locale in .mo file name

# 1.3.2

## Fix
* Handled dependency from SitePress::get_setting()
* Removed dependency to SitePress when instantiating the class
* Updated translations
* Fixed possible javascript exception in Firefox, when using event.preventDefault();

# 1.3.1

## Features
* Added WPML capabilities (see online documentation)
* SSL support for included CSS and javascript now is properly handled
* Support for links to custom post type is working now as expected
* Links was not changed into sticky when default language was not English. Now it's fixed

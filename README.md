# Palamut WordPress Theme Framework

**Contributors:** stevenselcuk
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 5.1  
**Stable tag:** 1.0  
**Version:** 1.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  
**Tags:** one-column, two-columns, right-sidebar, flexible-header, accessibility-ready, custom-colors, custom-header, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, post-formats, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready

Here is a short description of the theme that might appear in the customizer.

## Description

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).
 
 
A few notes about the sections above:
 
*   "Contributors" is a comma separated list of wp.orgusernames
*   "Tags" is a comma separated list of tags that apply to the theme
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the theme*. Note that it might work on
higher versions... this is just the highest one you've verified.

## File Structure
    
    ├── build/                   # WordPress Installion
    ├── dist/                    # Ready to shipping builded files (zips & theme and palamut folders)
    ├── src/                     # Source files
    │   ├── assets/              # Assets directory
    │       ├── fonts/           # Fonts directory
    │       ├── img/             # Image directory
    │       ├── js/              # JavaScript files
    │       ├── styles/          # CSS files
    │   ├── plugins/             # Include Palamut the Companion to your theme
    │   ├── theme/               # Standard Theme files
    ├── tools/                   # Tools and utilities
    │   ├── dev-plugins          # Developer Plugins (Just for development env.)
    │   ├── dummy-data           # Demo posts and testing data
    └── .babelrc                 # Babel configuration
    └── .gitignore               # Git ignored files
    └── LICENSE                  # License agreements
    └── README.md                # You are reading this
    └── gulpfile.js              # Gulp configuration
    └── package.json             # Node packages


## Setup : Baby Steps

Follow the Baby Steps when you are starting to develop new theme
 
A few notes about the sections above:
 
$`git clone https://github.com/stevenselcuk/palamut.git yourdesiredfoldernamehere`

$`cd yourdesiredfoldernamehere`

$`npm install`

$`npm run install:wordpress`

$`npm run dev`

The latest command starts gulp task which has opens a new tab in your default browser. Please proceed to standard WordPress installation at this step.
You will need a new database. You may want to use your old one if available but the new database is strongly recommended.
When you finish the WordPress installation wizard, you also finished the Baby Steps tasks.

## Setup : Toddler Stuff

* Go `http://127.0.0.1:3020/wp-admin` (Login WordPress if not logged yet) and proceed Dashboard > Plugins Activate all plugins except `Hello Dolly` & `Akismet Anti-Spam`.
  ( If you want to develop a WooCommerce theme you may want to install & activate WooCommerce Plugin. )
* Go Dashboard > Themes and activate the theme : pkg.name.
 ( It's our theme, just looks weird, for now.)
* Go Dashboard > Tools > Import and find WordPress row and click "Install Now" & after installing click Run Importer 
Find themeunittestdata.wordpress.xml under yourdesiredfoldernamehere/tools/dummy-data and click "Upload file and import"
Click checkbox "Download and import file attachments" and click submit.
* Looks good! Just go 'http://127.0.0.1:3010' and start to work.

## Setup : Young as fuck

*


## Frequently Asked Questions

* A question that someone might have?
 
An answer to that question.


## Copyright

Twenty Seventeen WordPress Theme, Copyright 2016 WordPress.org
Twenty Seventeen is distributed under the terms of the GNU GPL

Palamut bundles the following third-party resources:

Font Awesome icons, Copyright Dave Gandy
**License:** SIL Open Font License, version 1.1.
Source: http://fontawesome.io/

Bundled header image, Copyright Alvin Engler
**License:** CC0 1.0 Universal (CC0 1.0)
Source: https://unsplash.com/@englr?photo=bIhpiQA009k

## Changelog

### 1.0
* Released: June 1, 2019

Initial release

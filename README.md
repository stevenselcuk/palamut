[![TODO board](https://imdone.io/api/1.0/projects/5d0d2ddbca642f04f5a40896/badge)](https://imdone.io/app#/board/stevenselcuk/palamut)

# Palamut : The WordPress Developer Habitat
[![Buy Me A Coffee](https://raw.githubusercontent.com/stevenselcuk/palamut/master/tools/orange_img.png)](https://www.buymeacoffee.com/stevenselcuk)


[![Codacy Badge](https://api.codacy.com/project/badge/Grade/b33f52710a25481cad1c777042789f7a)](https://app.codacy.com/app/stevenjselcuk/palamut?utm_source=github.com&utm_medium=referral&utm_content=stevenselcuk/palamut&utm_campaign=Badge_Grade_Dashboard)
[![palamut version](https://img.shields.io/badge/habitat-1.0.9-blue.svg)](https://img.shields.io/badge/habitat-1.0.9-blue.svg)
[![palamut theme version](https://img.shields.io/badge/theme-1.0.0-brightgreen.svg)](https://img.shields.io/badge/theme-1.0.0-brightgreen.svg)
[![palamut plugin version](https://img.shields.io/badge/plugin-1.0.0-brightgreen.svg)](https://img.shields.io/badge/plugin-1.0.0-brightgreen.svg) [![Greenkeeper badge](https://badges.greenkeeper.io/stevenselcuk/palamut.svg)](https://greenkeeper.io/)

## What is Palamut?

Palamut is a habitat where is your unique WordPress theme born and lives. 
**What is inside?**

### WordPress Starter Theme (v.1.0.0)
It's your first spark. Tested up to WordPress 5.2. Support all WordPress Template Hierarchy. But there are some extras: Portfolio template (and also it's own category page, single and loop page. Starter theme includes customizer support with custom controls.
**Other Starter Theme Features:**
- Main Menu
- Good looking mobile menu
- Social Accounts menu
- Sidebar (It is a classic, just  like 2010)
- Footer Widget Area X 2

### Palamut The companion Plugin (v.1.0.0)
Yes, it has the same name as this repo but don't worry. All features are in here which are must in plugin domain in according with Envato. What are they?🤔
- Gutenberg Blocks
- Elementor Widgets (Right, It has gooooood support for Elementor)
- WordPress Widgets
- Short Codes ( Yes, I don't forget Classic Editor Support)
- Demo Import

### Helpers
Some additional features for your comfort.👐
**Gulp**
It's your friend who never lets you down. Includes life saving tasks and there is more browserSync with PHP server! No more boring PHP stuff.😓 Live reload with this feature! Perfekt mix.🍔

**3rd Party Plugins**
Palamut coded iaw WPTRT, Envato guideline. Palamut recommends Envato Theme Check, Query Monitor, Classic Editor and Elementor plugin for your working habitat. You can find them under /tools. 

## File Structure
    
    ├── build/                   # WordPress Installion
    ├── dist/                    # Ready to shipping builded files (zips & theme and palamut folders)
    ├── src/                     # Source files
    │   ├── assets/              # Assets directory
    │       ├── fonts/           # Fonts directory
    │       ├── img/             # Image directory
    │       ├── js/              # Main App JS File
    │       ├── styles/          # SCSS files
    │   ├── plugins/             
    │       ├── palamut/         # Palamut the Companion for your theme
    │   ├── theme/               # Standard Theme files
    │       ├── assets/ 
    │       ├── components/
    │       ├── inc/ 
    │       ├── languages/ 
    │       ├── wooCommerce/ 
    ├── tools/                   # Tools and utilities
    │   ├── dev-plugins          # Developer Plugins (Just for development env.)
    │   ├── dummy-data           # Demo posts and testing data
    └── .babelrc                 # Babel configuration
    └── .gitignore               # Git ignored files
    └── LICENSE                  # License agreements
    └── README.md                # You are reading this
    └── gulpfile.js              # Gulp configuration
    └── package.json             # Node packages


## Initial Setup : Baby Steps

Follow the Baby Steps when you are starting to develop new theme.

* Open your terminal and go your working directory and follow these commands:
 
`$ npx create palamut`

* Enter your theme project credentials, (they are must and yes you can change later them in yourthemename/package.json )

`$ npm run dev`

* You have just finished WordPress installation step. Go other step  Dev : Toddler Stuff.

## Dev : Toddler Stuff

* Go `http://127.0.0.1:3020/wp-admin` (Login WordPress if not logged yet) and proceed Dashboard > Plugins Activate all plugins except **Hello Dolly** & **Akismet Anti-Spam**.
  ( If you want to develop a **WooCommerce** supported theme you may want to install & activate **WooCommerce Plugin**. )
* Go `Dashboard > Themes` and activate the theme : yourthemename.
 ( It's our theme, just looks weird, for now.)
* Go `Dashboard > Tools > Import` and find WordPress row and click "Install Now" & after installing click Run Importer 
Find **themeunittestdata.wordpress.xml** under **yourdesiredfoldernamehere/tools/dummy-data** and click **Upload file and import**
Click checkbox "Download and import file attachments" and click submit.
* Just go `http://127.0.0.1:3010` this is your theme! Looks good!

## Build : Young as fuck

`$ npm run build`
* Your theme, plugin files and zip located under /yourthemename/dist/

## Frequently Asked Questions

* May I ask a question?
 
Sure, stevenjselcuk on gmail.com shoot here!


## Copyright

Palamut WordPress Starter Theme, Copyright 2019 Tabby Cat, LLC
Palamut is distributed under the terms of the GNU GPL

Palamut bundles the following third-party resources:

Font Awesome icons, Copyright Dave Gandy
**License:** SIL Open Font License, version 1.1.
Source: http://fontawesome.io/

## Palamut

### 1.0
* Released: Feb 1, 2019
Initial release
### 1.1.0
* Released: May 2, 2019
Building task has been added.  Use `npm run build`. Files and folders appears in `./build`


## Palamut The companion Plugin

### 1.0
* Released: July 1, 2019
Initial release

## Palamut the Companion Plugin Changelog

### 1.0
* Released: July 1, 2019
Initial release

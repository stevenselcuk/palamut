# Palamut WordPress Theme Framework & Companion Plugin


## What is Palamut?

Palamut is a habitat where is your unique WordPress theme born and lives. 
**What is inside?**
### WordPress Starter Theme
It's your first spark. Tested up to WordPress 5.2. Support all WordPress Template Hierarchy. But there are some extras: Portfolio template (and also it's own category page, single and loop page. Starter theme includes customizer support with custom controls.
**Other Starter Theme Features:**
- Main Menu
- Good looking mobile menu
- Social Accounts menu
- Sidebar (It is a classic, just  like 2010)
- Footer Widget Area X 2
**Companion Plugin: The Palamut**
Yes, it has the same name as this repo but don't worry. All features are in here which are must in plugin domain in according with Envato. What are they?🤔
- Gutenberg Blocks
- Elementor Widgets (Right, It has gooooood support for Elementor)
- WordPress Widgets
- Short Codes ( Yes, I don't forget Classic Editor Support)
- Demo Import
**Gulp**
It's your friend who never lets you down. Includes life saving tasks and there is more browserSync with PHP server! No more boring PHP stuff.😓 Live reload with this feature! Perfekt mix.🍔
**Helpers**
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


## Setup : Baby Steps

Follow the Baby Steps when you are starting to develop new theme.

* Open your terminal and go your working directory and follow these commands:
 
`$ git clone https://github.com/stevenselcuk/palamut.git yourdesiredfoldernamehere`

`$ cd yourdesiredfoldernamehere`

`$ npm install`

`$ npm run install:wordpress`

`$ npm run dev`

* The latest command starts gulp task which has opens a new tab in your default browser. Please proceed to standard **WordPress installation** at this step.
You will need a new database. *You may want to use your old one if available but the new database is strongly recommended.*
When you finish the WordPress installation wizard, return to the terminal and break current task and run 

`$ npm run config:wordpress`


* You have just finished WordPress installation step. Go other step : Toddler Stuff.

## Setup : Toddler Stuff

* Go `http://127.0.0.1:3020/wp-admin` (Login WordPress if not logged yet) and proceed Dashboard > Plugins Activate all plugins except **Hello Dolly** & **Akismet Anti-Spam**.
  ( If you want to develop a **WooCommerce** supported theme you may want to install & activate **WooCommerce Plugin**. )
* Go `Dashboard > Themes` and activate the theme : pkg.name.
 ( It's our theme, just looks weird, for now.)
* Go `Dashboard > Tools > Import` and find WordPress row and click "Install Now" & after installing click Run Importer 
Find **themeunittestdata.wordpress.xml** under **yourdesiredfoldernamehere/tools/dummy-data** and click **Upload file and import**
Click checkbox "Download and import file attachments" and click submit.
* Just go `http://127.0.0.1:3010` this is your theme! Looks good!

## Setup : Young as fuck

* Open your favorite editor and edit /yourdesiredfoldernamehere/packgage.json
Find these lines and edit **Yourthemename** things as you want. 

    "name": "Yourthemename", *No spaces please*
    "version": "1.0.0",
    "slug": "yourthemename", *No spaces please*
    "prefix": "yourthemenamebutshort", *No spaces please*
    "textdomain": "yourthemename", *No spaces please*

( Don't forget reset as 1.0.0 to version, it is important.)
* Go your working directory and delete /yourdesiredfoldernamehere/.git
* Proceed to 'https://github.com/new' and create new private repository pass other options.
* And init new git & add origin & push it It is someting like that: 

    git init
    git commit -m "first commit"
    git remote add origin https://github.com/yourname/your-new-repo.git
    git push -u origin master

## You better work : Ricky Steps


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

## Framework Changelog

### 1.0
* Released: Feb 1, 2019
Initial release
### 1.1.0
* Released: May 2, 2019
Building task has been added.  Use `npm run build`. Files and folders appears in `./build`


## WordPress Theme Boilerplate Changelog

### 1.0
* Released: April 1, 2019
Initial release

### 1.1.0
* Released: May 1, 2019
Woocommerce support has been implemented.

## Palamut the Companion Plugin Changelog

### 1.0
* Released: June 1, 2019
Initial release

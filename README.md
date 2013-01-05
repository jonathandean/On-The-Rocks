On-The-Rocks
============

Lightweight and responsive WordPress theme that uses SASS, Bourbon and Neat. Although anyone can run this theme, this is intended to be more a developer theme to get you started with some basic functionality and tools to build your own. It is essentially going to be the new theme for my website (jonathandean.com) minus a few design elements that are unique to my own "brand".

Status
======

Currently in active development. Many things are still missing, many things are poorly done.

Features
========

- Responsive design to support all screen types from Desktop to Tablet to Mobile (using Neat: https://github.com/thoughtbot/neat)
- Clean CSS source using SASS (http://sass-lang.com/) and Bourbon (http://thoughtbot.com/bourbon/), though for your purposes you are free to just edit the compiled CSS or just use normal CSS in your child theme. Pull requests must modify the SASS (.scss) files to accepted.
- HTML5 and CSS3
- Image free, CSS only
- Settings page in Appearance > Theme Options to hide or specially display a particluar category (I use this for posts created from my twitter updates, courtesty of the twitter tools plugin: http://wordpress.org/extend/plugins/twitter-tools/) You can hide a category from the main blog loop, "collapse" that category in a special smaller display format or keep in the page but hide via CSS. Check out the theme settings page in WordPress admin to see all options.
- Threaded comments support when enabled in Settings > Discussions
- Main nav supports WordPress Menus or will fall back to displaying all pages if none is created in your Appearance > Menus settings

Browser support
===============

I don't care much about catering to older browsers, escpecially Internet Explorer. My audience wouldn't be using them and I don't believe in supporting out of date software that is free to upgrade unless critical to your users or business. You can support browsers that don't support CSS3 yourself.
    
Creating your own Child Theme
=============================

This is probably the best way to use On The Rocks in our own site. Rather than modifying the this theme itself, you can create your own Child Theme and still be able to pull in updates to On The Rocks. (Changes to contribute to On The Rocks itself should come in the form of a fork and pull request for the benefit of the community.) For more information see http://codex.wordpress.org/Child_Themes

The simpliest Child Theme contains just a style.css where you adjust the visual display of the theme with your own look and branding. A basic Child Theme looks something like this, where you import the On The Rocks compiled style.css in your own css file and then override or add styles below. For example, create a directory in your wp-content/themes/ directory for your new theme and put something like this in it:

    /*
    Theme Name: On The Rocks Child
    Description: Child theme for the On The Rocks theme 
    Author: Your name here
    Template: on_the_rocks
    */
    
    @import url("../on_the_rocks/style.css");
    
    // Custom CSS goes here

If you are using SCSS then you can also make the import statement compile the On The Rocks CSS into it by pointing to the SCSS source instead. This will prevent an extra request in the browser. This would look like:

    /*
    Theme Name: On The Rocks Child using SCSS
    Description: Child theme for the On The Rocks theme 
    Author: Your name here
    Template: on_the_rocks
    */
    
    @import "../../on_the_rocks/scss/style.scss";
    
    // Custom SCSS goes here

Note that in this version there is no url and the path points to the .scss file instead of .css.

To take advantage of the variables and mixins of On The Rocks, you can import those as well:

    /*
    Theme Name: On The Rocks Child using SCSS
    Description: Child theme for the On The Rocks theme
    Author: Your name here
    Template: on_the_rocks
    */

    @import "../../on_the_rocks/scss/variables";
    @import "../../on_the_rocks/scss/mixins";
    @import "../../on_the_rocks/scss/style.scss";

    // Custom SCSS goes here

You can also modify markup, add functionaliy, etc. by adding template files and other functionality. See http://codex.wordpress.org/Child_Themes for more information.

Adding your logo in the main navigation
=======================================

You can easily customize the logo area by making a file in your child theme called logo.php. To use an image there, you can do something like this:

    <h1><a href="<?php echo site_url(); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/logo.svg" alt="<?php bloginfo('name'); ?>"/></a></h1>

Using the retina-display SASS mixin
===================================

TODO

Using the SVG image fallback script
===================================

There's a small JavaScript script included that will automatically replace all SVG images on the page (using an <img> tag with a .svg extension) with a fallback format when SVG is not supported by the browser. If the image has the attribute data-svg-fallback replaces the image src with that value. If it doesn't have that attribute it sets the image src to the same filename but with a .png extension. Therefore, if you intended to use .svg images, you should either provide an alternative via the data-svg-fallback attribute or by putting a .png image with the same name in the same directory.

Note: the current version requires jQuery but a non-jQuery version will likely be added soon. I may also add a theme option to select the desired version or none.

Clone the repository
====================

Go into your project's wp-content/themes/ directory and run:

    cd [project root]/wp-content/themes/
    git clone git@github.com:jonathandean/On-The-Rocks.git on_the_rocks
    
This projects contains neat as a submodule. When you clone the repository you'll have the directory that contain the submodule but not the files yet. To get them, you'll have to run:

    git submodule init
    git submodule update

To get the latest version of On The Rocks in a repostory where you added it as a submodule:

    cd [project root]/wp-content/themes/on_the_rocks/
    git checkout master
    git pull
    cd [project root]
    git commit -am "Updated On The Rocks with the latest version in master"
    
Compiling the SCSS
==================

First you must install SASS if you don't already have it. I would recommend at least version 3.2.1

    gem install sass
    sass --watch scss/style.scss:style.css
    
More information at http://sass-lang.com/

Use as a git submodule
======================

You may wish to use this as a submodule in your existing git repository. For instance, if you have your whole WordPress site in your repository, you can do something like this to add On The Rocks to your themes directory as a submodule:

    cd [project root]
    git submodule add git@github.com:jonathandean/On-The-Rocks.git wp-content/themes/on_the_rocks

Now the directory wp-content/themes/on_the_rocks acts as its own repository inside of your main repository. Now you can go into this directory and pull the latest or checkout a particular revision. Then when you commit the directory in the parent repository it essentially commits the info that you are using a particular revision of On The Rocks there.

This allows you to stay up to date with On The Rocks using git rather than manually pasting in the files into your own repository.

For more on git submodules, see http://git-scm.com/book/en/Git-Tools-Submodules

Setup
=====

These are the steps I used to set up bourbon and neat. You don't need to do this when you clone the repository, but I thought it might be useful for you to see how I did it and also for my own future reference:

Install bourbon (first time)

    gem install bourbon
    cd scss/
    bourbon install
    
Update bourbon (when needed)

    gem update bourbon
    cd scss/
    bourbon update
    
Install neat (git submodule)

    cd [project root]
    git submodule add git://github.com/thoughtbot/neat.git scss/neat
    
Compile SCSS

    gem install sass
    cd [project root]
    sass --watch scss/style.scss:style.css


On-The-Rocks
============

Lightweight WordPress theme using SASS, Bourbon and Neat

Clone the repository
====================

Go into your project's wp-content/themes/ directory and run:

    cd [project root]/wp-content/themes/
    git clone git@github.com:jonathandean/On-The-Rocks.git on_the_rocks
    

Use as a git submodule
======================

You may wish to use this as a submodule in your existing git repository. For instance, if you have your whole WordPress site in your repository, you can do something like this to add On The Rocks to your themes directory as a submodule. For more on git submodules, see http://git-scm.com/book/en/Git-Tools-Submodules

    cd [project root]
    git submodule add git@github.com:jonathandean/On-The-Rocks.git wp-content/themes/on_the_rocks
    
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
    
    @import url("../on_the_rocks/scss/style.scss");
    
    // Custom CSS goes here

You can also modify markup, add functionaliy, etc. by adding template files and other functionality. See http://codex.wordpress.org/Child_Themes for more information.

Contribute/Setup
================

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
    cd [project root]
    sass --watch scss/style.scss:style.css


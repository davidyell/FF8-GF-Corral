#Final Fantasy VIII Corral
An application to organise your Guardian Forces so that you can maximise the junction coverage on your team or teams.  

##Why?
Tried to build an OOP application without using a framework.

##Premise
The idea is that when your team gets stripped of all their Guardian Forces you have to spend time working out which ones go on 
which character to ensure that all your characters can have as many stats junctioned as possible without having any 
overlaps, such as one character having two HP-J.

## Requirements
* PHP 7.1+

##Installation
If you clone the project to a folder, and then run `composer install` to install the dependencies and get the 
autoloader setup.

Then you can either configure your web server to run the application or run it using PHP's server.

```bash
cd web/public && php -S localhost:4040
```

There is a test suite which can be run with
 
```bash
vendor/bin/phpunit
```

## Configuration
There are two XML files which hold the data for the Characters and GF's. You can edit these files by copying them from 
`src/neon1024/Characters/Characters.xml` and `src/neon1024/GuardianForces/GFs.xml` and placing copies into the `config` 
directory. Here they can be edited to match your current GF configs.  

If you have removed or added new abilities to your GF's using items, you will want to customise the `GFs.xml` file to match.  

The junctions that can be placed in the XML file are Case SenSiTive.  
* HP-J
* Str-J
* Vit-J
* Mag-J
* Spr-J
* Eva-J
* Hit-J
* Luck-J

## Junction system
If you're not familiar with the game, or what a Guardian Force is, or how it works. You can read more on Wikipedia.
https://en.wikipedia.org/wiki/Final_Fantasy_VIII#Junction_system

##Credit
David Yell <neon1024@gmail.com>  
Squaresoft / Square Enix - Final Fantasy VIII

## License
[![Creative Commons Licence](https://i.creativecommons.org/l/by-sa/4.0/88x31.png)](http://creativecommons.org/licenses/by-sa/4.0/)  
This work is licensed under a [Creative Commons Attribution-ShareAlike 4.0 International License](http://creativecommons.org/licenses/by-sa/4.0/).

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/739c8310-f6bc-4847-a4cc-2ff4417db956/big.png)](https://insight.sensiolabs.com/projects/739c8310-f6bc-4847-a4cc-2ff4417db956)

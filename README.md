#Final Fantasy VIII Corral
An application to organise your Guardian Forces so that you can maximise the junction coverage on your team or teams.

##Why?
Tried to build an OOP application without using a framework.

##Premise
The idea is that when your team gets stripped of all their GF's you have to spend time working out which ones go on which character to ensure that all your characters can have as many stats junctioned as possible without having any overlaps, such as one character having two HP-J.

##Installation
If you clone the project to a folder, and then run `composer install` to install the dependencies and get the autoloader setup.

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

## Development
Further development should be undertaken in the develop branch.

##Credit
David Yell <neon1024@gmail.com>  
Squaresoft / Square Enix - Final Fantasy VIII


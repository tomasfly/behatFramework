# BDD Project - Sonar Service

BDD project which has as a main goal to perform Automation Testing on Sonar Service using Behat open source behavior-driven development framework. An additonal framework was included in the project called PHPUnit. Httpful PHP library was used to interact with the API, and a PHP class called KLogger to do the logging. 

# Installation

1. Clone repository : git clone https://tomas_fly_ar@bitbucket.org/tomas_fly_ar/tfleiderman-test-qaautomation.git
2. Execute: curl http://getcomposer.org/installer | php
3. Execute: php composer.phar install 

# Test execution
Execute command: behat/behat in linux or bin\behat.bat in Windows

In order to run sanity test:
bin\behat.bat @sanity

# Notes 
* Project developed with Windows 7 OS.
* PHP version: 7.0.2
* IDE: phpStorm 10.0.3
# Symfony Content Management Framework Sandbox


## Getting started

### You will need:
  * Git 1.6+
  * PHP 5.3.2+
  * phpUnit 3.5+ (optional)

### Get the code

    git clone git://github.com/symfony-cmf/cmf-sandbox.git
    cd cmf-sandbox
    git submodule update --init --recursive
    app/console assets:install web/ --symlink

This will fetch the main project and all it's dependencies ( Zend, Symfony, Doctrine\PHPCR, Jackalope ... )

### Create your personal config file

You have to copy the default config.yml to fit your needs:

    cp app/config/config.yml.dist app/config/config.yml

### Install and run Apache Jackrabbit

In order to run tests or application, you will need a working Jackrabbit server running and listening by default on localhost port 8080.

#### Download the Jackrabbit server

Official download website: [http://jackrabbit.apache.org/downloads.html](http://jackrabbit.apache.org/downloads.html)

#### Run the Jar inside the project directory

    mv jackrabbit-standalone-*.jar jackrabbit-standalone.jar
    java -jar jackrabbit-standalone.jar

#### Try it

Open you browser on [http://localhost:8080/](http://localhost:8080/)
You should have a default jackrabbit homepage.

### Run the test suite

Tests are written with PHPUnit.

    phpunit -c app

### Access by web browser

Create an apache virtual host entry along the lines of

    <Virtualhost *:80>
        Servername cmf.lo
        DocumentRoot /path/to/symfony-cmf/cmf-sandbox/web
        <Directory /path/to/symfony-cmf/cmf-sandox>
            AllowOverride All
        </Directory>
    </Virtualhost>

And add an entry to your hosts file for cmf.lo

Now go to [http://cmf.lo/app_dev.php](http://cmf.lo/app_dev.php)

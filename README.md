ToastyCMS2
==========

New, Improved, and simplified version of ToastyCMS

More details to come, but if you get here early follow the steps below to get started.

Setting up a new instance of ToastyCMS2 in 8 easy steps:

    1) Download or clone the repository
    2) Move the extracted site to your web server's root directory
    3) Create a new MySQL database
    4) Import the database.sql file found in the CMS root directory into your MySQL database
    5) Rename app/Config/database.php.default to app/Config/database.php
    6) In database.php, set you MySQL database connection information
        a. hostname
        b. username
        c. password
        d. database name
    7) Browse to yourwebsite.com/
    8) SET THE DEFAULT SALT AND CIPHER SEED values in 
        
        app/Config/core.security.php on lines 203 and 208
        
        You can get some random values from: https://www.grc.com/passwords.htm
                
    9) After changing the salt and cipher seed values, SET THE ROOT ACCOUNT PASSWORD by navigating to
        
        http://<your website>/<path to toastycms>/management/toasty_core/users/edit/1
        
    Authentication will be disabled until the Security.cipherseed and Security.salt values are updated and the root password
    is set
    
    10) Start toasting a new website and leave comments, report bugs, and open issues here.
    
    
Known issues:
    - There are issues running ToastyCMS under a WAMP server. It was develped in a Linux environment and I made some 
    assumptions about where executables may exist. Although I am not formally supporting running in a WAMP environment,
    post any WAMP related issues in the issues section and I will take a look at it.

    




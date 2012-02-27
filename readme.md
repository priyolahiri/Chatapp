#CHATAPP - LIVE CHATWALL

This project is based on PHP, Redis, and Pusher API. 
This application provides an live chatwall with social login. The target is to make it embeddable on your own website/wordpress blog/other cms.
Pusher is used for pub/sub and redis is used for maintaining history of closed chats and for providing chat history to users joining in late to the conversation since Pusher does not have a History API. The PHP framework in use is Laravel (stable 2.x release). On the UI front it uses Jquery, Jquery UI, Jquery Noty and 99lime.com's fantastic HTML Kickstart.

This project is under construction and not ready for production use yet.

##REQUIREMENTS

1. PHP 5.3x
2. MySQL or any other fork with native php mysql support
3. Redis server and Rediska library
4. Memcached server and memcached php library
5. [Pusher.com](http://www.pusher.com) account
6. Twitter and Facebook app

##SETUP INSTRUCTIONS
1. Sign-up for a Pusher.com account if you don't have one
2. Install redis-server. On Ubuntu add chris-lea's redis repository from Launchpad and then do apt-get update and apt-get install redis-server
3. Dowload and instlall the rediska library using PEAR
4. Make sure you have memcached and the memcached php library installed and running.
5. Git clone the project
6. Create an apache virtualhost configuration and set the document root to the public directory
7. Create a mysql db
8. Import the application/config/db.sql file into the newly created database
9. Open public/index.php and change the pusher values with what you get from your Pusher.com account
10. Open application/config/application.php and change the url element to point to your virtualhost address and define a random 32 character key in the key element
11. Open application/config/cache.php and application/config/session.php and make necessary changes. By default, it's set to memcache running on 127.0.0.1
12. Open public/hybridauth/config.php and disable all adapters except Facebook and Twitter. Fill in your API values for Facebook and Twitter. Refer [HybridAuth Docs](http://hybridauth.sourceforge.net) for more info.
13. Open http://yourvhost.com and login using Facebook or Twitter. Once successfully logged in, open the mysql db and change the role of the user to "admin"
14. You are now the admin and ready to rock!

This project is in active development and evaluation at [SportsKeeda.com](http://www.sportskeeda.com)

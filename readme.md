#CHATAPP - LIVE CHATWALL AND SCORE

This project is based on PHP, Redis, and Pusher API. 
This application provides an embeddable live chatwall with social login.
Pusher is used for pub/sub and redis is used for maintaining history of closed chats and for providing chat history to users joining in late to the conversation since Pusher does not have a History API. The PHP framework in use is Laravel (stable 2.x release). On the UI front it uses Jquery, Jquery UI, Jquery Noty and 99lime.com's fantastic HTML Kickstart.

##REQUIREMENTS

1. PHP 5.3x
2. MySQL or any other fork with native php mysql support
3. Redis
4. Pusher.com account

##SETUP INSTRUCTIONS

This project is in active development and evaluation at [SportsKeeda.com](http://www.sportskeeda.com)

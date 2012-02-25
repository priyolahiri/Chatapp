<!DOCTYPE html> 
<html> 
    <head> 
    <title>Page Title</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
    <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
</head> 
<body> 

<div id="page1" data-role="page">
    <div data-role="header">
        <a href="#" data-role="button" data-icon="back" data-iconpos="notext" data-rel="back"></a> 
        <h1>Page Title</h1>
    </div><!-- /header -->

    <div data-role="content">    
        <p>To recreate the bug <p>
        <p> 1.click on show button 1 </p>
        <p> 2.click back </p>
        <p> 3.click on show button 2 </p>
        <p> 4.button is distorted </p>
            
        <a id="showbtn1"  href="#" data-role="button">show only button 1</a>
         <a id="showbtn2" href="#" data-role="button">show only button 2</a>           
    </div><!-- /content -->

    <div data-role="footer">
        <h4>Page Footer</h4>
    </div><!-- /footer -->
</div><!-- /page -->
    
<div id="page2" data-role="page">

    <div data-role="header">
        <a href="#" data-role="button" data-icon="back" data-iconpos="notext" data-rel="back"></a> 
        <h1>Page Title</h1>
    </div><!-- /header -->

    <div data-role="content">    
        <a id="btn1" href="#" data-role="button">button 1</a>
        <a id="btn2" href="#" data-role="button">button 2</a>        
    </div><!-- /content -->

    <div data-role="footer">
        <h4>Page Footer</h4>
    </div><!-- /footer -->
</div><!-- /page -->    

</body>
</html>​
$namespace(function() {
    
$namespace('#top').replaceWith(templateHeader);
$namespace('#footer').replaceWith(templateFooter);
    
    });
    
var templateHeader = '<h1> hello header</h1>';
var templateFooter = '<h1> hello footer</h1>';
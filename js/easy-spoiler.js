/**
 * Handle: easySpoiler
 * Version: 0.2
 * Enqueue: true
 *
 * Author: dyerware
 * Author URI: http://www.dyerware.com
 * Copyright © 2009, 2010  dyerware
 * Support: support@dyerware.com
 */
 
function wpSpoilerToggle(id) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {
        e.style.display = 'none';
        me.value='Show';
    }
    else
    {        
        e.style.display = 'block';
        me.value='Hide';
    }
}

function wpSpoilerHide(id) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {      
        e.style.display = 'none';
        me.value='Show';
    }
}
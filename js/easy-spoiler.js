/**
 * Handle: easySpoiler
 * Version: 0.7
 * Enqueue: true
 *
 * Author: dyerware
 * Author URI: http://www.dyerware.com
 * Copyright © 2009, 2010, 2011  dyerware
 * Support: support@dyerware.com
 */
 
function wpSpoilerToggle(id, doAnim, showName, hideName, speed, doIframes) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {
        if (doAnim)
            {jQuery("#" + id).slideUp(speed);}
        else
            {e.style.display = 'none';}
        me.value=showName;
    }
    else
    {     
        if (doAnim)
            {jQuery("#" + id).fadeIn(speed);} 
        e.style.display = 'block';
        me.value=hideName;
        
        if (doIframes)
        	{jQuery("#" + id).find('iframe').each(function (i) {this.src = this.src;});}
    }
}

function wpSpoilerHide(id, doAnim, showName, speed) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {   
        if (doAnim)
            {jQuery("#" + id).slideUp(speed);}
        e.style.display = 'none';
        me.value=showName;
    }
}
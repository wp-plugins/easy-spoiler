/**
 * Handle: easySpoiler
 * Version: 0.3
 * Enqueue: true
 *
 * Author: dyerware
 * Author URI: http://www.dyerware.com
 * Copyright © 2009, 2010  dyerware
 * Support: support@dyerware.com
 */
 
function wpSpoilerToggle(id, doAnim, showName, hideName) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {
        if (doAnim)
            {jQuery("#" + id).slideUp('fast');}
        else
            {e.style.display = 'none';}
        me.value=showName;
    }
    else
    {     
        if (doAnim)
            {jQuery("#" + id).fadeIn('fast');} 
        e.style.display = 'block';
        me.value=hideName;
    }
}

function wpSpoilerHide(id, doAnim, showName) 
{
    var myName = id + '_action';
    var me = document.getElementById(myName);
    var e = document.getElementById(id);
    
    if(e.style.display == 'block')
    {   
        if (doAnim)
            {jQuery("#" + id).slideUp('fast');}
        e.style.display = 'none';
        me.value=showName;
    }
}
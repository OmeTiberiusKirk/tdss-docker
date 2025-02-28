
var blockState = Array();
blockState['photo_tutorials_1'] = false;
blockState['photo_tutorials_2'] = false;
blockState['stuff_accessories'] = false;
blockState['machine'] = false;
var changeClass = Array();

function toggle_submenu_block(block_id) {
	var block_elem = document.getElementById(block_id);
	var block_elem_group = document.getElementById(block_id+'_group');
	
	var today = new Date();
	today.setTime( today.getTime() );
	var cookie_expires = 1000 * 60 * 60 * 24;
	var expires_date = new Date( today.getTime() + (cookie_expires) );
	
	if(block_elem) {		
		if(blockState[block_id]) {			
			//block_elem.className = 'submenu_group_closed';
			block_elem.className = changeClass[block_id];
			block_elem_group.style.display = 'none';
			block_elem_group.style.visibility = 'hidden';
			blockState[block_id] = false;
			document.cookie = 'show_'+block_id+'=0;expires='+expires_date.toGMTString()+";path=/";
		} else {
			block_elem.className = 'submenu_group_open';
			block_elem_group.style.display = 'block';
			block_elem_group.style.visibility = 'visible';
			blockState[block_id] = true;			
			
			document.cookie = 'show_'+block_id+'=1;expires='+expires_date.toGMTString()+";path=/";
		}		
	}
	return false;
}
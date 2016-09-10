function replyTitle()
{
	document.getElementById('replyTitle').scrollIntoView(); 
}
	document.getElementById('replyTo').value = document.getElementById('OP').innerHTML;

	function clickItem(item)
	{
		if (item == "OP")
		{
			document.getElementById('replyTo').value = document.getElementById('OP').innerHTML;
			replyTitle();
		}
		else
		{
			document.getElementById('replyTo').value = item;
			replyTitle();
		}
	}

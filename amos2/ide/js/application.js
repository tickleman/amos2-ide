$(document).ready(function()
{

	// can enter tab characters into textarea
	$('body').build('call', 'textarea', $.fn.presstab);

	//--------------------------------------------------------------------------------- F1 => compile
	shortcut.add('F1', function()
	{
		$('.actions .compile a').click();
	});

	//------------------------------------------------------------------------------------- F2 => run
	shortcut.add('F2', function()
	{
		$('.actions .run a').click();
	});

});

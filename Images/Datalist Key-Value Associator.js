function InputHandler(e)
{
	var input = e.target,
		list = input.getAttribute('list'),
		options = document.querySelectorAll('#' + list + ' option'),
		hiddenInput = input.parentElement.getElementsByClassName('candidatestudentid')[0],
		inputValue = input.value;
	
	hiddenInput.value = inputValue;

	for(var i = 0; i < options.length; i++)
	{
		var option = options[i];

		if(option.innerText === inputValue)
		{
			hiddenInput.value = option.getAttribute('data-value');
			break;
		}
	}
}

var AwardInputGroups = document.getElementsByClassName('candidateinput');
for (var Index = 0; Index != AwardInputGroups.length; Index++)
{
	AwardInputGroups[Index].getElementsByClassName('candidatestudentname')[0].addEventListener(
		'input',
		InputHandler
	);
}
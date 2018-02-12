var fileTypes = [
'image/jpeg',
'image/pjpeg',
'image/png'
]

function validFileType(file) {
	for(var i = 0; i < fileTypes.length; i++) {
		if(file.type === fileTypes[i]) {
			return false;
		}
	}

	return true;
}

function validate(e)
{
	//	Determine if the form has errors
	if(validFileType()){
		// 	Prevents the form from submitting
		e.preventDefault();
	}

	return true;
}

function load()
{
	// Add event listener for the form submit
	document.getElementById("register").addEventListener("submit", validate);

}

// Add the event listener for the document load
document.addEventListener("DOMContentLoaded", load);
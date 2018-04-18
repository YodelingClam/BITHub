$(document).ready(function ()
{
	$("#ImgControl").change(function()
	{
		readURL(this);
	});
});

function readURL(input)
{
	if (input.files && input.files[0])
	{
		var reader = new FileReader();

		reader.onload = function (e)
		{
			$('#ImgPreview').attr('src', e.target.result);
			$('#ImgContain').css('display', 'block');
			$('#ImgPreview').css('display', 'block');
		}

		reader.readAsDataURL(input.files[0]);
	}
}
function hideImage()
{
	$('#ImgContain').css('display', 'none');
	$('#ImgPreview').css('display', 'none');
}

function displayEdit(label) {
	temp = '#'+label+"Edit";
	value = $(temp).text();
	document.getElementById(label+'Edit').innerHTML = '<input style="width:100%; color:white; background: transparent; border-style: none; font-weight: bold;" name=email type=text value='+value+' required autofocus/>'; 
	document.getElementById(label+'Edit').onclick = "";
	document.getElementById(label+'Label').innerHTML = '<button onclick=update("'+label+'") style="height:20px;">Save</button>';
}
function update(label) {
	$.ajax({
		type: 'POST',
		url: 'update.php',
		data: {
			type: label,
			name: $("input[name='"+label+"']").val()
		},
		success: function(data) {
			document.getElementById(label+'Edit').innerHTML = data; 
			document.getElementById(label+'Edit').onclick = 'displayEdit("'+label+'")';
			document.getElementById(label+'Label').innerHTML = 'Email:';
		}
	});
}
function updateImage(){
	var uri;
	var reader = new FileReader();
	reader.onload = function (e) {
		uri = e.target.result;
	};
	alert(uri);
	$.ajax({
		type: 'POST',
		url: 'update.php',
		data: {
			type: 'image',
			imguri: uri
		},
		success: function(data) {
			alert(data);
		}
	});
}
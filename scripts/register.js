// When the user clicks on <div>, open the popup
function myFunction() {

    document.getElementById('my-div').style.display = 'block';
    document.getElementById('my-div').style.right = (window.innerWidth/2 - (document.getElementById('my-div').offsetWidth)/2)+'px';
}
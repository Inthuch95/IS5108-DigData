function showContext(site) {
	var xhttp; 
	if (str == "") {
		document.getElementById("txtHint").innerHTML = "";
		return;
	}else { 
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("context").innerHTML = this.responseText;
			}
		};
	xhttp.open("GET", "PHP/getContextBySite.php?q="+site, true);
	xhttp.send();
	}
}
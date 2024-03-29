

function showContext(trench) {
	var site = document.getElementById("location").value;
	var xhttp;
	if (site == "") {
		document.getElementById("context").innerHTML = "<option>Select site first</option>";
		document.getElementById("contextDesc").style.display = "none";
		return;
	}
	else if(trench == ""){
		document.getElementById("context").innerHTML = "<option>Select trench first</option>";
		document.getElementById("contextDesc").style.display = "none";
		return;
	}else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("context").innerHTML = this.responseText;
				document.getElementById("contextDesc").style.display = "none";
			}
		};
	xmlhttp.open("GET", "PHP/getContextBySite.php?q="+site+"&q1="+trench, true);
	xmlhttp.send();
	}



}

function showContextDesc(context) {

	var xhttp;
	if (context == "") {
		document.getElementById("contextDesc").innerHTML = "";
		document.getElementById("contextDesc").style.display = "none";
		return;
	}else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("contextDesc").innerHTML = this.responseText;
				document.getElementById("contextDesc").style.display = "initial";
			}
		};

	xmlhttp.open("GET", "PHP/getContextDesc.php?q="+context, true);
	xmlhttp.send();
	}

}


function showTrench(site) {
	var xhttp;
	if (site == "") {
		document.getElementById("trench").innerHTML = "<option>Select site first</option>";
		document.getElementById("context").innerHTML = "<option>Select site first</option>";
		document.getElementById("contextDesc").style.display = "none";
		document.getElementById("trench").disabled = true;
		document.getElementById("context").disabled = true;
		return;
	}else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {

				if(!this.responseText.includes("No trench")){
					document.getElementById("trench").innerHTML = this.responseText;
					document.getElementById("trench").disabled = false;
					document.getElementById("context").disabled = false;
					document.getElementById("context").innerHTML = "<option>Select trench first</option>";
				}
				else{

					document.getElementById("trench").innerHTML  = "<option>No trench available</option>";
					document.getElementById("context").innerHTML  = "<option>No context available</option>";
					document.getElementById("trench").disabled = true;
					document.getElementById("context").disabled = true;
				}

				//document.getElementById("context").innerHTML = "<option>Select trench first</option>";
				document.getElementById("contextDesc").style.display = "none";
			}
		};

	xmlhttp.open("GET", "PHP/getTrench.php?q="+site, true);
	xmlhttp.send();
	}
}

function showTrench_AddContext(site) {

	var xhttp;
	if (site == "") {
		document.getElementById("trench").innerHTML = "<option>Select site first</option>";
		document.getElementById("trench").disabled = true;
		document.getElementById("context").value = "Select site first"
		document.getElementById("newTrench").style.display = "none";
		document.getElementById("newTrenchInput").value = "";
		//showNewTrench_Addcontext("");
		return;
	}else {
		
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();

		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}


		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if(this.responseText != "No trench"){
					document.getElementById("trench").disabled = false;
					document.getElementById("trench").innerHTML = this.responseText+"<option value ='New trench'>New trench</option>";
					document.getElementById("newTrench").style.display = "none";
					showNewTrench_Addcontext("");
				}
				else{
					document.getElementById("trench").disabled = false;
					document.getElementById("trench").innerHTML  = "<option value ='New trench'>New trench</option>";
					document.getElementById("newTrench").style.display = "block";
					showNewTrench_Addcontext("New trench");
				}

				//document.getElementById("trench").innerHTML = this.responseText+"<option value ='New trench'>New trench</option>";
			}
		};

	xmlhttp.open("GET", "PHP/getTrench.php?q="+site, true);
	xmlhttp.send();
	}
}

function showNewTrench_Addcontext(trench){
	if (trench == "New trench") {
		document.getElementById("newTrench").style.display = "block";
		document.getElementById("context").value = 1;
		return;
	}
	else{
		document.getElementById("newTrench").style.display = "none";
		
		var site = document.getElementById("location").value;
		var xhttp;
		if (site == "") {
			document.getElementById("context").value = "Select site first";
			return;
		}
		else if(trench == ""){
			document.getElementById("context").value = "Select trench first";
			return;
		}else {
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();

			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("context").value = this.responseText;
					
				}
			};
		xmlhttp.open("GET", "PHP/getNextContextBySiteTrench.php?q="+site+"&q1="+trench, true);
		xmlhttp.send();
		}
		
	}
}

function showNextContextNum_Addcontext(trench){
	


}

function confirmAddSite() {
    //var txt;
    var r = confirm("Are you sure?");

    if (r == true) {
		var name = document.getElementById("name").value;
		var description = document.getElementById("description").value;
		var xhttp;

			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();

			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("addResult").innerHTML = this.responseText;
					//document.getElementById("contextDesc").style.display = "none";
				}
			};

		xmlhttp.open("GET", "PHP/insertSite.php?name="+name+"&description="+description, true);
		xmlhttp.send();


        //txt = "You pressed OK!";
    } else {
        //txt = "You pressed Cancel!";
    }
    //document.getElementById("demo").innerHTML = txt;
}

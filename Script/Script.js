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
					document.getElementById("trench").innerHTML = this.responseText;
				}
				else{
					
					document.getElementById("trench").innerHTML  = "<option>No trench available</option>";
				}
				
				document.getElementById("context").innerHTML = "<option>Select trench first</option>";
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
		document.getElementById("newTrench").style.display = "none";
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
					document.getElementById("trench").innerHTML = this.responseText+"<option value ='New trench'>New trench</option>";
					document.getElementById("newTrench").style.display = "none";
				}
				else{
					document.getElementById("trench").innerHTML  = "<option value ='New trench'>New trench</option>";
					document.getElementById("newTrench").style.display = "block";
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
		return;
	}
	else{
		
		document.getElementById("newTrench").style.display = "none";
	}
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


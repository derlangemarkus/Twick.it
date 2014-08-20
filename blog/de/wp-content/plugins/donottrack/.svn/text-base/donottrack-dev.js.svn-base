domwrite=document.write;
document.write=sanitizer;

var spy=['quantserve.com','media6degrees.com'];
	
function sanitizer(tS) {
	ttS=tS.toLowerCase();
	if ((ttS.indexOf(unescape('%3Cscript')) != -1) && (ttS.indexOf(unescape('src=')) != -1)){
		for (x in spy) {
			if (ttS.indexOf(spy[x]) != -1) {
				tS=ttS.replace(/</g,'<!--').replace(/>/g,'-->');
				break;
				}
			}
		}
	writeOut(tS);
	}
		
function writeOut(tS) {
	document.write=domwrite;
	document.write(tS);
	document.write=sanitizer;
	}

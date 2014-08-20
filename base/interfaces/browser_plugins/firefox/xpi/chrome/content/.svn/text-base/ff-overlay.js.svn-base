twickit.onFirefoxLoad = function(event) {
  document.getElementById("contentAreaContextMenu")
          .addEventListener("popupshowing", function (e){ twickit.showFirefoxContextMenu(e); }, false);
};

twickit.showFirefoxContextMenu = function(event) {
  // show or hide the menuitem based on what the context menu is on
  document.getElementById("context-twickit").hidden = gContextMenu.onImage;
};

window.addEventListener("load", function () { twickit.onFirefoxLoad(); }, false);

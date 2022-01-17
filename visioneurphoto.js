


var rotate_delay = 1000;
current = 0;
function next() {
if (document.slideform.slide[current+1]) {
document.images.show.src = document.slideform.slide[current+1].value;
document.slideform.slide.selectedIndex = ++current;
   }
else first();
}
function previous() {
if (current-1 >= 0) {
document.images.show.src = document.slideform.slide[current-1].value;
document.slideform.slide.selectedIndex = --current;
   }
else last();
}
function first() {
current = 0;
document.images.show.src = document.slideform.slide[0].value;
document.slideform.slide.selectedIndex = 0;
}
function last() {
current = document.slideform.slide.length-1;
document.images.show.src = document.slideform.slide[current].value;
document.slideform.slide.selectedIndex = current;
}
function ap(text) {
document.slideform.slidebutton.value = (text == "Stop") ? "Start" : "Stop";
rotate();
}
function change() {
current = document.slideform.slide.selectedIndex;
document.images.show.src = document.slideform.slide[current].value;
}
function rotate() {
if (document.slideform.slidebutton.value == "Stop") {
current = (current == document.slideform.slide.length-1) ? 0 : current+1;
document.images.show.src = document.slideform.slide[current].value;
document.slideform.slide.selectedIndex = current;
window.setTimeout("rotate()", rotate_delay);
   }
}
//  End -->
</script>

    Réglez simplement deux paramètres dans ce script : rotate_delay indique le délai d'affichage entre deux images en cas de déroulement automatique (en millisecondes), current qui indique le numéro de l'image de départ (0 correspond à la première image de votre liste).

    Créez ensuite votre visionneuse à proprement parler :
<form name=slideform>
<table cellspacing=1 cellpadding=4 bgcolor="#000000">
<tr>
<td align=center bgcolor="white">
<b>Image Slideshow</b>
</td>
</tr>
<tr>
<td align=center bgcolor="white" width=200 height=150>
<img src="mon_image1.jpg" name="show">
</td>
</tr>
<tr>
<td align=center bgcolor="#C0C0C0">
<select name="slide" onChange="change();">
<option value="bora1.jpg" selected>image 1
<option value="bora2.jpg">image 2
<option value="bora3.jpg">image 3
<option value="bora4.jpg">image 4
</select>
</td>
</tr>
<tr>
<td align=center bgcolor="#C0C0C0">
<input type=button onClick="first();" value="I<<" title="Début">
<input type=button onClick="previous();" value="<<" title="Précédent">
<input type=button name="slidebutton" onClick="ap(this.value);" value="I>" title="Lecture">
<input type=button onClick="next();" value=">>" title="Suivant">
<input type=button onClick="last();" value=">>I" title="Fin">
</td>
</tr>
</table>
</form>



